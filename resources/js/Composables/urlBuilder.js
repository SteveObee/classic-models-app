/**
 * @param {string} url
 * @param {object} params
 */

export function useUrlBuilder(url, params) {
    let urlString = url

    for ( let param in params) {
        const query = '&' + param + '=' + params[param]

        urlString += query
    }

    return url && urlString
}