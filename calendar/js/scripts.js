'use strict'

console.log('imported script.js');

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
        cell.setAttribute("id", `${Number(selectMonth.value) + 1}-${date}-${year}`);
        if (date === today.getDate() && year === today.getFullYear() && month === today.getMonth()) {
          cell.className = '';
          cell.style = 'background-color: #8BC3F7;';
        } // color today's date
        cell.appendChild(cellText);
        cell.appendChild(br);
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
function email() {
  let bookingData = document.getElementById('currentBooking').dataset.booking;
  let booking = JSON.parse(bookingData);
  console.log(booking);

  var xmlHttp = new XMLHttpRequest();
  xmlHttp.onreadystatechange = function () {
    if (xmlHttp.readyState == 4 && xmlHttp.status == 200) {
      console.log(xmlHttp.responseText);
    }
  }
  xmlHttp.open("post", "../email.php");
  xmlHttp.send(bookingData);





}
function createBooking(startDate, clientFullName, color, title, booking) {

  let cell = document.getElementById(startDate);
  if (cell == null) return;


  let detailsPanel = document.createElement("span");
  detailsPanel.id = 'currentBooking';
  detailsPanel.dataset.booking = JSON.stringify(booking);
  let emailButton = document.createElement("button");
  let bookingEl = document.createElement("span");
  emailButton.className = 'btn btn-primary';
  emailButton.textContent = 'Email Booking';
  emailButton.onclick = email;
  bookingEl.innerHTML = clientFullName;
  // bookingEl.innerHTML = clientFullName.toUpperCase() + '';
  // bookingEl.title = title;
  bookingEl.className = 'badge p-1 m-1';
  bookingEl.style = `background-color: ${color}; color: white;cursor: pointer;font-size: 8px;`;
  bookingEl.addEventListener('dblclick', () => {
    let sideDetails = document.getElementById('sideDetails');
    while (sideDetails.hasChildNodes()) {
      sideDetails.removeChild(sideDetails.lastChild);
    }
    detailsPanel.innerHTML = getDetailsPane(booking);
    sideDetails.appendChild(detailsPanel);
    sideDetails.appendChild(emailButton);
  })
  cell.appendChild(bookingEl);

}

function getDetailsPane(booking) {
  let primaryVenueService = ``;
  let primaryVenueNote = ``;
  let clientPrimaryEmail = ``;
  let hostPrimaryEmail = ``;
  let clientPrimaryNote = ``;
  if (booking.clientPrimaryNoteId) {
    clientPrimaryNote = `<div><span>clientPrimaryNote:</span> ${booking.clientPrimaryNote}</div>`;
  }
  if (booking.hostPrimaryEmailId) {
    hostPrimaryEmail = `<div><span>hostPrimaryEmail:</span> ${booking.hostPrimaryEmail}</div>`;
  }
  if (booking.clientPrimaryEmailId) {
    clientPrimaryEmail = `<div><span>clientPrimaryEmail:</span> ${booking.clientPrimaryEmail}</div>`;
  }
  if (booking.primaryVenueNoteId) {
    primaryVenueNote = `<div><span>VenueNote:</span> ${booking.primaryVenueNote}</div>`;
  }
  if (booking.primaryVenueServiceId) {
    primaryVenueService = `<div><span>VenueServiceName:</span> ${booking.primaryVenueServiceName}</div> <div><span>VenueServiceUserAccount:</span> ${booking.primaryVenueServiceUserAccount}</div> <div><span>VenueServiceWebsite:</span> ${booking.primaryVenueServiceWebsite}</div> <div><span>VenueServiceNotes:</span> ${booking.primaryVenueServiceNotes}</div> `;
  }
  return `
  <div class="booking-details">
    <div><span>[${booking.StartTime} - ${booking.EndTime} ${booking.venueName}]<span></div>

    <div hidden><span>bookingId:</span> ${booking.bookingId}</div>
    <div hidden><span>clientConfirm:</span> ${booking.clientConfirm}</div>
    <div><span>bookingType:</span> ${booking.bookingType}</div>
    <div><span>StartDate:</span> ${booking.StartDate}</div>
    <div hidden><span>bookingDateTimeStart:</span> ${booking.bookingDateTimeStart}</div>
    <div><span>StartTime:</span> ${booking.StartTime}</div>
    <div hidden><span>bookingDateTimeEnd:</span> ${booking.bookingDateTimeEnd}</div>
    <div><span>EndDate:</span> ${booking.EndDate}</div>
    <div><span>EndTime:</span> ${booking.EndTime}</div>
    <div><span>timezone:</span> ${booking.timezone}</div>
    <div><span>bookingLength:</span> ${booking.bookingLength}</div>
    <div><span>clientFullName:</span> ${booking.clientFullName}</div>
    <div><span>bookingColor:</span> ${booking.bookingColor}</div>
    <div><span>venueName:</span> ${booking.venueName}</div>
    <div><span>hostFullName:</span> ${booking.hostFullName}</div>
    ${hostPrimaryEmail}
    <div><span>bookingStatus:</span> ${booking.bookingStatus}</div>
    ${clientPrimaryEmail}
    ${clientPrimaryNote}
    ${primaryVenueNote}
    ${primaryVenueService}
    <div hidden><span>clientTzId:</span> ${booking.clientTzId}</div>
  </div>
  `;
}
function populateCalendar(event) {
  window.booking_array.forEach(booking => {
    let primaryVenueService = ``;
    let primaryVenueNote = ``;
    let clientPrimaryEmail = ``;
    let hostPrimaryEmail = ``;
    let clientPrimaryNote = ``;
    if (booking.clientPrimaryNoteId) {
      clientPrimaryNote = `clientPrimaryNote: ${booking.clientPrimaryNote}`;
    }
    if (booking.hostPrimaryEmailId) {
      hostPrimaryEmail = `hostPrimaryEmail: ${booking.hostPrimaryEmail}`;
    }
    if (booking.clientPrimaryEmailId) {
      clientPrimaryEmail = `clientPrimaryEmail: ${booking.clientPrimaryEmail}`;
    }
    if (booking.primaryVenueNoteId) {
      primaryVenueNote = `VenueNote: ${booking.primaryVenueNote}`;
    }
    if (booking.primaryVenueServiceId) {
      primaryVenueService = `VenueServiceName: ${booking.primaryVenueServiceName}VenueServiceUserAccount: ${booking.primaryVenueServiceUserAccount}VenueServiceWebsite: ${booking.primaryVenueServiceWebsite}VenueServiceNotes: ${booking.primaryVenueServiceNotes}`;
    }
    let clientIsConfirmed;
    let venueIsConfirmed;
    if (booking.clientConfirm === '1') {
      clientIsConfirmed = '<span style="float:left"><i style="margin-right:2px;margin-bottom:2px;color:green;background-color:white;" class="fas fa-check-square"></i>';
    } else {
      clientIsConfirmed = '<span style="float:left"><i style="margin-right:2px;margin-bottom:2px;background-color:white;color:red;" class="fas fa-times-circle"></i>';
    }
    if (booking.venueConfirm === '1') {
      venueIsConfirmed = '<span style="float:left"><i style="margin-right:2px;color:green;background-color:white;" class="fas fa-check-square"></i>';
    } else {
      // <a href='../bookings/update_vc.php?id=${booking.bookingId}&vc=1' title='Confirm Venue'> </a>
      venueIsConfirmed = `<span style="float:left"><a  href="../bookings/update_vc.php?id=${booking.bookingId}&vc=1" title="Confirm Venue"><i style="margin-right:2px;background-color:white;color:red;" class="fas fa-times-circle"></i></a>`;
    }
    const startDate = booking['StartDate'];
    const clientFullName = clientIsConfirmed + booking['clientFullName'] + '</span>' + '<br>' + venueIsConfirmed + booking['venueName'] + '</span>';
    // const clientFullName = booking['clientFullName'] + '-' + booking['venueName'];
    const color = (booking['bookingColor'] === null) ? 'rgb(0, 0, 0)' : booking['bookingColor'];
    const title = '';
    //   const title = `
    // [${booking.StartTime} - ${booking.EndTime} ${booking.venueName}]
    // <div hidden><span>bookingId:</span> ${booking.bookingId}</div>
    // bookingType: ${booking.bookingType}
    // StartDate: ${booking.StartDate}
    // bookingDateTimeStart: ${booking.bookingDateTimeStart}
    // StartTime: ${booking.StartTime}
    // bookingDateTimeEnd: ${booking.bookingDateTimeEnd}
    // EndDate: ${booking.EndDate}
    // EndTime: ${booking.EndTime}
    // timezone: ${booking.timezone}
    // bookingLength: ${booking.bookingLength}
    // clientFullName: ${booking.clientFullName}
    // bookingColor: ${booking.bookingColor}
    // venueName: ${booking.venueName}
    // hostFullName: ${booking.hostFullName}
    // ${hostPrimaryEmail}
    // bookingStatus: ${booking.bookingStatus}
    // ${clientPrimaryEmail}
    // ${ clientPrimaryNote }
    // ${primaryVenueNote}
    // ${primaryVenueService}
    // clientTzId: ${booking.clientTzId}

    // `;
    createBooking(startDate, clientFullName, color, title, booking);
  })
}
window.addEventListener('load', populateCalendar)
document.getElementById('next').addEventListener('click', next)
document.getElementById('previous').addEventListener('click', previous)