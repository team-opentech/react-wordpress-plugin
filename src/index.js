import React from "react";
import ReactDOM from "react-dom/client"; // Updated to use createRoot
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
  const time_range = container.getAttribute("data-time-range") || "";
  const terminal = container.getAttribute("data-terminal") || ""; // New terminal parameter
  const delayed_type = container.getAttribute("data-delayed-type") || "";
  const delayed_time = container.getAttribute("data-delayed-time") || "";
  const title = container.getAttribute("data-title") || "";

  // console.log("Shortcode data: ", type, airportCode, airp_codeType, delayed_type, delayed_time);

  // Initialize query parameters
  let queryParams = new URLSearchParams({
    type,
    size,
    offset_value: 0,
  });

  // Append parameters conditionally
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
  if (time_range !== "") queryParams.append("time_range", time_range);
  if (terminal !== "") queryParams.append("terminal", terminal); // Append terminal if available
  if (delayed_type !== "" && delayed_time !== ""){
    queryParams.append("delayed_type", delayed_type);
    queryParams.append("delayed_time", delayed_time);
  }
  if (title !== "") queryParams.append("title", title)
  // console.log("Delayed details: ", delayed_time, delayed_type, type);

  // Initialize the React root and render the App component
  const root = ReactDOM.createRoot(container); // Use createRoot
  root.render(
    <App
      type={type}
      size={size}
      queryParams={queryParams}
    />
  );
});
