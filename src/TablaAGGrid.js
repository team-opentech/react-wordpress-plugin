import React, { useEffect, useState, useRef, useMemo } from "react";
import { AgGridReact } from "ag-grid-react";
import "ag-grid-community/styles/ag-grid.css";
import "ag-grid-community/styles/ag-theme-alpine.css";
import "./style.css";
import moment, { min } from "moment-timezone";
import CustomLoadingOverlay from "./customLoadingOverlay";

const TablaAGGrid = ({ type, size, queryParams, data, loadingData }) => {
  const gridRef = useRef(null);
  const [gridApi, setGridApi] = useState(null);
  const [gridColumnApi, setGridColumnApi] = useState(null);
  const [currentPage, setCurrentPage] = useState(0);
  const [globalData, setGlobalData] = useState(data);
  const [rowData, setRowData] = useState([]);
  let [offset, setOffset] = useState(0);
  const [dataFromApi, setdataFromApi] = useState(true);
  const [loading, setLoading] = useState(false);
  const [lastPage, setLastPage] = useState(false);
  const [params, setParams] = useState(queryParams);
  const [nextClicked, setNextClicked] = useState(false);
  const [localTime, setLocalTime] = useState(null); // Estado para almacenar la hora local del aeropuerto
  const [localDate, setLocalDate] = useState(null); // Estado para almacenar la fecha local del aeropuerto
  const [incrementedTime, setIncrementedTime] = useState(null); // Estado para la hora incrementada
  const [localDateTime, setLocalDateTime] = useState(null);
  const time_range = queryParams.get("time_range");
  const baseUrl = window.location.origin;

  const fetchLocalTime = () => {
    const localTimeUrl = `${baseUrl}/wp-json/mi-plugin/v1/local-time?${queryParams}`;
    fetch(localTimeUrl)
      .then((response) => {
        if (!response.ok) {
          throw new Error("Error fetching local time");
        }
        return response.json();
      })
      .then((data) => {
        const localDateTime = data.local_time; // Store the full datetime string
        const localDate = localDateTime.split(" ")[0]; // Extract only the date part
        const localTime = localDateTime.split(" ")[1]; // Extract only the time part
        setLocalTime(localTime); // Set only the time part if needed elsewhere
        setLocalDate(localDate); // Set only the date part if needed elsewhere
        setIncrementedTime(localTime); // Initialize the incremented time with only the time
        setLocalDateTime(localDateTime); // Store the full datetime string in a new state variable
        console.log("Local time 2:", localDateTime);
      })
      .catch((error) => {
        console.error("Error fetching local time:", error);
      });
  };

  useEffect(() => {
    if (type !== "flight") {
      fetchLocalTime(); // Solo llamar si el tipo no es "flight"
    }
  }, []);

  useEffect(() => {
    if (localTime) {
      const intervalId = setInterval(() => {
        setIncrementedTime((prevTime) => {
          if (!prevTime) return prevTime;

          // Split the time part into hours, minutes, and seconds
          let [hours, minutes, seconds] = prevTime.split(":").map(Number);

          // Increment the seconds
          seconds += 1;
          if (seconds >= 60) {
            seconds = 0;
            minutes += 1;
          }
          if (minutes >= 60) {
            minutes = 0;
            hours += 1;
          }
          if (hours >= 24) {
            hours = 0;
          }

          // Return the new time string with the updated time
          return `${String(hours).padStart(2, "0")}:${String(minutes).padStart(
            2,
            "0"
          )}:${String(seconds).padStart(2, "0")}`;
        });
      }, 1000);

      return () => clearInterval(intervalId);
    }
  }, [localTime]);

  const handleNextClick = () => {
    if (!loading && !lastPage) {
      gridApi.paginationGoToNextPage();
      setNextClicked(true); // Indicar que el botón Next ha sido clickeado
    }
  };

  const onPaginationChanged = () => {
    if (!gridApi) return;
    updatePaginationState(gridApi);
  };

  const updatePaginationState = (api) => {
    const totalPages = api.paginationGetTotalPages();
    const currentPage = api.paginationGetCurrentPage();
    setCurrentPage(currentPage);
    setLastPage(currentPage === totalPages - 1);

    if (currentPage >= totalPages - 1 && dataFromApi && nextClicked) {
      handleMoreDataFromApi();
    }
    setNextClicked(false); // Reiniciar el estado después de actualizar la paginación
  };

  useEffect(() => {
    // Asegura que las columnas se ajusten cuando se cambia el tamaño de la ventana
    const handleResize = () =>
      gridColumnApi && gridColumnApi.sizeColumnsToFit();
    window.addEventListener("resize", handleResize);

    return () => window.removeEventListener("resize", handleResize);
  }, [gridColumnApi]);

  useEffect(() => {
    const params = new URLSearchParams(queryParams);
    params.set("offset", offset);
    setParams(params);
  }, [offset, queryParams]);

  const autoSizeStrategy = {
    autoSizeAllColumns: true,
    type: window.innerWidth > 768 ? "fitGridWidth" : "fitCellContents",
  };

  // useEffect(() => {
  //   if (data && data.length > 0) {
  //     if (window.innerWidth > 768) {
  //       const formattedData = data.map((item) => ({
  //         flight: item.flight.toLowerCase(),
  //         airport: `${item.airport} (${
  //           type === "arrivals" ? item.dep_code : item.arr_code
  //         })`,
  //         airport_city:
  //           type === "arrivals" ? item.depAirport_city : item.arrAirport_city,
  //         airport_state:
  //           type === "arrivals" ? item.depAirport_state : item.arrAirport_state,
  //         airport_country:
  //           type === "arrivals"
  //             ? item.depAirport_country
  //             : item.arrAirport_country,
  //         city: type === "arrivals" ? item.dep_city : item.arr_city,
  //         airline_name: `${item.airline_name} (${item.airline_code})`,
  //         depart: moment.tz(item.depart, item.tz_dep).format("HH:mm z"),
  //         arrive: moment.tz(item.arrive, item.tz_arr).format("HH:mm z"),
  //         status: item.status,
  //         dep_code: item.dep_code,
  //         arr_code: item.arr_code,
  //         airline_code: item.airline_code,
  //       }));
  //       setRowData(formattedData);
  //     } else {
  //       const formattedData = data.map((item) => ({
  //         flight: item.flight.toLowerCase(),
  //         city:
  //           type === "arrivals"
  //             ? `${item.dep_city}/(${item.dep_code})`
  //             : `${item.arr_city}/(${item.arr_code})`,
  //         airline_name: `${item.airline_name} (${item.airline_code})`,
  //         airport_city:
  //           type === "arrivals" ? item.depAirport_city : item.arrAirport_city,
  //         airport_state:
  //           type === "arrivals" ? item.depAirport_state : item.arrAirport_state,
  //         airport_country:
  //           type === "arrivals"
  //             ? item.depAirport_country
  //             : item.arrAirport_country,
  //         depart: moment.tz(item.depart, item.tz_dep).format("HH:mm z"),
  //         arrive: moment.tz(item.arrive, item.tz_arr).format("HH:mm z"),
  //         status: item.status,
  //         dep_code: item.dep_code,
  //         arr_code: item.arr_code,
  //         airline_code: item.airline_code,
  //       }));
  //       setRowData(formattedData);
  //     }
  //   } else {
  //     setRowData([]);
  //   }
  // }, [data, type]);

  useEffect(() => {
    if (data && data.length > 0) {
      let filteredData = data;
      if (time_range && time_range > 0) {
        // Convert localDateTime to a moment object
        const localTimeMoment = moment(localDateTime, "YYYY-MM-DD HH:mm:ss");

        // Calculate the end of the time range
        const rangeEndMoment = localTimeMoment
          .clone()
          .add(time_range, "minutes");
        // Filter the flight data
        filteredData = data.filter((item) => {
          // Parse the flight time
          const flightTime = type === "arrivals" ? item.arrive : item.depart;
          const flightTimeMoment = moment(flightTime, "YYYY-MM-DD HH:mm:ss");

          console.log(
            "Flight Time Moment:",
            flightTimeMoment.format("HH:mm:ss")
          );

          // Case 1: The rangeEndMoment is after the localTimeMoment (same-day comparison)
          if (rangeEndMoment.isAfter(localTimeMoment)) {
            return flightTimeMoment.isBetween(
              localTimeMoment,
              rangeEndMoment,
              null,
              "[]"
            );
          }
          // Case 2: The rangeEndMoment crosses over midnight (next-day comparison)
          else {
            return (
              flightTimeMoment.isAfter(localTimeMoment) || // Flights later the same day
              flightTimeMoment.isBefore(rangeEndMoment) // Flights early the next day
            );
          }
        });
      }
      console.log("Filtered Data:", filteredData);
      const formattedData = filteredData.map((item) => ({
        flight: item.flight.toLowerCase(),
        city:
          type === "arrivals"
            ? `${item.dep_city}/(${item.dep_code})`
            : `${item.arr_city}/(${item.arr_code})`,
        airline_name: `${item.airline_name} (${item.airline_code})`,
        airport_city:
          type === "arrivals" ? item.depAirport_city : item.arrAirport_city,
        airport_state:
          type === "arrivals" ? item.depAirport_state : item.arrAirport_state,
        airport_country:
          type === "arrivals"
            ? item.depAirport_country
            : item.arrAirport_country,
        depart: moment(item.depart, "YYYY-MM-DD HH:mm:ss").format("HH:mm"), // Format time only
        arrive: moment(item.arrive, "YYYY-MM-DD HH:mm:ss").format("HH:mm"), // Format time only
        dep_date: moment(item.depart, "YYYY-MM-DD HH:mm:ss").format("YYYY-MM-DD"), // Format date only
        arr_date: moment(item.arrive, "YYYY-MM-DD HH:mm:ss").format("YYYY-MM-DD"), // Format date only
        airline_name: `${item.airline_name} (${item.airline_code})`,
        status: item.status,
        dep_code: item.dep_code,
        arr_code: item.arr_code,
        airline_code: item.airline_code,
      }));
      setRowData(formattedData);
    }
  }, [data, type]);

  const tableName = () => {
    const status = queryParams.get("status");
    const airline = queryParams.get("airlineCode") ? data[0].airline : "";
    const airport =
      data && data.length > 0 && type === "arrivals"
        ? data[0].arrAirport
        : data[0].depAirport || "";

    const StatusIcon = () => {
      switch (status) {
        case "cancelled":
          return <Cancelled_Flight style={{ width: 5, height: 5 }} />;
        case "landed":
          return <Landed_Flight style={{ width: 5, height: 5 }} />;
        case "scheduled":
          return <Scheduled_Flight style={{ width: 5, height: 5 }} />;
        default:
          return <Active_Flight style={{ width: 5, height: 5 }} />;
      }
    };

    const ScheduledIcon = () => {
      if (type === "arrivals") {
        return <Arrival_Airplane style={{ width: 5, height: 5 }} />;
      } else {
        return <Departure_Airplane style={{ width: 5, height: 5 }} />;
      }
    };

    return (
      <div className="flex flex-wrap h-auto w-full text-white bg-[#013877] items-center justify-center py-[1%] uppercase space-x-4">
        {status && <StatusIcon />}
        {!status && <ScheduledIcon />}
        <div classNAme="flex flex-col flex-wrap justify-center">
          <h2 className="flex text-white font-semibold font-sans">
            {!status
              ? `${
                  type === "arrivals" && !status
                    ? "Arrival schedule"
                    : "Departures schedule"
                }`
              : ""}
            {status ? `${status} flights` : ""} {airport}
          </h2>
          <h2 className="flex text-white font-bold font-sans mt-2">
            {incrementedTime ? `Local Time: ${incrementedTime}` : ""}
          </h2>
        </div>
      </div>
    );
  };

  const columnDefsDesktop = [
    {
      headerName: "Flight",
      field: "flight",
      cellStyle: {
        color: "#0056b3",
        textDecoration: "underline",
        cursor: "pointer",
        wordBreak: "break-all",
        flexWrap: "wrap",
        minWidth: 120,
      },
      minWidth: 120,
      headerComponentParams: {
        template:
          '<div class="ag-cell-label-container" role="presentation">' +
          '  <h3 ref="eMenu" class="ag-header-icon ag-header-cell-menu-button"></h3>' +
          '  <div ref="eLabel" class="ag-header-cell-label" role="presentation">' +
          '    <h3 ref="eSortOrder" class="ag-header-icon ag-sort-order" ></h3>' +
          '    <h3 ref="eSortAsc" class="ag-header-icon ag-sort-ascending-icon" ></h3>' +
          '    <h3 ref="eSortDesc" class="ag-header-icon ag-sort-descending-icon" ></h3>' +
          '    <h3 ref="eSortNone" class="ag-header-icon ag-sort-none-icon" ></h3>' +
          '    <h3 ref="eText" class="ag-header-cell-text" role="columnheader"></h3>' +
          '    <h3 ref="eFilter" class="ag-header-icon ag-filter-icon"></h3>' +
          "  </div>" +
          "</div>",
      },
    },
    {
      headerName: "Airline",
      field: "airline_name",
      cellStyle: {
        color: "#0056b3",
        textDecoration: "underline",
        cursor: "pointer",
        wordBreak: "break-all",
        flexWrap: "wrap",
        minWidth: 250,
      },
      minWidth: 250,
      headerComponentParams: {
        template:
          '<div class="ag-cell-label-container" role="presentation">' +
          '  <h3 ref="eMenu" class="ag-header-icon ag-header-cell-menu-button"></h3>' +
          '  <div ref="eLabel" class="ag-header-cell-label" role="presentation">' +
          '    <h3 ref="eSortOrder" class="ag-header-icon ag-sort-order" ></h3>' +
          '    <h3 ref="eSortAsc" class="ag-header-icon ag-sort-ascending-icon" ></h3>' +
          '    <h3 ref="eSortDesc" class="ag-header-icon ag-sort-descending-icon" ></h3>' +
          '    <h3 ref="eSortNone" class="ag-header-icon ag-sort-none-icon" ></h3>' +
          '    <h3 ref="eText" class="ag-header-cell-text" role="columnheader"></h3>' +
          '    <h3 ref="eFilter" class="ag-header-icon ag-filter-icon"></h3>' +
          "  </div>" +
          "</div>",
      },
    },
    {
      headerName: type === "arrivals" ? "Departure City" : "Arrival City",
      field: "city",
      cellStyle: {
        wordBreak: "break-all",
        flexWrap: "wrap",
        minWidth: 150,
      },
      minWidth: 150,
      headerComponentParams: {
        template:
          '<div class="ag-cell-label-container" role="presentation">' +
          '  <h3 ref="eMenu" class="ag-header-icon ag-header-cell-menu-button"></h3>' +
          '  <div ref="eLabel" class="ag-header-cell-label" role="presentation">' +
          '    <h3 ref="eSortOrder" class="ag-header-icon ag-sort-order" ></h3>' +
          '    <h3 ref="eSortAsc" class="ag-header-icon ag-sort-ascending-icon" ></h3>' +
          '    <h3 ref="eSortDesc" class="ag-header-icon ag-sort-descending-icon" ></h3>' +
          '    <h3 ref="eSortNone" class="ag-header-icon ag-sort-none-icon" ></h3>' +
          '    <h3 ref="eText" class="ag-header-cell-text" role="columnheader"></h3>' +
          '    <h3 ref="eFilter" class="ag-header-icon ag-filter-icon"></h3>' +
          "  </div>" +
          "</div>",
      },
    },
    {
      headerName: type === "arrivals" ? "Departure Airport" : "Arrival Airport",
      field: "airport",
      cellStyle: {
        color: "#0056b3",
        textDecoration: "underline",
        cursor: "pointer",
        wordBreak: "break-all",
        flexWrap: "wrap",
        minWidth: 300,
      },
      minWidth: 300,
      headerComponentParams: {
        template:
          '<div class="ag-cell-label-container" role="presentation">' +
          '  <h3 ref="eMenu" class="ag-header-icon ag-header-cell-menu-button"></h3>' +
          '  <div ref="eLabel" class="ag-header-cell-label" role="presentation">' +
          '    <h3 ref="eSortOrder" class="ag-header-icon ag-sort-order" ></h3>' +
          '    <h3 ref="eSortAsc" class="ag-header-icon ag-sort-ascending-icon" ></h3>' +
          '    <h3 ref="eSortDesc" class="ag-header-icon ag-sort-descending-icon" ></h3>' +
          '    <h3 ref="eSortNone" class="ag-header-icon ag-sort-none-icon" ></h3>' +
          '    <h3 ref="eText" class="ag-header-cell-text" role="columnheader"></h3>' +
          '    <h3 ref="eFilter" class="ag-header-icon ag-filter-icon"></h3>' +
          "  </div>" +
          "</div>",
      },
    },
    {
      headerName: "Depart",
      field: "depart",
      cellStyle: { wordBreak: "break-all", flexWrap: "wrap", minWidth: 120 },
      minWidth: 120,
      headerComponentParams: {
        template:
          '<div class="ag-cell-label-container" role="presentation">' +
          '  <h3 ref="eMenu" class="ag-header-icon ag-header-cell-menu-button"></h3>' +
          '  <div ref="eLabel" class="ag-header-cell-label" role="presentation">' +
          '    <h3 ref="eSortOrder" class="ag-header-icon ag-sort-order" ></h3>' +
          '    <h3 ref="eSortAsc" class="ag-header-icon ag-sort-ascending-icon" ></h3>' +
          '    <h3 ref="eSortDesc" class="ag-header-icon ag-sort-descending-icon" ></h3>' +
          '    <h3 ref="eSortNone" class="ag-header-icon ag-sort-none-icon" ></h3>' +
          '    <h3 ref="eText" class="ag-header-cell-text" role="columnheader"></h3>' +
          '    <h3 ref="eFilter" class="ag-header-icon ag-filter-icon"></h3>' +
          "  </div>" +
          "</div>",
      },
    },
    {
       headerName: "Depart Date",
      field: "dep_date",
      cellStyle: { wordBreak: "break-all", flexWrap: "wrap", minWidth: 120 },
      minWidth: 120,
      headerComponentParams: {
        template:
          '<div class="ag-cell-label-container" role="presentation">' +
          '  <h3 ref="eMenu" class="ag-header-icon ag-header-cell-menu-button"></h3>' +
          '  <div ref="eLabel" class="ag-header-cell-label" role="presentation">' +
          '    <h3 ref="eSortOrder" class="ag-header-icon ag-sort-order" ></h3>' +
          '    <h3 ref="eSortAsc" class="ag-header-icon ag-sort-ascending-icon" ></h3>' +
          '    <h3 ref="eSortDesc" class="ag-header-icon ag-sort-descending-icon" ></h3>' +
          '    <h3 ref="eSortNone" class="ag-header-icon ag-sort-none-icon" ></h3>' +
          '    <h3 ref="eText" class="ag-header-cell-text" role="columnheader"></h3>' +
          '    <h3 ref="eFilter" class="ag-header-icon ag-filter-icon"></h3>' +
          "  </div>" +
          "</div>",
      },
    },
    {
      headerName: "Arrive",
      field: "arrive",
      cellStyle: { wordBreak: "break-all", flexWrap: "wrap", minWidth: 120 },
      minWidth: 120,
      headerComponentParams: {
        template:
          '<div class="ag-cell-label-container" role="presentation">' +
          '  <h3 ref="eMenu" class="ag-header-icon ag-header-cell-menu-button"></h3>' +
          '  <div ref="eLabel" class="ag-header-cell-label" role="presentation">' +
          '    <h3 ref="eSortOrder" class="ag-header-icon ag-sort-order" ></h3>' +
          '    <h3 ref="eSortAsc" class="ag-header-icon ag-sort-ascending-icon" ></h3>' +
          '    <h3 ref="eSortDesc" class="ag-header-icon ag-sort-descending-icon" ></h3>' +
          '    <h3 ref="eSortNone" class="ag-header-icon ag-sort-none-icon" ></h3>' +
          '    <h3 ref="eText" class="ag-header-cell-text" role="columnheader"></h3>' +
          '    <h3 ref="eFilter" class="ag-header-icon ag-filter-icon"></h3>' +
          "  </div>" +
          "</div>",
      },
    },
        {
       headerName: "Arrival Date",
      field: "arr_date",
      cellStyle: { wordBreak: "break-all", flexWrap: "wrap", minWidth: 120 },
      minWidth: 120,
      headerComponentParams: {
        template:
          '<div class="ag-cell-label-container" role="presentation">' +
          '  <h3 ref="eMenu" class="ag-header-icon ag-header-cell-menu-button"></h3>' +
          '  <div ref="eLabel" class="ag-header-cell-label" role="presentation">' +
          '    <h3 ref="eSortOrder" class="ag-header-icon ag-sort-order" ></h3>' +
          '    <h3 ref="eSortAsc" class="ag-header-icon ag-sort-ascending-icon" ></h3>' +
          '    <h3 ref="eSortDesc" class="ag-header-icon ag-sort-descending-icon" ></h3>' +
          '    <h3 ref="eSortNone" class="ag-header-icon ag-sort-none-icon" ></h3>' +
          '    <h3 ref="eText" class="ag-header-cell-text" role="columnheader"></h3>' +
          '    <h3 ref="eFilter" class="ag-header-icon ag-filter-icon"></h3>' +
          "  </div>" +
          "</div>",
      },
    },
    {
      headerName: "Status",
      field: "status",
      cellStyle: (params) => {
        {
          if (params.value === "landed") {
            return { color: "green" };
          }
          if (params.value === "scheduled") {
            return { color: "gray" };
          }
          if (params.value === "cancelled") {
            return { color: "red" };
          }
          return { color: "blue" };
        }
      },
      minWidth: 120,
      headerComponentParams: {
        template:
          '<div class="ag-cell-label-container" role="presentation">' +
          '  <h3 ref="eMenu" class="ag-header-icon ag-header-cell-menu-button"></h3>' +
          '  <div ref="eLabel" class="ag-header-cell-label" role="presentation">' +
          '    <h3 ref="eSortOrder" class="ag-header-icon ag-sort-order" ></h3>' +
          '    <h3 ref="eSortAsc" class="ag-header-icon ag-sort-ascending-icon" ></h3>' +
          '    <h3 ref="eSortDesc" class="ag-header-icon ag-sort-descending-icon" ></h3>' +
          '    <h3 ref="eSortNone" class="ag-header-icon ag-sort-none-icon" ></h3>' +
          '    <h3 ref="eText" class="ag-header-cell-text" role="columnheader"></h3>' +
          '    <h3 ref="eFilter" class="ag-header-icon ag-filter-icon"></h3>' +
          "  </div>" +
          "</div>",
      },
    },
  ];

  const columnDefsMobile = [
    {
      headerName: "Flight",
      field: "flight",
      cellStyle: {
        color: "#0056b3",
        textDecoration: "underline",
        cursor: "pointer",
        wordBreak: "break-all",
        flexWrap: "wrap",
      },
      headerComponentParams: {
        template:
          '<div class="ag-cell-label-container" role="presentation">' +
          '  <h3 ref="eMenu" class="ag-header-icon ag-header-cell-menu-button"></h3>' +
          '  <div ref="eLabel" class="ag-header-cell-label" role="presentation">' +
          '    <h3 ref="eSortOrder" class="ag-header-icon ag-sort-order" ></h3>' +
          '    <h3 ref="eSortAsc" class="ag-header-icon ag-sort-ascending-icon" ></h3>' +
          '    <h3 ref="eSortDesc" class="ag-header-icon ag-sort-descending-icon" ></h3>' +
          '    <h3 ref="eSortNone" class="ag-header-icon ag-sort-none-icon" ></h3>' +
          '    <h3 ref="eText" class="ag-header-cell-text" role="columnheader"></h3>' +
          '    <h3 ref="eFilter" class="ag-header-icon ag-filter-icon"></h3>' +
          "  </div>" +
          "</div>",
      },
    },
    {
      headerName:
        type === "arrivals" ? "Departure City/Airport" : "Arrival City/Airport",
      field: "city",
      cellStyle: (params) => {
        {
          if (params.value.includes("/")) {
            return {
              color: "#0056b3",
              textDecoration: "underline",
              cursor: "pointer",
            };
          }
          return { wordBreak: "break-all", flexWrap: "wrap" };
        }
      },
      headerComponentParams: {
        template:
          '<div class="ag-cell-label-container" role="presentation">' +
          '  <h3 ref="eMenu" class="ag-header-icon ag-header-cell-menu-button"></h3>' +
          '  <div ref="eLabel" class="ag-header-cell-label" role="presentation">' +
          '    <h3 ref="eSortOrder" class="ag-header-icon ag-sort-order" ></h3>' +
          '    <h3 ref="eSortAsc" class="ag-header-icon ag-sort-ascending-icon" ></h3>' +
          '    <h3 ref="eSortDesc" class="ag-header-icon ag-sort-descending-icon" ></h3>' +
          '    <h3 ref="eSortNone" class="ag-header-icon ag-sort-none-icon" ></h3>' +
          '    <h3 ref="eText" class="ag-header-cell-text" role="columnheader"></h3>' +
          '    <h3 ref="eFilter" class="ag-header-icon ag-filter-icon"></h3>' +
          "  </div>" +
          "</div>",
      },
    },
    {
      headerName: "Status",
      field: "status",
      cellStyle: (params) => {
        {
          if (params.value === "landed") {
            return { color: "green" };
          }
          if (params.value === "scheduled") {
            return { color: "gray" };
          }
          if (params.value === "cancelled") {
            return { color: "red" };
          }
          return { color: "blue" };
        }
      },
      headerComponentParams: {
        template:
          '<div class="ag-cell-label-container" role="presentation">' +
          '  <h3 ref="eMenu" class="ag-header-icon ag-header-cell-menu-button"></h3>' +
          '  <div ref="eLabel" class="ag-header-cell-label" role="presentation">' +
          '    <h3 ref="eSortOrder" class="ag-header-icon ag-sort-order" ></h3>' +
          '    <h3 ref="eSortAsc" class="ag-header-icon ag-sort-ascending-icon" ></h3>' +
          '    <h3 ref="eSortDesc" class="ag-header-icon ag-sort-descending-icon" ></h3>' +
          '    <h3 ref="eSortNone" class="ag-header-icon ag-sort-none-icon" ></h3>' +
          '    <h3 ref="eText" class="ag-header-cell-text" role="columnheader"></h3>' +
          '    <h3 ref="eFilter" class="ag-header-icon ag-filter-icon"></h3>' +
          "  </div>" +
          "</div>",
      },
    },
    {
      headerName: "Airline",
      field: "airline_name",
      cellStyle: {
        color: "#0056b3",
        textDecoration: "underline",
        cursor: "pointer",
        wordBreak: "break-all",
        flexWrap: "wrap",
      },
      headerComponentParams: {
        template:
          '<div class="ag-cell-label-container" role="presentation">' +
          '  <h3 ref="eMenu" class="ag-header-icon ag-header-cell-menu-button"></h3>' +
          '  <div ref="eLabel" class="ag-header-cell-label" role="presentation">' +
          '    <h3 ref="eSortOrder" class="ag-header-icon ag-sort-order" ></h3>' +
          '    <h3 ref="eSortAsc" class="ag-header-icon ag-sort-ascending-icon" ></h3>' +
          '    <h3 ref="eSortDesc" class="ag-header-icon ag-sort-descending-icon" ></h3>' +
          '    <h3 ref="eSortNone" class="ag-header-icon ag-sort-none-icon" ></h3>' +
          '    <h3 ref="eText" class="ag-header-cell-text" role="columnheader"></h3>' +
          '    <h3 ref="eFilter" class="ag-header-icon ag-filter-icon"></h3>' +
          "  </div>" +
          "</div>",
      },
    },
    {
      headerName: "Depart",
      field: "depart",
      cellStyle: { wordBreak: "break-all", flexWrap: "wrap" },
      headerComponentParams: {
        template:
          '<div class="ag-cell-label-container" role="presentation">' +
          '  <h3 ref="eMenu" class="ag-header-icon ag-header-cell-menu-button"></h3>' +
          '  <div ref="eLabel" class="ag-header-cell-label" role="presentation">' +
          '    <h3 ref="eSortOrder" class="ag-header-icon ag-sort-order" ></h3>' +
          '    <h3 ref="eSortAsc" class="ag-header-icon ag-sort-ascending-icon" ></h3>' +
          '    <h3 ref="eSortDesc" class="ag-header-icon ag-sort-descending-icon" ></h3>' +
          '    <h3 ref="eSortNone" class="ag-header-icon ag-sort-none-icon" ></h3>' +
          '    <h3 ref="eText" class="ag-header-cell-text" role="columnheader"></h3>' +
          '    <h3 ref="eFilter" class="ag-header-icon ag-filter-icon"></h3>' +
          "  </div>" +
          "</div>",
      },
    },
        {
       headerName: "Depart Date",
      field: "dep_date",
      cellStyle: { wordBreak: "break-all", flexWrap: "wrap", minWidth: 120 },
      minWidth: 120,
      headerComponentParams: {
        template:
          '<div class="ag-cell-label-container" role="presentation">' +
          '  <h3 ref="eMenu" class="ag-header-icon ag-header-cell-menu-button"></h3>' +
          '  <div ref="eLabel" class="ag-header-cell-label" role="presentation">' +
          '    <h3 ref="eSortOrder" class="ag-header-icon ag-sort-order" ></h3>' +
          '    <h3 ref="eSortAsc" class="ag-header-icon ag-sort-ascending-icon" ></h3>' +
          '    <h3 ref="eSortDesc" class="ag-header-icon ag-sort-descending-icon" ></h3>' +
          '    <h3 ref="eSortNone" class="ag-header-icon ag-sort-none-icon" ></h3>' +
          '    <h3 ref="eText" class="ag-header-cell-text" role="columnheader"></h3>' +
          '    <h3 ref="eFilter" class="ag-header-icon ag-filter-icon"></h3>' +
          "  </div>" +
          "</div>",
      },
    },
    {
      headerName: "Arrive",
      field: "arrive",
      cellStyle: { wordBreak: "break-all", flexWrap: "wrap" },
      headerComponentParams: {
        template:
          '<div class="ag-cell-label-container" role="presentation">' +
          '  <h3 ref="eMenu" class="ag-header-icon ag-header-cell-menu-button"></h3>' +
          '  <div ref="eLabel" class="ag-header-cell-label" role="presentation">' +
          '    <h3 ref="eSortOrder" class="ag-header-icon ag-sort-order" ></h3>' +
          '    <h3 ref="eSortAsc" class="ag-header-icon ag-sort-ascending-icon" ></h3>' +
          '    <h3 ref="eSortDesc" class="ag-header-icon ag-sort-descending-icon" ></h3>' +
          '    <h3 ref="eSortNone" class="ag-header-icon ag-sort-none-icon" ></h3>' +
          '    <h3 ref="eText" class="ag-header-cell-text" role="columnheader"></h3>' +
          '    <h3 ref="eFilter" class="ag-header-icon ag-filter-icon"></h3>' +
          "  </div>" +
          "</div>",
      },
    },
        {
       headerName: "Arrive Date",
      field: "arr_date",
      cellStyle: { wordBreak: "break-all", flexWrap: "wrap", minWidth: 120 },
      minWidth: 120,
      headerComponentParams: {
        template:
          '<div class="ag-cell-label-container" role="presentation">' +
          '  <h3 ref="eMenu" class="ag-header-icon ag-header-cell-menu-button"></h3>' +
          '  <div ref="eLabel" class="ag-header-cell-label" role="presentation">' +
          '    <h3 ref="eSortOrder" class="ag-header-icon ag-sort-order" ></h3>' +
          '    <h3 ref="eSortAsc" class="ag-header-icon ag-sort-ascending-icon" ></h3>' +
          '    <h3 ref="eSortDesc" class="ag-header-icon ag-sort-descending-icon" ></h3>' +
          '    <h3 ref="eSortNone" class="ag-header-icon ag-sort-none-icon" ></h3>' +
          '    <h3 ref="eText" class="ag-header-cell-text" role="columnheader"></h3>' +
          '    <h3 ref="eFilter" class="ag-header-icon ag-filter-icon"></h3>' +
          "  </div>" +
          "</div>",
      },
    },
  ];

  function handleMoreDataFromApi() {
    if (dataFromApi && !loading) {
      setLoading(true);
      // Calcula el nuevo valor de offset sin modificar el estado directamente
      const newOffset = offset + 1;

      // Prepara la nueva URL con el nuevo offset
      const newParams = new URLSearchParams(params); // Asegúrate de que customEndpointUrl es accesible
      newParams.set("offset_value", newOffset); // Actualiza el parámetro offset
      const baseDomain = window.location.origin;
      const url = new URL(
        `${baseDomain}/wp-json/mi-plugin/v1/fetch-flight-data?${newParams}`
      );
      // Hace la petición con la nueva URL
      fetch(url.toString())
        .then((response) => {
          if (response.status === 204) {
            // Si la respuesta es 204 No Content, detén la visualización de más datos
            setdataFromApi(false);
            setLoading(false);
            // No procedas más en la cadena de promesas
            return;
          }

          if (response.ok && response.status !== 204) {
            // Si la respuesta está bien, procede a parsear el JSON
            // Actualiza el offset en el estado
            setOffset(newOffset);
            setLoading(false);
            return response.json();
          }

          // Si no es una respuesta exitosa, lanza un error
          throw new Error("Network response was not ok");
        })
        .then((data) => {
          setGlobalData((prevData) => [...prevData, ...data]);
          if (data && data.length > 0) {
            let filteredData = globalData;
            if (time_range && time_range > 0) {
              // Convert localDateTime to a moment object
              const localTimeMoment = moment(
                localDateTime,
                "YYYY-MM-DD HH:mm:ss"
              );

              // Calculate the end of the time range
              const rangeEndMoment = localTimeMoment
                .clone()
                .add(time_range, "minutes");

              // Filter the flight data
              filteredData = globalData.filter((item) => {
                // Parse the flight time
                const flightTime =
                  type === "arrivals" ? item.arrive : item.depart;
                const flightTimeMoment = moment(
                  flightTime,
                  "YYYY-MM-DD HH:mm:ss"
                );

                console.log(
                  "Flight Time Moment:",
                  flightTimeMoment.format("HH:mm:ss")
                );

                // Case 1: The rangeEndMoment is after the localTimeMoment (same-day comparison)
                if (rangeEndMoment.isAfter(localTimeMoment)) {
                  return flightTimeMoment.isBetween(
                    localTimeMoment,
                    rangeEndMoment,
                    null,
                    "[]"
                  );
                }
                // Case 2: The rangeEndMoment crosses over midnight (next-day comparison)
                else {
                  return (
                    flightTimeMoment.isAfter(localTimeMoment) || // Flights later the same day
                    flightTimeMoment.isBefore(rangeEndMoment) // Flights early the next day
                  );
                }
              });
            }
          }
          const formattedData = filteredData.map((item) => ({
            flight: item.flight,
            airport: `${item.airport} (${
              type === "arrivals" ? item.dep_code : item.arr_code
            })`,
            airport: `${item.airport} (${
              type === "arrivals" ? item.dep_code : item.arr_code
            })`,
            airport_city:
              type === "arrivals" ? item.depAirport_city : item.arrAirport_city,
            airport_state:
              type === "arrivals"
                ? item.depAirport_state
                : item.arrAirport_state,
            airport_country:
              type === "arrivals"
                ? item.depAirport_country
                : item.arrAirport_country,
            city: type === "arrivals" ? item.dep_city : item.arr_city,
            airline_name: `${item.airline_name} (${item.airline_code})`,
            status: item.status,
            depart: moment.tz(item.depart, item.tz_dep).format("HH:mm z"),
            arrive: moment.tz(item.arrive, item.tz_arr).format("HH:mm z"),
            dep_date: moment(item.depart, "YYYY-MM-DD HH:mm:ss").format("YYYY-MM-DD"), // Format date only
            arr_date: moment(item.arrive, "YYYY-MM-DD HH:mm:ss").format("YYYY-MM-DD"), // Format date only
          }));
          // Concatena los nuevos datos con los existentes
          setRowData((prevRowData) => [...prevRowData, ...formattedData]);
          setLoading(false);
        })
        .catch((error) => {
          console.error("Error fetching data:", error);
          setLoading(false);
        });
    }
  }

  return (
    <div className="ag-theme-alpine">
      {data && tableName()}
      {loadingData && (
        <div
          className="ag-custom-loading-cell"
          style={{ padding: "15px", lineHeight: "25px", fontSize: "24px" }}
        >
          <i className="fas fa-spinner fa-pulse"></i>{" "}
          <span> Loading data, one moment please...</span>
        </div>
      )}
      <AgGridReact
        rowData={rowData}
        loading={loadingData}
        suppressNoRowsOverlay={true}
        loadingOverlayComponent={CustomLoadingOverlay}
        columnDefs={
          window.innerWidth > 768 ? columnDefsDesktop : columnDefsMobile
        }
        ref={gridRef}
        suppressPaginationPanel={true}
        onPaginationChanged={onPaginationChanged}
        onGridReady={(params) => setGridApi(params.api)}
        // onGridReady={onGridReady}
        autoSizeStrategy={autoSizeStrategy}
        domLayout="autoHeight"
        onCellClicked={(event) => {
          if (event.column.colId === "flight") {
            const flightCode = event.data.flight;

            if (!flightCode) {
              window.location.href = `${window.location.origin}/404.html`;
              return;
            }
            window.location.href = `/flight/${flightCode}`;
          }
          if (event.column.colId === "airport") {
            const airportCode =
              type === "arrivals"
                ? event.data.dep_code.toLowerCase()
                : event.data.arr_code.toLowerCase();
            const airport_city = event.data.airport_city;
            const airport_state = event.data.airport_state;
            const airport_country = event.data.airport_country;
            // Verifica si baseUrl termina con '/' y elimina el último carácter si es necesario
            window.location.href = `/${airport_country}/${airport_state}/${airport_city}/${airportCode}/${
              type === "arrivals" ? "departures" : "arrivals"
            }`;
          }
          if (event.column.colId === "city" && window.innerWidth <= 768) {
            const airportCode =
              type === "arrivals"
                ? event.data.dep_code.toLowerCase()
                : event.data.arr_code.toLowerCase();
            const airport_city = event.data.airport_city;
            const airport_state = event.data.airport_state;
            const airport_country = event.data.airport_country;
            // Verifica si baseUrl termina con '/' y elimina el último carácter si es necesario
            window.location.href = `/${airport_country}/${airport_state}/${airport_city}/${airportCode}/${
              type === "arrivals" ? "departures" : "arrivals"
            }`;
          }
          if (event.column.colId === "airline_name") {
            const airlineCode = event.data.airline_code.toLowerCase();
            const baseUrl = window.location.href.split(
              type === "arrivals" ? "arrivals" : "departures"
            )[0];
            window.location.href = `${baseUrl}${
              type === "arrivals" ? "arrivals" : "departures"
            }/${airlineCode}`;
          }
        }}
        pagination={true}
        paginationPageSize={size}
      />
      <div className="flex justify-start items-center space-x-4 my-4">
        <button
          className={`button ${currentPage > 0 && !loading ? "" : "disabled"}`}
          onClick={() => gridApi.paginationGoToFirstPage()}
          disabled={currentPage === 0 || loading}
        >
          First Page
        </button>
        <button
          className={`button ${currentPage > 0 && !loading ? "" : "disabled"}`}
          onClick={() => gridApi.paginationGoToPreviousPage()}
          disabled={currentPage === 0 || loading}
        >
          Previous
        </button>
        <button
          className={`button ${dataFromApi && !loading ? "" : "disabled"}`}
          onClick={handleNextClick}
          disabled={(!dataFromApi && lastPage) || loading}
        >
          Next
        </button>
        <button
          className={`button ${!lastPage && !loading ? "" : "disabled"}`}
          onClick={() => gridApi.paginationGoToLastPage()}
          disabled={lastPage || loading}
        >
          Last Page
        </button>
        {loading && (
          <div className="ml-4 text-lg font-semibold">Loading...</div>
        )}
        {!dataFromApi && lastPage && (
          <p className="text-center text-red-700 font-semibold">
            ***** No more data *****
          </p>
        )}
      </div>
    </div>
  );
};

export default TablaAGGrid;

export const Arrival_Airplane = () => {
  return (
    <svg
      width="61"
      height="52"
      viewBox="0 0 61 52"
      fill="none"
      xmlns="http://www.w3.org/2000/svg"
    >
      <path
        d="M20.1401 30.3972L14.47 35.3015C13.8819 35.8089 14.1342 36.7734 14.8965 36.9295L17.3249 37.4266C17.5177 37.4661 17.7193 37.4442 17.8988 37.3623L35.0598 29.6258"
        stroke="white"
        stroke-width="2"
        stroke-miterlimit="10"
        stroke-linecap="round"
        stroke-linejoin="round"
      />
      <path
        d="M49.4692 24.8685L36.9967 22.3151L29.1841 5.78729C29.068 5.51281 28.8184 5.32965 28.5245 5.26948L25.5671 4.66403C24.9793 4.54369 24.4215 5.02471 24.4523 5.6224L25.0568 19.8707L13.2456 17.4526C12.0148 17.2007 11.0001 16.3613 10.531 15.1935L8.92726 11.2479C8.81458 10.9569 8.55077 10.7498 8.23849 10.6859L6.36485 10.3023C5.72194 10.1707 5.15322 10.705 5.24955 11.3563L6.0831 17.2877C6.65731 21.2139 9.61052 24.364 13.4864 25.1575L53.3104 33.3104C54.633 33.5812 55.9165 32.7339 56.1872 31.4113C56.3527 30.6031 56.099 29.7856 55.5317 29.191L53.2952 26.9341C52.2483 25.8776 50.9204 25.1656 49.4692 24.8685Z"
        stroke="white"
        stroke-width="2"
        stroke-miterlimit="10"
        stroke-linecap="round"
        stroke-linejoin="round"
      />
      <path
        d="M43.7759 27.5307L43.5922 27.4931"
        stroke="white"
        stroke-width="2"
        stroke-miterlimit="10"
        stroke-linecap="round"
        stroke-linejoin="round"
      />
      <path
        d="M40.1021 26.7786L39.9184 26.741"
        stroke="white"
        stroke-width="2"
        stroke-miterlimit="10"
        stroke-linecap="round"
        stroke-linejoin="round"
      />
      <path
        d="M36.4283 26.0265L36.2446 25.9889"
        stroke="white"
        stroke-width="2"
        stroke-miterlimit="10"
        stroke-linecap="round"
        stroke-linejoin="round"
      />
      <path
        d="M32.7545 25.2743L32.5708 25.2367"
        stroke="white"
        stroke-width="2"
        stroke-miterlimit="10"
        stroke-linecap="round"
        stroke-linejoin="round"
      />
      <path
        d="M29.0807 24.5222L28.897 24.4846"
        stroke="white"
        stroke-width="2"
        stroke-miterlimit="10"
        stroke-linecap="round"
        stroke-linejoin="round"
      />
      <path
        d="M25.4069 23.7701L25.2232 23.7325"
        stroke="white"
        stroke-width="2"
        stroke-miterlimit="10"
        stroke-linecap="round"
        stroke-linejoin="round"
      />
      <path
        d="M21.7331 23.018L21.5494 22.9804"
        stroke="white"
        stroke-width="2"
        stroke-miterlimit="10"
        stroke-linecap="round"
        stroke-linejoin="round"
      />
      <path
        d="M18.0593 22.2659L17.8756 22.2283"
        stroke="white"
        stroke-width="2"
        stroke-miterlimit="10"
        stroke-linecap="round"
        stroke-linejoin="round"
      />
      <path
        d="M7 51H57.625"
        stroke="white"
        stroke-width="2"
        stroke-miterlimit="10"
        stroke-linecap="round"
        stroke-linejoin="round"
      />
    </svg>
  );
};
export const Cancelled_Flight = () => {
  return (
    <svg
      width="70"
      height="70"
      viewBox="0 0 70 70"
      fill="none"
      xmlns="http://www.w3.org/2000/svg"
    >
      <path
        d="M48.4375 37H48.25"
        stroke="white"
        stroke-width="1.875"
        stroke-miterlimit="10"
        stroke-linecap="round"
        stroke-linejoin="round"
      />
      <path
        d="M44.6875 37H44.5"
        stroke="white"
        stroke-width="1.875"
        stroke-miterlimit="10"
        stroke-linecap="round"
        stroke-linejoin="round"
      />
      <path
        d="M40.9375 37H40.75"
        stroke="white"
        stroke-width="1.875"
        stroke-miterlimit="10"
        stroke-linecap="round"
        stroke-linejoin="round"
      />
      <path
        d="M37.1875 37H37"
        stroke="white"
        stroke-width="1.875"
        stroke-miterlimit="10"
        stroke-linecap="round"
        stroke-linejoin="round"
      />
      <path
        d="M33.4375 37H33.25"
        stroke="white"
        stroke-width="1.875"
        stroke-miterlimit="10"
        stroke-linecap="round"
        stroke-linejoin="round"
      />
      <path
        d="M29.6875 37H29.5"
        stroke="white"
        stroke-width="1.875"
        stroke-miterlimit="10"
        stroke-linecap="round"
        stroke-linejoin="round"
      />
      <path
        d="M25.9375 37H25.75"
        stroke="white"
        stroke-width="1.875"
        stroke-miterlimit="10"
        stroke-linecap="round"
        stroke-linejoin="round"
      />
      <path
        d="M22.1875 37H22"
        stroke="white"
        stroke-width="1.875"
        stroke-miterlimit="10"
        stroke-linecap="round"
        stroke-linejoin="round"
      />
      <circle cx="35" cy="35" r="33" stroke="white" stroke-width="4" />
      <path
        d="M54.0899 34H41.3586L30.3899 19.375C30.2211 19.1294 29.9399 19 29.6399 19H26.6211C26.0211 19 25.5711 19.5831 25.7211 20.1625L29.1711 34H17.1149C15.8586 34 14.6961 33.3812 14.0024 32.3312L11.6399 28.7875C11.4711 28.525 11.1711 28.375 10.8524 28.375H8.93988C8.28363 28.375 7.83363 29.0125 8.05863 29.6313L10.0649 35.275C11.4149 39.0063 14.9399 41.5 18.8961 41.5H59.5461C60.8961 41.5 61.9836 40.4125 61.9836 39.0625C61.9836 38.2375 61.5711 37.4875 60.8961 37.0187L58.2524 35.2563C57.0149 34.4313 55.5711 34 54.0899 34Z"
        stroke="white"
        stroke-width="2"
        stroke-miterlimit="10"
        stroke-linecap="round"
        stroke-linejoin="round"
      />
      <path d="M17 10L55 62" stroke="white" stroke-width="4" />
    </svg>
  );
};
export const Departure_Airplane = () => {
  return (
    <svg
      width="57"
      height="51"
      viewBox="0 0 57 51"
      fill="none"
      xmlns="http://www.w3.org/2000/svg"
    >
      <path
        d="M1 30.8303L8.11563 28.5128"
        stroke="white"
        stroke-width="2"
        stroke-miterlimit="10"
        stroke-linecap="round"
        stroke-linejoin="round"
      />
      <path
        d="M1 8.3641L11.8656 4.70035"
        stroke="white"
        stroke-width="2"
        stroke-miterlimit="10"
        stroke-linecap="round"
        stroke-linejoin="round"
      />
      <path
        d="M6.67938 38.2216L17.4906 34.7003"
        stroke="white"
        stroke-width="2"
        stroke-miterlimit="10"
        stroke-linecap="round"
        stroke-linejoin="round"
      />
      <path
        d="M55.1875 49.1866H55.375"
        stroke="white"
        stroke-width="2"
        stroke-miterlimit="10"
        stroke-linecap="round"
        stroke-linejoin="round"
      />
      <path
        d="M1 49.1866H51.625"
        stroke="white"
        stroke-width="2"
        stroke-miterlimit="10"
        stroke-linecap="round"
        stroke-linejoin="round"
      />
      <path
        d="M25.1837 27.041L22.6731 34.1041C22.4125 34.8372 23.1062 35.5497 23.845 35.3097L26.2037 34.5447C26.3912 34.4828 26.5562 34.3647 26.6706 34.2053L37.6469 19.1866"
        stroke="white"
        stroke-width="2"
        stroke-miterlimit="10"
        stroke-linecap="round"
        stroke-linejoin="round"
      />
      <path
        d="M46.1819 8.33785L35.8581 11.6922L20.9069 1.17347C20.6706 0.993472 20.3631 0.955972 20.0781 1.04972L17.2075 1.9816C16.6375 2.1691 16.3881 2.8591 16.7106 3.36535L24.2669 15.4591L12.8012 19.1828C11.6069 19.5728 10.3094 19.3441 9.32499 18.5585L5.98186 15.9185C5.73999 15.7235 5.40811 15.671 5.10624 15.7703L3.28749 16.3591C2.66311 16.5635 2.43249 17.3078 2.83749 17.8272L6.48999 22.5747C8.92749 25.706 13.0506 26.9885 16.8119 25.766L53.6894 13.7828C54.9737 13.3647 55.6712 11.9941 55.2531 10.7116C55 9.92972 54.3756 9.34285 53.5881 9.10472L50.5281 8.24597C49.0975 7.84472 47.5919 7.88035 46.1819 8.33785Z"
        stroke="white"
        stroke-width="2"
        stroke-miterlimit="10"
        stroke-linecap="round"
        stroke-linejoin="round"
      />
      <path
        d="M43.33 13L43.1504 13.0537"
        stroke="white"
        stroke-width="2"
        stroke-miterlimit="10"
        stroke-linecap="round"
        stroke-linejoin="round"
      />
      <path
        d="M39.7371 14.074L39.5575 14.1277"
        stroke="white"
        stroke-width="2"
        stroke-miterlimit="10"
        stroke-linecap="round"
        stroke-linejoin="round"
      />
      <path
        d="M36.1442 15.148L35.9645 15.2017"
        stroke="white"
        stroke-width="2"
        stroke-miterlimit="10"
        stroke-linecap="round"
        stroke-linejoin="round"
      />
      <path
        d="M32.5513 16.222L32.3716 16.2757"
        stroke="white"
        stroke-width="2"
        stroke-miterlimit="10"
        stroke-linecap="round"
        stroke-linejoin="round"
      />
      <path
        d="M28.9584 17.296L28.7787 17.3498"
        stroke="white"
        stroke-width="2"
        stroke-miterlimit="10"
        stroke-linecap="round"
        stroke-linejoin="round"
      />
      <path
        d="M25.3655 18.3701L25.1858 18.4238"
        stroke="white"
        stroke-width="2"
        stroke-miterlimit="10"
        stroke-linecap="round"
        stroke-linejoin="round"
      />
      <path
        d="M21.7725 19.4441L21.5929 19.4978"
        stroke="white"
        stroke-width="2"
        stroke-miterlimit="10"
        stroke-linecap="round"
        stroke-linejoin="round"
      />
      <path
        d="M18.1796 20.5181L18 20.5718"
        stroke="white"
        stroke-width="2"
        stroke-miterlimit="10"
        stroke-linecap="round"
        stroke-linejoin="round"
      />
    </svg>
  );
};
export const Active_Flight = () => {
  return (
    <svg
      width="57"
      height="53"
      viewBox="0 0 57 53"
      fill="none"
      xmlns="http://www.w3.org/2000/svg"
    >
      <path
        d="M19.8569 27.2988L15.2856 33.2406C14.8113 33.8556 15.2519 34.75 16.03 34.75H18.5088C18.7056 34.75 18.8988 34.6881 19.0581 34.5719L34.3188 23.5506"
        stroke="white"
        stroke-width="2"
        stroke-miterlimit="10"
        stroke-linecap="round"
        stroke-linejoin="round"
      />
      <path
        d="M47.4813 16H34.75L23.7813 1.375C23.6125 1.12938 23.3313 1 23.0313 1H20.0125C19.4125 1 18.9625 1.58312 19.1125 2.1625L22.5625 16H10.5063C9.25001 16 8.08751 15.3812 7.39376 14.3312L5.03126 10.7875C4.86251 10.525 4.56251 10.375 4.24376 10.375H2.33126C1.67501 10.375 1.22501 11.0125 1.45001 11.6313L3.45626 17.275C4.80626 21.0063 8.33126 23.5 12.2875 23.5H52.9375C54.2875 23.5 55.375 22.4125 55.375 21.0625C55.375 20.2375 54.9625 19.4875 54.2875 19.0187L51.6438 17.2563C50.4063 16.4313 48.9625 16 47.4813 16Z"
        stroke="white"
        stroke-width="2"
        stroke-miterlimit="10"
        stroke-linecap="round"
        stroke-linejoin="round"
      />
      <path
        d="M42.4375 19.75H42.25"
        stroke="white"
        stroke-width="2"
        stroke-miterlimit="10"
        stroke-linecap="round"
        stroke-linejoin="round"
      />
      <path
        d="M38.6875 19.75H38.5"
        stroke="white"
        stroke-width="2"
        stroke-miterlimit="10"
        stroke-linecap="round"
        stroke-linejoin="round"
      />
      <path
        d="M34.9375 19.75H34.75"
        stroke="white"
        stroke-width="2"
        stroke-miterlimit="10"
        stroke-linecap="round"
        stroke-linejoin="round"
      />
      <path
        d="M31.1875 19.75H31"
        stroke="white"
        stroke-width="2"
        stroke-miterlimit="10"
        stroke-linecap="round"
        stroke-linejoin="round"
      />
      <path
        d="M27.4375 19.75H27.25"
        stroke="white"
        stroke-width="2"
        stroke-miterlimit="10"
        stroke-linecap="round"
        stroke-linejoin="round"
      />
      <path
        d="M23.6875 19.75H23.5"
        stroke="white"
        stroke-width="2"
        stroke-miterlimit="10"
        stroke-linecap="round"
        stroke-linejoin="round"
      />
      <path
        d="M19.9375 19.75H19.75"
        stroke="white"
        stroke-width="2"
        stroke-miterlimit="10"
        stroke-linecap="round"
        stroke-linejoin="round"
      />
      <path
        d="M16.1875 19.75H16"
        stroke="white"
        stroke-width="2"
        stroke-miterlimit="10"
        stroke-linecap="round"
        stroke-linejoin="round"
      />
      <path
        d="M13.2456 39.9044C12.1113 37.9431 9.99062 36.625 7.5625 36.625C3.93625 36.625 1 39.5612 1 43.1875C1 46.8119 3.93625 49.75 7.5625 49.75"
        stroke="white"
        stroke-width="2"
        stroke-miterlimit="10"
        stroke-linecap="round"
      />
      <path
        d="M18.8106 47.8788C19.3994 47.095 19.75 46.1181 19.75 45.0625C19.75 42.4731 17.6519 40.375 15.0625 40.375C13.6938 40.375 12.4581 40.9619 11.6013 41.8994"
        stroke="white"
        stroke-width="2"
        stroke-miterlimit="10"
        stroke-linecap="round"
        stroke-linejoin="round"
      />
      <path
        d="M30.5425 40.3731C31.7012 37.0975 34.8269 34.75 38.5 34.75C41.7081 34.75 44.4981 36.5406 45.925 39.175"
        stroke="white"
        stroke-width="2"
        stroke-miterlimit="10"
        stroke-linecap="round"
        stroke-linejoin="round"
      />
      <path
        d="M23.5769 47.9406C23.5263 47.6144 23.5 47.2787 23.5 46.9375C23.5 43.3112 26.4362 40.375 30.0625 40.375C31.0919 40.375 32.0669 40.6131 32.9331 41.0369"
        stroke="white"
        stroke-width="2"
        stroke-miterlimit="10"
        stroke-linecap="round"
        stroke-linejoin="round"
      />
      <path
        d="M42.8819 42.2481C43.9337 40.0319 46.195 38.5 48.8125 38.5C52.4388 38.5 55.375 41.4362 55.375 45.0625C55.375 48.6869 52.4388 51.625 48.8125 51.625H29.125"
        stroke="white"
        stroke-width="2"
        stroke-miterlimit="10"
        stroke-linecap="round"
        stroke-linejoin="round"
      />
    </svg>
  );
};
export const Landed_Flight = () => {
  return (
    <svg
      width="57"
      height="34"
      viewBox="0 0 57 34"
      fill="none"
      xmlns="http://www.w3.org/2000/svg"
    >
      <path
        d="M47.0899 16H34.3586L23.3899 1.375C23.2211 1.12938 22.9399 1 22.6399 1H19.6211C19.0211 1 18.5711 1.58312 18.7211 2.1625L22.1711 16H10.1149C8.85863 16 7.69613 15.3812 7.00238 14.3312L4.63988 10.7875C4.47113 10.525 4.17113 10.375 3.85238 10.375H1.93988C1.28363 10.375 0.833634 11.0125 1.05863 11.6313L3.06488 17.275C4.41488 21.0063 7.93988 23.5 11.8961 23.5H52.5461C53.8961 23.5 54.9836 22.4125 54.9836 21.0625C54.9836 20.2375 54.5711 19.4875 53.8961 19.0187L51.2524 17.2563C50.0149 16.4313 48.5711 16 47.0899 16Z"
        stroke="white"
        stroke-width="2"
        stroke-miterlimit="10"
        stroke-linecap="round"
        stroke-linejoin="round"
      />
      <path
        d="M42.0461 19.75H41.8586"
        stroke="white"
        stroke-width="2"
        stroke-miterlimit="10"
        stroke-linecap="round"
        stroke-linejoin="round"
      />
      <path
        d="M38.2961 19.75H38.1086"
        stroke="white"
        stroke-width="2"
        stroke-miterlimit="10"
        stroke-linecap="round"
        stroke-linejoin="round"
      />
      <path
        d="M34.5461 19.75H34.3586"
        stroke="white"
        stroke-width="2"
        stroke-miterlimit="10"
        stroke-linecap="round"
        stroke-linejoin="round"
      />
      <path
        d="M30.7961 19.75H30.6086"
        stroke="white"
        stroke-width="2"
        stroke-miterlimit="10"
        stroke-linecap="round"
        stroke-linejoin="round"
      />
      <path
        d="M27.0461 19.75H26.8586"
        stroke="white"
        stroke-width="2"
        stroke-miterlimit="10"
        stroke-linecap="round"
        stroke-linejoin="round"
      />
      <path
        d="M23.2961 19.75H23.1086"
        stroke="white"
        stroke-width="2"
        stroke-miterlimit="10"
        stroke-linecap="round"
        stroke-linejoin="round"
      />
      <path
        d="M19.5461 19.75H19.3586"
        stroke="white"
        stroke-width="2"
        stroke-miterlimit="10"
        stroke-linecap="round"
        stroke-linejoin="round"
      />
      <path
        d="M15.7961 19.75H15.6086"
        stroke="white"
        stroke-width="2"
        stroke-miterlimit="10"
        stroke-linecap="round"
        stroke-linejoin="round"
      />
      <path
        d="M4.4447 32.0707H55.0697"
        stroke="white"
        stroke-width="2"
        stroke-miterlimit="10"
        stroke-linecap="round"
        stroke-linejoin="round"
      />
    </svg>
  );
};
export const Scheduled_Flight = () => {
  return (
    <svg
      width="61"
      height="61"
      viewBox="0 0 61 61"
      fill="none"
      xmlns="http://www.w3.org/2000/svg"
    >
      <path
        d="M40.3593 42.8783H40.2148"
        stroke="white"
        stroke-width="1.875"
        stroke-miterlimit="10"
        stroke-linecap="round"
        stroke-linejoin="round"
      />
      <path
        d="M37.468 42.8783H37.3235"
        stroke="white"
        stroke-width="1.875"
        stroke-miterlimit="10"
        stroke-linecap="round"
        stroke-linejoin="round"
      />
      <path
        d="M34.5767 42.8783H34.4322"
        stroke="white"
        stroke-width="1.875"
        stroke-miterlimit="10"
        stroke-linecap="round"
        stroke-linejoin="round"
      />
      <path
        d="M31.6854 42.8783H31.5409"
        stroke="white"
        stroke-width="1.875"
        stroke-miterlimit="10"
        stroke-linecap="round"
        stroke-linejoin="round"
      />
      <path
        d="M28.7941 42.8783H28.6496"
        stroke="white"
        stroke-width="1.875"
        stroke-miterlimit="10"
        stroke-linecap="round"
        stroke-linejoin="round"
      />
      <path
        d="M25.9028 42.8783H25.7583"
        stroke="white"
        stroke-width="1.875"
        stroke-miterlimit="10"
        stroke-linecap="round"
        stroke-linejoin="round"
      />
      <path
        d="M23.0115 42.8783H22.8669"
        stroke="white"
        stroke-width="1.875"
        stroke-miterlimit="10"
        stroke-linecap="round"
        stroke-linejoin="round"
      />
      <path
        d="M20.1202 42.8783H19.9756"
        stroke="white"
        stroke-width="1.875"
        stroke-miterlimit="10"
        stroke-linecap="round"
        stroke-linejoin="round"
      />
      <path
        d="M44.8586 40.3333H34.9535L26.4196 29.2833C26.2883 29.0978 26.0695 29 25.8361 29H23.4875C23.0207 29 22.6706 29.4406 22.7873 29.8783L25.4714 40.3333H16.0915C15.1141 40.3333 14.2097 39.8658 13.6699 39.0725L11.8319 36.395C11.7006 36.1967 11.4672 36.0833 11.2192 36.0833H9.73124C9.22067 36.0833 8.87056 36.565 9.04562 37.0325L10.6065 41.2967C11.6568 44.1158 14.3993 46 17.4773 46H49.1036C50.1539 46 51 45.1783 51 44.1583C51 43.535 50.6791 42.9683 50.1539 42.6142L48.097 41.2825C47.1342 40.6592 46.011 40.3333 44.8586 40.3333Z"
        stroke="white"
        stroke-width="2"
        stroke-miterlimit="10"
        stroke-linecap="round"
        stroke-linejoin="round"
      />
      <path
        d="M3 21.3333H58M15.2222 3V9.11111M45.7778 3V9.11111M12.7778 58H48.2222C51.6447 58 53.3562 58 54.6633 57.3339C55.8131 56.7481 56.7481 55.8131 57.3339 54.6633C58 53.3562 58 51.6447 58 48.2222V18.8889C58 15.4663 58 13.7551 57.3339 12.4478C56.7481 11.2979 55.8131 10.3631 54.6633 9.77719C53.3562 9.11111 51.6447 9.11111 48.2222 9.11111H12.7778C9.35525 9.11111 7.64396 9.11111 6.33673 9.77719C5.18683 10.3631 4.25195 11.2979 3.66608 12.4478C3 13.7551 3 15.4663 3 18.8889V48.2222C3 51.6447 3 53.3562 3.66608 54.6633C4.25195 55.8131 5.18683 56.7481 6.33673 57.3339C7.64396 58 9.35522 58 12.7778 58Z"
        stroke="white"
        stroke-width="5"
        stroke-linecap="round"
        stroke-linejoin="round"
      />
    </svg>
  );
};
