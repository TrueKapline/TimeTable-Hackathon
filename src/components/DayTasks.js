import React, {useState, useEffect} from 'react'
import GetSheduleNew from './GetSheduleNew'

export default function DayTasks(props) {
    const [date, setDate] = useState(props.id);
    useEffect(() => {
        setDate(props.name);
    });
  return (
    <ul className='container_for_tasks_2'>
        <GetSheduleNew date={date}/>
    </ul>
  )
}
