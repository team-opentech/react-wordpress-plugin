import React from 'react';
// Asumiendo que tienes un archivo de íconos o que estás usando algún paquete para ellos
// Por ejemplo, podrías usar react-icons para Ionicons
import { IoAirplane } from 'react-icons/io5';
import { formatDate, formatTimeWithAMPM, secondsToHours, minutesToHours, getElapsedTime, getRemainingTime } from './helpers'; // Asegúrate de implementar o importar estas funciones

const FlightCard = ({ data }) => {
    const getWidth = (flight) => {
        if (flight.status === "landed") return 100;
        if (flight.status === "scheduled") return 0;
        return (getElapsedTime(flight) / (flight.duration * 60)) * 100;
      };
    
      const renderFlightStatus = (flight) => {
        if (flight.status === "landed") return <p className='text-xs text-orange-600'>Landed {minutesToHours(flight.duration)} ago</p>;
        if (flight.status === "scheduled") return <p className='text-xs text-orange-600'>Expected to depart in {secondsToHours(getRemainingTime(flight))}</p>;
        return <p className='text-xs text-orange-600'>Arriving in {secondsToHours(getRemainingTime(flight))}</p>;
      };
      return (
        <section class='container mx-auto my-8'>
          <div class='px-4 flex flex-col items-center justify-center sm:px-16'>
            <div class='bg-lightBlue-500 rounded-xl w-full p-4 sm:p-8 md:p-12 shadow-sm'>
              <div class='bg-white w-full h-full rounded-xl shadow-sm flex flex-col'>
                <div class='w-full flex flex-row items-center p-4 lg:px-8'>
                  <div class='pr-2 border-lightBlue-500'>
                    <img src={data.airlineLogo} alt='airline logo' width="48" height="48" />
                  </div>
                  <div class='px-2 border-x-[1px] border-lightBlue-500'>
                    <p class='text-sm text-[#7794B0] font-semibold'>{data.airlineName} {data.flightNumber}</p>
                    <p class='text-sm text-[#7794B0] font-normal'>{data.flightIcao} / {data.flightIata}</p>
                  </div>
                  <div class='pl-2'>
                    <p class='uppercase text-sm font-bold text-orange-600'>{data.status}</p>
                    {renderFlightStatus(flight)}
                  </div>
                </div>
                <div class='w-full flex flex-row p-4 gap-4 flex-wrap justify-between lg:px-8'>
                  <div class='w-fit'>
                    <p class='font-semibold text-lg text-customGreen leading-none uppercase'>{data.depIata}</p>
                    <p class='font-semibold text-lg text-[#013877] leading-none uppercase'>{data.depCity}</p>
                    <p class='font-light text-sm text-[#7794B0] pt-1'>left <span class='font-semibold text-base text-[#013877]'>Gate {data.depGate}</span></p>
                    <p class='text-blue-500 font-semibold pb-1 border-b-[1px] border-dashed border-[#7794B0]'>{data.depAirportName} - {data.depIata}</p>
                    <p class='text-sm text-[#7794B0]'>{formatDate(data.depTimeTs)}</p>
                    {
                      data.depDelayed === null ? (
                        <p class='text-sm text-[#7794B0]'>{formatTimeWithAMPM(data.depTimeTs)} <span class='text-customGreen'>(On time)</span></p>
                      ) : (
                        <p class='text-sm text-[#7794B0]'>{formatTimeWithAMPM(data.depTimeTs)} <span class='text-customGreen'>({data.depDelayed} minutes later)</span></p>
                      )
                    }
                  </div>
                  <div class='w-fit self-end'>
                    <p class='font-semibold text-lg text-orange-600 leading-none uppercase'>{data.arrIata}</p>
                    <p class='font-semibold text-lg text-[#013877] leading-none uppercase'>{data.arrCity}</p>
                    <p class='font-light text-sm text-[#7794B0] pt-1'>arriving at <span class='font-semibold text-base text-[#013877]'>Gate {data.arrGate}</span></p>
                    <p class='text-blue-500 font-semibold pb-1 border-b-[1px] border-dashed border-[#7794B0]'>{data.arrAirportName} - {data.arrIata}</p>
                    <p class='text-sm text-[#7794B0]'>{formatDate(data.arrTimeTs)}</p>
                    {
                      data.arrDelayed === null ? (
                        <p class='text-sm text-[#7794B0]'>{formatTimeWithAMPM(data.arrTimeTs)} <span class='text-orange-600'>(On time)</span></p>
                      ) : (
                        <p class='text-sm text-[#7794B0]'>{formatTimeWithAMPM(data.arrTimeTs)} <span class='text-orange-600'>({data.arrDelayed} minutes later)</span></p>
                      )
                    }
                  </div>
                </div>
                <div class='w-full px-6 relative lg:px-12'>
                  <div class="h-1 w-full bg-orange-300 opacity-90 mb-2">
                    <div class="h-1 bg-customGreen relative" style={{
                      width: `${getWidth(flight)}%`
                    }}>
                      <IoAirplaneSolid class='text-customGreen h-7 w-7 absolute -inset-y-3 -right-3' />
                    </div>
                    <div class='h-4 w-4 rounded-full bg-orange-600 absolute -inset-y-2 right-4 lg:right-10'></div>
                    <div class='h-4 w-4 rounded-full bg-customGreen absolute -inset-y-2 left-4 lg:left-10'></div>
                  </div>
                </div>
                <div class='w-full flex flex-row p-4 justify-between gap-x-2 lg:px-8'>
                  <div>
                    {
                      data.status === "en-route" && (
                        <div class='bg-[#4C6884] rounded p-1'>
                          <p class='text-xs font-medium text-white'>{secondsToHours(getElapsedTime(data))} elapsed</p>
                        </div>
                      )
                    }
                    {/* <p class='text-xs font-medium text-[#4C6884] pt-1'><span class='font-bold'>243 mi</span> flow</p> */}
                  </div>
                  <div>
                    <p class='text-xs font-medium text-center text-[#4C6884] pt-1'>
                      <span class='font-bold'>{minutesToHours(data.duration)}</span> total travel time
                    </p>
                  </div>
                  <div>
                    {
                      data.status === "en-route" && (
                        <div class='bg-[#4C6884] rounded p-1'>
                          <p class='text-xs font-medium text-white'>{secondsToHours(getRemainingTime(data))} remaining</p>
                        </div>
                      )
                    }
                    {/* <p class='text-xs font-medium text-[#4C6884] pt-1'><span class='font-bold'>1,377 mi</span> mi to go</p> */}
                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>
      );

};

export default FlightCard;