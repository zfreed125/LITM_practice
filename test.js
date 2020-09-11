const genre_array = [
  {
    id: "1",
    genreName: "Technology",
    contactId: "1",
    venueId: null,
  },
  {
    id: "2",
    genreName: "Area 51",
    contactId: "1",
    venueId: null,
  },
  {
    id: "5",
    genreName: "Extra-Terrestrials",
    contactId: "2",
    venueId: null,
  },
  {
    id: "6",
    genreName: "Area 51",
    contactId: "2",
    venueId: null,
  },
  {
    id: "7",
    genreName: "Psychic",
    contactId: "2",
    venueId: null,
  },
  {
    id: "10",
    genreName: "Extra-Terrestrials",
    contactId: null,
    venueId: "1",
  },
  {
    id: "16",
    genreName: "Extra-Terrestrials",
    contactId: null,
    venueId: "15",
  },
  {
    id: "11",
    genreName: "Area 51",
    contactId: null,
    venueId: "2",
  },
  {
    id: "12",
    genreName: "Area 51",
    contactId: null,
    venueId: "1",
  },
  {
    id: "14",
    genreName: "Area 51",
    contactId: null,
    venueId: "14",
  },
  {
    id: "15",
    genreName: "Area 51",
    contactId: null,
    venueId: "14",
  },
];

const venue_name_array = [
  {
    id: "1",
    venueName: "Midnight Society",
  },
  {
    id: "2",
    venueName: "Mandela Effect",
  },
  {
    id: "14",
    venueName: "Test",
  },
  {
    id: "15",
    venueName: "Adam",
  },
];
const { deduplicateArrayById } = require("./funcs.js");

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
      gsearch
        .filter((genre) => genre.genreName.includes(searchTerm))
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

// function deduplicateArrayById(arr) {
//   return arr.filter((el, idx) => idx === arr.findIndex((i) => i.id === el.id));
// }

const filteredVenues = getFilteredVenues(
  ["xtr"],
  genre_array,
  venue_name_array
);

console.table(filteredVenues);
