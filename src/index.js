import React from "react";
import ReactDOM from "react-dom";
import App from "./App";
import "./style.css"; // Asegura que los estilos se importan correctamente

document.addEventListener("DOMContentLoaded", () => {
  const containers = document.querySelectorAll(
    "[data-react-app='mi-react-app']"
  );

  containers.forEach((container) => {
    const iataCode = container.getAttribute("data-iata-code");
    const type = container.getAttribute("data-type");
    const size = container.getAttribute("data-size") || "10"; // Valor predeterminado

    ReactDOM.render(
      <App iataCode={iataCode} type={type} size={size} />,
      container
    );
  });
});

