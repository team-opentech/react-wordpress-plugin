import React from "react";
import TablaAGGrid from "./TablaAGGrid";
import "./style.css";

const App = ({ iataCode, type, size }) => {
  // Ahora los valores de iataCode, type y size son proporcionados directamente como props
  console.log(`Fetching data for airport code: ${iataCode} with type: ${type} and size: ${size}`);

  return (
    <div className="main-container">
      <h1 style={{ paddingLeft: 16 }}>{type} de Datos del Aeropuerto: {iataCode}</h1>
      <div style={{ width: '100%' }}>
        <TablaAGGrid iataCode={iataCode} type={type} size={parseInt(size)}/>
      </div>
    </div>
  );
};

export default App;

