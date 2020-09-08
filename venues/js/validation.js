function validateForm() {
    var venueName = document.forms["myForm"]["venueName"];
    var venueTypeId = document.forms["myForm"]["venueTypeId"];
    var contactNameId = document.forms["myForm"]["contactNameId"];
    var hostNameId = document.forms["myForm"]["hostNameId"];
    var venueDateStart = document.forms["myForm"]["venueDateStart"];
    var venueTimeStart = document.forms["myForm"]["venueTimeStart"];
    var venueDateEnd = document.forms["myForm"]["venueDateEnd"];
    var venueTimeEnd = document.forms["myForm"]["venueTimeEnd"];
    var timezoneId = document.forms["myForm"]["timezoneId"];

        //  test
        let errors = 0;
        if (venueName.value == "") {
            venueName.nextElementSibling.classList.remove("hide");
            venueName.focus();
            errors++;
        }
        if (venueTypeId.value === "-1") {
            venueTypeId.nextElementSibling.classList.remove("hide");
            venueTypeId.focus();
            errors++;
        }

        if (contactNameId.value === "-1") {
            contactNameId.nextElementSibling.classList.remove("hide");
            contactNameId.focus();
            errors++;
        }

        if (hostNameId.value === "-1") {
            hostNameId.nextElementSibling.classList.remove("hide");
            hostNameId.focus();
            errors++;
        }

        if (venueDateStart.value == "") {
            console.log(venueDateStart.nextElementSibling);
            venueDateStart.nextElementSibling.classList.remove("hide");
            venueDateStart.focus();
            errors++;
        }
        if (venueTimeStart.value == "") {
            venueTimeStart.nextElementSibling.classList.remove("hide");
            venueTimeStart.focus();
            errors++;
        }
        if (venueDateEnd.value == "") {
            venueDateEnd.nextElementSibling.classList.remove("hide");
            venueDateEnd.focus();
            errors++;
        }
        if (venueTimeEnd.value == "") {
            venueTimeEnd.nextElementSibling.classList.remove("hide");
            venueTimeEnd.focus();
            errors++;
        }
        if (timezoneId.value === "-1") {
            timezoneId.nextElementSibling.classList.remove("hide");
            timezoneId.focus();
            errors++;
        }
        console.log(errors);
        if (errors > 0) {
            return false;
        } else {
            return true;
        }
        // test
}