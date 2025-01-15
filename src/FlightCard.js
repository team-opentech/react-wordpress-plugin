import React, { useEffect, useState } from "react";

import {
  formatDate,
  formatTimeWithAMPM,
  // secondsToHours,
  minutesToHours,
  // getElapsedTime,
  // getRemainingTime,
} from "./helper.js";
import { DateTime } from "luxon";
import moment, { min } from "moment-timezone";

const FlightCard = ({ data, loadingData }) => {
  const [localTime, setLocalTime] = useState(null); // Estado para almacenar la hora local del aeropuerto de salida
  const [localArrTime, setLocalArrTime] = useState(null); // Estado para almacenar la hora local del aeropuerto de llegada
  const baseUrl = window.location.origin;
  // console.log("FlightCard data", data);

  const fetchLocalTime = (data) => {
    // Construct queryParams dynamically using the values from `data`
    const queryParamsDep = `airportCode=${data?.depIata}&airp_codeType=iata`;
    const queryParamsArr = `airportCode=${data?.arrIata}&airp_codeType=iata`;

    const localTimeDepUrl = `${baseUrl}/wp-json/mi-plugin/v1/local-time?${queryParamsDep}`;
    const localTimeArrUrl = `${baseUrl}/wp-json/mi-plugin/v1/local-time?${queryParamsArr}`;

    fetch(localTimeDepUrl)
      .then((response) => {
        if (!response.ok) {
          throw new Error("Error fetching local time");
        }
        return response.json();
      })
      .then((data) => {
        const localDateTime = data.local_time; // Store the full datetime string
        const localTime = localDateTime.split(" ")[1]; // Extract only the time part

        setLocalTime(localDateTime); // Set only the time part if needed elsewhere
      })
      .catch((error) => {
        console.error("Error fetching local time:", error);
      });
    fetch(localTimeArrUrl)
      .then((response) => {
        if (!response.ok) {
          throw new Error("Error fetching local time");
        }
        return response.json();
      })
      .then((data) => {
        const localDateTime = data.local_time; // Store the full datetime string
        const localTime = localDateTime.split(" ")[1]; // Extract only the time part

        setLocalArrTime(localDateTime); // Set only the time part if needed elsewhere
      })
      .catch((error) => {
        console.error("Error fetching local time:", error);
      });
  };

  useEffect(() => {
    // Check if data and data.depIata are available before fetching
    if (data && data.depIata && data.arrIata) {
      fetchLocalTime(data);
    }
  }, [data]);

  const getElapsedTime = (data) => {
    if (!data?.depTimeTs) return 0;

    const departureTime = new Date(data.depTimeTs.replace(" ", "T")).getTime(); // Normalize to ISO format
    const currentTime = new Date().getTime(); // Current time in milliseconds

    const elapsedTime = (currentTime - departureTime) / 1000; // Time elapsed in seconds
    return Math.max(elapsedTime, 0); // Ensure elapsed time is not negative
  };

  const getWidth = (data) => {
    if (!data) return 0;

    if (data.status === "landed") return 100; // Full progress if the flight has landed
    if (data.status === "scheduled" || data.status === "cancelled") return 0; // No progress for scheduled or cancelled flights

    const elapsedTime = getElapsedTime(data); // Get elapsed time in seconds
    const totalDurationSeconds = data.duration * 60; // Convert duration from minutes to seconds

    // Calculate the progress percentage
    const progressPercentage = (elapsedTime / totalDurationSeconds) * 100;
    return Math.min(progressPercentage, 100); // Ensure the progress does not exceed 100%
  };

  // const getWidth = (data) => {
  //   if (data === null) return;
  //   if (data?.status === "landed") return 100;
  //   if (data?.status === "scheduled") return 0;
  //   const elapsedTime = getElapsedTime(data);
  //   const totalDurationSeconds = data.duration * 60;

  //   if ((elapsedTime / totalDurationSeconds) * 100 > 100) {
  //     return 100;
  //   } else {
  //     return (elapsedTime / totalDurationSeconds) * 100;
  //   }
  // };
  // const getWidth = (data) => {
  //   if (data === null) return;
  //   if (data?.status === "landed") return 100;
  //   if (data?.status === "scheduled") return 0;
  //   if ((getElapsedTime(data) / (data.duration * 60)) * 100 > 100) {
  //     return 100;
  //   } else {
  //     return (getElapsedTime(data) / (data.duration * 60)) * 100;
  //   }
  // };

  // Helper function to calculate remaining time in seconds
  const getRemainingTime = (targetTime, currentTime) => {
    if (!targetTime || !currentTime) return 0; // Fallback if either time is missing

    // Ensure both targetTime and currentTime have the same date and format
    const normalizeTime = (time, baseTime) => {
      if (time.length <= 8) {
        // If time is in HH:mm:ss or HH:mm, prepend the date from baseTime
        const currentDate = new Date(baseTime.replace(" ", "T"))
          .toISOString()
          .split("T")[0]; // Extract YYYY-MM-DD
        return `${currentDate} ${time}`; // Combine date and time
      }
      return time; // Return full datetime as-is
    };

    const normalizedTarget = normalizeTime(targetTime, currentTime).replace(
      " ",
      "T"
    );
    const normalizedCurrent = currentTime.replace(" ", "T");

    const target = new Date(normalizedTarget).getTime(); // Convert normalized target time to timestamp
    const current = new Date(normalizedCurrent).getTime(); // Convert normalized current time to timestamp

    if (isNaN(target) || isNaN(current)) {
      console.error("Invalid date format:", { targetTime, currentTime });
      return 0; // Fallback for invalid date formats
    }

    // Return difference in seconds (positive if target is ahead, negative if behind)
    return (target - current) / 1000;
  };

  // Helper function to format seconds into "Xh Ymin"
  const secondsToHours = (seconds) => {
    if (isNaN(seconds)) return "N/A"; // Fallback for invalid input

    const isPast = seconds < 0; // Check if the time difference is negative
    const absSeconds = Math.abs(seconds); // Get the absolute value of seconds
    const hours = Math.floor(absSeconds / 3600);
    const minutes = Math.floor((absSeconds % 3600) / 60);

    return `${isPast ? "-" : ""}${hours > 0 ? `${hours}h ` : ""}${minutes}min`;
  };

  // Main render function
  const renderFlightStatus = (data, localTime, localArrTime) => {
    if (!data || !localTime) return null;

    let remainingTime;

    // Handle different statuses
    switch (data.status) {
      case "scheduled":
        remainingTime = getRemainingTime(data.depTimeTs, localTime);
        return (
          <p className="text-sm text-[#7794B0]">
            Expected to depart in {secondsToHours(remainingTime)}
          </p>
        );

      case "landed":
        remainingTime = getRemainingTime(localArrTime, data.arrTimeTs);
        return (
          <p className="text-sm text-[#7794B0]">
            Landed {secondsToHours(remainingTime)} ago
          </p>
        );

      case "cancelled":
        return null;

      default:
        const expectedArrivalTime = new Date(
          new Date(data.depTimeTs.replace(" ", "T")).getTime() +
            data.duration * 60000 // Add duration in milliseconds
        ).toISOString();

        remainingTime = getRemainingTime(expectedArrivalTime, localTime);
        return (
          <p className="text-sm text-[#7794B0]">
            Arriving in {secondsToHours(remainingTime)}
          </p>
        );
    }
  };

  // const renderFlightStatus = (data, localTime, localArrTime) => {
  //   if (data === null || localTime === null) return null;

  //   const remainingTime = getRemainingTime(data, localTime);

  //   if (data?.status === "landed") {
  //     return (
  //       <p className="text-sm text-[#7794B0]">
  //         Landed   {}   ago
  //       </p>
  //     );
  //   }

  //   if (data?.status === "scheduled") {
  //     return (
  //       <p className="text-sm text-[#7794B0]">
  //         Expected to depart in {secondsToHours(remainingTime)}
  //       </p>
  //     );
  //   }
  //   if (data?.status === "cancelled") {
  //     return <p className="text-sm text-[#7794B0]">Flight Cancelled</p>;
  //   }

  //   return (
  //     <p className="text-sm text-[#7794B0]">
  //       Arriving in {secondsToHours(remainingTime)}
  //     </p>
  //   );
  // };

  // const renderFlightStatus = (data) => {
  //   if (data === null) return;
  //   if (data?.status === "landed")
  //     return (
  //       <p className="text-sm text-[#7794B0]">
  //         Landed {minutesToHours(data.duration)} ago
  //       </p>
  //     );
  //   if (data.status === "scheduled")
  //     return (
  //       <p className="text-sm text-[#7794B0]">
  //         Expected to depart in {secondsToHours(getRemainingTime(data))}
  //       </p>
  //     );
  //   return (
  //     <p className="text-sm text-[#7794B0]">
  //       Arriving in {secondsToHours(getRemainingTime(data))}
  //     </p>
  //   );
  // };

  // Function to format time and show delay if exists
  const formatTimeWithDelay = (time, delay) => {
    // If time is undefined or invalid, return a fallback
    if (!time) {
      return (
        <div>
          <div>Time: N/A</div>
          <div>Date: N/A</div>
        </div>
      );
    }

    // Split the input time into date and time
    const [formattedDate, formattedTime] = time.toString().split(" ");
    // Format the date to dd-mm-yyyy
    const [year, month, day] = formattedDate.split("-");
    const formattedDateDDMMYYYY = `${day}-${month}-${year}`;
    // Create the delay text if delay exists
    const delayText =
      delay && delay > 0 ? `(Delayed by ${minutesToHours(delay)})` : null;

    // Return a div containing the time, date, and delay information
    return (
      <div>
        <div>
          {formattedTime} {delayText && `${delayText}`}
        </div>
        <div>{formattedDateDDMMYYYY}</div>
      </div>
    );
  };

  return (
    <section className="container mx-auto my-8">
      <div className="px-4 flex flex-col items-center justify-center sm:px-16">
        {localTime && (
          <div className="px-2 border-x-[1px] border-lightBlue-500">
            <p className="text-lg text-[#7794B0] font-semibold">
              Departure local Time {localTime}
            </p>
            <p className="text-lg text-[#7794B0] font-semibold">
              Arrival local Time {localArrTime}
            </p>
          </div>
        )}
        {loadingData && (
          <div
            className="ag-custom-loading-cell"
            style={{ padding: "15px", lineHeight: "25px", fontSize: "24px" }}
          >
            <i className="fas fa-spinner fa-pulse"></i>{" "}
            <span> Loading data, one moment please...</span>
          </div>
        )}
        <div className="bg-lightBlue-500 rounded-xl w-full p-4 sm:p-8 md:p-12 shadow-sm">
          <div className="bg-white w-full h-full rounded-xl shadow-sm flex flex-col">
            <div className="w-full flex flex-row items-center p-4 lg:px-8">
              <div className="pr-2 border-lightBlue-500">
                <img
                  src={data?.airlineLogo || ""}
                  alt="airline logo"
                  width="48"
                  height="48"
                />
              </div>
              <div className="px-2 border-x-[1px] border-lightBlue-500">
                <p className="text-sm text-[#7794B0] font-semibold">
                  {data?.airlineName || ""} {data?.flightNumber || ""}
                </p>
                <p className="text-sm text-[#7794B0] font-normal">
                  {data?.flightIcao || ""} / {data?.flightIata || ""}
                </p>
              </div>
              <div className="pl-2">
                <p className="uppercase text-sm font-bold text-orange-600">
                  {data?.status || ""}
                </p>
                {renderFlightStatus(data, localTime, localArrTime) || null}
              </div>
            </div>
            <div className="w-full flex flex-row p-4 gap-4 flex-wrap justify-between lg:px-8">
              <div className="w-fit">
                {/* <p className="font-semibold text-lg text-customGreen leading-none uppercase">
                  {data.depIata}
                </p> */}
                <p className="font-semibold text-lg text-[#013877] leading-none uppercase">
                  {data?.depCity || ""}
                </p>
                {/* <p className="font-light text-sm text-[#7794B0] pt-1">
                  left{" "}
                  <span className="font-semibold text-base text-[#013877]">
                    Gate {data?.depGate}
                  </span>
                </p> */}
                <p className="text-blue-500 font-semibold pb-1 border-b-[1px] border-dashed border-[#7794B0]">
                  {data?.depAirportName || ""} - {data?.depIata || ""}
                </p>
                <p className="text-sm text-[#7794B0] capitalize">
                  Local Departure Time
                  {formatTimeWithDelay(data?.depTimeTs, data?.depDelayed)}
                </p>
                {/* {data?.depDelayed === null ? (
                  <p className="text-sm text-[#7794B0] capitalize">
                    {/* {formatTimeWithAMPM(parseInt(data?.depTimeTs || null))}{" "} }
                    {moment.tz(data?.depTimeTs, data?.tz_dep).format("HH:mm z") || null}
                    {/* <span className="text-customGreen">(On time)</span> }
                  </p>
                ) : (
                  <p className="text-sm text-[#7794B0] capitalize">
                    {/* {formatTimeWithAMPM(parseInt(data?.depTimeTs || null))}{" "} }
                    {moment.tz(data?.depTimeTs, data?.tz_dep).format("HH:mm z") || null}
                    {/* <span className="text-customGreen">
                      ({data.depDelayed} minutes later)
                    </span> }
                  </p>
                )} */}
                <p className="font-light text-sm text-[#7794B0] pt-1">
                  <span className="font-semibold text-base text-[#013877]">
                    {data?.depGate || ""} Gate
                  </span>
                </p>
              </div>
              <div className="w-fit self-end">
                {/* <p className="font-semibold text-lg text-orange-600 leading-none uppercase">
                  {data.arrIata}
                </p> */}
                <p className="font-semibold text-lg text-[#013877] leading-none uppercase">
                  {data?.arrCity || ""}
                </p>
                {/* <p className="font-light text-sm text-[#7794B0] pt-1">
                  arriving at{" "}
                  <span className="font-semibold text-base text-[#013877]">
                    Gate {data.arrGate}
                  </span>
                </p> */}
                <p className="text-blue-500 font-semibold pb-1 border-b-[1px] border-dashed border-[#7794B0]">
                  {data?.arrAirportName || ""} - {data?.arrIata || ""}
                </p>
                <p className="text-sm text-[#7794B0] capitalize">
                  Local Arrival Time
                  {formatTimeWithDelay(data?.arrTimeTs, data?.arrDelayed)}
                </p>

                {/* {data?.arrDelayed === null ? (
                  <p className="text-sm text-[#7794B0] capitalize">
                    {/* {formatTimeWithAMPM(parseInt(data?.arrTimeTs || null))}{" "} }
                    {moment.tz(data?.arrTimeTs, data?.tz_arr).format("HH:mm z") || null}
                    {/* <span className="text-orange-600">(On time)</span> }
                  </p>
                ) : (
                  <p className="text-sm text-[#7794B0] capitalize">
                    {/* {formatTimeWithAMPM(parseInt(data?.arrTimeTs || null))}{" "} }
                    {moment.tz(data?.arrTimeTs, data?.tz_arr).format("HH:mm z") || null}
                    {/* <span className="text-orange-600">
                      ({data.arrDelayed} minutes later)
                    </span> }
                  </p>
                )} */}
                <p className="font-light text-sm text-[#7794B0] pt-1">
                  <span className="font-semibold text-base text-[#013877]">
                    {data?.arrGate || ""} Gate
                  </span>
                </p>
              </div>
            </div>
            <div className="w-full px-6 relative lg:px-12">
              <div
                className={`${
                  data?.status !== "cancelled"
                    ? "h-1 w-full bg-orange-300 opacity-90 mb-2"
                    : "hidden"
                }`}
              >
                <div
                  className="h-1 bg-customGreen relative"
                  style={{
                    width: `${getWidth(data || null)}%`,
                  }}
                >
                  {/* <IoAirplaneSolid className='text-customGreen h-7 w-7 absolute -inset-y-3 -right-3' /> */}
                  <AirplaneIcon className="text-customGreen h-7 w-7 absolute -inset-y-3 -right-3 rotate-90" />
                </div>
                <div className="h-4 w-4 rounded-full bg-orange-600 absolute -inset-y-2 right-4 lg:right-10"></div>
                <div className="h-4 w-4 rounded-full bg-customGreen absolute -inset-y-2 left-4 lg:left-10"></div>
              </div>
            </div>
            <div className="w-full flex flex-row p-4 justify-center gap-x-2 lg:px-8">
              {/* <div>
                {data.status === "en-route" && (
                  <div className="bg-[#4C6884] rounded p-1">
                    <p className="text-xs font-medium text-white">
                      {secondsToHours(getElapsedTime(data))} elapsed
                    </p>
                  </div>
                )}
              </div> */}
              <div>
                <p
                  className={`${
                    data?.status !== "cancelled"
                      ? "text-xs font-medium text-center text-[#4C6884] pt-1"
                      : "hidden"
                  }`}
                >
                  <span className="font-bold">
                    {data?.status !== "cancelled" &&
                      minutesToHours(data?.duration || null)}
                  </span>{" "}
                  total travel time
                </p>
              </div>
              {/* <div>
                {data.status === "en-route" && (
                  <div className="bg-[#4C6884] rounded p-1">
                    <p className="text-xs font-medium text-white">
                      {secondsToHours(getRemainingTime(data))} remaining
                    </p>
                  </div>
                )}
              </div> */}
            </div>
          </div>
        </div>
      </div>
    </section>
  );
};

const AirplaneIcon = (props) => (
  <svg
    xmlns="http://www.w3.org/2000/svg"
    width="24"
    height="24"
    viewBox="0 0 24 24"
    fill="none"
    stroke="currentColor"
    strokeWidth="2"
    strokeLinecap="round"
    strokeLinejoin="round"
    {...props} // Propaga todas las props recibidas al SVG
  >
    <path d="M21 16v-2l-8-5V3.5a1.5 1.5 0 0 0-3 0V9l-8 5v2l8-2.5V19l-3 2v1l4-1 4 1v-1l-3-2v-5.5z"></path>
  </svg>
);

export default FlightCard;
