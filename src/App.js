import React, { useEffect, useState } from "react";
import TablaAGGrid from "./TablaAGGrid";
import FlightInfo from "./FlightInfo"; // Asegúrate de tener este componente.
import "./style.css";

const App = ({ type, size, flight, queryParams }) => {
  const [data, setData] = useState([]);
  const [loadingData, setLoadingData] = useState(true);
  const baseUrl = window.location.origin;
  // console.log("flight", flight);

  const customEndpointUrl = `${baseUrl}/wp-json/mi-plugin/v1/fetch-flight-data?${queryParams}`;
  // console.log("customEndpointUrl", customEndpointUrl);

  useEffect(() => {
    // console.log("Fetching data...");
    fetch(customEndpointUrl)
      .then((response) => {
        if (!response.ok) throw new Error("Network response was not ok");
        return response.json();
      })
      .then((data) => {
        setData(data);
        setLoadingData(false);
      })
      .catch((error) => {
        console.error("Error fetching flight data:", error);
      });
  }, []);

  return (
    <div className="main-container">
      {type === "flight" && <FlightInfo data={data.length === 0 ? null : data} loadingData={loadingData}/>}
      {type != "flight" && (
        <TablaAGGrid
          loadingData={loadingData}
          type={type}
          size={parseInt(size, 10)}
          data={data.length === 0 ? null : data}
          queryParams={queryParams}
        />
      )}
    </div>
  );
};

export default App;
