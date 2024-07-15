import React, { useEffect, useState } from "react";

import FlightCard from "./FlightCard";

const FlightInfo = ({ data }) => {
  // console.log("Data para FlightInfo", data);

  return (
    <>
      <FlightCard data={data} />
    </>
  );
};

export default FlightInfo;
