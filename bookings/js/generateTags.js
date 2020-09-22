function getVenueList(venue_name_array) {
    var venue_select = document.getElementById('venueNameId');
    while (venue_select.hasChildNodes()) {
        venue_select.removeChild(venue_select.lastChild);
    }
    var j;
    for (j = 0; j < venue_name_array.length; j++) {
        var opt = venue_name_array[j];
        var el = document.createElement("option");
        if (opt['id'] === selected_venue) {
            el.selected = true;
        }
        el.textContent = opt['venueName'];
        el.value = opt['id'];

        venue_select.appendChild(el);
    }
}
function updateGenreTags(Id, genreDivId, tagKeyName, getValueFromSelect) {
    let genreTagDiv = document.getElementById(genreDivId);
    while (genreTagDiv.hasChildNodes()) {
        genreTagDiv.removeChild(genreTagDiv.lastChild);
    }
    let h;
    for (h = 0; h < genre_array.length; h++) {
        let el = document.createElement("span");
        let tag = genre_array[h];
        if (tag[tagKeyName] === Id) {
            el.dataset.label = tag['genreName'];
            el.dataset.id = Id;
            el.innerHTML = tag['genreName'] + ' <span class="btn-delete">X</span>';
            el.className = 'badge badge-primary p-1 m-1 fu';
            el.addEventListener('click', (event) => {
                var name = event.currentTarget.dataset.label;
                var id = event.currentTarget.dataset.id;
                genre_array = genre_array.filter(function (obj) {
                    return obj.genreName !== name;
                });
                genreTagDiv.removeChild(el);
                getValueFromSelect(id);
            })
            genreTagDiv.appendChild(el);
        }
    }
}

// Note: This will eventually be able to be abtracted with the commented code below
function getValueFromClientSelect(clientId) {
    let x = document.getElementById('clientNameId');
    x.nextElementSibling.classList.add('hide');

    updateGenreTags(clientId, 'genreContactTags', 'contactId', getValueFromClientSelect)
    // updateClientGenreTags(clientId);
    showBookingsForClient(clientId);
    var SearchTermsDiv = document.getElementById('genreContactTags');
    searchTerm = [].map.call(SearchTermsDiv.children, function (e) {
        return e.getAttribute('data-label')
    })
    // console.clear();
    // console.log("New");
    // console.log(searchTerm);

    const filteredVenues = getFilteredVenues(
        searchTerm,
        genre_array_original,
        venue_name_array_from_db
    );

    // console.log("genre_array",genre_array);
    // console.log("filteredVenues",filteredVenues);
    var newFilteredVenuesByTag = changeVenueList(filteredVenues);
    // console.log("newFilteredVenuesByTag",newFilteredVenuesByTag);
    getVenueList(newFilteredVenuesByTag);
}



// Note: This will eventually be able to be abtracted with the commented code below
function addTagFromClientInput(e) {
    let x = document.getElementById('clientNameId');
    contactId = x.options[x.selectedIndex].value;
    let btn = document.getElementById('addTagToClient');
    let input = document.getElementById('btnTagToClient');
    let genreTagDiv = document.getElementById('genreContactTags');
    genreTagDiv.removeChild(btn);
    genreTagDiv.removeChild(input);
    let el = document.createElement("span");
    el.dataset.label = e;
    el.dataset.id = contactId;
    el.innerHTML = e + ' <span class="btn-delete">X</span>';
    el.className = 'badge badge-primary p-1 m-1 fu';
    el.addEventListener('click', (event) => {
        var name = event.currentTarget.dataset.label;
        var id = event.currentTarget.dataset.id;
        genre_array = genre_array.filter(function (obj) {
            return obj.genreName !== name;
        });
        genreTagDiv.removeChild(el);
        getValueFromClientSelect(id);

    })
    genre_array.push({ 'id': null, 'genreName': e, 'contactId': contactId, 'venueId': null });

    genreTagDiv.appendChild(el);

}


function createInputTag(e, tagId, btnId, addTagFromInput, getValueFromSelect) {
    var genreDiv = document.getElementById(e);
    var input = document.createElement("input");
    input.id = tagId;
    var btn = document.createElement("button");
    btn.id = btnId
    btn.textContent = 'add';
    btn.type = 'button';
    btn.addEventListener('click', () => {
        addTagFromInput(document.getElementById(tagId).value)
        getValueFromSelect(genreDiv.lastChild.dataset.id);
    })

    genreDiv.appendChild(input);
    genreDiv.appendChild(btn);
    input.focus();
}


function getValueFromVenueSelect(venueId) {
    let x = document.getElementById('venueNameId');
    x.nextElementSibling.classList.add('hide');
    updateGenreTags(venueId, 'genreVenueTags', 'venueId', getValueFromVenueSelect);

    // Note: This code needs to be re-written to allow reverse search gsearch will need to handle client instead of venue

    // var SearchTermsDiv = document.getElementById('genreVenueTags');
    // searchTerm = [].map.call(SearchTermsDiv.children, function (e) {
    //     return e.getAttribute('data-label')
    // })
    // const filteredVenues = getFilteredVenues(
    //     searchTerm,
    //     genre_array_original,
    //     venue_name_array_from_db
    // );
    // var newFilteredVenuesByTag = changeVenueList(filteredVenues);
    // getVenueList(newFilteredVenuesByTag);
}


// Note: Need to put this back when we add the reverse gsearch for Venue
// function addTagFromVenueInput(e) {
//     let x = document.getElementById('venueNameId');
//     venueId = x.options[x.selectedIndex].value;
//     let btn = document.getElementById('addTagToVenue');
//     let input = document.getElementById('btnTagToVenue');
//     let genreTagDiv = document.getElementById('genreVenueTags');
//     genreTagDiv.removeChild(btn);
//     genreTagDiv.removeChild(input);
//     let el = document.createElement("span");
//     el.innerHTML = e + ' <span class="btn-delete">X</span>';
//     el.className = 'badge badge-primary p-1 m-1 fu';
//     el.addEventListener('click', (event) => {
//         var name = event.currentTarget.dataset.label;
//         var id = event.currentTarget.dataset.id;
//         genre_array = genre_array.filter(function (obj) {
//             return obj.genreName !== name;
//         });
//         genreTagDiv.removeChild(el);
//         getValueFromVenueSelect(id);
//     })
//     genre_array.push({ 'id': null, 'genreName': e, 'contactId': null, 'venueId': venueId });
//     genreTagDiv.appendChild(el);
// }