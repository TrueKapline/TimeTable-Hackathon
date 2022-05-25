import React from 'react'

import classnames from 'classnames';

import * as calendar from './calendar'

import './css/style.css';
import './css/index.css';

import Lection from './dots/Lection.svg';
import Laba from './dots/Laba.svg';
import Practice from './dots/Practice.svg';
import Event from './dots/Event.svg';
import Project from './dots/Project.svg';


export default class Calendar extends React.Component {
    static defaultProps = {
        date: new Date(),
        years: [2021, 2022],
        monthNames: ['Январь', 'Февраль', 'Март', 'Апрель', 'Май', 'Июнь', 'Июль', 'Август', 'Сентябрь', 'Октябрь', 'Ноябрь', 'Декабрь'],
        weekDayNames: ['ПН', 'ВТ', 'СР', 'ЧТ', 'ПТ', 'СБ', 'ВС'],
        onChange: Function.prototype
    };

    state = {
        date: this.props.date,
        currentDate: new Date(),
        selectedDate: null,
        date__daySelect: null
    };

    get year() {
        return this.state.date.getFullYear();
    }

    get month() {
        return this.state.date.getMonth();
    }

    get day() {
        return this.state.date.getDate();
    }
    get dayOfWeek() {
        let dayOfWeek = this.state.date.getDay();

        if (dayOfWeek === 1) {
            dayOfWeek = 'Понедельник';
        }

        if (dayOfWeek === 2) {
            dayOfWeek = 'Вторник';
        }

        if (dayOfWeek === 3) {
            dayOfWeek = 'Среда';
        }

        if (dayOfWeek === 4) {
            dayOfWeek = 'Четверг';
        }

        if (dayOfWeek === 5) {
            dayOfWeek = 'Пчтница';
        }

        if (dayOfWeek === 6) {
            dayOfWeek = 'Суббота';
        }

        if (dayOfWeek === 0) {
            dayOfWeek = 'Воскресенье';
        }

        return dayOfWeek;
    }

    handlePrevButtonClick = () => {
        const date = new Date(this.year, this.month - 1);

        this.setState({ date });
    };

    handleNextButtonClick = () => {
        const date = new Date(this.year, this.month + 1);

        this.setState({ date });
    };

    handleSelectChange = () => {
        const year = this.yearSelect.value;
        const month = this.monthSelect.value;

        const date = new Date(year, month);

        this.setState({ date });
    };

    handleDayClick = date => {

        this.setState({ selectedDate: date });
        this.props.onChange(date);

        this.setState({ date__daySelect: date });
        this.props.onChange(date);

        // var MyDiv1 = document.getElementById('day.selected');
        // var MyDiv2 = document.getElementById('date__daySelect');
        // MyDiv2.innerHTML = MyDiv1.innerHTML;
    };

    handleMonthOut = () => {
        let month = this.state.date.getMonth();

        if (month === 0) {
            month = '0' + 1;
        }
        if (month === 1) {
            month = '0' + 2;
        }
        if (month === 2) {
            month = '0' + 3;
        }
        if (month === 3) {
            month = '0' + 4;
        }
        if (month === 4) {
            month = '0' + 5;
        }
        if (month === 5) {
            month = '0' + 6;
        }
        if (month === 6) {
            month = '0' + 7;
        }
        if (month === 7) {
            month = '0' + 8;
        }
        if (month === 8) {
            month = '0' + 9;
        }
        if (month === 9) {
            month = 10;
        }
        if (month === 10) {
            month = 11;
        }
        if (month === 11) {
            month = 12;
        }

        return month;
    };


    render() {

        const { years, monthNames, weekDayNames } = this.props;
        const { currentDate, selectedDate } = this.state;

        const monthData = calendar.getMonthData(this.year, this.month);

        return (

            <div className='content'>
                <div className="calendar__mini1">
                    <header>
                        <button onClick={this.handlePrevButtonClick}>{'<'}</button>
                        <select
                            ref={element => this.monthSelect = element}
                            value={this.month}
                            onChange={this.handleSelectChange}
                        >
                            {monthNames.map((name, index) =>
                                <option key={name} value={index}>{name}</option>
                            )}
                        </select>
                        <select
                            ref={element => this.yearSelect = element}
                            value={this.year}
                            onChange={this.handleSelectChange}
                        >
                            {years.map(year =>
                                <option key={year} value={year}>{year}</option>
                            )}
                        </select>
                        <button onClick={this.handleNextButtonClick}>{'>'}</button>
                    </header>
                    <section className="table">
                        <table>
                            <thead>
                                <tr>
                                    {weekDayNames.map(name =>
                                        <th key={name}>{name}</th>
                                    )}
                                </tr>
                            </thead>

                            <tbody>
                                {monthData.map((week, index) =>
                                    <tr className="week" key={index}>
                                        {week.map((date, index) => date ?
                                            <td
                                                key={index}
                                                className={classnames('day', {
                                                    'today': calendar.areEqual(date, currentDate),
                                                    'selected': calendar.areEqual(date, selectedDate)
                                                })}
                                                onClick={() => this.handleDayClick(date)}
                                            >{date.getDate()}</td>
                                            :
                                            <td key={index} />
                                        )}
                                    </tr>
                                )}
                            </tbody>
                        </table>
                    </section>
                    <div className="border__bottom"></div>
                    <section className="events">
                        <div className="events__info">
                            <div className="info__day">
                                <span className='day__today'>Сегодня</span>
                            </div>
                            <div className="info__date">
                                <span id='day.selected' className='date__day'>
                                    {this.state.date.getDate()}.
                                </span>
                                <span className='date__day'>
                                    {this.handleMonthOut()}.
                                </span>
                                <span className='date__day'>
                                    {this.state.date.getFullYear()}
                                </span>
                            </div>
                        </div>
                        <div>
                            <ul className="events__items">
                                <li className="items__item">
                                    <img src={Lection} alt="" />
                                    <p>Уборка территории</p>
                                </li>
                                <li className="items__item">
                                    <img src={Laba} alt="" />
                                    <p>Обустраивание личного
                                        пространства</p>
                                </li>
                                <li className="items__item">
                                    <img src={Practice} alt="" />
                                    <p>Собирание оригами</p>
                                </li>
                                <li className="items__item">
                                    <img src={Event} alt="" />
                                    <p>Наблюдение за кометой</p>
                                </li>
                                <li className="items__item">
                                    <img src={Project} alt="" />
                                    <p>Поиск внеземных существ</p>
                                </li>
                            </ul>
                        </div>
                    </section>
                </div>
                <div className="calendar__mini2">
                    <section className="week">
                        <div className="week__container">
                            <div className="week__inform">
                                <div className="inform__day">
                                    <span>
                                        {this.dayOfWeek}
                                    </span>
                                </div>
                                <div className="inform__dat">
                                    <span id='date__daySelect' className='date__daySelect'>
                                        {this.state.date.getDate()}.
                                    </span>
                                    <span className='date__day'>
                                        {this.handleMonthOut()}.
                                    </span>
                                    <span className='date__day'>
                                        {this.state.date.getFullYear()}
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div className="week__items">
                            <div className="items__container">
                                <div className="week__item">
                                    <div className="item__head">
                                        <div className="head__title">
                                            <span>Уборка территории | У кустов сирени</span>
                                        </div>
                                        <div className="head__time">
                                            <span>8:30 – 10:00</span>
                                        </div>
                                    </div>
                                    <div className="item__teacher">
                                        <span>Тюлиппа</span>
                                    </div>
                                    <div className="item__inf">
                                        <button className="type">Лекция</button>
                                        <button className="group">Мумрики</button>
                                        <button className="pod__group">1 подгруппа</button>
                                    </div>
                                </div>
                                <div className="week__item">
                                    <div className="item__head">
                                        <div className="head__title">
                                            <span>Уборка территории | У кустов сирени</span>
                                        </div>
                                        <div className="head__time">
                                            <span>10:10 – 11:40</span>
                                        </div>
                                    </div>
                                    <div className="item__teacher">
                                        <span>Тюлиппа</span>
                                    </div>
                                    <div className="item__inf">
                                        <button className="type">Лекция</button>
                                        <button className="group">Мумрики</button>
                                        <button className="pod__group">1 подгруппа</button>
                                    </div>
                                </div>
                                <div className="week__item">
                                    <div className="item__head">
                                        <div className="head__title">
                                            <span>Уборка территории | У кустов сирени</span>
                                        </div>
                                        <div className="head__time">
                                            <span>12:10 – 13:40</span>
                                        </div>
                                    </div>
                                    <div className="item__teacher">
                                        <span>Тюлиппа</span>
                                    </div>
                                    <div className="item__inf">
                                        <button className="type">Лекция</button>
                                        <button className="group">Мумрики</button>
                                        <button className="pod__group">1 подгруппа</button>
                                    </div>
                                </div>
                                <div className="week__item">
                                    <div className="item__head">
                                        <div className="head__title">
                                            <span className='outline'>Уборка территории | У кустов сирени</span>
                                        </div>
                                        <div className="head__time">
                                            <span className='outline'>12:10 – 13:40</span>
                                        </div>
                                    </div>
                                    <div className="item__teacher">
                                        <span>Тюлиппа</span>
                                    </div>
                                    <div className="item__inf">
                                        <button className="type">Лекция</button>
                                        <button className="group">Мумрики</button>
                                        <button className="pod__group">1 подгруппа</button>
                                    </div>
                                </div>
                                <div className="week__item">
                                    <div className="item__head">
                                        <div className="head__title">
                                            <span>Уборка территории | У кустов сирени</span>
                                        </div>
                                        <div className="head__time">
                                            <span>12:10 – 13:40</span>
                                        </div>
                                    </div>
                                    <div className="item__teacher">
                                        <span>Тюлиппа</span>
                                    </div>
                                    <div className="item__inf">
                                        <button className="type">Лекция</button>
                                        <button className="group">Мумрики</button>
                                        <button className="pod__group">1 подгруппа</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        );
    }
}