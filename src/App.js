import React from "react";
import TablaAGGrid from "./TablaAGGrid";
import FlightInfo from "./FlightInfo"; // Asegúrate de tener este componente.
import "./style.css";

const App = ({ type, size, data, airportCode, flight, queryParams}) => {
  // Determina qué componente renderizar basado en el tipo.
  const renderComponent = () => {
    if (type === 'flight' && flight) {
      return <FlightInfo data={data}/>;
    } else {
      return <TablaAGGrid type={type} size={parseInt(size, 10)} data={data} queryParams={queryParams}/>;
    }
  };

  return (
    <div className="main-container">
      {renderComponent()}
    </div>
  );
};

export default App;
