import React from 'react';
import ReactDOM from 'react-dom';
import App from './App';
import './style.css'; // Asegura que los estilos se importan correctamente

document.addEventListener('DOMContentLoaded', () => {
    ReactDOM.render(<App />, document.getElementById('mi-react-app'));
});
// document.addEventListener("DOMContentLoaded", () => {
//     const containerType = window['miReactAppParams'].type;
//     const appContainers = document.querySelectorAll(`[id='${containerType}-app']`);
//     console.log("containerType", containerType);
//     console.log("appContainers", appContainers[0])
//     appContainers.forEach((container) => {
//         ReactDOM.render(<App />, container);
//     });
//   //   ReactDOM.render(<App />, document.getElementById("arrivals-app"));
//   });
// import React from 'react';
// import ReactDOM from 'react-dom';
// import App from './App';

// document.addEventListener('DOMContentLoaded', () => {
//     // Encuentra todos los contenedores que siguen el patrón 'mi-react-app-' seguido de cualquier cosa (usando expresiones regulares)
//     const appContainers = document.querySelectorAll("[id^='mi-react-app-']");

//     appContainers.forEach(container => {
//         // Extrae el número único al final del ID del contenedor
//         const uniqueId = container.id.match(/^mi-react-app-(\d+)$/)[1];
//         // Accede a los parámetros pasados específicos de esta instancia del shortcode
//         const params = window['miReactAppParams' + uniqueId];

//         // Comprueba si los parámetros específicos existen para evitar errores
//         if (params) {
//             ReactDOM.render(
//                 <App {...params} />,
//                 container
//             );
//         }
//     });
// });

