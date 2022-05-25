import React from "react";
import Day from "./Day";
export default function Month({month}) {
  console.log(month);
  return (
    <div className="calendar__container__month flex-1 grid grid-cols-7 grid-rows-5">
      {month.map((row, i) => (
        <React.Fragment key={i}>
          {row.map((day, idx) => (
            <Day day={day} key={idx} rowIdx={i} />
          ))}
        </React.Fragment>
      ))}
    </div>
  );
}
