import React, {Component} from 'react'
import '../css/style.css'

export default class GetSheduleNew extends Component {
  constructor(props) {
      super(props);
      this.state = {
          items: []
      }
  }
  
  updateTask() {
    fetch('https://mypew.ru/php/table.php', {
        method: 'POST',
        header: {
            'Accept': 'application/json',
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            table : 3,
            date : this.props.date,
            day_count: 1,
            delete_pair: false
        })
    })
    .then (res => res.json())
    .then ((response) => {
        this.setState({
            items: response
        });
    })
  }
  componentDidUpdate(prevProps) {
    if (this.props.date !== prevProps.date) {
        this.updateTask();
        console.log(1);
    }
  }
  render() {
      const {items} = this.state;
      return (
      items.map(item => {
        if (item.groups) {
            return (
                <li key={item.id} className={"container_part_task " 
                + (item.groups[0] === 'Снорки' ? '_task_blue':'') 
                + (item.groups[0] === 'Муми-тролли' ? '_task_pink':'') 
                + (item.groups[0] === 'Мумрики' ? '_task_green':'')
                + (item.groups[1] === 'Снорки' ? '_task_blue':'') 
                + (item.groups[1] === 'Муми-тролли' ? '_task_pink':'') 
                + (item.groups[1] === 'Мумрики' ? '_task_green':'')
                + (item.groups[2] === 'Снорки' ? '_task_blue':'') 
                + (item.groups[2] === 'Муми-тролли' ? '_task_pink':'') 
                + (item.groups[2] === 'Мумрики' ? '_task_green':'')
                }>
                    <span className='part_task ' >{item.title}</span>
                </li>
            )
        }
      }))
  }
}

