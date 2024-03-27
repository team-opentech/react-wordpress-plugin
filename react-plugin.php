<?php
/**
 * Plugin Name: Mi Plugin React con AG Grid
 * Description: Muestra cómo integrar React y AG Grid en WordPress y pasar datos dinámicamente a través de un shortcode.
 * Version: 1.0
 * Author: Tu Nombre
 */
defined('ABSPATH') or die('¡Acceso directo no permitido!');

function enqueue_react_app_script() {
    // Asegúrate de ajustar la ruta al script de React según tu estructura de archivos
    wp_enqueue_script('mi-react-app-js', plugins_url('/build/mi-react-app.js', __FILE__), array(), '1.0', true);
}
add_action('wp_enqueue_scripts', 'enqueue_react_app_script');

function generar_shortcode_react_app($atts, $content, $tag) {
    $atts = shortcode_atts([
        'iata_code' => 'JFK',
        'size' => '10',
    ], $atts);

    // Determina el tipo basado en el nombre del shortcode
    $type = ($tag == 'departures_app') ? 'departures' : 'arrivals';
    
    // Devuelve el contenedor de la aplicación React con los data attributes necesarios
    return "<div class='react-app-container' data-react-app='mi-react-app' data-iata-code='{$atts['iata_code']}' data-type='{$type}' data-size='{$atts['size']}'></div>";
}

// Registra los shortcodes
add_shortcode('arrivals_app', 'generar_shortcode_react_app');
add_shortcode('departures_app', 'generar_shortcode_react_app');
?>