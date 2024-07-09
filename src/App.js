import React, { useEffect } from "react";
import TablaAGGrid from "./TablaAGGrid";
import FlightInfo from "./FlightInfo"; // Asegúrate de tener este componente.
import "./style.css";

const App = ({ type, size, flight, queryParams }) => {
  const [data, setData] = useState([]);
  const baseUrl = window.location.origin;

  const customEndpointUrl = `${baseUrl}/wp-json/mi-plugin/v1/fetch-flight-data?${queryParams}`;

  useEffect(() => {
    fetch(customEndpointUrl)
      .then((response) => {
        if (!response.ok) throw new Error("Network response was not ok");
        return response.json();
      })
      .then((data) => {
        setData(data);
      })
      .catch((error) => {
        console.error("Error fetching flight data:", error);
      });
  }, []);

  return (
    <div className="main-container">
      {type === "flight" && flight ? (
        <FlightInfo data={data} />
      ) : (
        <TablaAGGrid
          type={type}
          size={parseInt(size, 10)}
          data={data}
          queryParams={queryParams}
        />
      )}
    </div>
  );
};

export default App;
