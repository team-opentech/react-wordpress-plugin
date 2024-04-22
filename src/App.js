import React from "react";
import TablaAGGrid from "./TablaAGGrid";
import FlightInfo from "./FlightInfo"; // Asegúrate de tener este componente.
import "./style.css";

const App = ({ type, size, path, data, airportCode, flight}) => {
  // Determina qué componente renderizar basado en el tipo.
  const renderComponent = () => {
    if (type === 'flight' && flight) {
      return <FlightInfo path={path} data={data}/>;
    } else {
      return <TablaAGGrid type={type} size={parseInt(size, 10)}  path={path} data={data}/>;
    }
  };

  return (
    <div className="main-container">
      {airportCode && <h1 style={{ paddingLeft: 16 }}>Datos del Aeropuerto: {airportCode}</h1>}
      {flight && <h1 style={{ paddingLeft: 16 }}>Datos del Vuelo: {flight}</h1>}
      {renderComponent()}
    </div>
  );
};

export default App;
