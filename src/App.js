import React, { useState, useContext, useEffect } from "react";
//import "./App.css";
import './css/style.css';
import { getMonth } from "./util";
import CalendarHeader from "./components/CalendarHeader";
import Month from "./components/Month";
import GlobalContext from "./context/GlobalContext";

function App() {
  const {monthIndex} = useContext(GlobalContext);
  const [currenMonth, setCurrentMonth] = useState(getMonth(monthIndex));
  
  useEffect(() => {
    setCurrentMonth(getMonth(monthIndex));
  }, [monthIndex]);

  return (
      <div className="h-screen flex flex-col">
        <CalendarHeader />
        <div className="flex flex-1">
          <Month month={currenMonth} />
        </div>
      </div>
  );
}

export default App;
