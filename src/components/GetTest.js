import React, {useState, useContext} from 'react'
import GlobalContext from "./../context/GlobalContext";

export default function GetTest(props) {
    const {monthIndex} = useContext(GlobalContext);
    const[task, setTask] = useState(updateTask(props.month));

    useEffect(() => {
        setTask(updateTask(props.month));
      }, [monthIndex]);

    
    
    function updateTask(month) {
        fetch('https://mypew.ru/php/table.php', {
            method: 'POST',
            header: {
                'Accept': 'application/json',
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                table : 3,
                date : "2022-"+month+"-16",
                day_count: 1,
            })
        })
        .then (res => res.json())
        .then ((response) => {
            //console.log(response);
            return Array(2).fill([]).map(() => {return response});
        })
      }
  return (
    <div>{console.log(task)}</div>
  )
}
