<template>
    <div class="pagination">
        <ul class="pagination__list">
            <li class="pagination__item">
                <router-link :to="`/${prevPage}`" class="pagination__link" :class="{ 'pagination__link--disabled': currentPage == prevPage }">
                    ❮
                </router-link>
            </li>
            <li class="pagination__item" :key="n" v-for="n in getTotalPagesNum">
                <router-link :to="`/${n}`" active-class="pagination__link--active" class="pagination__link" :class="{ 'pagination__link--active': 1 === currentPage && n === 1 }">
                    {{ n }}
                </router-link>
            </li>
            <li class="pagination__item">
                <router-link :to="`${nextPage}`" class="pagination__link" :class="{ 'pagination__link--disabled': currentPage == nextPage }">
                    ❯
                </router-link>
            </li>
        </ul>
    </div>
</template>

<script>
import { mapGetters } from 'vuex';

export default {
    computed: {
        currentPage () {
            return this.$route.params.id || 1;
        },
        nextPage () {
            const currentPage = parseInt(this.currentPage);
            if (currentPage >= this.getTotalPagesNum) {
                return this.getTotalPagesNum;
            }
            return currentPage+1;
        },
        prevPage () {
            const currentPage = parseInt(this.currentPage);
            if (currentPage <= 1) {
                return 1;
            }
            return this.currentPage-1;
        },
        ...mapGetters([
            'getTotalPagesNum'
        ])
    },
}
</script>

<style lang="scss">
.pagination {
    &__list {
        display: flex;
        flex-flow: row wrap;
        justify-content: center;
        margin: 0;
        padding: 0;
        list-style-type: none;
    }

    &__item {
        margin: 0 2px;
    }

    &__link {
        position: relative;
        display: flex;
        justify-content: center;
        align-items: center;
        align-content: center;
        width: 25px;
        height: 25px;
        color: #717171;
        font-size: 12px;
        font-weight: bold;
        text-decoration: none;
        background: rgba(245,245,245,1);
        background: linear-gradient(0deg, rgba(0,0,0,0.12) 0%, rgba(255,255,255,1) 100%);
        border: 1px solid #BFBFBF;
        border-radius: 4px;
        z-index: 1;

        &--active {
            overflow: hidden;
            color: #FFF;
            background: #606060;
            border: 0;
            box-shadow: inset 0 0 5px 1px rgba(0,0,0,0.4);
            &::after {
                content: '';
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: red;
                background: linear-gradient(0deg, rgba(0,0,0,0.09) 0%, rgba(255,255,255,0.09) 100%);
                z-index: -1;
            }
        }
    }
}
</style>


