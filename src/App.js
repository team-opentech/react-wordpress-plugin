import React from "react";
import TablaAGGrid from "./TablaAGGrid";
import "./style.css";

const App = () => {
  const iataCode = window.miReactAppParams?.iataCode || "Valor por defecto";
  const type = window.miReactAppParams?.type || "Valor por defecto";
  const size = parseInt(window.miReactAppParams?.size || '10');

  console.log("window.miReactAppParams", window.miReactAppParams);
  console.log(`Fetching data for airport code: ${iataCode}`);

  return (
    <div class="main-container">
      <h1 style={{ paddingLeft: 16 }}>{type} de Datos del Aeropuerto: {iataCode}</h1>
      <div style={{ width: '100%' }}>
        <TablaAGGrid iataCode={iataCode} type={type} size={size}/>
      </div>
    </div>
  );
};

export default App;
// import React from 'react';
// import TablaAGGrid from './TablaAGGrid';

// const App = ({ iataCode, type, size, containerId }) => {
//     console.log(`Renderizando en el contenedor: ${containerId}, Tipo: ${type}, Código IATA: ${iataCode}, Tamaño: ${size}`);

//     return (
//         <div className="app-container">
//             <h1>Visualización de Datos para {iataCode}: {type}</h1>
//             <TablaAGGrid iataCode={iataCode} type={type} size={parseInt(size)} />
//         </div>
//     );
// };

// export default App;

