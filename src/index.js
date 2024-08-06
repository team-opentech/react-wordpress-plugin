import React from "react";
import ReactDOM from "react-dom/client"; // Actualizado para usar createRoot
import App from "./App";
import "./style.css";

document.querySelectorAll(".react-app-container").forEach((container) => {
  const type = container.getAttribute("data-type");
  const airportCode = container.getAttribute("data-airport-code");
  const airp_codeType = container.getAttribute("data-airp-codetype");
  const flight = container.getAttribute("data-flight");
  const flight_codeType = container.getAttribute("data-flight-codetype");
  const size = container.getAttribute("data-size");
  const airlineCode = container.getAttribute("data-airline");
  const airl_codeType = container.getAttribute("data-airl-codetype");
  const status = container.getAttribute("data-status");
  const delayed_time = container.getAttribute("data-delayed-time");
  const delayed_type = container.getAttribute("data-delayed-type");

  // const baseUrl = window.location.origin;
  let queryParams = new URLSearchParams({
    type,
    size,
    offset_value: 0,
  });
  // console.log("flight", flight);
  console.log("airportCode", airportCode);
  console.log("delayed type", delayed_type);

  if (airportCode !== "") {
    queryParams.append("airportCode", airportCode);
    queryParams.append("airp_codeType", airp_codeType);
  }
  if (flight !== "") {
    queryParams.append("flight", flight);
    queryParams.append("flight_codeType", flight_codeType);
  }
  if (airlineCode !== "") {
    queryParams.append("airlineCode", airlineCode);
    queryParams.append("airl_codeType", airl_codeType);
  }
  if (status !== "") queryParams.append("status", status);

  if (delayed_time !== "") queryParams.append("delayed_time", delayed_time);
  if (delayed_type !== "") queryParams.append("delayed_type", delayed_type);

  console.log("queryParams", queryParams.toString());

  const root = ReactDOM.createRoot(container); // Usar createRoot
  root.render(
    <App
      type={type}
      size={size}
      flight={flight}
      queryParams={queryParams}
    />
  );
});
