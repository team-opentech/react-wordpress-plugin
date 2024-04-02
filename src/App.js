import React from "react";
import TablaAGGrid from "./TablaAGGrid";
import "./style.css";

const App = ({ airportCode, type, size, apiKey, path }) => {
  // Ahora los valores de airportCode, type y size son proporcionados directamente como props
  console.log(`Fetching data for airport code: ${airportCode} with type: ${type} and size: ${size}`);
  console.log("API Key:", apiKey);
  console.log("Path:", path);

  return (
    <div className="main-container">
      <h1 style={{ paddingLeft: 16 }}>{type} de Datos del Aeropuerto: {airportCode}</h1>
      <div style={{ width: '100%' }}>
        <TablaAGGrid airportCode={airportCode} type={type} size={parseInt(size)} apiKey={apiKey} path={path}/>
      </div>
    </div>
  );
};

export default App;

