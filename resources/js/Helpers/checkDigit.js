export function checkDigit (event) {
    if (event.key.length === 1 && isNaN(Number(event.key))) {
        event.preventDefault();
    }
};