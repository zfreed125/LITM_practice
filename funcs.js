function deduplicateArrayById(arr) {
    return arr.filter((el, idx) => idx === arr.findIndex((i) => i.id === el.id));
}

module.exports = { deduplicateArrayById };
