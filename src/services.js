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
