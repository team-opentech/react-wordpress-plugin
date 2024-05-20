import axios from 'axios';

const BASE_URL = "https://airlabs.co/api/v9";
const AIRLINE_LOGO_BASE_URL = "https://airlabs.co/img/airline/m";

const getFlightData = async (flightCode, apiKey) => {
  const apiInstance = axios.create({
    baseURL: BASE_URL,
    params: {
      api_key: apiKey,
    },
  });
  try {
    const response = await apiInstance.get("/flight", {
      params: { flight_iata: flightCode },
    });
    const data = response.data.response;
    if (!data) {
      throw new Error("Unexpected data format from API");
    }
    return response.data;
  } catch (error) {
    throw new Error(`Failed to fetch flight data: ${error}`);
  }
};
const fetchIataDetails = async (endpoint, code, apiKey) => {
  if (!code) {
    throw new Error(`IATA code is missing for ${endpoint}`);
  }
  const apiInstance = axios.create({
    baseURL: BASE_URL,
    params: {
      api_key: apiKey,
    },
  });

  try {
    const response = await apiInstance.get(endpoint, {
      params: { iata_code: code },
    });
    return response.data.response[0];
  } catch (error) {
    throw new Error(`Failed to fetch data from ${endpoint}: ${error}`);
  }
};

const createFlightCardInfo = (flightData) => {
  const details = flightData.response;
  return {
    airlineLogo: `${AIRLINE_LOGO_BASE_URL}/${details.airline_iata}.png`,
    flightIata: details.flight_iata,
    flightIcao: details.flight_icao,
    flightNumber: details.flight_number,
    status: details.status,
    depIata: details.dep_iata,
    depGate: details.dep_gate,
    depTimeTs: details.dep_time_ts,
    depDelayed: details.dep_delayed,
    arrIata: details.arr_iata,
    arrGate: details.arr_gate,
    arrTimeTs: details.arr_time_ts,
    arrDelayed: details.arr_delayed,
    duration: details.duration,
    airlineName: null,
    depAirportName: null,
    depCity: null,
    arrAirportName: null,
    arrCity: null,
  };
};

export async function getFlightCardInfo(flightCode, apiKey) {
  try {
    const flightData = await getFlightData(flightCode, apiKey);
    // console.log("Flight data service function:", flightData);

    const [airlineDetails, departureDetails, arrivalDetails] =
      await Promise.all([
        fetchIataDetails("/airlines", flightData.response.airline_iata, apiKey),
        fetchIataDetails("/airports", flightData.response.dep_iata, apiKey),
        fetchIataDetails("/airports", flightData.response.arr_iata, apiKey),
      ]);

    const flightCardInfo = createFlightCardInfo(flightData);
    flightCardInfo.airlineName = airlineDetails.name || null;
    flightCardInfo.depAirportName = departureDetails.name || null;
    flightCardInfo.depCity = departureDetails.city || null;
    flightCardInfo.arrAirportName = arrivalDetails.name || null;
    flightCardInfo.arrCity = arrivalDetails.city || null;

    return flightCardInfo;
  } catch (error) {
    console.error("Error while fetching flight card info:", error);
    throw error;
  }
}
// function mi_plugin_fetch_flight_data($request) {
//   // Recuperar el API Key desde las opciones del plugin
//   $apiKey = get_option('mi_plugin_api_key');
//   if (!$apiKey) {
//       return new WP_Error('api_key_not_set', 'API Key no configurado en el plugin.', ['status' => 500]);
//   }

//   // Recuperar parámetros del request
//   $type = $request->get_param('type');
//   $airportCode = $request->get_param('airportCode');
//   $flight = $request->get_param('flight');
//   $codeType = $request->get_param('codeType');

//   // Determinar el endpoint correcto y los parámetros según el tipo
//   $apiUrl = 'https://airlabs.co/api/v9/';
//   $apiImgUrl = 'https://airlabs.co/img/airline/m/';
//   switch ($type) {
//     case 'departures':
//       $endpoint = "schedules?dep_{$codeType}={$airportCode}&api_key={$apiKey}";
//       break;
//     case 'arrivals':
//       $endpoint = "schedules?arr_{$codeType}={$airportCode}&api_key={$apiKey}";
//       break;
//     case 'flight':
//       $endpoint = "flight?flight_{$codeType}={$flight}&api_key={$apiKey}";
//       break;
//     default:
//       return new WP_Error('invalid_type', 'El tipo de consulta proporcionado no es válido', ['status' => 400]);
//   }

//   $fullUrl = $apiUrl . $endpoint;

//   // Realizar la petición al API externo
//   $response = wp_remote_get($fullUrl);
//   if (is_wp_error($response)) {
//       return new WP_Error('api_fetch_error', 'Error al realizar el fetch al API externo.', ['status' => 500]);
//   }
//   $data = json_decode(wp_remote_retrieve_body($response), true);
//   // Asumiendo que la respuesta es un JSON
//   // $body = wp_remote_retrieve_body($response);
//   // $data = json_decode($body, true);

//   if ($type === 'flight' && !empty($data)) {

//     $flightDetails = [
//       'airlineLogo' =>  isset($data['response'][0]['airline_iata']) ? $apiImgUrl . $data['response'][0]['airline_iata'] . ".png" : '',
//       'flightIata' => $data['response'][0]['flight_iata'],
//       'flightIcao' => $data['response'][0]['flight_icao'],
//       'flightNumber' => $data['response'][0]['flight_number'],
//       'status' => $data['response'][0]['status'],
//       'depIata' => $data['response'][0]['dep_iata'],
//       'depGate' => $data['response'][0]['dep_gate'],
//       'depTimeTs' => $data['response'][0]['dep_time_ts'],
//       'depDelayed' => $data['response'][0]['dep_delayed'],
//       'arrIata' => $data['response'][0]['arr_iata'],
//       'arrGate' => $data['response'][0]['arr_gate'],
//       'arrTimeTs' => $data['response'][0]['arr_time_ts'],
//       'arrDelayed' => $data['response'][0]['arr_delayed'],
//       'duration' => $data['response'][0]['duration'],
//       'airlineName' => $data['response'][0]['airline_name'],
//       'depAirportName' => $data['response'][0]['dep_name'],
//       'depCity' => $data['response'][0]['dep_city'],
//       'arrAirportName' => $data['response'][0]['arr_name'],
//       'arrCity' => $data['response'][0]['arr_city']
//   ];
//   return new WP_REST_Response($flightDetails, 200);
//       // Extraer valores
//       // $airlineIata = $data['airline_iata'] ?? '';
//       // $depIata = $data['dep_iata'] ?? '';
//       // $arrIata = $data['arr_iata'] ?? '';

//       // Realizar consultas adicionales para airline_iata, dep_iata, y arr_iata
//       // $airlineData = wp_remote_get("https://airlabs.co/api/v9/airlines?iata_code={$airlineIata}&api_key={$apiKey}");
//       // $depAirportData = wp_remote_get("https://airlabs.co/api/v9/airports?iata_code={$depIata}&api_key={$apiKey}");
//       // $arrAirportData = wp_remote_get("https://airlabs.co/api/v9/airports?iata_code={$arrIata}&api_key={$apiKey}");

//       // Asumiendo que las respuestas son JSONs
//       // $airlineDataBody = wp_remote_retrieve_body($airlineData);
//       // $depAirportDataBody = wp_remote_retrieve_body($depAirportData);
//       // $arrAirportDataBody = wp_remote_retrieve_body($arrAirportData);

//       // Agregar información adicional al response
//       // $data['airline_info'] = json_decode($airlineDataBody, true);
//       // $data['dep_airport_info'] = json_decode($depAirportDataBody, true);
//       // $data['arr_airport_info'] = json_decode($arrAirportDataBody, true);
//   }else if($type === 'departures' || $type === 'arrivals'){
//     $flightsData = [];
//     foreach ($data['response'][0] as $flight) {
//       switch ($type) {
//         case 'departures':
//           $airportData = wp_remote_get("https://airlabs.co/api/v9/airports?iata_code={$flight['arr_iata']}&api_key={$apiKey}");
//           break;
//         case 'arrivals':
//           $airportData = wp_remote_get("https://airlabs.co/api/v9/airports?iata_code={$flight['dep_iata']}&api_key={$apiKey}");
//           break;
//       }
//       $flightsData[] = [
//         'flight' => $flight['flight_iata'],
//         'airport' => json_decode(wp_remote_retrieve_body($airportData), true)['response'][0][0]['name'],
//         'depart' => $flight['dep_time'],
//         'arrive' => $flight['arr_time'],
//       ];
//     }
//     return new WP_REST_Response($flightsData, 200);
//   }

//   // Devolver la respuesta
//   // return new WP_REST_Response($data['response'], 200);
// }