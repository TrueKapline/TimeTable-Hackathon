const DAYS_IN_WEEK = 7;
const DAYS_IN_MONTH = [31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];
const Month = {
    January: 0,
    February: 0,
    March: 0,
    April: 0,
    May: 0,
    June: 0,
    July: 0,
    August: 0,
    September: 0,
    October: 0,
    November: 0,
    December: 0
};

export function areEqual(a, b) {
    if(!a || !b) return false;

    return (
        a.getFullYear() === b.getFullYear() && 
        a.getMonth() === b.getMonth() &&
        a.getDate() === b.getDate()
    );
}

export function isLeapYear(year) {
    return !((year % 4) || (!(year % 100) & (year % 400)));
}

export function getDaysInMonth(date) { 
    const month = date.getMonth();
    const year = date.getFullYear();
    const daysInMonth = DAYS_IN_MONTH[month];
    
    if(isLeapYear(year) && month === Month.February) {
        return daysInMonth + 1;
    } else {
        return daysInMonth;
    }
}

export function getDayOfWeek(date) {
    const dayOfWeek = date.getDay();

    if(dayOfWeek === 0) {
        return 6;
    } else {
        return dayOfWeek - 1;
    }
    
}

export function getMonthData(year, month) {
    const result = [];
    const date = new Date(year, month);
    let day = 1;
    const daysInMonth = getDaysInMonth(date); //Дней в году
    const monthStartsOn = getDayOfWeek(date); //День недели исходя из даты

    for (let i = 0; i < (daysInMonth + monthStartsOn) / DAYS_IN_WEEK; i++) { //Сколько в месяце будет недель
        result[i] = [];

        for (let j = 0; j < DAYS_IN_WEEK; j++) {
            if((i === 0 && j < monthStartsOn) || day > daysInMonth) {
                result[i][j] = undefined;
            } else {
                result[i][j] = new Date(year, month, day++);
            }
        }
    }

    return result;
}

export function daySelected() {


    // var MyDiv1 = document.getElementById('day.selected');
    // var MyDiv2 = document.getElementById('date__daySelect');
    // MyDiv2.innerHTML = MyDiv1.innerHTML;
}