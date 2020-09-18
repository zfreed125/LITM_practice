function showBookingsForClient(clientId) {
    const clientName = contacts_array.find(function (c) {
        return c.id == clientId;
    }).fullname;
    let el = document.createElement("span");
    let bookingsByClientDiv = document.getElementById("bookingsByClient");
    const filtered = bookings_array.filter(function (obj) {
        return obj.clientNameId == clientId;
    });
    el.innerHTML = bookingsByClient(filtered);
    while (bookingsByClientDiv.hasChildNodes()) {
        bookingsByClientDiv.removeChild(bookingsByClientDiv.lastChild);
    }
    bookingsByClientDiv.appendChild(el);
}

function getLocalDateTimeFromUtc(utcDateTime) {
    const userTz = moment.tz.guess();
    const utcDt = moment.tz(utcDateTime, "UTC");
    const dt = utcDt.clone().tz(userTz);
    const formattedDt = dt.format("YYYY-MM-DD h:mm a");
    return [dt, formattedDt];
}
function clientBookingsByMonth(bookings) {
    // bookings is already sorted by startDate in the current user's tz
    // returns an object of arrays, each of a month of client bookings
    // retval = {
    //     2020: [
    //         [],
    //         [],
    //     ],
    //     2019: [
    //         [],
    //         [],
    //     ],
    // }

    const yearsInBookings = Array.from(
        new Set(bookings.map((booking) => booking.startDate.year()))
    );
    const retval = yearsInBookings.reduce((bookingsTable, year) => {
        bookingsTable[year] = [[], [], [], [], [], [], [], [], [], [], [], []];
        return bookingsTable;
    }, {});
    bookings.forEach((booking) => {
        retval[booking.startDate.year()][booking.startDate.month()].push(booking);
    });
    return retval;
}

function bookingsByClient(filtered) {
    const sortDescending = (a, b) => (a.startDate >= b.startDate ? -1 : 1);
    //   const MONTHS = [
    //     "January",
    //     "February",
    //     "March",
    //     "April",
    //     "May",
    //     "June",
    //     "July",
    //     "August",
    //     "September",
    //     "October",
    //     "November",
    //     "December",
    //   ];
    const MONTHS_REVERSE = [
        "December",
        "November",
        "October",
        "September",
        "August",
        "July",
        "June",
        "May",
        "April",
        "March",
        "February",
        "January",
    ];

    const data = filtered
        .map((booking) => {
            const [startDate, startDateFormatted] = getLocalDateTimeFromUtc(
                booking.utcDateTimeStart
            );
            const [endDate, endDateFormatted] = getLocalDateTimeFromUtc(
                booking.utcDateTimeEnd
            );
            return {
                ...booking,
                startDate,
                startDateFormatted,
                endDate,
                endDateFormatted,
            };
        })
        .sort(sortDescending);

    const bookingsTable = clientBookingsByMonth(data);
    const venues = changeVenueList(venue_name_array_from_db);

    let html = '<div class="booking-details"><div class="bookingsDetailsHeader">Historical Log</div>';

    const bookingsTableHtml = Object.keys(bookingsTable)
        .sort((a, b) => parseInt(a) >= parseInt(b) ? -1 : 1)
        .reduce((outerHtml, year) => {
            bookingsTable[year]     // months by year
                .reverse()          // sort months in reverse
                .forEach((month, idx) => {
                    if (month.length) {
                        const sectionTitle = `<h6>${year} - ${MONTHS_REVERSE[idx]}</h6>`
                        const bookingsHtml = month.reduce((html, booking) => {
                            const venue = venues.find(v => v.id === booking.venueNameId)?.venueName ?? 'unassigned'
                            return html + `<div class="history_row">${venue}: (${booking.startDateFormatted})-(${booking.endDateFormatted})</div>`
                        }, '')

                        let sectionHtml = `<div>${sectionTitle}${bookingsHtml}</div>`
                        outerHtml += sectionHtml
                    }
                })
            return outerHtml
        }, html) + '</div>'
    // console.log(bookingsTableHtml)
    return bookingsTableHtml
}
