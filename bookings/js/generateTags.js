function updateClientGenreTags(clientNameId) {
    let genreTagDiv = document.getElementById('genreContactTags');
    while (genreTagDiv.hasChildNodes()) {
        genreTagDiv.removeChild(genreTagDiv.lastChild);
    }
    let h;
    for (h = 0; h < genre_array.length; h++) {
        let el = document.createElement("span");
        let tag = genre_array[h];
        if (tag['contactId'] === clientNameId) {
            el.dataset.label = tag['genreName'];
            el.dataset.id = clientNameId;
            el.innerHTML = tag['genreName'] + ' <span class="btn-delete">X</span>';
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
            genreTagDiv.appendChild(el);
        }
    }
}

function updateVenueGenreTags(venueNameId) {
    let genreTagDiv = document.getElementById('genreVenueTags');
    while (genreTagDiv.hasChildNodes()) {
        genreTagDiv.removeChild(genreTagDiv.lastChild);
    }
    let h;
    for (h = 0; h < genre_array.length; h++) {
        let el = document.createElement("span");
        let tag = genre_array[h];
        if (tag['venueId'] === venueNameId) {
            el.dataset.label = tag['genreName'];
            el.dataset.id = venueNameId;
            el.innerHTML = tag['genreName'] + ' <span class="btn-delete">X</span>';
            el.className = 'badge badge-primary p-1 m-1 fu';
            el.addEventListener('click', (event) => {
                var name = event.currentTarget.dataset.label;
                genre_array = genre_array.filter(function (obj) {
                    return obj.genreName !== name;
                });
                genreTagDiv.removeChild(el);
            })
            genreTagDiv.appendChild(el);
        }
    }

}
function getValueFromClientSelect(clientId) {
    let x = document.getElementById('clientNameId');
    x.nextElementSibling.classList.add('hide');
    updateClientGenreTags(clientId);
    showBookingsForClient(clientId);
    var clientSearchTermsDiv = document.getElementById('genreContactTags');
    searchTerm = [].map.call(clientSearchTermsDiv.children, function (e) {
        return e.getAttribute('data-label')
    })
    console.clear();
    console.log("New");
    console.log(searchTerm);
    
    const filteredVenues = getFilteredVenues(
        searchTerm,
        genre_array_original,
        venue_name_array_from_db
        );
        
    console.log("genre_array",genre_array);
    console.log("filteredVenues",filteredVenues);
    var newFilteredVenuesByTag = changeVenueList(filteredVenues);
    console.log("newFilteredVenuesByTag",newFilteredVenuesByTag);
    getVenueList(newFilteredVenuesByTag);
}

function getValueFromVenueSelect(venueId) {
    let x = document.getElementById('venueNameId');
    x.nextElementSibling.classList.add('hide');
    updateVenueGenreTags(venueId);
}


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
        var name = event.currentTarget.dataset.id;
        genre_array = genre_array.filter(function (obj) {
            return obj.genreName !== name;
        });
        genreTagDiv.removeChild(el);
        getValueFromClientSelect(id);

    })
    genre_array.push({ 'id': null, 'genreName': e, 'contactId': contactId, 'venueId': null });

    genreTagDiv.appendChild(el);

}
function addTagFromVenueInput(e) {
    let x = document.getElementById('venueNameId');
    venueId = x.options[x.selectedIndex].value;
    let btn = document.getElementById('addTagToVenue');
    let input = document.getElementById('btnTagToVenue');
    let genreTagDiv = document.getElementById('genreVenueTags');
    genreTagDiv.removeChild(btn);
    genreTagDiv.removeChild(input);
    let el = document.createElement("span");
    el.innerHTML = e + ' <span class="btn-delete">X</span>';
    el.className = 'badge badge-primary p-1 m-1 fu';
    el.addEventListener('click', (event) => {
        var name = event.currentTarget.dataset.label;
        genre_array = genre_array.filter(function (obj) {
            return obj.genreName !== name;
        });
        genreTagDiv.removeChild(el);
    })
    genre_array.push({ 'id': null, 'genreName': e, 'contactId': null, 'venueId': venueId });
    genreTagDiv.appendChild(el);


}

function createInputClientTag(e) {
    var genreClientDiv = document.getElementById(e);
    var input = document.createElement("input");
    input.id = 'addTagToClient';
    var btn = document.createElement("button");
    btn.id = 'btnTagToClient'
    btn.textContent = 'add';
    btn.type = 'button';
    btn.addEventListener('click', () => {
        addTagFromClientInput(document.getElementById('addTagToClient').value)
        // console.log(genreClientDiv.lastChild.dataset.id);
        getValueFromClientSelect(genreClientDiv.lastChild.dataset.id);
    })

    genreClientDiv.appendChild(input);
    genreClientDiv.appendChild(btn);
}
function createInputVenueTag(e) {
    var genreVenueDiv = document.getElementById(e);
    var input = document.createElement("input");
    input.id = 'addTagToVenue';
    var btn = document.createElement("button");
    btn.id = 'btnTagToVenue'
    btn.textContent = 'add';
    btn.type = 'button';
    btn.addEventListener('click', () => {
        addTagFromVenueInput(document.getElementById('addTagToVenue').value)
    })

    genreVenueDiv.appendChild(input);
    genreVenueDiv.appendChild(btn);
}