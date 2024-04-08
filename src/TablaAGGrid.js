import React, { useEffect, useState, useRef } from "react";
import { AgGridReact } from "ag-grid-react";
import "ag-grid-community/styles/ag-grid.css";
import "ag-grid-community/styles/ag-theme-alpine.css";
import axios from "axios";
import "./style.css";

// const AIRLABS_API_KEY = "e3d4bf45-f8f2-44f4-a1fd-f18da01fa931";

const TablaAGGrid = ({ type, size, path, data }) => {
  // console.log("Data obtenida TablaAGGrid: ", data);
  const gridRef = useRef(null);
  const [gridApi, setGridApi] = useState(null);
  const [rowData, setRowData] = useState(data);

  const autoSizeStrategy = {
    autoSizeAllColumns: true,
    // type: "fitCellContents"
    // type: "fitGridWidth"
    type: "",
  };
  useEffect(() => {
    // Carga de datos y configuración existente...
    if (gridApi && window.innerWidth > 768) {
      gridApi.sizeColumnsToFit();
    }
  }, [gridApi]);

  useEffect(() => {
    function handleResize() {
      if (gridApi) {
        if (window.innerWidth > 768) {
          gridApi.sizeColumnsToFit();
          autoSizeStrategy.type = "fitGridWidth";
        } else {
          gridApi.resetRowHeights();
          autoSizeStrategy.type = "fitCellContents";
        }
      }
    }
    window.addEventListener("resize", handleResize);
    return () => window.removeEventListener("resize", handleResize);
  }, [gridApi]);
  // useEffect(() => {
  //   const formattedData = data.map((item) => ({
  //     time: item.arr_time,
  //     flight: item.flight_iata,
  //     from: item.dep_iata,
  //     to: item.arr_iata,
  //     airline: item.airline_iata,
  //     status: item.status,
  //   }));
  //   setRowData(formattedData);
  // }, [])

  // useEffect(() => {
  //   const AIRLABS_API_KEY = apiKey;
  //   // console.log("AG Grid Type", type);
  //   if (airportCode !== "Valor por defecto") {
  //     const fetchData = async () => {
  //       try {
  //         const endpoint = type === "departures" ? "dep_iata" : "arr_iata";
  //         // console.log(
  //         //   `AG Grid fetch link: https://airlabs.co/api/v9/schedules?${endpoint}=${airportCode}&api_key=${AIRLABS_API_KEY}`
  //         // );
  //         const response = await axios.get(
  //           `https://airlabs.co/api/v9/schedules?${endpoint}=${airportCode}&api_key=${AIRLABS_API_KEY}`
  //         );
  //         // const response = await axios.get(
  //         //   `https://airlabs.co/api/v9/schedules?arr_iata=${airportCode}&api_key=${AIRLABS_API_KEY}`
  //         // );
  //         if (response.data && response.data.response) {
  //           const formattedData = response.data.response.map((item) => ({
  //             time: item.arr_time,
  //             flight: item.flight_iata,
  //             from: item.dep_iata,
  //             to: item.arr_iata,
  //             airline: item.airline_iata,
  //             status: item.status,
  //           }));
  //           setRowData(formattedData);
  //         }
  //       } catch (error) {
  //         console.error("Error fetching arrivals data:", error);
  //       }
  //     };
  //     fetchData();
  //   }
  //   if (window.innerWidth > 768) {
  //     autoSizeStrategy.type = "fitGridWidth";
  //   } else {
  //     autoSizeStrategy.type = "fitCellContents";
  //   }
  // }, [airportCode]);

  const columnDefs = [
    {
      headerName: "Flight",
      field: "flight",
    },
    {
      headerName: type == "arrivals" ? "From" : "To",
      field: "airport",
    },
    // { headerName: "Flight", field: "flight" },
    { headerName: "Depart", field: "depart" },
    { headerName: "Arrive", field: "arrive" },
  ];

  function handleGridType(type, size) {
    switch (type) {
      case "arrivals":
        return (
          <AgGridReact
            rowData={rowData}
            columnDefs={columnDefs}
            ref={gridRef}
            onGridReady={(params) => setGridApi(params.api)}
            autoSizeStrategy={autoSizeStrategy}
            domLayout="autoHeight"
            onCellClicked={(event) => {
              if (event.column.colId === "flight") {
                const flightCode = event.data.flight;
                const baseUrl = `${window.location.protocol}//${window.location.host}`;

                if (!flightCode) {
                  window.location.href = `${baseUrl}/404.html`;
                  return;
                }
                window.location.href = `${baseUrl}${path}${flightCode}`;
              }
            }}
            // onRowClicked={(event) => {
            //   const flightCode = event.data.flight;
            //   const baseUrl = `${window.location.protocol}//${window.location.host}`;

            //   if (!flightCode) {
            //     window.location.href = `${baseUrl}/404.html`;
            //     return;
            //   }
            //   window.location.href = `${baseUrl}${path}${flightCode}`;
            // }}
            pagination={true}
            paginationPageSize={size}
          />
        );
      case "departures":
        return (
          <AgGridReact
            rowData={rowData}
            columnDefs={columnDefs}
            ref={gridRef}
            onGridReady={(params) => setGridApi(params.api)}
            autoSizeStrategy={autoSizeStrategy}
            domLayout="autoHeight"
            onRowClicked={(event) => {
              const flightCode = event.data.flight;
              const baseUrl = `${window.location.protocol}//${window.location.host}`;

              if (!flightCode) {
                window.location.href = `${baseUrl}/404.html`;
                return;
              }
              window.location.href = `${baseUrl}${path}${flightCode}`;
            }}
            pagination={true}
            paginationPageSize={size}
          />
        );
      default:
        return null;
    }
  }

  return <div className="ag-theme-alpine">{handleGridType(type, size)}</div>;
};

export default TablaAGGrid;
