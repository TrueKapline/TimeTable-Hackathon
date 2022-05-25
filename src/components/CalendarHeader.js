import dayjs from "dayjs";
import React, { useContext } from "react";
import GlobalContext from "../context/GlobalContext";


export default function CalendarHeader() {
  const { monthIndex, setMonthIndex } = useContext(GlobalContext);
  function handlePrevMonth() {
    document.getElementById("preloader_malc").style.opacity = "90%";
    document.getElementById("preloader_malc").style.zIndex = "99";
    setTimeout(function() {
        document.getElementById("preloader_malc").style.opacity = "0%";
        document.getElementById("preloader_malc").style.zIndex = "-1";
    }, 1500);
    setMonthIndex(monthIndex - 1);
  }
  function handleNextMonth() {
    document.getElementById("preloader_malc").style.opacity = "90%";
    document.getElementById("preloader_malc").style.zIndex = "99";
    setTimeout(function() {
        document.getElementById("preloader_malc").style.opacity = "0%";
        document.getElementById("preloader_malc").style.zIndex = "-1";
    }, 1500);
    setMonthIndex(monthIndex + 1);
  }

    function start_accordion(id) {
        let label = document.getElementById(id);
        label.parentNode.classList.toggle('active');
    }

    function start_filter_accordion(id) {
        let label = document.getElementById(id);
        console.log(label);
        label.parentNode.classList.toggle('active');
    }


    /*document.addEventListener('click',e => console.log(e.target))
    /*let filter_label = document.getElementById('filter_label');
    for (let i=0; i<filter_label.length; i++){
	    filter_label[i].addEventListener('click', function() {
			this.parentNode.classList.toggle('active');
        })
	};*/
  
  return (
    <div className="page__header">
    <header className="page__header__container">
        <div className="title__calendar">Календарь</div>
        <div className="slider">
            <div className="slider__form">
                <div className="slider__form__button">
                <button onClick={handlePrevMonth} id="btn_prevent" className="slider__but">
                    <img className="slider__but__image" src="img/timetable_header/previous.svg" alt="Logo" />
                </button>
                <button onClick={handleNextMonth} id="btn_next" className="slider__but">
                    <img className="slider__but__image" src="img/timetable_header/next.svg" alt="Logo" />
                </button>
                </div>
                <span className="slider__month">
                    {dayjs(new Date(dayjs().year(), monthIndex)).format("MM") === '01' && ('Январь ')}
                    {dayjs(new Date(dayjs().year(), monthIndex)).format("MM") === '02' && ('Февраль ')}
                    {dayjs(new Date(dayjs().year(), monthIndex)).format("MM") === '03' && ('Март ')}
                    {dayjs(new Date(dayjs().year(), monthIndex)).format("MM") === '04' && ('Апрель ')}
                    {dayjs(new Date(dayjs().year(), monthIndex)).format("MM") === '05' && ('Май ')}
                    {dayjs(new Date(dayjs().year(), monthIndex)).format("MM") === '06' && ('Июнь ')}
                    {dayjs(new Date(dayjs().year(), monthIndex)).format("MM") === '07' && ('Июль ')}
                    {dayjs(new Date(dayjs().year(), monthIndex)).format("MM") === '08' && ('Авугст ')}
                    {dayjs(new Date(dayjs().year(), monthIndex)).format("MM") === '09' && ('Сентябрь ')}
                    {dayjs(new Date(dayjs().year(), monthIndex)).format("MM") === '10' && ('Октябрь ')}
                    {dayjs(new Date(dayjs().year(), monthIndex)).format("MM") === '11' && ('Ноябрь ')}
                    {dayjs(new Date(dayjs().year(), monthIndex)).format("MM") === '12' && ('Декабрь ')}
                    {dayjs(new Date(dayjs().year(), monthIndex)).format("YYYY")}
                </span>
            </div>
        </div>
        <div className="accordion">
            <form className="search" id="label" onClick={(e) => start_accordion("label", e)}>
                <img className="search__lupa" src="img/timetable_header/search_lupa.svg" alt="Logo" />
                <input className="search__input" type="text" value={"Поиск"} disabled />
                <button type="button" className="search__slide"><img  className="search__slide__image" src="img/timetable_header/slide.svg"alt="Logo" /></button>
            </form>
            <div id="content" className="content">
                <div>
                    <div className="filter__chapter" onClick={(e) => start_filter_accordion("Aud", e)}>
                        <div className="filter__title">Аудитории</div>
                        <div className="filter__accordion">
                            <div className="filter__accordion__container">
                                <div className="label" id="Aud">
                                    <div>Все</div>
                                    <img className="filter__search__slide" src="img/timetable_header/slide.svg"/>
                                </div>
                                <div className="filtr_content">
                                    <div className="filtr_content_part">Все</div>
                                    <div className="filtr_content_part">Обсерватория</div>
                                    <div className="filtr_content_part">Грот</div>
                                    <div className="filtr_content_part">Зимний сад</div>
                                    <div className="filtr_content_part">Чердак</div>
                                    <div className="filtr_content_part">У кустов сирени</div>
                                    <div className="filtr_content_part">Танцплощадка</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div className="filter__chapter" onClick={(e) => start_filter_accordion("Prep", e)}>
                        <div className="filter__title">Преподаватели</div>
                        <div className="filter__accordion">
                            <div className="filter__accordion__container">
                                <div className="label" id="Prep">
                                    <div>Все</div>
                                    <img className="filter__search__slide" src="img/timetable_header/slide.svg"/>
                                </div>
                                <div className="filtr_content">
                                    <div className="filtr_content_part">Все</div>
                                    <div className="filtr_content_part">Ти-ти-у-у</div>
                                    <div className="filtr_content_part">Шуссель</div>
                                    <div className="filtr_content_part">Муми-мама</div>
                                    <div className="filtr_content_part">Морра</div>
                                    <div className="filtr_content_part">Туу-тикки</div>
                                    <div className="filtr_content_part">Юксаре</div>
                                    <div className="filtr_content_part">Тюлиппа</div>
                                    <div className="filtr_content_part">Тофсла</div>
                                    <div className="filtr_content_part">Муми-папа</div>
                                    <div className="filtr_content_part">Тофсла и Вифсла</div>
                                    <div className="filtr_content_part">Ондатр</div>
                                    <div className="filtr_content_part">Филифьонк</div>
                                    <div className="filtr_content_part">Онкельскрут</div>
                                    <div className="filtr_content_part">Дронт Эдвард</div>
                                    <div className="filtr_content_part">Фредриксон</div>
                                    <div className="filtr_content_part">Пожилой господин</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div className="filter__chapter" onClick={(e) => start_filter_accordion("Group", e)}>
                        <div className="filter__title">Группы</div>
                        <div className="filter__accordion">
                            <div className="filter__accordion__container">
                                <div className="label" id="Group">
                                    <div>Все</div>
                                    <img className="filter__search__slide" src="img/timetable_header/slide.svg"/>
                                </div>
                                <div className="filtr_content">
                                    <div className="filtr_content_part">Все</div>
                                    <div className="filtr_content_part">Мумрики</div>
                                    <div className="filtr_content_part">Муми-тролли</div>
                                    <div className="filtr_content_part">Снорки</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div className="filter__chapter" onClick={(e) => start_filter_accordion("Merp", e)}>
                        <div className="filter__title">Мероприятия</div>
                        <div className="filter__accordion">
                            <div className="filter__accordion__container">
                                <div className="label" id="Merp">
                                    <div>Все</div>
                                    <img className="filter__search__slide" src="img/timetable_header/slide.svg"/>
                                </div>
                                <div className="filtr_content">
                                    <div className="filtr_content_part">Все</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div className="filter__chapter" onClick={(e) => start_filter_accordion("Prod", e)}>
                        <div className="filter__title">Проекты</div>
                        <div className="filter__accordion">
                            <div className="filter__accordion__container">
                                <div className="label" id="Prod">
                                    <div>Все</div>
                                    <img className="filter__search__slide" src="img/timetable_header/slide.svg"/>
                                </div>
                                <div className="filtr_content">
                                    <div className="filtr_content_part">Все</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
    </div>
  );
}
