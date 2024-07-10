import React from "react";
import ReactDOM from "react-dom/client"; // Actualizado para usar createRoot
import App from "./App";
import "./style.css";

document.querySelectorAll(".react-app-container").forEach((container) => {
  const type = container.getAttribute("data-type");
  const airportCode = container.getAttribute("data-airport-code") || "";
  const airp_codeType = container.getAttribute("data-airp-codetype") || "";
  const flight = container.getAttribute("data-flight") || "";
  const flight_codeType = container.getAttribute("data-flight-codetype") || "";
  const size = container.getAttribute("data-size");
  const airlineCode = container.getAttribute("data-airline") || "";
  const airl_codeType = container.getAttribute("data-airl-codetype") || "";
  const status = container.getAttribute("data-status") || "";

  // const baseUrl = window.location.origin;
  let queryParams = new URLSearchParams({
    type,
    size,
    offset_value: 0,
  });

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

  const root = ReactDOM.createRoot(container); // Usar createRoot
  root.render(
    <App
      type={type}
      size={size}
      flight={flight}
      queryParams={queryParams}
    />
  );
  // const customEndpointUrl = `${baseUrl}/wp-json/mi-plugin/v1/fetch-flight-data?${queryParams}`;

  // fetch(customEndpointUrl)
  //   .then((response) => {
  //     if (!response.ok) throw new Error("Network response was not ok");
  //     return response.json();
  //   })
  //   .then((data) => {
     
  //   })
  //   .catch((error) => {
  //     console.error("Error fetching flight data:", error);
  //     const root = ReactDOM.createRoot(container);
  //     root.render(<div>Error loading data: {error.message}</div>);
  //   });
});
