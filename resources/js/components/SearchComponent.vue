<template>
    <div class="search">
        <div class="search__wrapper">
            <div class="search__input-wrapper">
                <input type="text" class="search__input" placeholder="Search suppliers" v-model.lazy="search">
            </div>
            <div class="search__rating-wrapper">
                <select class="search__rating" name="poundng-rating" id="poundng-rating" v-model="rating">
                    <option :value="0">Select pound rating</option>
                    <option :value="1">1</option>
                    <option :value="2">2</option>
                    <option :value="3">3</option>
                    <option :value="4">4</option>
                    <option :value="5">5</option>
                </select>
            </div>
            <div class="search__button-wrapper">
                <button class="search__button button" @click="resetFilters">Reset</button>
            </div>
            <div class="search__button-wrapper">
                <button class="search__button button button--blue" @click="updateFilters">Search</button>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    computed: {
        search: {
            get () {
                return this.$store.state.filters.search;
            },
            set (value) {
                this.$store.commit('updateSearchFilter', value);
            }
        },
        rating: {
            get () {
                return this.$store.state.filters.poundRating;
            },
            set (value) {
                this.$store.commit('updateRatingFilter', value);
            }
        }
    },
    methods: {
        updateFilters () {
            if (this.search !== '' || this.rating !== 0) {
                this.$store.commit('updateSearchResults');
                this.$router.push({name: 'page', params: {id: '1'}});
            }
        },
        resetFilters () {
            this.$store.commit('resetResults');
            this.$router.push({name: 'page', params: {id: '1'}});
        }
    }
}
</script>


<style lang="scss">
.search {
    margin-bottom: 14px;

    @media (min-width: 768px) {
        margin-bottom: 18px;
    }

    &__wrapper {
        display: flex;
        flex-flow: row wrap;
        width: 100%;
        max-width: 720px;
        margin-right: auto;
        margin-left: auto;

        @media (min-width: 1024px) {
            margin-right: initial;
            margin-left: 09.63%;
        }
    }

    &__input-wrapper {
        flex: 0 0 100%;
        max-width: 100%;
        margin-bottom: 10px;
        @media (min-width: 768px) {
            flex: 0 0 355px;
            max-width: 355px;
            margin-right: 10px;
            margin-bottom: 0;
        }
        @media (min-width: 1024px) {
            flex: 0 0 370px;
            max-width: 370px;
            margin-right: 10px;
            margin-bottom: 0;
        }
    }

    &__input {
        display: block;
        width: 100%;
        max-width: 370px;
        min-height: 30px;
        margin: 0;
        padding: 0 10px;
        font-size: 12px;
        border: 1px solid #D6D6D6;
        border-radius: 5px;

        &:focus,
        &:active {
            outline: 0;
            box-shadow: 0 0 0 2px rgba(darken(#D6D6D6, 10%), 0.25);
        }
    }

    &__rating-wrapper {
        display: flex;
        flex: 0 0 100%;
        max-width: 100%;
        max-height: 30px;
        margin-right: 10px;
        margin-bottom: 10px;
        padding: 6px;
        background-color: #EAECED;
        border-radius: 4px;

        @media (min-width: 375px) {
            flex: 0 0 130px;
            max-width: 130px;
            margin-bottom: 0;
        }

        @media (min-width: 768px) {
            flex: 0 0 160px;
            max-width: 160px;
        }
    }

    &__rating {
        width: 100%;
        max-height: 18px;
        font-size: 11px;

        &:focus,
        &:active {
            outline: 0;
            box-shadow: 0 0 0 2px rgba(darken(#2288B7, 10%), 0.25);
        }
    }

    &__button-wrapper {
        margin-right: 10px;

        &:last-of-type {
            margin-right: 0;
        }
    }
}
</style>
