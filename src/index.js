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
  // Encuentra todos los contenedores de la aplicación React.
  const appContainers = document.querySelectorAll(".react-app-container");

  appContainers.forEach(container => {
    const type = container.getAttribute("data-type");
    const airportCode = container.getAttribute("data-airport-code");
    const size = container.getAttribute("data-size");
    const apiKey = container.getAttribute("data-api-key");
    const path = container.getAttribute("data-path");
    const flight = container.getAttribute("data-flight");

    // Monta el componente App con los props adecuados.
    ReactDOM.render(
      <App
        airportCode={airportCode}
        type={type}
        size={size}
        apiKey={apiKey}
        path={path}
        flight={flight}
      />,
      container
    );
  });
});
