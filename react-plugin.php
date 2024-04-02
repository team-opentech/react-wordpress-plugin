<?php
/**
 * Plugin Name: Mi Plugin React con AG Grid
 * Description: Muestra cómo integrar React y AG Grid en WordPress y pasar datos dinámicamente a través de un shortcode.
 * Version: 1.0
 * Author: Tu Nombre
 */

 defined('ABSPATH') or die('¡Acceso directo no permitido!');

 function enqueue_react_app_script() {
     wp_enqueue_script('mi-react-app-js', plugins_url('/build/mi-react-app.js', __FILE__), array(), '1.0', true);
     
     $opciones = array(
         'apiKey' => get_option('mi_plugin_api_key'),
         'path' => get_option('mi_plugin_path'),
     );
     wp_localize_script('mi-react-app-js', 'opcionesDelPlugin', $opciones);
 }
 add_action('wp_enqueue_scripts', 'enqueue_react_app_script');
 
 function generar_shortcode_react_app($atts, $content, $tag) {
    $atts = shortcode_atts([
        'iata_code' => '',
        'icao_code' => '',
        'size' => '10',
    ], $atts);

    if (empty($atts['iata_code']) && empty($atts['icao_code'])) {
        return "Por favor, incluye al menos el IATA code o el ICAO code del aeropuerto para proceder.";
    }

        // Recuperar los valores guardados en los ajustes del plugin
        $apiKey = get_option('mi_plugin_api_key');
        $path = get_option('mi_plugin_path');

    $type = ($tag == 'departures_app') ? 'departures' : 'arrivals';
    $codeValue = !empty($atts['iata_code']) ? $atts['iata_code'] : $atts['icao_code'];
    $codeType = !empty($atts['iata_code']) ? 'iata' : 'icao';
    
    return "<div class='react-app-container' data-react-app='mi-react-app' data-airport-code='{$codeValue}' data-api-key='{$apiKey}' data-path='{$path}' data-code-type='{$codeType}' data-type='{$type}' data-size='{$atts['size']}'></div>";
}

 add_shortcode('arrivals_app', 'generar_shortcode_react_app');
 add_shortcode('departures_app', 'generar_shortcode_react_app');

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