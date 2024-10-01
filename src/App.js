import React, { useEffect, useState } from "react";
import TablaAGGrid from "./TablaAGGrid";
import FlightInfo from "./FlightInfo"; // Asegúrate de tener este componente.
import "./style.css";

const App = ({ type, size, queryParams }) => {
  const [data, setData] = useState([]);
  const [loadingData, setLoadingData] = useState(true);
  const [error, setError] = useState(null);
  const [serverTimings, setServerTimings] = useState([]); // Estado para almacenar tiempos del servidor
  const [pageLoadTime, setPageLoadTime] = useState(null); // Estado para almacenar el tiempo de carga de la página
  const baseUrl = window.location.origin;

  const customEndpointUrl = `${baseUrl}/wp-json/mi-plugin/v1/fetch-flight-data?${queryParams}`;

  useEffect(() => {
    fetch(customEndpointUrl)
      .then((response) => {
        const timings = response.headers.get("Server-Timing");
        if (timings) {
          const parsedTimings = timings.split(",").map((timing) => {
            const [name, duration] = timing.split(";dur=");
            return { name, duration };
          });
          setServerTimings(parsedTimings);
        }

        return response.json().then((data) => {
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
          setError({
            message: "Error fetching flight data",
            code: "generic_error",
          });
        }
        setLoadingData(false);
      });

    // Measure page load times
    const measurePageLoadTime = () => {
      const [pageLoad] = performance.getEntriesByType("navigation");
      if (pageLoad) {
        setPageLoadTime(pageLoad.loadEventEnd - pageLoad.startTime);
        console.log(
          "Page Load Time:",
          pageLoad.loadEventEnd - pageLoad.startTime,
          "ms"
        );
      }
    };

    // Use window load event to ensure all resources are loaded
    window.addEventListener("load", measurePageLoadTime);

    return () => {
      window.removeEventListener("load", measurePageLoadTime);
    };
  }, [customEndpointUrl]);

  return (
    <div className="main-container">
      {type === "flight" && (
        <FlightInfo
          data={data.length === 0 ? null : data}
          loadingData={loadingData}
        />
      )}
      {type !== "flight" && (
        <TablaAGGrid
          loadingData={loadingData}
          type={type}
          size={parseInt(size, 10)}
          data={data && data.length ? data : null}
          queryParams={queryParams}
        />
      )}
      {/* Mostrar tiempos del servidor */}
      {/* {serverTimings.length > 0 && (
        <div className="server-timings">
          <h3>Server Timings</h3>
          <ul>
            {serverTimings.map((timing, index) => (
              <li key={index}>
                {timing.name}: {timing.duration} ms
              </li>
            ))}
          </ul>
        </div>
      )}
      {/* Mostrar tiempo de carga de la página */}
      {/* {pageLoadTime !== null && (
        <div className="page-load-time">
          <h3>Page Load Time</h3>
          <p>{pageLoadTime} ms</p>
        </div>
      )} */}
    </div>
  );
};

export default App;
