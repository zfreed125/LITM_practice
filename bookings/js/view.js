show = [];
function myFunction(id) {
    if (id.style.display === "block") {
        id.style.display = "none";
        show.pop(id['id']);
    } else {
        show.push(id['id']);
        id.style.display = "block";
    }
    sessionStorage.setItem("bookings_uncollapsed", JSON.stringify(show));
}
function dbclick(el) {
    console.log(el);
}
function searchType() {
    console.log("Venue");
    let input, divs, rows;
    divs = document.querySelectorAll('[data-type]');
    input = document.getElementById('searchTypeInput').value.toLowerCase();
    if (input.length != 0) {
        divs.forEach(div => div.classList.add('dontShow'))
        rows = document.querySelectorAll(`[data-type*="` + input + `"]`);
        rows.forEach(row => row.classList.remove('dontShow'))
    } else {
        divs.forEach(div => div.classList.remove('dontShow'))
    }

}
function searchVenueNames() {
    console.log("Venue");
    let input, divs, rows;
    divs = document.querySelectorAll('[data-venuename]');
    input = document.getElementById('searchVenueNamesInput').value.toLowerCase();
    if (input.length != 0) {
        divs.forEach(div => div.classList.add('dontShow'))
        rows = document.querySelectorAll(`[data-venuename*="` + input + `"]`);
        rows.forEach(row => row.classList.remove('dontShow'))
    } else {
        divs.forEach(div => div.classList.remove('dontShow'))
    }

}
function searchContactNames() {
    console.log("Contact");
    let input, divs, rows;
    divs = document.querySelectorAll('[data-contactname]');
    input = document.getElementById('searchContactNamesInput').value.toLowerCase();
    if (input.length != 0) {
        divs.forEach(div => div.classList.add('dontShow'))
        rows = document.querySelectorAll(`[data-contactname*="` + input + `"]`);
        rows.forEach(row => row.classList.remove('dontShow'))
    } else {
        divs.forEach(div => div.classList.remove('dontShow'))
    }

}
function ClientConfirm() {
    let input, divs, rows;
    divs = document.querySelectorAll('[data-clientconfirm]');

    input = document.getElementById('ClientConfirm').checked;
    if (input) {
        divs.forEach(div => div.classList.add('dontShow'))
        rows = document.querySelectorAll(`[data-clientconfirm="` + input + `"]`);
        rows.forEach(row => row.classList.remove('dontShow'))
    } else {
        divs.forEach(div => div.classList.remove('dontShow'))
    }

}
function VenueConfirm() {
    let input, divs, rows;
    divs = document.querySelectorAll('[data-venueconfirm]');

    input = document.getElementById('VenueConfirm').checked;
    if (input) {
        divs.forEach(div => div.classList.add('dontShow'))
        rows = document.querySelectorAll(`[data-venueconfirm="` + input + `"]`);
        rows.forEach(row => row.classList.remove('dontShow'))
    } else {
        divs.forEach(div => div.classList.remove('dontShow'))
    }

}
window.addEventListener('load', (event) => {
    // var uncollapsed = JSON.parse(sessionStorage.getItem("bookings_uncollapsed"));
    // for (i = 0; i < uncollapsed.length; i++) {
    //     id = document.getElementById(uncollapsed[i]);
    //     myFunction(id);
    // } 


});