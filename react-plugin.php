<?php
/**
 * Plugin Name: Mi Plugin React con AG Grid
 * Description: Muestra cómo integrar React y AG Grid en WordPress y pasar datos dinámicamente a través de un shortcode.
 * Version: 1.0
 * Author: Tu Nombre
 */

 defined('ABSPATH') or die('¡Acceso directo no permitido!');

 function mi_plugin_activate() {
    global $wpdb;
    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

    $table_name = $wpdb->prefix . 'flight_data';

    if ($wpdb->get_var("SHOW TABLES LIKE '{$table_name}'") != $table_name) {
        $charset_collate = $wpdb->get_charset_collate();

        $sql = "CREATE TABLE $table_name (
            id mediumint(9) NOT NULL AUTO_INCREMENT,
            iata_code varchar(4) NOT NULL,
            icao_code varchar(4) NOT NULL,
            flight_data longtext NOT NULL,
            last_updated datetime DEFAULT CURRENT_TIMESTAMP NOT NULL,
            PRIMARY KEY  (id)
        ) $charset_collate;";

        dbDelta($sql);

        // Guarda un mensaje de éxito en la base de datos para mostrarlo luego
        update_option('mi_plugin_db_message', 'Base de datos Flight_Data creada con éxito.');
    } else {
        // Si la tabla ya existe, también guarda un mensaje
        update_option('mi_plugin_db_message', 'La base de datos Flight_Data ya existe.');
    }
}
register_activation_hook(__FILE__, 'mi_plugin_activate');

function mi_plugin_show_db_message() {
    $message = get_option('mi_plugin_db_message');
    if (!empty($message)) {
        ?>
        <script type="text/javascript">
            console.log('<?php echo esc_js($message); ?>');
        </script>
        <?php
        // Borra el mensaje una vez mostrado para no repetirlo en futuras cargas de página
        delete_option('mi_plugin_db_message');
    }
}
add_action('wp_footer', 'mi_plugin_show_db_message');

add_action('rest_api_init', function () {
    register_rest_route('mi-plugin/v1', '/fetch-flight-data', array(
      'methods' => 'GET',
      'callback' => 'mi_plugin_fetch_flight_data',
      'args' => array(
        'type' => array(
          'required' => true,
          'validate_callback' => function ($param, $request, $key) {
            return in_array($param, ['departures', 'arrivals', 'flight']);
          }
        ),
        'airportCode' => array('required' => false),
        'flight' => array('required' => false),
      ),
      'permission_callback' => '__return_true'
    ));
  });

  function mi_plugin_fetch_flight_data($request) {
    // Recuperar el API Key desde las opciones del plugin
    $apiKey = get_option('mi_plugin_api_key');
    if (!$apiKey) {
      return new WP_Error('api_key_not_set', 'API Key no configurado en el plugin.', ['status' => 500]);
    }
  
    // Recuperar parámetros del request
    $type = $request->get_param('type');
    $airportCode = $request->get_param('airportCode');
    $flight = $request->get_param('flight');
  
    // Determinar el endpoint correcto y los parámetros según el tipo
    $apiUrl = 'https://airlabs.co/api/v9/';
    switch ($type) {
      case 'departures':
        $endpoint = "schedules?dep_iata={$airportCode}&api_key={$apiKey}";
        break;
      case 'arrivals':
        $endpoint = "schedules?arr_iata={$airportCode}&api_key={$apiKey}";
        break;
      case 'flight':
        $endpoint = "flight?flight_iata={$flight}&api_key={$apiKey}";
        break;
      default:
        return new WP_Error('invalid_type', 'El tipo de consulta proporcionado no es válido', ['status' => 400]);
    }
  
    $fullUrl = $apiUrl . $endpoint;
  
    // Realizar la petición al API externo
    $response = wp_remote_get($fullUrl);
    if (is_wp_error($response)) {
      return new WP_Error('api_fetch_error', 'Error al realizar el fetch al API externo.', ['status' => 500]);
    }
  
    // Asumiendo que la respuesta es un JSON
    $body = wp_remote_retrieve_body($response);
    $data = json_decode($body, true);
  
    // Devolver la respuesta
    return new WP_REST_Response($data, 200);
  }
  

function enqueue_react_app_script() {
    wp_enqueue_script('mi-react-app-js', plugins_url('/build/mi-react-app.js', __FILE__), array(), '1.0', true);

    $db_message = get_option('mi_plugin_db_message', 'No hay mensaje disponible');

    $opciones = array(
        'apiKey' => get_option('mi_plugin_api_key'),
        'path' => get_option('mi_plugin_path'),
        'dbMessage' => $db_message, // Agrega el mensaje de la base de datos aquí
    );

    // Pasar todas las opciones al script de React como una variable global
    wp_localize_script('mi-react-app-js', 'phpVars', $opciones);

    // Opcional: borra el mensaje una vez que lo pasas, para no repetirlo
    delete_option('mi_plugin_db_message');
}
add_action('wp_enqueue_scripts', 'enqueue_react_app_script');


 function generar_shortcode_react_app($atts, $content, $tag) {
    // Atributos por defecto
    $atts = shortcode_atts([
        'iata_code' => '',
        'icao_code' => '',
        'size' => '10',
        'flight' => '', // Nuevo parámetro para el shortcode numero-vuelo
    ], $atts);

    // Validación básica
    if (($tag == 'arrivals_app' || $tag == 'departures_app') && empty($atts['iata_code']) && empty($atts['icao_code'])) {
        return "Por favor, incluye al menos el IATA code o el ICAO code del aeropuerto para proceder.";
    }
    // if (empty($atts['iata_code']) && empty($atts['icao_code'])) {
    //     return "Por favor, incluye al menos el IATA code o el ICAO code del aeropuerto para proceder.";
    // }

    $type = $tag == 'departures_app' ? 'departures' : ($tag == 'arrivals_app' ? 'arrivals' : 'flight'); // Nuevo caso para 'vuelo'
    $codeValue = !empty($atts['iata_code']) ? $atts['iata_code'] : $atts['icao_code'];

    // Recuperar los valores guardados en los ajustes del plugin
    $apiKey = get_option('mi_plugin_api_key');
    $path = get_option('mi_plugin_path');

    return "<div class='react-app-container' data-react-app='mi-react-app' data-flight='{$atts['flight']}' data-airport-code='{$codeValue}' data-api-key='{$apiKey}' data-path='{$path}' data-type='{$type}' data-size='{$atts['size']}'></div>";

}

add_shortcode('arrivals_app', 'generar_shortcode_react_app');
add_shortcode('departures_app', 'generar_shortcode_react_app');
add_shortcode('numero-vuelo', 'generar_shortcode_react_app'); // Registrar el nuevo shortcode

// Añadir la página de configuraciones y registrar las opciones
add_action('admin_menu', 'mi_plugin_menu');
function mi_plugin_menu() {
    add_options_page('Configuración del Plugin de Vuelos', 'Vuelos Settings', 'manage_options', 'mi-plugin-settings', 'mi_plugin_settings_page');
}

function mi_plugin_settings_page() {
    ?>
    <div class="wrap">
        <h2>Configuración del Plugin de Vuelos</h2>
        <form method="post" action="options.php">
            <?php
            settings_fields('mi-plugin-settings-group');
            do_settings_sections('mi-plugin-settings');
            submit_button();
            ?>
        </form>
    </div>
    <?php
}

add_action('admin_init', 'mi_plugin_settings_init');
function mi_plugin_settings_init() {
    register_setting('mi-plugin-settings-group', 'mi_plugin_api_key');
    register_setting('mi-plugin-settings-group', 'mi_plugin_path');

    add_settings_section('mi-plugin-settings-section', 'Ajustes del API', 'mi_plugin_settings_section_callback', 'mi-plugin-settings');

    add_settings_field('mi-plugin-api-key', 'API Key de AirLabs', 'mi_plugin_api_key_callback', 'mi-plugin-settings', 'mi-plugin-settings-section');
    add_settings_field('mi-plugin-path', 'Path para Consultas', 'mi_plugin_path_callback', 'mi-plugin-settings', 'mi-plugin-settings-section');
}

function mi_plugin_settings_section_callback() { echo 'Ingresa tu API Key y el Path para las consultas de vuelos.'; }
function mi_plugin_api_key_callback() { $api_key = get_option('mi_plugin_api_key'); echo "<input type='text' id='mi_plugin_api_key' name='mi_plugin_api_key' value='" . esc_attr($api_key) . "' />"; }
function mi_plugin_path_callback() { $path = get_option('mi_plugin_path'); echo "<input type='text' id='mi_plugin_path' name='mi_plugin_path' value='" . esc_attr($path) . "' />"; }

// Añadir el enlace de "Settings" en la página de plugins
function mi_plugin_add_settings_link($links) {
    $settings_link = '<a href="options-general.php?page=mi-plugin-settings">' . __('Settings') . '</a>';
    array_push($links, $settings_link);
    return $links;
}
$plugin = plugin_basename(__FILE__);
add_filter("plugin_action_links_$plugin", 'mi_plugin_add_settings_link');
?>