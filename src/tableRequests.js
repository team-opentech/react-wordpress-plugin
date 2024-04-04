import axios from "axios";

const AIRLABS_API_KEY = 'e3d4bf45-f8f2-44f4-a1fd-f18da01fa931';

export async function getArrivals(airportCode) {
  // console.log("airport code", airportCode);
  try {
    const response = await axios.get(`https://airlabs.co/api/v9/schedules?arr_iata=${airportCode}&api_key=${AIRLABS_API_KEY}`);
    
    if (!Array.isArray(response.data.response)) {
      throw new Error('Unexpected data format from API');
    }

    const data = response.data.response.map(items => ({
      time: items.arr_time,
      flight: items.flight_iata,
      from: items.dep_iata,
      airline: items.airline_iata,
      status: items.status
    }));
    
    return data;
  } catch (error) {
    console.error('Error al obtener datos:', error);
    throw error;
  }
}

export async function getDepartures(airportCode) {
  try {
    const response = await axios.get(`https://airlabs.co/api/v9/schedules?dep_iata=${airportCode}&api_key=${AIRLABS_API_KEY}`);
    
    if (!Array.isArray(response.data.response)) {
      throw new Error('Unexpected data format from API');
    }

    const data = response.data.response.map(items => ({
      time: items.dep_time,
      flight: items.flight_iata,
      from: items.arr_iata,
      airline: items.airline_iata,
      status: items.status
    }));
    
    return data;
  } catch (error) {
    console.error('Error al obtener datos:', error);
    throw error;
  }
}
