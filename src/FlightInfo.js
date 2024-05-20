import React, { useEffect, useState } from "react";
import { getFlightCardInfo } from "./services"; // Asegúrate de que esta ruta sea correcta
import FlightCard from "./FlightCard";

const FlightInfo = ({ data }) => {
  console.log("Data para FlightInfo", data);
  const [flightInfo, setFlightInfo] = useState(null);
  const [loading, setLoading] = useState(true);
  // const [error, setError] = useState(null);

  // useEffect(() => {
  //   if (!flightCode) {
  //     console.error('Flight code is required');
  //     setLoading(false);
  //     return;
  //   }

  //   getFlightCardInfo(flightCode, apiKey)
  //     .then(info => {
  //       // console.log('Flight info:', info);
  //       setFlightInfo(info);
  //       setLoading(false);
  //     })
  //     .catch(err => {
  //       console.error("Failed to fetch flight card info:", err);
  //       setError(err);
  //       setLoading(false);
  //     });
  // }, [flightCode]);

  // if (loading) return <div>Loading...</div>;
  // if (error) return <div>Error loading flight info.</div>;
  // if (!data) return <div>No flight info available.</div>;

  return (
    <>
      {/* <FlightCard data={flightInfo} /> */}
      <FlightCard data={data} />
      {/* Aquí puedes incluir <NextFlights /> o cualquier otro componente relacionado */}
    </>
  );
};

export default FlightInfo;
