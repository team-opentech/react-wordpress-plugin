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

    // Creación o actualización de la tabla airlines
    $sql_airlines = "CREATE TABLE {$wpdb->prefix}airlines (
        iata_code varchar(3) NOT NULL,
        icao_code varchar(4) DEFAULT '',
        name varchar(255) NOT NULL,
        logo_url varchar(255) DEFAULT '',
        PRIMARY KEY (iata_code)
    ) $charset_collate;";
    dbDelta($sql_airlines);

    // Creación o actualización de la tabla airports
    $sql_airports = "CREATE TABLE {$wpdb->prefix}airports (
        iata_code varchar(3) NOT NULL,
        icao_code varchar(4) DEFAULT '',
        name varchar(255) NOT NULL,
        city varchar(255) DEFAULT '',
        country varchar(255) DEFAULT '',
        PRIMARY KEY (iata_code)
    ) $charset_collate;";
    dbDelta($sql_airports);

    // Creación o actualización de la tabla flights
    $sql_flights = "CREATE TABLE {$wpdb->prefix}flights (
        flight_iata varchar(7) NOT NULL,
        flight_icao varchar(8) DEFAULT '',
        airline_iata varchar(3) NOT NULL,
        dep_iata varchar(3) NOT NULL,
        arr_iata varchar(3) NOT NULL,
        dep_time_ts bigint DEFAULT 0,
        arr_time_ts bigint DEFAULT 0,
        status varchar(20) DEFAULT '',
        flight_number varchar(10) DEFAULT '',
        dep_gate varchar(10) DEFAULT '',
        arr_gate varchar(10) DEFAULT '',
        dep_delayed int DEFAULT 0,
        arr_delayed int DEFAULT 0,
        duration int DEFAULT 0,
        PRIMARY KEY (flight_iata)
    ) $charset_collate;";
    dbDelta($sql_flights);

    $sql_schedules = "CREATE TABLE {$wpdb->prefix}schedules (
        id bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
        iata_code varchar(3) NOT NULL,
        type enum('departure', 'arrival') NOT NULL,
        date date NOT NULL,
        updated_time datetime NOT NULL DEFAULT current_timestamp(),
        PRIMARY KEY (id),
        UNIQUE KEY idx_iata_type (iata_code, type)
    ) $charset_collate;";
    dbDelta($sql_schedules);

    $sql_schedule_details = "CREATE TABLE {$wpdb->prefix}schedule_details (
        id bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
        schedule_id bigint(20) UNSIGNED NOT NULL,
        flight_iata varchar(7) NOT NULL,
        airport varchar(255) NOT NULL,
        depart bigint(20) DEFAULT NULL,
        arrive bigint(20) DEFAULT NULL,
        PRIMARY KEY (id),
        FOREIGN KEY (schedule_id) REFERENCES {$wpdb->prefix}schedules(id) ON DELETE CASCADE
    ) $charset_collate;";
    dbDelta($sql_schedule_details);
    // $sql_schedule_details = "CREATE TABLE {$wpdb->prefix}schedule_details (
    //     id bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
    //     schedule_id bigint(20) UNSIGNED NOT NULL,
    //     flight_iata varchar(7) NOT NULL,
    //     airport varchar(255) NOT NULL,
    //     depart bigint(20) DEFAULT NULL,
    //     arrive bigint(20) DEFAULT NULL,
    //     PRIMARY KEY (id)
    // ) $charset_collate;";
    // dbDelta($sql_schedule_details);

    // Intenta cargar datos JSON de aeropuertos
    $json_data = file_get_contents(plugin_dir_path(__FILE__) . 'airports.json');
    if ($json_data === false) {
        error_log('Error al leer el archivo de aeropuertos');
        return;
    }

    $airports = json_decode($json_data, true);
    if (!is_array($airports) || !isset($airports['response'])) {
        error_log('Error al decodificar el archivo JSON de aeropuertos o la clave \'response\' no está presente');
        return;
    }

    $airports_table = $wpdb->prefix . 'airports';
    foreach ($airports['response'] as $airport) {
        $result = $wpdb->insert(
            $airports_table,
            [
                'name' => $airport['name'],
                'iata_code' => $airport['iata_code'],
                'icao_code' => $airport['icao_code'],
                'lat' => $airport['lat'],
                'lng' => $airport['lng'],
                'country' => $airport['country_code']
            ],
            ['%s', '%s', '%s', '%f', '%f', '%s']
        );
        if ($result === false) {
            error_log('Error al insertar aeropuerto: ' . $wpdb->last_error);
        }
    }

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
    global $wpdb;
    $apiKey = get_option('mi_plugin_api_key');
    if (!$apiKey) {
        return new WP_Error('api_key_not_set', 'API Key no configurado en el plugin.', ['status' => 500]);
    }

    $type = $request->get_param('type');
    $airportCode = $request->get_param('airportCode');
    $flight = $request->get_param('flight');
    $codeType = $request->get_param('codeType');

    // Tablas de la base de datos
    $flights_table = $wpdb->prefix . 'flights';
    $airports_table = $wpdb->prefix . 'airports';
    $airlines_table = $wpdb->prefix . 'airlines';

    $apiUrl = 'https://airlabs.co/api/v9/';
    $apiImgUrl = 'https://airlabs.co/img/airline/m/';
    // $apiImgUrl = "";
    // Dependiendo del tipo de consulta, se define la lógica
    switch ($type) {
        case 'flight':
            // Buscar en la base de datos por flight_iata
            $flightData = $wpdb->get_row($wpdb->prepare(
                "SELECT * FROM {$flights_table} WHERE flight_iata = %s",
                $flight
            ), ARRAY_A);

            if ($flightData) {
                // Si los datos existen en la base de datos
                $airlineData = $wpdb->get_row($wpdb->prepare(
                    "SELECT name, logo_url FROM {$airlines_table} WHERE iata_code = %s", 
                    $flightData['airline_iata']
                ), ARRAY_A);

                if(!$airlineData && $flightData['airline_iata'] !== '') {
                    $response = wp_remote_get("{$apiUrl}airlines?iata_code={$flightData['airline_iata']}&api_key={$apiKey}");
                    if (!is_wp_error($response) && wp_remote_retrieve_response_code($response) == 200) {
                        $data = json_decode(wp_remote_retrieve_body($response), true);
                        if (!empty($data['response'])) {
                            $airlineData = $data['response'][0];
                            $wpdb->replace(
                                $airlines_table,
                                [
                                    'iata_code' => $airlineData['iata_code'],
                                    'icao_code' => $airlineData['icao_code'],
                                    'name' => $airlineData['name'],
                                    'logo_url' => "{$apiImgUrl}{$airlineData['iata_code']}.png",
                                ],
                                ['%s', '%s', '%s', '%s']
                            );
                        }
                    }                    
                }
                
                $depAirportData = $wpdb->get_row($wpdb->prepare(
                    "SELECT name, city FROM {$airports_table} WHERE iata_code = %s", 
                    $flightData['dep_iata']
                ), ARRAY_A);

                if(!$depAirportData && $flightData['dep_iata'] !== '') {
                    $response = wp_remote_get("{$apiUrl}airports?iata_code={$flightData['dep_iata']}&api_key={$apiKey}");
                    if (!is_wp_error($response) && wp_remote_retrieve_response_code($response) == 200) {
                        $data = json_decode(wp_remote_retrieve_body($response), true);
                        if (!empty($data['response'])) {
                            $depAirportData = $data['response'][0];
                            $wpdb->replace(
                                $airports_table,
                                [
                                    'iata_code' => $depAirportData['iata_code'],
                                    'icao_code' => $depAirportData['icao_code'],
                                    'name' => $depAirportData['name'],
                                    'city' => $flightData['city'],
                                    'country' => $depAirportData['country'],
                                ],
                                ['%s', '%s', '%s', '%s', '%s',]
                            );
                        }
                    }
                }
                
                $arrAirportData = $wpdb->get_row($wpdb->prepare(
                    "SELECT name, city FROM {$airports_table} WHERE iata_code = %s", 
                    $flightData['arr_iata']
                ), ARRAY_A);

                if(!$arrAirportData && $flightData['arr_iata'] !== '') {
                    $response = wp_remote_get("{$apiUrl}airports?iata_code={$flightData['arr_iata']}&api_key={$apiKey}");
                    if (!is_wp_error($response) && wp_remote_retrieve_response_code($response) == 200) {
                        $data = json_decode(wp_remote_retrieve_body($response), true);
                        if (!empty($data['response'])) {
                            $arrAirportData = $data['response'][0];
                            $wpdb->replace(
                                $airports_table,
                                [
                                    'iata_code' => $arrAirportData['iata_code'],
                                    'icao_code' => $arrAirportData['icao_code'],
                                    'name' => $arrAirportData['name'],
                                    'city' => $arrAirportData['city'],
                                    'country' => $arrAirportData['country'],
                                ],
                                ['%s', '%s', '%s', '%s', '%s',]
                            );
                        }
                    }
                }

                $response = [
                    'airlineLogo' => "{$apiImgUrl}{$flightData['airline_iata']}.png",
                    'flightIata' => $flightData['flight_iata'],
                    'flightIcao' => $flightData['flight_icao'],
                    'flightNumber' => $flightData['flight_number'],
                    'status' => $flightData['status'],
                    'depIata' => $flightData['dep_iata'],
                    'depGate' => $flightData['dep_gate'],
                    'depTimeTs' => $flightData['dep_time_ts'],
                    'depDelayed' => $flightData['dep_delayed'],
                    'arrIata' => $flightData['arr_iata'],
                    'arrGate' => $flightData['arr_gate'],
                    'arrTimeTs' => $flightData['arr_time_ts'],
                    'arrDelayed' => $flightData['arr_delayed'],
                    'duration' => $flightData['duration'],
                    'airlineName' => $airlineData['name'],
                    'depAirportName' => $depAirportData['name'],
                    'depCity' => $depAirportData['city'],
                    'arrAirportName' => $arrAirportData['name'],
                    'arrCity' => $arrAirportData['city'],
                ];
                return new WP_REST_Response($response, 200);
            } else {
                // Si no existen en la base, consulta la API y guarda los resultados
                $fullUrl = "https://airlabs.co/api/v9/flight?flight_iata={$flight}&api_key={$apiKey}";
                // $fullUrl = "";
                $response = wp_remote_get($fullUrl);
                if (is_wp_error($response)) {
                    return new WP_Error('api_fetch_error', 'Error al realizar el fetch al API externo.', ['status' => 500]);
                }
                $data = json_decode(wp_remote_retrieve_body($response), true);
                if (isset($data['response'])) {
                    $flightData = $data['response'];
                    $airlineLogoUrl = "{$apiImgUrl}{$flightData['airline_iata']}.png";

                    $wpdb->replace(
                        $airlines_table,
                        [
                            'iata_code' => $flightData['airline_iata'],
                            'icao_code' => $flightData['airline_icao'],
                            'name' => $flightData['airline_name'],
                            'logo_url' => $airlineLogoUrl,
                        ],
                        ['%s', '%s', '%s', '%s']
                    );

                    $wpdb->replace(
                        $airports_table,
                        [
                            'iata_code' => $flightData['dep_iata'],
                            'icao_code' => $flightData['dep_icao'],
                            'name' => $flightData['dep_name'],
                            'city' => $flightData['dep_city'],
                            'country' => $flightData['dep_country'],
                        ],
                        ['%s', '%s', '%s', '%s', '%s']
                    );

                    $wpdb->replace(
                        $airports_table,
                        [
                            'iata_code' => $flightData['arr_iata'],
                            'icao_code' => $flightData['arr_icao'],
                            'name' => $flightData['arr_name'],
                            'city' => $flightData['arr_city'],
                            'country' => $flightData['arr_country'],
                        ],
                        ['%s', '%s', '%s', '%s', '%s']
                    );

                    $wpdb->replace(
                        $flights_table,
                        [
                            'flight_iata' => $flightData['flight_iata'],
                            'flight_icao' => $flightData['flight_icao'],
                            'flight_number' => $flightData['flight_number'],
                            'airline_iata' => $flightData['airline_iata'],
                            'status' => $flightData['status'],
                            'dep_iata' => $flightData['dep_iata'],
                            'dep_gate' => $flightData['dep_gate'],
                            'dep_time_ts' => $flightData['dep_time_ts'],
                            'dep_delayed' => $flightData['dep_delayed'],
                            'arr_iata' => $flightData['arr_iata'],
                            'arr_gate' => $flightData['arr_gate'],
                            'arr_time_ts' => $flightData['arr_time_ts'],
                            'arr_delayed' => $flightData['arr_delayed'],
                            'duration' => $flightData['duration'],
                        ],
                        ['%s','%s','%s','%s','%s','%s','%s','%d','%d','%s','%s','%d','%d','%d',]
                    );
                    
                    $formatedData = [
                        'airlineLogo' => $airlineLogoUrl,
                        'flightIata' => $flightData['flight_iata'],
                        'flightIcao' => $flightData['flight_icao'],
                        'flightNumber' => $flightData['flight_number'],
                        'status' => $flightData['status'],
                        'depIata' => $flightData['dep_iata'],
                        'depGate' => $flightData['dep_gate'],
                        'depTimeTs' => $flightData['dep_time_ts'],
                        'depDelayed' => $flightData['dep_delayed'],
                        'arrIata' => $flightData['arr_iata'],
                        'arrGate' => $flightData['arr_gate'],
                        'arrTimeTs' => $flightData['arr_time_ts'],
                        'arrDelayed' => $flightData['arr_delayed'],
                        'duration' => $flightData['duration'],
                        'airlineName' => $flightData['airline_name'],
                        'depAirportName' => $flightData['dep_name'],
                        'depCity' => $flightData['dep_city'],
                        'arrAirportName' => $flightData['arr_name'],
                        'arrCity' => $flightData['arr_city'],
                    ];
                    return new WP_REST_Response($formatedData, 200);
                }
            }
            break;
            case 'departures':
                case 'arrivals':
                    $isDepartures = $type === 'departures';
                    $scheduleType = $isDepartures ? 'departure' : 'arrival';
                    
                    // Buscar en la tabla schedules
                    $schedule = $wpdb->get_row($wpdb->prepare(
                        "SELECT id FROM {$wpdb->prefix}schedules 
                        WHERE iata_code = %s AND type = %s", 
                        $airportCode, $scheduleType
                    ), ARRAY_A);
                    
                    if ($schedule) {
                        // Buscar detalles asociados en schedule_details
                        $flightDetails = $wpdb->get_results($wpdb->prepare(
                            "SELECT * FROM {$wpdb->prefix}schedule_details WHERE schedule_id = %d", 
                            $schedule['id']
                        ), ARRAY_A);
                        
                        if (!empty($flightDetails)) {
                            // Formatear los detalles del vuelo para la respuesta
                            $formattedFlights = array_map(function ($flight) {
                                return [
                                    'flight' => $flight['flight_iata'],
                                    'airport' => $flight['airport'],
                                    'depart' => $flight['depart'],
                                    'arrive' => $flight['arrive'],
                                ];
                            }, $flightDetails);
                    
                            return new WP_REST_Response($formattedFlights, 200);
                        } else {
                            return new WP_REST_Response(['message' => 'No flight details available'], 404);
                        }
                    }
                
                    // Si no hay información reciente, consulta al API de Airlabs
                    $endpointUrl = $isDepartures? "https://airlabs.co/api/v9/schedules?dep_iata={$airportCode}&api_key={$apiKey}" : "https://airlabs.co/api/v9/schedules?arr_iata={$airportCode}&api_key={$apiKey}";
                    $logPath = plugin_dir_path(__FILE__) . 'debug.log'; // Asegúrate de que el directorio tiene permisos de escritura.
                    // error_log($endpointUrl . "\n", 3, $logPath);
                    
                    $apiResponse = wp_remote_get($endpointUrl);
                
                    if (is_wp_error($apiResponse)) {
                        return new WP_Error('api_fetch_error', 'Error al obtener datos del API de Airlabs.', ['status' => 500]);
                    }
                
                    $schedulesData = json_decode(wp_remote_retrieve_body($apiResponse), true);
                    // error_log($schedulesData['response'] . "\n", 3, $logPath);

                    if (isset($schedulesData['response']) && !empty($schedulesData['response'])) {
                        // Identificar o insertar en la tabla schedules
                        
                        if (!$scheduleId = $wpdb->get_var($wpdb->prepare("SELECT id FROM {$wpdb->prefix}schedules WHERE iata_code = %s AND type = %s", $airportCode, $scheduleType))) {
                            $wpdb->insert(
                                "{$wpdb->prefix}schedules",
                                [
                                    'iata_code' => $airportCode,
                                    'type' => $scheduleType,
                                    'date' => current_time('mysql', 1),
                                    'updated_time' => current_time('mysql', 1)
                                ],
                                ['%s', '%s', '%s', '%s']
                            );
                            $scheduleId = $wpdb->insert_id;
                        } else {
                            $wpdb->update(
                                "{$wpdb->prefix}schedules",
                                ['updated_time' => current_time('mysql', 1)],
                                ['id' => $scheduleId],
                                ['%s'],
                                ['%d']
                            );
                        }
                    
                        // Procesar cada vuelo obtenido del API
                        $formattedFlights = [];

                        foreach ($schedulesData['response'] as $flightData) {
                            $airportCodeToCheck = $isDepartures ? $flightData['arr_iata'] : $flightData['dep_iata'];
                            $airportName = $wpdb->get_var($wpdb->prepare(
                                "SELECT name FROM {$wpdb->prefix}airports WHERE iata_code = %s",
                                $airportCodeToCheck
                            ));

                            // Intentar insertar en la tabla schedule_details
                            $insert_result = $wpdb->insert(
                                "{$wpdb->prefix}schedule_details",
                                [
                                    'schedule_id' => $scheduleId,
                                    'flight_iata' => $flightData['flight_iata'],
                                    'airport' => $airportName,
                                    'depart' => $flightData['dep_time_ts'],
                                    'arrive' => $flightData['arr_time_ts'],
                                ],
                                ['%d', '%s', '%s', '%d', '%d']
                            );

                            if ($insert_result !== false) {
                                $formattedFlights[] = [
                                    'flight' => $flightData['flight_iata'],
                                    'airport' => $airportName,
                                    'depart' => $flightData['dep_time_ts'],
                                    'arrive' => $flightData['arr_time_ts'],
                                ];
                            } else {
                                error_log('Error al insertar en schedule_details: ' . $wpdb->last_error);
                            }
                        }

                        return new WP_REST_Response($formattedFlights, 200);

                        // foreach ($schedulesData['response'] as $flightData) {

                        //     $airportCodeToCheck = $isDepartures ? $flightData['arr_iata'] : $flightData['dep_iata'];

                        //     $airportName = $wpdb->get_var($wpdb->prepare(
                        //         "SELECT name FROM {$wpdb->prefix}airports WHERE iata_code = %s",
                        //         $airportCodeToCheck
                        //     ));
                    
                        //     // Insertar en la tabla schedule_details
                        //     $wpdb->insert(
                        //         "{$wpdb->prefix}schedule_details",
                        //         [
                        //             'schedule_id' => $scheduleId,
                        //             'flight_iata' => $flightData['flight_iata'],
                        //             'airport' => $airportName,
                        //             'depart' => $flightData['dep_time_ts'],
                        //             'arrive' => $flightData['arr_time_ts'],
                        //         ],
                        //         ['%d', '%s', '%s', '%d', '%d']
                        //     );
                        //     if ($insert_result === false) {
                        //         error_log('Error al insertar en schedule_details: ' . $wpdb->last_error);
                        //     }
                            
                        // }
                        
                        // $formattedFlights = array_map(function ($flight) use ($wpdb, $isDepartures) {
                        //     // Determinar el código IATA correcto para buscar el nombre del aeropuerto
                        //     $airportCode = $isDepartures ? $flight['arr_iata'] : $flight['dep_iata'];
                                
                        //     // Buscar el nombre del aeropuerto en la tabla airports
                        //     $airportName = $wpdb->get_var($wpdb->prepare(
                        //         "SELECT name FROM {$wpdb->prefix}airports WHERE iata_code = %s",
                        //            $airportCode
                        //     ));
                        
                        //     return [
                        //         'flight' => $flight['flight_iata'],
                        //         'airport' => $airportName,
                        //         'depart' => $flight['dep_time_ts'],
                        //         'arrive' => $flight['arr_time_ts'],
                        //     ];
                        // }, $schedulesData['response']);

                        // return new WP_REST_Response($formattedFlights, 200);
                    }
                     else {
                        return new WP_Error('no_data_found', 'No se encontraron datos para los parámetros especificados.', ['status' => 404]);
                    }
                
                    break;
        default:
            return new WP_Error('invalid_request', 'Tipo de solicitud no válida.', ['status' => 400]);
    }
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