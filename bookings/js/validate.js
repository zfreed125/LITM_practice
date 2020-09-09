function formValidate() {
    var venueName = document.forms["myForm"]["venueNameId"];
    var clientName = document.forms["myForm"]["clientNameId"];
    var bookingType = document.getElementById("bookingTypeId");

    if (bookingType.value == "-1") {
        bookingType.nextElementSibling.classList.remove("hide");
        bookingType.focus();
        return false;
    }

    if (bookingType.value == "2") {
        if (venueName.value == "-1") {
            venueName.nextElementSibling.classList.remove("hide");
            venueName.focus();
            return false;
        }
    } else if (bookingType.value == "1") {
        if (clientName.value == "-1") {
            clientName.nextElementSibling.classList.remove("hide");
            clientName.focus();
            return false;
        }
    }
}