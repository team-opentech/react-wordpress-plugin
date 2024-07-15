import { DateTime } from "luxon";

export function getElapsedTime(flightInfo) {
  if (!flightInfo) return;
  const departureTime = Number(flightInfo.depTimeTs);
  if (isNaN(departureTime)) throw new Error("Invalid departure timestamp.");

  const currentTime = DateTime.now().toSeconds();

  return currentTime - departureTime;
}

export function getRemainingTime(flightInfo) {
  if (!flightInfo) return;
  const totalDurationSeconds = flightInfo.duration * 60;

  const elapsedTime = getElapsedTime(flightInfo);

  return totalDurationSeconds - elapsedTime;
}

export function getRemainingTimeToDepart(flightInfo) {
  if (!flightInfo) return;
  const departureTime = Number(flightInfo.depTimeTs);
  if (isNaN(departureTime)) throw new Error("Invalid departure timestamp.");

  const currentTime = DateTime.now().toSeconds();

  return departureTime - currentTime;
}


export function formatDate(unixTimestamp){
    const days = ['sunday', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday'];
    const months = ['jan', 'feb', 'mar', 'apr', 'may', 'jun', 'jul', 'aug', 'sep', 'oct', 'nov', 'dec'];
  
    const date = new Date(unixTimestamp * 1000); // Convertir a milisegundos multiplicando por 1000
  
    const dayName= days[date.getDay()];
    const dayNumber = date.getDate();
    const monthName= months[date.getMonth()];
    const year = date.getFullYear();
  
    return `${dayName}, ${dayNumber} ${monthName} ${year}`;
  }


export function getFormatUnixTime(unixTimestamp){
  const dateObj = convertUnixToDateTime(unixTimestamp);

  const hours = dateObj.hour;
  const minutes = dateObj.minute;

  const ampm = hours >= 12 ? 'pm' : 'am';

  // Convert hours to 12-hour format
  const formattedHours = hours % 12 || 12;

  // Pad single-digit minutes with a leading 0
  const formattedMinutes = minutes < 10 ? `0${minutes}` : minutes;

  return `${formattedHours}:${formattedMinutes}${ampm}`;
}

export function minutesToHours(minutesInput){
  const hours = Math.floor(minutesInput / 60);
  const minutes = Math.round(minutesInput % 60);

  return `${hours}h ${minutes}min`;
}

export function secondsToHours(secondsInput){
  const hours = Math.floor(secondsInput / 3600);
  const minutes = Math.round((secondsInput % 3600) / 60);

  return `${hours}h ${minutes}min`;
}

export function convertUnixToDateTime(timeTs) {
  if (timeTs === null) return null;
  return DateTime.fromSeconds(timeTs).setZone("America/Caracas");
}

export function formatTimeWithAMPM(timeTs){
  const dateTime = convertUnixToDateTime(timeTs);
  return dateTime.toFormat("h:mm a");
}

export function formatTimeToAMPM(dateTimeString){
  if (!dateTimeString) return "-----";

  const date = new Date(dateTimeString);
  let hours = date.getHours();
  const minutes = String(date.getMinutes()).padStart(2, '0');
  const ampm = hours >= 12 ? 'PM' : 'AM';
  
  hours = hours % 12;
  hours = hours ? hours : 12;

  return `${hours}:${minutes} ${ampm}`;
}

export const getDayOfWeek = (dateTimeString) => {
    if (!dateTimeString) return "-----";
    const [datePart, timePart] = dateTimeString.split(' ');
  
    const [year, month, day] = datePart.split('-').map(Number);
    const [hours, minutes] = timePart.split(':').map(Number);
  
    // Note: JavaScript months are zero-based, so we subtract 1 from the month
    const jsDate = new Date(year, month - 1, day, hours, minutes);
  
    return jsDate.toLocaleDateString('en-US', { weekday: 'long' });
  }

  export function getFormatTime(dateTimeString) {
    if (!dateTimeString) return "-----";
    const [/*datePart*/, timePart] = dateTimeString.split(' ');
  
    // const [year, month, day] = datePart.split('-').map(Number);
    const [hours, minutes] = timePart.split(':').map(Number);
    
    const ampm = hours >= 12 ? 'pm' : 'am';
  
    // Convert hours to 12-hour format
    const formattedHours = hours % 12 || 12;
  
    // Pad single-digit minutes with a leading 0
    const formattedMinutes = minutes < 10 ? `0${minutes}` : minutes;
  
    return `${formattedHours}:${formattedMinutes}${ampm}`;
  }
