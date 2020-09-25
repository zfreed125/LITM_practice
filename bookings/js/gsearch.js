
function getFilteredVenues(q, genre_array, venue_name_array) {
    const MIN_SEARCH_TERM_LENGTH = 3;
    const gsearch = genre_array
        .filter((g) => g.venueId !== null)
        .map((g) => ({
            genreName: g.genreName.toLowerCase(),
            venueId: g.venueId,
        }));

    const filteredVenues = q.reduce((filteredVenuesArray, searchTerm) => {
        if (searchTerm.length >= MIN_SEARCH_TERM_LENGTH) {
            if (searchTerm === 'all') {
                filteredVenuesArray = venue_name_array;
            }
            gsearch
                .filter((genre) => genre.genreName.includes(searchTerm.toLowerCase()))
                .forEach((genre) => {
                    const venue = venue_name_array.find(
                        (venue) => venue.id === genre.venueId
                    );
                    filteredVenuesArray.push(venue);
                });
        }
        return filteredVenuesArray;
    }, []);

    return deduplicateArrayById(filteredVenues);
}

function deduplicateArrayById(arr) {
    return arr.filter((el, idx) => idx === arr.findIndex((i) => i.id === el.id));
}