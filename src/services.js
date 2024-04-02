// Simula las funciones getFlightData y fetchIataDetails para fines de este ejemplo.
// Deberías reemplazar estas implementaciones con tus propias llamadas a la API.

const getFlightData = async (flightCode) => {
    // Implementación simulada
    return {
      response: {
        airline_iata: "AA",
        dep_iata: "JFK",
        arr_iata: "LAX"
      }
    };
  };
  
  const fetchIataDetails = async (endpoint, code) => {
    // Implementación simulada
    return {
      name: "Ejemplo",
      city: "Ciudad Ejemplo"
    };
  };
  
  const createFlightCardInfo = (flightData) => {
    // Simula la creación de un objeto FlightCardInfo basado en flightData
    return {};
  };
  
  export async function getFlightCardInfo(flightCode) {
    try {
      const flightData = await getFlightData(flightCode);
  
      const [airlineDetails, departureDetails, arrivalDetails] = await Promise.all([
        fetchIataDetails('/airlines', flightData.response.airline_iata),
        fetchIataDetails('/airports', flightData.response.dep_iata),
        fetchIataDetails('/airports', flightData.response.arr_iata),
      ]);
  
      const flightCardInfo = createFlightCardInfo(flightData);
      flightCardInfo.airlineName = airlineDetails.name || null;
      flightCardInfo.depAirportName = departureDetails.name || null;
      flightCardInfo.depCity = departureDetails.city || null;
      flightCardInfo.arrAirportName = arrivalDetails.name || null;
      flightCardInfo.arrCity = arrivalDetails.city || null;
  
      return flightCardInfo;
    } catch (error) {
      console.error('Error while fetching flight card info:', error);
      throw error;
    }
  }
  