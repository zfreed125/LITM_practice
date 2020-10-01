show = [];
function myFunction(id) {
    if (id.style.display === "block") {
        id.style.display = "none";
        show.pop(id['id']);
    } else {
        show.push(id['id']);
        id.style.display = "block";
    }
    sessionStorage.setItem("contacts_uncollapsed", JSON.stringify(show));
}
function collapseAll() {
    var x = document.querySelectorAll(".table");
    for (j = 0; j < x.length; j++) {
        if (x[j].style.display === "block") {
            x[j].style.display = "none";
            show.pop(x[j]['id']);
        }
        sessionStorage.setItem("contacts_uncollapsed", JSON.stringify(show));
    }
}
// function clearAllNames(){
//     divs = document.querySelectorAll('[data-lastname]');
//     divs.forEach(div => div.classList.remove('dontShow'))
//     input = document.getElementById('searchInput').value = '';

// }
function searchLastNames() {
    console.log("last");
    let input, divs, rows;
    divs = document.querySelectorAll('[data-lastname]');
    input = document.getElementById('searchLastInput').value.toLowerCase();
    if (input.length != 0) {
        divs.forEach(div => div.classList.add('dontShow'))
        rows = document.querySelectorAll(`[data-lastname*="` + input + `"]`);
        rows.forEach(row => row.classList.remove('dontShow'))
    } else {
        divs.forEach(div => div.classList.remove('dontShow'))
    }

}
function searchFirstNames() {
    console.log("first");
    let input, divs, rows;
    divs = document.querySelectorAll('[data-firstname]');

    input = document.getElementById('searchFirstInput').value.toLowerCase();
    if (input.length != 0) {
        divs.forEach(div => div.classList.add('dontShow'))
        rows = document.querySelectorAll(`[data-firstname*="` + input + `"]`);
        rows.forEach(row => row.classList.remove('dontShow'))
    } else {
        divs.forEach(div => div.classList.remove('dontShow'))
    }

}

function searchActive() {
    let input, divs, rows;
    divs = document.querySelectorAll('[data-active]');

    input = document.getElementById('searchActive').checked;
    console.log("active", input);
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
    var uncollapsed = JSON.parse(sessionStorage.getItem("contacts_uncollapsed"));
    for (i = 0; i < uncollapsed.length; i++) {
        id = document.getElementById(uncollapsed[i]);
        myFunction(id);
    }


});