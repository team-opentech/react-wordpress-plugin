import React, { useEffect, useState } from "react";
import TablaAGGrid from "./TablaAGGrid";
import FlightInfo from "./FlightInfo"; // Asegúrate de tener este componente.
import "./style.css";

const App = ({ type, size, flight, queryParams }) => {
  const [data, setData] = useState([]);
  const [loadingData, setLoadingData] = useState(true);
  const [error, setError] = useState(null);
  const baseUrl = window.location.origin;
  // console.log("flight", flight);

  const customEndpointUrl = `${baseUrl}/wp-json/mi-plugin/v1/fetch-flight-data?${queryParams}`;
  // console.log("customEndpointUrl", customEndpointUrl);

  useEffect(() => {
    // console.log("Fetching data...");
    fetch(customEndpointUrl)
    .then((response) => {
      return response.json().then(data => {
        if (!response.ok) {
          throw data;
        }
        return data;
      });
    })
      .then((data) => {
        setData(data);
        setLoadingData(false);
      })
      .catch((error) => {
        console.error("Error fetching flight data:", error);
        if (error.code === "month_limit_exceeded") {
          setError({ message: error.message, code: error.code });
        } else {
          setError({ message: "Error fetching flight data", code: "generic_error" });
        }
        console.log("Error", error);
        setLoadingData(false);
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
