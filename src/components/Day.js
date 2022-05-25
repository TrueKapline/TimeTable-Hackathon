import React from "react";
import DayTasks from "./DayTasks";

export default function Day({ day, rowIdx }) {
  return (
    <div className="border__table flex flex-col">
      <header className="flex flex-col items-center title_tasks">
        {rowIdx === 0 && (
          <p className="text-sm mt-1 calendar_title_table">
            {day.format("ddd").toUpperCase() === 'MON' && ('ПН')}
            {day.format("ddd").toUpperCase() === 'TUE' && ('ВТ')}
            {day.format("ddd").toUpperCase() === 'WED' && ('СР')}
            {day.format("ddd").toUpperCase() === 'THU' && ('ЧТ')}
            {day.format("ddd").toUpperCase() === 'FRI' && ('ПТ')}
            {day.format("ddd").toUpperCase() === 'SAT' && ('СБ')}
            {day.format("ddd").toUpperCase() === 'SUN' && ('ВС')}
          </p>
        )}
        <p className="text-sm p-1 my-1 text-center">
            {day.format("DD")}
        </p>
        
      </header>
      <div className="flex-1 cursor-pointer container_for_tasks">
        <DayTasks name={day.format("YYYY-MM-DD")} id="0"/>
      </div>
    </div>
  );
}
