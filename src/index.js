// import React from "react";
// import ReactDOM from "react-dom";
// import App from "./App";
// import "./style.css"; // Asegura que los estilos se importan correctamente

// document.addEventListener("DOMContentLoaded", () => {
//   const containers = document.querySelectorAll(".react-app-container");

//   containers.forEach(container => {
//       const airportCode = container.getAttribute("data-airport-code");
//       const type = container.getAttribute("data-type");
//       const size = container.getAttribute("data-size");
//       const apiKey = container.getAttribute("data-api-key");
//       const path = container.getAttribute("data-path");

//       // Ahora apiKey y path están disponibles para ser utilizados en tu componente React
//       ReactDOM.render(
//           <App airportCode={airportCode} type={type} size={size} apiKey={apiKey} path={path} />,
//           container
//       );
//   });
// });
import React from "react";
import ReactDOM from "react-dom";
import App from "./App";
import "./style.css";

document.addEventListener("DOMContentLoaded", () => {
  if (typeof phpVars !== "undefined" && phpVars.dbMessage) {
    console.log("Mensaje desde PHP:", phpVars.dbMessage);
  }

  const appContainers = document.querySelectorAll(".react-app-container");

  appContainers.forEach((container) => {
    const type = container.getAttribute("data-type");
    const airportCode = container.getAttribute("data-airport-code") || "";
    const flight = container.getAttribute("data-flight") || "";
    const apiKey = container.getAttribute("data-api-key");
    const path = container.getAttribute("data-path");
    const size = container.getAttribute("data-size");

    const baseUrl = window.location.origin;
    const queryParams = new URLSearchParams({
      type,
      airportCode: airportCode || 'null',
      flight,
    }).toString();

    const customEndpointUrl = `${baseUrl}/wp-json/mi-plugin/v1/fetch-flight-data?${queryParams}`;

    fetch(customEndpointUrl)
      .then((response) => {
        if (!response.ok) {
          throw new Error("Network response was not ok");
        }
        return response.json();
      })
      .then((data) => {
        console.log("Data obtenida: ", data.response);
        ReactDOM.render(
          <App
            type={type}
            airportCode={airportCode}
            size={size}
            flight={flight}
            apiKey={apiKey}
            path={path}
            data={data.response}
          />,
          container
        );
      })
      .catch((error) => {
        console.error("Error fetching flight data:", error);
      });
  });
});
