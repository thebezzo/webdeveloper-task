import Vue from 'vue';
import Vuex from 'vuex';
import { chunk } from 'lodash-es';
import filterPages from './functions/filterPages';

Vue.use(Vuex);

const APP_API = 'http://localhost:8000/api';

export default new Vuex.Store({
    state: {
        ready: false,
        error: false,
        reultsHeader: [
            'Supplier',
            'Pound Rating',
            'Reference',
            'Value'
        ],
        pages: [],
        filteredPages: [],
        filters: {
            search: '',
            poundRating: 0,
        },
        totalPages: null
    },
    getters: {
        reultsHeader (state) {
            return state.reultsHeader;
        },
        getTotalPagesNum (state) {
            return state.totalPages;
        },
        getPageByIndex (state) {
            return function (index) {
                if (index < 0) {
                    return state.filteredPages.length === 0 ? state.pages[0] : state.filteredPages[0];
                }
                if (index > state.totalPages) {
                    return [];
                }
                if (index === 0) {
                    return state.filteredPages.length === 0 ? state.pages[0] : state.filteredPages[0];
                }
                return state.filteredPages.length === 0 ? state.pages[index-1] : state.filteredPages[index-1];
            }
        },
        getItem (state) {
            return function ({id, page}) {
                return state.pages[parseInt(page-1)][parseInt(id)];
            };
        }
    },
    mutations: {
        pushPage (state, payload) {
            state.pages.push(payload);
        },
        updateTotalPages (state, payload) {
            state.totalPages = payload;
        },
        updateErrorStatus (state, payload) {
            state.error = payload;
        },
        updateAppStatus (state, payload) {
            state.ready = payload;
        },
        updateSearchFilter (state, payload) {
            state.filters.search = payload;
        },
        updateRatingFilter (state, payload) {
            state.filters.poundRating = payload;
        },
        updateSearchResults (state) {
            let pages = state.pages.flat();
            pages = filterPages(pages, state.filters);
            pages = chunk(pages, 5);
            state.filteredPages = pages;
            state.totalPages = pages.length
        },
        resetResults (state) {
            state.filters.search = '';
            state.filters.poundRating = 0;
            state.filteredPages = [];
            state.totalPages = state.pages.length;
        },
    },
    actions: {
        async fetchData ({commit}) {
            let id = 1;
            while (id !== -1) {
                const url = `${APP_API}/items/${id}`;
                await axios.get(url)
                    .then(response => {
                        const { data, total, next_page } = response.data;
                        commit('updateTotalPages', total);
                        commit('pushPage', data)
                        id = next_page;
                    })
                    .catch(() => {
                        commit('updateErrorStatus', true);
                    })
                    .finally(() => {
                        commit('updateAppStatus', true);
                    });
            }
        }
    }
})
