import React from 'react';

import CalendarMini from './components/Calendar';

class App_2 extends React.Component {

    render() {
        return (
            <div>
                <CalendarMini
                    onChange={this.handelDateChange}
                />
            </div>
        );
    }
}

export default App_2;
