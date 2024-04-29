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

  document.querySelectorAll(".react-app-container").forEach(container => {
    const type = container.getAttribute("data-type");
    const airportCode = container.getAttribute("data-airport-code") || "";
    const airp_codeType = container.getAttribute("data-airp-codetype") || "";
    const flight = container.getAttribute("data-flight") || "";
    const flight_codeType = container.getAttribute("data-flight-codetype") || "";
    const size = container.getAttribute("data-size");
    const airlineCode = container.getAttribute("data-airline") || "";
    const airl_codeType = container.getAttribute("data-airl-codetype") || "";
    const status = container.getAttribute("data-status") || "";

    const baseUrl = window.location.origin;
    let queryParams = new URLSearchParams({
      type,
      size,
      offset: 0,
    });

    // Agregar solo si están presentes

    if (airportCode !== '') {
      queryParams.append('airportCode', airportCode);
      queryParams.append('airp_codeType', airp_codeType);
    
    }
    if (flight !== '') {
      queryParams.append('flight', flight);
      queryParams.append('flight_codeType', flight_codeType);
    }
    if (airlineCode !== ''){
      queryParams.append('airlineCode', airlineCode);
      queryParams.append('airl_codeType', airl_codeType)
    }
    if (status !== '') queryParams.append('status', status);

    const customEndpointUrl = `${baseUrl}/wp-json/mi-plugin/v1/fetch-flight-data?${queryParams}`;

    fetch(customEndpointUrl)
      .then(response => {
        if (!response.ok) throw new Error("Network response was not ok");
        return response.json();
      })
      .then(data => {
        ReactDOM.render(
          <App
            type={type}
            size={size}
            data={data}
            airportCode={airportCode}
            flight={flight}
            queryParams={queryParams}
          />,
          container
        );
      })
      .catch(error => {
        console.error("Error fetching flight data:", error);
      });
  });
});
