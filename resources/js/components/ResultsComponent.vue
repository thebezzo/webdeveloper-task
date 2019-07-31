<template>
    <div class="results">
        <div class="results__header">
            <div class="results__row results__row--high">
                <div class="results__column results__column--blank"
                     :key="index"
                     v-for="(headerName, index) in reultsHeader">
                    <p class="results__column-value results__column-value--dark">
                        {{ headerName }}
                    </p>
                </div>
            </div>
        </div>
        <div class="results__body">
            <div class="results__row" :key="index" v-for="(item, index) in getPageByIndex($route.params.id || 1)" @click="openDetails(index)">
                <div class="results__column" :key="key" v-for="(value, key, index) in item">
                    <div class="results__column-label">
                        {{ reultsHeader[index] }}
                    </div>
                    <div :class="`results__column-value results__column-value--${key}`"
                         v-if="key === 'rating'">
                        <rating-component :rate="value"></rating-component>
                    </div>
                    <p :class="`results__column-value results__column-value--${key}`"
                       v-else-if="key === 'value'">
                        {{ formatValue(value) }}
                    </p>
                    <p :class="`results__column-value results__column-value--${key}`"
                       v-else>
                        {{ value }}
                    </p>
                </div>
            </div>
        </div>
        <div class="results__modal" v-if="showModal">
            <modal-component :title="modal.name" :rating="modal.rating" :value="modal.value" :reference="modal.reference" @close="showModal = false"></modal-component>
        </div>
    </div>
</template>

<script>
import Dinero from 'dinero.js';
import { mapGetters } from 'vuex';

export default {
    data () {
        return {
            showModal: false,
            modal: {
                name: null,
                rating: null,
                value: null,
                reference: null
            }
        }
    },
    computed: {
        ...mapGetters([
            'currentPage',
            'reultsHeader',
            'getPageByIndex',
        ])
    },
    methods: {
        formatValue (value) {
            const price = Dinero({
                amount: value,
                currency: 'GBP'
            }).toFormat('$0,0.00');
            return price;
        },
        openDetails (id) {
            const page = this.$route.params.id || 1;
            const { name, rating, value, reference } = this.$store.getters.getItem({ id, page })
            this.showModal = true;
            this.modal = { name, rating, value: this.formatValue(value), reference };
        }
    }
}
</script>

<style lang="scss">
.results {
    margin: 0 auto 18px;
    border: 1px solid #D6D6D6;
    border-radius: 5px;
    box-shadow: 0 4px 6px -4px rgba(0,0,0,0.08);

    &__header {
        display: none;
        background-color: #EBECED;
        border-bottom: 1px solid #CCCFD1;

        @media (min-width: 768px) {
            display: block;
        }
    }

    &__row {
        display: flex;
        flex-flow: row wrap;
        min-height: 50px;
        padding: 8px;

        @media (min-width: 768px) {
            padding: 0;
        }

        &:not(:last-of-type) {
            border-bottom: 1px solid #CCCFD1;
        }

        &:nth-child(even) {
            background-color: #F8F8F8;
        }

        &:not(.results__row--high) {
            cursor: pointer;

            &:hover {
                background-color: darken(#F8F8F8, 10%);
            }
        }

        &--high {
            min-height: 58px;
        }
    }

    &__column {
        display: flex;
        flex: 0 0 100%;
        flex-flow: row wrap;

        &:not(:last-of-type) {
            margin-bottom: 12px;

            @media (min-width: 768px) {
                margin-bottom: 0;
            }
        }

        @media (min-width: 768px) {
            align-items: center;
            align-content: center;
        }

        &:nth-child(1) {
            @media (min-width: 768px) {
                flex: 0 0 55.5%;
                padding-right: 15px;
                padding-left: 30px;
            }

            @media (min-width: 1024px) {
                flex: 0 0 58.5%;
            }
        }

        &:nth-child(2) {
            @media (min-width: 768px) {
                flex: 0 0 22%;
            }

            @media (min-width: 1024px) {
                flex: 0 0 19%;
            }
        }

        &:nth-child(3) {
            @media (min-width: 768px) {
                flex: 0 0 11.25%;
            }
        }

        &:nth-child(4) {
            @media (min-width: 768px) {
                flex: 0 0 11.25%;
            }
        }

        &:not(:first-child) {
            @media (min-width: 768px) {
                padding: 0 5px;
                text-align: center;
            }
        }

        &:not(:last-child) {
            @media (min-width: 768px) {
                border-right: 1px solid #CCCFD1;
            }
        }

        &--blank {
            &:not(:last-child) {
                border-right: 0;
            }
        }
    }

    &__column-label {
        flex: 0 0 100%;
        max-width: 100%;
        margin-bottom: 2px;
        font-size: 13px;
        font-weight: bold;

        @media (min-width: 768px) {
            display: none;
        }
    }

    &__column-value {
        flex: 0 0 100%;
        max-width: 100%;
        margin-bottom: 0;
        color: #555;

        @media (min-width: 768px) {
            font-size: 14px;
        }

        &--dark {
            color: #666;
            font-weight: bold;
        }
    }
}
</style>
