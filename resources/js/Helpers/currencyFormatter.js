/**
 * @param {string} number
 */

export function currencyFormatter(number) {
    const convertedNumber = Number(number);

    return '£ ' + convertedNumber.toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2});
}