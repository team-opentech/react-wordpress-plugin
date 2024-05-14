import React, { useEffect } from "react";
// Asumiendo que tienes un archivo de íconos o que estás usando algún paquete para ellos
// Por ejemplo, podrías usar react-icons para Ionicons
// import { IoAirplane } from 'react-icons/io5';
import {
  formatDate,
  formatTimeWithAMPM,
  secondsToHours,
  minutesToHours,
  getElapsedTime,
  getRemainingTime,
} from "./helper.js"; // Asegúrate de implementar o importar estas funciones

const FlightCard = ({ data }) => {
  console.log("FlightCard data", data);
  const getWidth = (data) => {
    if (data.status === "landed") return 100;
    if (data.status === "scheduled") return 0;
    if ((getElapsedTime(data) / (data.duration * 60)) * 100 > 100) {
      return 100;
    } else {
      return (getElapsedTime(data) / (data.duration * 60)) * 100;
    }
  };

  const renderFlightStatus = (data) => {
    if (data.status === "landed")
      return (
        <p className="text-sm text-[#7794B0]">
          Landed {minutesToHours(data.duration)} ago
        </p>
      );
    if (data.status === "scheduled")
      return (
        <p className="text-sm text-[#7794B0]">
          Expected to depart in {secondsToHours(getRemainingTime(data))}
        </p>
      );
    return (
      <p className="text-sm text-[#7794B0]">
        Arriving in {secondsToHours(getRemainingTime(data))}
      </p>
    );
  };
  return (
    <section className="container mx-auto my-8">
      <div className="px-4 flex flex-col items-center justify-center sm:px-16">
        <div className="bg-lightBlue-500 rounded-xl w-full p-4 sm:p-8 md:p-12 shadow-sm">
          <div className="bg-white w-full h-full rounded-xl shadow-sm flex flex-col">
            <div className="w-full flex flex-row items-center p-4 lg:px-8">
              <div className="pr-2 border-lightBlue-500">
                <img
                  src={data.airlineLogo}
                  alt="airline logo"
                  width="48"
                  height="48"
                />
              </div>
              <div className="px-2 border-x-[1px] border-lightBlue-500">
                <p className="text-sm text-[#7794B0] font-semibold">
                  {data.airlineName} {data.flightNumber}
                </p>
                <p className="text-sm text-[#7794B0] font-normal">
                  {data.flightIcao} / {data.flightIata}
                </p>
              </div>
              <div className="pl-2">
                <p className="uppercase text-sm font-bold text-orange-600">
                  {data.status}
                </p>
                {renderFlightStatus(data)}
              </div>
            </div>
            <div className="w-full flex flex-row p-4 gap-4 flex-wrap justify-between lg:px-8">
              <div className="w-fit">
                {/* <p className="font-semibold text-lg text-customGreen leading-none uppercase">
                  {data.depIata}
                </p> */}
                <p className="font-semibold text-lg text-[#013877] leading-none uppercase">
                  {data.depCity}
                </p>
                <p className="font-light text-sm text-[#7794B0] pt-1">
                  left{" "}
                  <span className="font-semibold text-base text-[#013877]">
                    Gate {data.depGate}
                  </span>
                </p>
                <p className="text-blue-500 font-semibold pb-1 border-b-[1px] border-dashed border-[#7794B0]">
                  {data.depAirportName} - {data.depIata}
                </p>
                <p className="text-sm text-[#7794B0] capitalize">
                  {formatDate(parseInt(data.depTimeTs))}
                </p>
                {data.depDelayed === null ? (
                  <p className="text-sm text-[#7794B0] capitalize">
                    {formatTimeWithAMPM(parseInt(data.depTimeTs))}{" "}
                    {/* <span className="text-customGreen">(On time)</span> */}
                  </p>
                ) : (
                  <p className="text-sm text-[#7794B0] capitalize">
                    {formatTimeWithAMPM(parseInt(data.depTimeTs))}{" "}
                    {/* <span className="text-customGreen">
                      ({data.depDelayed} minutes later)
                    </span> */}
                  </p>
                )}
              </div>
              <div className="w-fit self-end">
                {/* <p className="font-semibold text-lg text-orange-600 leading-none uppercase">
                  {data.arrIata}
                </p> */}
                <p className="font-semibold text-lg text-[#013877] leading-none uppercase">
                  {data.arrCity}
                </p>
                {/* <p className="font-light text-sm text-[#7794B0] pt-1">
                  arriving at{" "}
                  <span className="font-semibold text-base text-[#013877]">
                    Gate {data.arrGate}
                  </span>
                </p> */}
                <p className="text-blue-500 font-semibold pb-1 border-b-[1px] border-dashed border-[#7794B0]">
                  {data.arrAirportName} - {data.arrIata}
                </p>
                <p className="text-sm text-[#7794B0] capitalize">
                  {formatDate(parseInt(data.arrTimeTs))}
                </p>
                {data.arrDelayed === null ? (
                  <p className="text-sm text-[#7794B0] capitalize">
                    {formatTimeWithAMPM(parseInt(data.arrTimeTs))}{" "}
                    {/* <span className="text-orange-600">(On time)</span> */}
                  </p>
                ) : (
                  <p className="text-sm text-[#7794B0] capitalize">
                    {formatTimeWithAMPM(parseInt(data.arrTimeTs))}{" "}
                    {/* <span className="text-orange-600">
                      ({data.arrDelayed} minutes later)
                    </span> */}
                  </p>
                )}
                <p className="font-light text-sm text-[#7794B0] pt-1">
                  Arriving at{" "}
                  <span className="font-semibold text-base text-[#013877]">
                    Gate {data.arrGate}
                  </span>
                </p>
              </div>
            </div>
            <div className="w-full px-6 relative lg:px-12">
              <div className="h-1 w-full bg-orange-300 opacity-90 mb-2">
                <div
                  className="h-1 bg-customGreen relative"
                  style={{
                    width: `${getWidth(data)}%`,
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
                <p className="text-xs font-medium text-center text-[#4C6884] pt-1">
                  <span className="font-bold">
                    {minutesToHours(data.duration)}
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
