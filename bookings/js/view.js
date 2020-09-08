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
window.addEventListener('load', (event) => {
    // var uncollapsed = JSON.parse(sessionStorage.getItem("bookings_uncollapsed"));
    // for (i = 0; i < uncollapsed.length; i++) {
    //     id = document.getElementById(uncollapsed[i]);
    //     myFunction(id);
    // } 


});