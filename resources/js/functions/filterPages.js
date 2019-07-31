/**
 * @param object[] pages
 * @param object filters
 */
export default function filterPages(pages, filters) {
    const { search, poundRating } = filters;
    if (search !== '' && poundRating !== 0) {
        return pages.filter(page => page.name.toLowerCase().includes(search.toLowerCase()) && page.rating === poundRating);
    }
    if (search !== '') {
        return pages.filter(page => page.name.toLowerCase().includes(search.toLowerCase()));
    }
    if (poundRating !== 0) {
        return pages.filter(page => page.rating === poundRating);
    }
    return pages;
}
