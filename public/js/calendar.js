// window.onload = createCalendar;
let monthsArray = ['January','February','March','April','May','June','July','August','September','October','November','December'];
// Allows us to make the calendar in the M,T,W,T,F,S,S format instead of S,M,T,W,T,F,S
let dayArray = [7,1,2,3,4,5,6];
class Calendar {
    constructor() {
        let date = new Date()
        this.year = date.getUTCFullYear();
        this.monthIndex = date.getUTCMonth();
        // Set date to the 1st of current month
        this.startOfMonthDate = new Date(this.year,this.monthIndex,1);
        // Month as a string
        this.month = monthsArray[this.monthIndex];
        this.date = 1;
        // Day of the week (0 means Sunday, 1 Monday etc.)
        this.dayAtStartOfMonth = this.startOfMonthDate.getDay();
        this.text='';
        // Colour of the top of each day
        this.color = 'red';
        this.numberOfDaysInMonth = this.daysInMonth(this.monthIndex,this.year);
        this._renderCalendarMonth();
    }

    // Number of days in the month
    daysInMonth(month,year) {
        return new Date(year,month+1,0).getDate();
    }

    // Renders the calendar month
    _renderCalendarMonth() {
        let i = 0;
        let calendarWrapper = document.getElementById('calendarWrapper');
        let calendarMonth = document.getElementById('calendarMonth');
        let iteratingDate =1;
        this.numberOfDaysInMonth = this.daysInMonth(this.monthIndex,this.year);
        // Set date to the 1st of current month
        this.startOfMonthDate = new Date(this.year,this.monthIndex,1);
        this.dayAtStartOfMonth = this.startOfMonthDate.getDay();
        calendarWrapper.innerHTML = '';
        // Changes month and year displayed
        calendarMonth.innerHTML = '';
        calendarMonth.innerHTML += `${this.month} ${this.year}`;      
        var myRequest = new Request('months.json');
        fetch(myRequest)
        .then(function(response) {return response.json();})
        .then(function(months) {
            let colour = 'light-grey';
            let colourTwo = "";
            let text = "";
            for (var i=1; i<=42;i++ ){
                if (i>=dayArray[calendar.dayAtStartOfMonth] && iteratingDate<=calendar.numberOfDaysInMonth){
                    if (`${iteratingDate}` in months[`${calendar.year}`][calendar.monthIndex]){
                        colour = months[`${calendar.year}`][calendar.monthIndex][`${iteratingDate}`].colour;
                        if (`text` in months[`${calendar.year}`][calendar.monthIndex][`${iteratingDate}`]){
                            text = months[`${calendar.year}`][calendar.monthIndex][`${iteratingDate}`].text;
                        }
                        if (`colourTwo` in months[`${calendar.year}`][calendar.monthIndex][`${iteratingDate}`]){
                            colourTwo = months[`${calendar.year}`][calendar.monthIndex][`${iteratingDate}`].colourTwo;
                        } 
                    }
                    if (colourTwo !== ""){
                        calendarWrapper.innerHTML +=`<div><div class="grid-two-col"><div class="${colour}"></div><div class= "${colourTwo}"><p class="calendar-number">${iteratingDate}</p></div></div><p class="calendar-text">${text}</p></div>`;
                        colourTwo = ""; 
                    } else {
                        calendarWrapper.innerHTML +=`<div><div class="grid-two-col"><div class="${colour}"></div><div class= "${colour}"><p class="calendar-number">${iteratingDate}</p></div></div><p class="calendar-text">${text}</p></div>`;
                    }
                    iteratingDate++;
                    text="";
                } else {
                    calendarWrapper.innerHTML += `<div><p class="calendar-text"></p></div>`;
                }
            }            
        });
    }

    // Displays next calendar month
    nextMonth() {
        if (this.monthIndex==11){
            this.monthIndex = 0;
            this.year += 1;
            this.month = monthsArray[this.monthIndex];
        } else {
            this.monthIndex += 1;
            this.month = monthsArray[this.monthIndex];
        }
        this._renderCalendarMonth();
    }
    
    // Displays previous calendar month
    prevMonth() {
        if (this.monthIndex==0){
            this.monthIndex = 11;
            this.month = monthsArray[this.monthIndex];
            this.year -= 1;
        } else {
            this.monthIndex -= 1;
            this.month = monthsArray[this.monthIndex];
        }
        this._renderCalendarMonth();
    }

    // AJAX handling
    // loadMonth(){
    // let xml = new XMLHttpRequest();
    // xml.open('GET','/calendar/lib/calendar-ajax.html',true);

    // xml.onload = function(){
    //     if(this.status==200){
    //         var months = JSON.parse(this.responseText);
    //     }
    //     let output = '';
    //     for (var i in months){
    //         console.log(months[i].month);
    //     }
    // }

    // xml.send();
    // }

    
}

// Creates the calendar
calendar = new Calendar();
leftArrow = document.getElementById('leftArrow');
rightArrow = document.getElementById('rightArrow');

// Clicking the arrows change the month
leftArrow.addEventListener("click", function(){
    calendar.prevMonth();
    
})
rightArrow.addEventListener("click", function(){
    calendar.nextMonth();
})
