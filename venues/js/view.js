show = [];
function myFunction(id) {
    if (id.style.display === "block") {
        id.style.display = "none";
        show.pop(id['id']);
    } else {
        show.push(id['id']);
        id.style.display = "block";
    }
    sessionStorage.setItem("venues_uncollapsed", JSON.stringify(show));
}
function collapseAll() {
    var x = document.querySelectorAll(".table");
    for (j = 0; j < x.length; j++) {
        if (x[j].style.display === "block") {
            x[j].style.display = "none";
            show.pop(x[j]['id']);
        }
        sessionStorage.setItem("venues_uncollapsed", JSON.stringify(show));
    }
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
function searchHostNames() {
    console.log("Host");
    let input, divs, rows;
    divs = document.querySelectorAll('[data-hostname]');

    input = document.getElementById('searchHostNamesInput').value.toLowerCase();
    if (input.length != 0) {
        divs.forEach(div => div.classList.add('dontShow'))
        rows = document.querySelectorAll(`[data-hostname*="` + input + `"]`);
        rows.forEach(row => row.classList.remove('dontShow'))
    } else {
        divs.forEach(div => div.classList.remove('dontShow'))
    }

}
function prerecorded() {
    console.log("Host");
    let input, divs, rows;
    divs = document.querySelectorAll('[data-preRecorded]');

    input = document.getElementById('prerecorded').value.toLowerCase();
    if (input.length != 0) {
        divs.forEach(div => div.classList.add('dontShow'))
        rows = document.querySelectorAll(`[data-preRecorded*="` + input + `"]`);
        rows.forEach(row => row.classList.remove('dontShow'))
    } else {
        divs.forEach(div => div.classList.remove('dontShow'))
    }

}

function searchHot() {
    let input, divs, rows;
    divs = document.querySelectorAll('[data-hotCold]');

    input = document.getElementById('searchHot').checked;
    if (input) {
        divs.forEach(div => div.classList.add('dontShow'))
        rows = document.querySelectorAll(`[data-hotCold="` + input + `"]`);
        rows.forEach(row => row.classList.remove('dontShow'))
    } else {
        divs.forEach(div => div.classList.remove('dontShow'))
    }

}
function searchActive() {
    let input, divs, rows;
    divs = document.querySelectorAll('[data-active]');

    input = document.getElementById('searchActive').checked;
    if (input) {
        divs.forEach(div => div.classList.add('dontShow'))
        rows = document.querySelectorAll(`[data-active="` + input + `"]`);
        rows.forEach(row => row.classList.remove('dontShow'))
    } else {
        divs.forEach(div => div.classList.remove('dontShow'))
    }

}
function searchEmails() {
    console.log("emails");
    let input, divs, rows;
    divs = document.querySelectorAll('[data-email]');
    console.log(divs);
    input = document.getElementById('searchEmailInput').value.toLowerCase();
    if (input.length != 0) {
        divs.forEach(div => div.closest('div').classList.add('dontShow'))
        rows = document.querySelectorAll(`[data-email*="` + input + `"]`);
        rows.forEach(row => row.closest('div').classList.remove('dontShow'))
    } else {
        divs.forEach(div => div.closest('div').classList.remove('dontShow'))
    }

}
window.addEventListener('load', (event) => {
    var uncollapsed = JSON.parse(sessionStorage.getItem("venues_uncollapsed"));
    for (i = 0; i < uncollapsed.length; i++) {
        id = document.getElementById(uncollapsed[i]);
        myFunction(id);
    }


});