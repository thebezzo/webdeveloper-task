<template>
    <ul class="rating">
        <li class="rating__item" :class="{ 'rating__item--active': n <= rate }" :key="n" v-for="n in 5">
            <span class="rating__item-value">
                £
            </span>
        </li>
    </ul>
</template>

<script>
export default {
    props: {
        rate: Number
    }
}
</script>

<style lang="scss">
.rating {
    display: flex;
    flex-flow: row wrap;
    justify-content: flex-start;
    margin: 0;
    padding: 0;
    list-style-type: none;

    @media (min-width: 768px) {
        justify-content: space-evenly;
    }

    &__item {
        display: flex;
        flex-flow: row wrap;
        justify-content: center;
        align-content: center;
        width: 25px;
        height: 25px;
        color: #666;
        font-weight: bold;
        background: rgba(245,245,245,1);
        background: linear-gradient(0deg, rgba(0,0,0,0.12) 0%, rgba(255,255,255,1) 100%);
        border: 1px solid #8F8F8F;
        border-radius: 100%;

        &:not(:last-child) {
            margin-right: 4px;

            @media (min-width: 768px) {
                margin-right: 0;
            }
        }

        &--active {
            color: #FFF;
            background: rgb(31,118,240);
            background: linear-gradient(0deg, rgba(31,118,240,1) 0%, rgba(107,161,243,1) 100%);
        }
    }
}
</style>
