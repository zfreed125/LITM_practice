'use strict'

console.log('imported script.js')

let today = new Date();
let currentMonth = today.getMonth();
let currentYear = today.getFullYear();
let selectYear = document.getElementById("year");
let selectMonth = document.getElementById("month");

let months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];

let monthAndYear = document.getElementById("monthAndYear");
showCalendar(currentMonth, currentYear);


function next() {
  currentYear = (currentMonth === 11) ? currentYear + 1 : currentYear;
  currentMonth = (currentMonth + 1) % 12;
  showCalendar(currentMonth, currentYear);
  populateCalendar();
}

function previous() {
  currentYear = (currentMonth === 0) ? currentYear - 1 : currentYear;
  currentMonth = (currentMonth === 0) ? 11 : currentMonth - 1;
  showCalendar(currentMonth, currentYear);
  populateCalendar();
}

function jump() {
  currentYear = parseInt(selectYear.value);
  currentMonth = parseInt(selectMonth.value);
  showCalendar(currentMonth, currentYear);
}

function showCalendar(month, year) {
  let firstDay = (new Date(year, month)).getDay();

  let tbl = document.getElementById("calendar-body"); // body of the calendar

  // clearing all previous cells
  tbl.innerHTML = "";

  // filing data about month and in the page via DOM.
  monthAndYear.innerHTML = months[month] + " " + year;
  selectYear.value = year;
  selectMonth.value = month;

  // creating all cells
  let date = 1;
  for (let i = 0; i < 6; i++) {
    // creates a table row
    let row = document.createElement("tr");

    //creating individual cells, filing them up with data.
    for (let j = 0; j < 7; j++) {
      if (i === 0 && j < firstDay) {
        let cell = document.createElement("td");
        let cellText = document.createTextNode("");
        cell.appendChild(cellText);
        row.appendChild(cell);
      }
      else if (date > daysInMonth(month, year)) {
        break;
      }

      else {
        let cell = document.createElement("td");
        let br = document.createElement("br");
        let cellText = document.createTextNode(date);
        // booking1 = document.createElement("span");
        // booking2 = document.createElement("span");
        // booking3 = document.createElement("span");
        // booking4 = document.createElement("span");
        // booking5 = document.createElement("span");
        // booking1.innerHTML = "test"+(date);
        cell.setAttribute("id", `${Number(selectMonth.value) + 1}-${date}-${year}`);
        // booking2.innerHTML = "test"+(date);
        // booking3.innerHTML = "test"+(date);
        // booking4.innerHTML = "test"+(date);
        // booking5.innerHTML = "test"+(date);
        // booking1.className = 'badge badge-primary p-1 m-1 fu';
        // booking2.className = 'badge badge-info p-1 m-1 fu';
        // booking3.className = 'badge badge-warning p-1 m-1 fu';
        // booking4.className = 'badge badge-danger p-1 m-1 fu';
        // booking5.className = 'badge badge-success p-1 m-1 fu';
        // cellText1 = document.createTextNode("test");
        if (date === today.getDate() && year === today.getFullYear() && month === today.getMonth()) {
          cell.className = '';
          cell.style = 'background-color: #8BC3F7;';
        } // color today's date
        cell.appendChild(cellText);
        cell.appendChild(br);
        // cell.appendChild(booking1);
        // cell.appendChild(booking2);
        // cell.appendChild(booking3);
        // cell.appendChild(booking4);
        // cell.appendChild(booking5);
        row.appendChild(cell);
        date++;
      }


    }

    tbl.appendChild(row); // appending each row into calendar body.
  }

}


// check how many days in a month code from https://dzone.com/articles/determining-number-days-month
function daysInMonth(iMonth, iYear) {
  return 32 - new Date(iYear, iMonth, 32).getDate();
}

// create function for booking
function createBooking(startDate, clientFullName, color, title, booking) {
  let cell = document.getElementById(startDate);
  if (cell == null) return;


  let detailsPanel = document.createElement("span");
  let bookingEl = document.createElement("span");
  bookingEl.innerHTML = clientFullName.toUpperCase();
  bookingEl.title = title;
  bookingEl.className = 'badge p-1 m-1';
  bookingEl.style = `background-color: ${color}; color: white;cursor: pointer;font-size: 8px;`;
  bookingEl.addEventListener('dblclick', () => {
    let sideDetails = document.getElementById('sideDetails');
    while (sideDetails.hasChildNodes()) {
      sideDetails.removeChild(sideDetails.lastChild);
    }
    detailsPanel.innerHTML = getDetailsPane(booking);
    sideDetails.appendChild(detailsPanel);
  })
  cell.appendChild(bookingEl);

}
function getDetailsPane(booking) {
  return `
  <div class="booking-details">
    <div>[${booking.StartTime} - ${booking.EndTime} ${booking.venueName}]</div>

    <div>bookingType: ${booking.bookingType}</div>
    <div>StartDate: ${booking.StartDate}</div>
    <div>StartTime: ${booking.StartTime}</div>
    <div>EndDate: ${booking.EndDate}</div>
    <div>EndTime: ${booking.EndTime}</div>
    <div>timezone: ${booking.timezone}</div>
    <div>bookingLength: ${booking.bookingLength}</div>
    <div>clientFullName: ${booking.clientFullName}</div>
    <div>bookingColor: ${booking.bookingColor}</div>
    <div>clientConfirm: ${booking.clientConfirm}</div>
    <div>venueName: ${booking.venueName}</div>
    <div>venueConfirm: ${booking.venueConfirm}</div>
    <div>bookingStatus: ${booking.bookingStatus}</div>
  </div>
  `;
}
function populateCalendar(event) {
  window.booking_array.forEach(booking => {
    const startDate = booking['StartDate'];
    const clientFullName = booking['clientFullName'] + '-' + booking['venueName'];
    const color = (booking['bookingColor'] === null) ? 'rgb(0, 0, 0)' : booking['bookingColor'];
    const title = `
  [12:00 - 13:00 Event name]
  bookingType: ${booking.bookingType}
  StartDate: ${booking.StartDate}
  StartTime: ${booking.StartTime}
  EndDate: ${booking.EndDate}
  EndTime: ${booking.EndTime}
  timezone: ${booking.timezone}
  bookingLength: ${booking.bookingLength}
  clientFullName: ${booking.clientFullName}
  bookingColor: ${booking.bookingColor}
  clientConfirm: ${booking.clientConfirm}
  venueName: ${booking.venueName}
  venueConfirm: ${booking.venueConfirm}
  bookingStatus: ${booking.bookingStatus}
  
  `;

    createBooking(startDate, clientFullName, color, title, booking);
  })
}
console.dir(window.booking_array);
window.addEventListener('load', populateCalendar)
document.getElementById('next').addEventListener('click', next)
document.getElementById('previous').addEventListener('click', previous)