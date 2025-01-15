import { DateTime } from "luxon";
import moment, { min } from "moment-timezone";
import { unix } from "moment";

// Get elapsed time since departure based on date string (format: "YYYY-MM-DD HH:mm")
export function getElapsedTime(flightInfo, localTime) {
  if (!flightInfo || !localTime) return 0;

  const departureTime = DateTime.fromFormat(flightInfo.depTimeTs, "yyyy-MM-dd HH:mm");
  if (!departureTime.isValid) throw new Error("Invalid departure date format.");

  // Combine `localTime` with today’s date for full DateTime object
  const currentDateString = DateTime.now().toFormat("yyyy-MM-dd");
  const currentTime = DateTime.fromFormat(`${currentDateString} ${localTime}`, "yyyy-MM-dd HH:mm");

  if (!currentTime.isValid) {
    console.error("Invalid localTime format:", localTime);
    return 0;
  }

  // Calculate the difference in seconds
  const elapsedTime = currentTime.diff(departureTime, "seconds").seconds;
  return isNaN(elapsedTime) ? 0 : elapsedTime; // Return 0 if NaN
}

// Get remaining flight time based on departure time and duration (duration is in minutes)
export function getRemainingTime(flightInfo, localTime) {
  if (!flightInfo || !localTime) return 0;

  const totalDurationSeconds = flightInfo.duration * 60; // Convert duration from minutes to seconds
  const elapsedTime = getElapsedTime(flightInfo, localTime);

  // Calculate remaining time and ensure it’s a valid number
  const remainingTime = totalDurationSeconds - elapsedTime;
  return isNaN(remainingTime) ? 0 : remainingTime; // Return 0 if NaN
}

// Get remaining time before departure
export function getRemainingTimeToDepart(flightInfo, localTime) {
  if (!flightInfo || !localTime) return 0;

  const departureTime = DateTime.fromFormat(flightInfo.depTimeTs, "yyyy-MM-dd HH:mm");
  if (!departureTime.isValid) throw new Error("Invalid departure date format.");

  const currentDateString = DateTime.now().toFormat("yyyy-MM-dd");
  const currentTime = DateTime.fromFormat(`${currentDateString} ${localTime}`, "yyyy-MM-dd HH:mm");

  if (!currentTime.isValid) {
    console.error("Invalid localTime format:", localTime);
    return 0;
  }

  // Calculate time until departure and ensure it’s a valid number
  const remainingTimeToDepart = departureTime.diff(currentTime, "seconds").seconds;
  return isNaN(remainingTimeToDepart) ? 0 : remainingTimeToDepart; // Return 0 if NaN
}

// Format a date string (YYYY-MM-DD HH:mm) into a readable date format
export function formatDate(dateTimeString) {
  const date = DateTime.fromFormat(dateTimeString, "yyyy-MM-dd HH:mm");

  if (!date.isValid) throw new Error("Invalid date format.");

  const dayName = date.toFormat("cccc"); // Full name of the day (e.g., "Monday")
  const dayNumber = date.toFormat("d");
  const monthName = date.toFormat("MMM"); // Short month name (e.g., "Jan")
  const year = date.toFormat("yyyy");

  return `${dayName}, ${dayNumber} ${monthName} ${year}`;
}

// Convert date string (YYYY-MM-DD HH:mm) to time with AM/PM format
export function getFormatUnixTime(dateTimeString) {
  const dateObj = DateTime.fromFormat(dateTimeString, "yyyy-MM-dd HH:mm");
  if (!dateObj.isValid) throw new Error("Invalid date format.");

  return dateObj.toFormat("h:mm a");
}

// Convert minutes to hours and minutes (e.g., "1h 57min")
export function minutesToHours(minutesInput) {
  const hours = Math.floor(minutesInput / 60);
  const minutes = Math.round(minutesInput % 60);

  return `${hours}h ${minutes}min`;
}

// Convert seconds to hours and minutes (e.g., "1h 57min")
export function secondsToHours(secondsInput) {
  const hours = Math.floor(secondsInput / 3600);
  const minutes = Math.round((secondsInput % 3600) / 60);

  return `${hours}h ${minutes}min`;
}

// export function getElapsedTime(flightInfo) {
//   if (!flightInfo) return;
//   const departureTime = Number(moment(flightInfo.depTimeTs).unix());
//   if (isNaN(departureTime)) throw new Error("Invalid departure timestamp.");

//   const currentTime = DateTime.now().toSeconds();

//   return currentTime - departureTime;
// }

// export function getRemainingTime(flightInfo) {
//   if (!flightInfo) return;
//   const totalDurationSeconds = flightInfo.duration * 60;

//   const elapsedTime = getElapsedTime(flightInfo);

//   return totalDurationSeconds - elapsedTime;
// }

// export function getRemainingTimeToDepart(flightInfo) {
//   if (!flightInfo) return;
//   const departureTime = Number(moment(flightInfo.depTimeTs).unix());
//   if (isNaN(departureTime)) throw new Error("Invalid departure timestamp.");

//   const currentTime = DateTime.now().toSeconds();

//   return departureTime - currentTime;
// }

// export function formatDate(unixTimestamp) {
//   const days = [
//     "sunday",
//     "monday",
//     "tuesday",
//     "wednesday",
//     "thursday",
//     "friday",
//     "saturday",
//   ];
//   const months = [
//     "jan",
//     "feb",
//     "mar",
//     "apr",
//     "may",
//     "jun",
//     "jul",
//     "aug",
//     "sep",
//     "oct",
//     "nov",
//     "dec",
//   ];

//   const date = new Date(unixTimestamp * 1000); // Convertir a milisegundos multiplicando por 1000

//   const dayName = days[date.getDay()];
//   const dayNumber = date.getDate();
//   const monthName = months[date.getMonth()];
//   const year = date.getFullYear();

//   return `${dayName}, ${dayNumber} ${monthName} ${year}`;
// }

// export function getFormatUnixTime(unixTimestamp) {
//   const dateObj = convertUnixToDateTime(unixTimestamp);

//   const hours = dateObj.hour;
//   const minutes = dateObj.minute;

//   const ampm = hours >= 12 ? "pm" : "am";

//   // Convert hours to 12-hour format
//   const formattedHours = hours % 12 || 12;

//   // Pad single-digit minutes with a leading 0
//   const formattedMinutes = minutes < 10 ? `0${minutes}` : minutes;

//   return `${formattedHours}:${formattedMinutes}${ampm}`;
// }

// export function minutesToHours(minutesInput) {
//   const hours = Math.floor(minutesInput / 60);
//   const minutes = Math.round(minutesInput % 60);

//   return `${hours}h ${minutes}min`;
// }

// export function secondsToHours(secondsInput) {
//   const hours = Math.floor(secondsInput / 3600);
//   const minutes = Math.round((secondsInput % 3600) / 60);

//   return `${hours}h ${minutes}min`;
// }

// export function convertUnixToDateTime(timeTs) {
//   if (timeTs === null) return null;
//   return DateTime.fromSeconds(timeTs).setZone("America/Caracas");
// }

// Format date string to time with AM/PM format, adjusting for the local timezone
export function formatTimeWithAMPM(dateTimeString) {
  const dateTime = convertDateTimeToLocal(dateTimeString);
  return dateTime.toFormat("h:mm a");
}

// export function formatTimeWithAMPM(timeTs) {
//   const dateTime = convertUnixToDateTime(timeTs);
//   return dateTime.toFormat("h:mm a");
// }

// Convert and format a date string (YYYY-MM-DD HH:mm) into AM/PM time format
export function formatTimeToAMPM(dateTimeString) {
  if (!dateTimeString) return "-----";

  const date = new Date(dateTimeString);
  let hours = date.getHours();
  const minutes = String(date.getMinutes()).padStart(2, "0");
  const ampm = hours >= 12 ? "PM" : "AM";

  hours = hours % 12 || 12; // Convert to 12-hour format
  return `${hours}:${minutes} ${ampm}`;
}

// export function formatTimeToAMPM(dateTimeString) {
//   if (!dateTimeString) return "-----";

//   const date = new Date(dateTimeString);
//   let hours = date.getHours();
//   const minutes = String(date.getMinutes()).padStart(2, "0");
//   const ampm = hours >= 12 ? "PM" : "AM";

//   hours = hours % 12;
//   hours = hours ? hours : 12;

//   return `${hours}:${minutes} ${ampm}`;
// }

// Get the day of the week from a DateTime string (YYYY-MM-DD HH:mm)
export const getDayOfWeek = (dateTimeString) => {
  if (!dateTimeString) return "-----";

  const dateObj = DateTime.fromFormat(dateTimeString, "yyyy-MM-dd HH:mm");
  if (!dateObj.isValid) throw new Error("Invalid date format.");

  return dateObj.toFormat("cccc"); // Return full weekday name
};

// export const getDayOfWeek = (dateTimeString) => {
//   if (!dateTimeString) return "-----";
//   const [datePart, timePart] = dateTimeString.split(" ");

//   const [year, month, day] = datePart.split("-").map(Number);
//   const [hours, minutes] = timePart.split(":").map(Number);

//   // Note: JavaScript months are zero-based, so we subtract 1 from the month
//   const jsDate = new Date(year, month - 1, day, hours, minutes);

//   return jsDate.toLocaleDateString("en-US", { weekday: "long" });
// };

// Format the time part of a DateTime string (YYYY-MM-DD HH:mm) into a 12-hour AM/PM format
export function getFormatTime(dateTimeString) {
  if (!dateTimeString) return "-----";

  const dateObj = DateTime.fromFormat(dateTimeString, "yyyy-MM-dd HH:mm");
  if (!dateObj.isValid) throw new Error("Invalid date format.");

  return dateObj.toFormat("h:mm a");
}

// export function getFormatTime(dateTimeString) {
//   if (!dateTimeString) return "-----";
//   const [/*datePart*/, timePart] = dateTimeString.split(' ');

//   // const [year, month, day] = datePart.split('-').map(Number);
//   const [hours, minutes] = timePart.split(':').map(Number);

//   const ampm = hours >= 12 ? 'pm' : 'am';

//   // Convert hours to 12-hour format
//   const formattedHours = hours % 12 || 12;

//   // Pad single-digit minutes with a leading 0
//   const formattedMinutes = minutes < 10 ? `0${minutes}` : minutes;

//   return `${formattedHours}:${formattedMinutes}${ampm}`;
// }
