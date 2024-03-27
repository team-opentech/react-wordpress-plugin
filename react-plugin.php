<?php
/**
 * Plugin Name: Mi Plugin React con AG Grid
 * Description: Muestra cómo integrar React y AG Grid en WordPress y pasar datos dinámicamente a través de un shortcode.
 * Version: 1.0
 * Author: Tu Nombre
 */
defined('ABSPATH') or die('¡Acceso directo no permitido!');
// function enqueue_react_app_script() {
//     wp_enqueue_script('mi-react-app-js', plugins_url('/build/mi-react-app.js', __FILE__), array(), null, true);
// }

// function mi_react_app_shortcode($atts) {
//     static $counter = 0;
//     $counter++;
    
//     $atts = shortcode_atts(array(
//         'iata_code' => 'Default',
//         'type' => 'arrivals',
//         'size' => '10',
//     ), $atts, 'mi_react_app');

//     $unique_id = 'mi-react-app-' . $counter;
//     wp_localize_script('mi-react-app-js', 'miReactAppParams' . $counter, array(
//         'iataCode' => $atts['iata_code'],
//         'type' => $atts['type'],
//         'size' => $atts['size'],
//         'containerId' => $unique_id,
//     ));

//     return "<div id='{$unique_id}'></div>";
// }
// add_shortcode('mi_react_app', 'mi_react_app_shortcode');

function enqueue_react_app_script() {
    wp_enqueue_script('mi-react-app-js', plugins_url('/build/mi-react-app.js', __FILE__), array(), null, true);
}

function mi_react_shortcode($atts) {
    enqueue_react_app_script();
    
    $atts = shortcode_atts(array(
        'iata_code' => 'Default',
        'type' => 'arrivals',
        'size' => '10',
    ), $atts, 'mi_react_app');

    wp_localize_script('mi-react-app-js', 'miReactAppParams', array(
        'iataCode' => $atts['iata_code'],
        'type' => $atts['type'],
        'size' => $atts['size']
    ));

    return "<div id='mi-react-app'></div>"; 
}
add_shortcode('mi_react_app', 'mi_react_shortcode');

// function departure_shortcode($atts) {
//     // enqueue_react_app_script();
    
//     $atts = shortcode_atts(array(
//         'iata_code' => 'Default',
//         'type' => 'departures',
//         'size' => '10',
//     ), $atts, 'departures_app');

//     wp_localize_script('mi-react-app-js', 'miReactAppParams', array(
//         'iataCode' => $atts['iata_code'],
//         'type' => $atts['type'],
//         'size' => $atts['size']
//     ));

//     return "<div id='departures-app'></div>"; 
// }
// add_shortcode('departures_app', 'departure_shortcode');
?>