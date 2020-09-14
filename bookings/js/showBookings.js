function showBookingsForClient(clientId) {
    const clientName = contacts_array.find(function (c) {
        return c.id == clientId;
    }).fullname
    let el = document.createElement("span");
    let bookingsByClientDiv = document.getElementById('bookingsByClient');
    const filtered = bookings_array.filter(function (obj) {
        return obj.clientNameId == clientId;
    });
    el.innerHTML = bookingsByClient(filtered);
    while (bookingsByClientDiv.hasChildNodes()) {
        bookingsByClientDiv.removeChild(bookingsByClientDiv.lastChild);
    }
    bookingsByClientDiv.appendChild(el);
}
function bookingsByClient(filtered) {
    let html = `<div class="booking-details">
    <div class="bookingsDetailsHeader" >Historical Log (All Date/Time is America/Chicago)</div>
    `;
    for (i = 0; i < filtered.length; i++) {
        let venue_name_array = changeVenueList(venue_name_array_from_db);
        const venueName = venue_name_array.find(function (v) {
            return v.id == filtered[i].venueNameId;
        })
        // console.log(typeof venueName);
        if (typeof venueName === 'undefined') {
            venue_name = 'undefined';
        } else {
            venue_name = venueName.venueName;
        }
        html += `
        <div class="history_row"><span>${venue_name}: (${filtered[i].bStartDate} ${filtered[i].bStartTime})-(${filtered[i].bEndDate} ${filtered[i].bEndTime}) (${filtered[i].timezone})<span></div>
        `;
    }
    html += '</div>';
    return html
}