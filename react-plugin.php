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
 
     $charset_collate = $wpdb->get_charset_collate();
 
     // Creación de tabla airlines
     $sql_airlines = "CREATE TABLE {$wpdb->prefix}airlines (
         id mediumint(9) NOT NULL AUTO_INCREMENT,
         iata_code varchar(4) NOT NULL,
         icao_code varchar(4) NOT NULL,
         name varchar(255) NOT NULL,
         logo_url varchar(255),
         PRIMARY KEY (id),
         UNIQUE KEY iata_code (iata_code),
         UNIQUE KEY icao_code (icao_code)
     ) $charset_collate;";
     dbDelta($sql_airlines);
 
     // Creación de tabla airports
     $sql_airports = "CREATE TABLE {$wpdb->prefix}airports (
         id mediumint(9) NOT NULL AUTO_INCREMENT,
         iata_code varchar(4) NOT NULL,
         icao_code varchar(4) NOT NULL,
         name varchar(255) NOT NULL,
         city varchar(255) NOT NULL,
         country varchar(255) NOT NULL,
         PRIMARY KEY (id),
         UNIQUE KEY iata_code (iata_code),
         UNIQUE KEY icao_code (icao_code)
     ) $charset_collate;";
     dbDelta($sql_airports);
 
     // Creación de tabla flights
     $sql_flights = "CREATE TABLE {$wpdb->prefix}flights (
      id mediumint(9) NOT NULL AUTO_INCREMENT,
      airline_iata varchar(4),
      flight_iata varchar(10) NOT NULL,
      flight_icao varchar(10),
      flight_number varchar(10),
      status varchar(20),
      dep_iata varchar(4),
      dep_gate varchar(10),
      dep_time_ts bigint,
      dep_delayed int,
      arr_iata varchar(4),
      arr_gate varchar(10),
      arr_time_ts bigint,
      arr_delayed int,
      duration int,
      airline_name varchar(255),
      dep_name varchar(255),
      dep_city varchar(255),
      arr_name varchar(255),
      arr_city varchar(255),
      airline_logo_url varchar(255),
      PRIMARY KEY (id),
      FOREIGN KEY (dep_iata) REFERENCES {$wpdb->prefix}airports(iata_code),
      FOREIGN KEY (arr_iata) REFERENCES {$wpdb->prefix}airports(iata_code),
      FOREIGN KEY (airline_iata) REFERENCES {$wpdb->prefix}airlines(iata_code)
  ) $charset_collate;";
     dbDelta($sql_flights);
 
     // Guarda un mensaje de éxito en la base de datos para mostrarlo luego
     update_option('mi_plugin_db_message', 'Tablas de Mi Plugin React creadas con éxito.');
 }
 register_activation_hook(__FILE__, 'mi_plugin_activate');
 
 function mi_plugin_show_db_message() {
     $message = get_option('mi_plugin_db_message');
     if (!empty($message)) {
         echo "<script type='text/javascript'>console.log('" . esc_js($message) . "');</script>";
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
        'codeType' => array(
          'required' => false,
          'validate_callback' => function ($param, $request, $key) {
            return in_array($param, ['iata', 'icao']);
          }
        )
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
    $codeType = $request->get_param('codeType');

    // Determinar el endpoint correcto y los parámetros según el tipo
    $apiUrl = 'https://airlabs.co/api/v9/';
    $apiImgUrl = 'https://airlabs.co/img/airline/m/';
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
    $data = json_decode(wp_remote_retrieve_body($response), true);
    // Asumiendo que la respuesta es un JSON
    // $body = wp_remote_retrieve_body($response);
    // $data = json_decode($body, true);

    if ($type === 'flight' && !empty($data)) {

      $flightDetails = [
        'airlineLogo' =>  isset($data['response']['airline_iata']) ? $apiImgUrl . $data['response']['airline_iata'] . ".png" : '',
        'flightIata' => $data['response']['flight_iata'],
        'flightIcao' => $data['response']['flight_icao'],
        'flightNumber' => $data['response']['flight_number'],
        'status' => $data['response']['status'],
        'depIata' => $data['response']['dep_iata'],
        'depGate' => $data['response']['dep_gate'],
        'depTimeTs' => $data['response']['dep_time_ts'],
        'depDelayed' => $data['response']['dep_delayed'],
        'arrIata' => $data['response']['arr_iata'],
        'arrGate' => $data['response']['arr_gate'],
        'arrTimeTs' => $data['response']['arr_time_ts'],
        'arrDelayed' => $data['response']['arr_delayed'],
        'duration' => $data['response']['duration'],
        'airlineName' => $data['response']['airline_name'],
        'depAirportName' => $data['response']['dep_name'],
        'depCity' => $data['response']['dep_city'],
        'arrAirportName' => $data['response']['arr_name'],
        'arrCity' => $data['response']['arr_city']
    ];
    return new WP_REST_Response($flightDetails, 200);
        // Extraer valores
        // $airlineIata = $data['airline_iata'] ?? '';
        // $depIata = $data['dep_iata'] ?? '';
        // $arrIata = $data['arr_iata'] ?? '';

        // Realizar consultas adicionales para airline_iata, dep_iata, y arr_iata
        // $airlineData = wp_remote_get("https://airlabs.co/api/v9/airlines?iata_code={$airlineIata}&api_key={$apiKey}");
        // $depAirportData = wp_remote_get("https://airlabs.co/api/v9/airports?iata_code={$depIata}&api_key={$apiKey}");
        // $arrAirportData = wp_remote_get("https://airlabs.co/api/v9/airports?iata_code={$arrIata}&api_key={$apiKey}");

        // Asumiendo que las respuestas son JSONs
        // $airlineDataBody = wp_remote_retrieve_body($airlineData);
        // $depAirportDataBody = wp_remote_retrieve_body($depAirportData);
        // $arrAirportDataBody = wp_remote_retrieve_body($arrAirportData);

        // Agregar información adicional al response
        // $data['airline_info'] = json_decode($airlineDataBody, true);
        // $data['dep_airport_info'] = json_decode($depAirportDataBody, true);
        // $data['arr_airport_info'] = json_decode($arrAirportDataBody, true);
    }
    else if($type === 'departures' || $type === 'arrivals'){
      $flightsData = [];
      foreach ($data['response'] as $flight) {
          // Inicializa variables para evitar errores de variables indefinidas
          $flightIata = '';
          $airport = '';
          
          if ($type === 'departures' && isset($flight['arr_iata'])) {
              $flightIata = $flight['arr_iata'];
              $airportData = wp_remote_get("https://airlabs.co/api/v9/airports?iata_code={$flightIata}&api_key={$apiKey}");
              $airport = json_decode(wp_remote_retrieve_body($airportData), true)['response'][0]['name'];
          } elseif ($type === 'arrivals' && isset($flight['dep_iata'])) {
              $flightIata = $flight['dep_iata'];
              $airportData = wp_remote_get("https://airlabs.co/api/v9/airports?iata_code={$flightIata}&api_key={$apiKey}");
              $airport = json_decode(wp_remote_retrieve_body($airportData), true)['response'][0]['name'];
          }

          // Opcionalmente, realiza una petición al API externo para obtener el nombre del aeropuerto
          // Asegúrate de que $flightIata no esté vacío antes de hacer la petición
  
          $flightsData[] = [
              'flight' => isset($flight['flight_iata']) ? $flight['flight_iata'] : '',
              'airport' => $airport, // Asegúrate de que esta variable tenga el nombre del aeropuerto
              'depart' => isset($flight['dep_time']) ? $flight['dep_time'] : '',
              'arrive' => isset($flight['arr_time']) ? $flight['arr_time'] : '',
          ];
      }
      return new WP_REST_Response($flightsData, 200);
  }

    // Devolver la respuesta
    // return new WP_REST_Response($data['response'], 200);
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
    $codeType = !empty($atts['iata_code']) ? 'iata' : 'icao';

    // Recuperar los valores guardados en los ajustes del plugin
    $apiKey = get_option('mi_plugin_api_key');
    $path = get_option('mi_plugin_path');

    return "<div class='react-app-container' data-react-app='mi-react-app' data-flight='{$atts['flight']}' data-airport-code='{$codeValue}' data-code-type='{$codeType}' data-api-key='{$apiKey}' data-path='{$path}' data-type='{$type}' data-size='{$atts['size']}'></div>";

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