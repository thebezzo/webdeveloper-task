<template>
    <div class="modal">
        <div class="modal__body">
            <button class="modal__close" @click="$emit('close')">
                ×
            </button>
            <h5 class="modal__title">
                {{ title }}
            </h5>
            <div class="modal__rating">
                <p class="modal__label modal__label--rating">
                    Rating
                </p>
                <rating-component :rate="rating"></rating-component>
            </div>
            <div class="modal__reference">
                <div class="modal__label modal__label--reference">
                    Reference
                </div>
                <p>{{ reference }}</p>
            </div>
            <div class="modal__value">
                <div class="modal__label modal__label--value">
                    Value
                </div>
                <p>{{ value }}</p>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        title: String,
        rating: Number,
        value: String,
        reference: Number
    },
}
</script>

<style lang="scss">
.modal {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0,0,0,0.5);
    z-index: 10;

    &__body {
        position: relative;
        width: calc(100% - 30px);
        margin: 30px auto;
        padding: 22px 30px;
        background-color: #FFF;
        border-radius: 4px;

        @media (min-width: 768px) {
            width: 75%;
            margin: 15% auto;
        }

        @media (min-width: 1024px) {
            width: 50%;
        }
    }

    &__close {
        position: absolute;
        top: 10px;
        right: 15px;
        width: 30px;
        height: 30px;
        padding: 0;
        font-size: 22px;
        font-weight: bold;
        line-height: 30px;
        text-align: center;
        background: 0;
        border: 0;
        cursor: pointer;

        &:focus {
            outline: 0;
            box-shadow: 0 0 0 2px rgba(darken(rgba(212,212,211,1), 10%), 0.25);
        }
    }

    &__title {
        margin-bottom: 18px;
        padding-right: 15px;
        color: #2288B7;
        font-size: 40px;
        font-weight: bold;
    }

    &__label {
        margin-bottom: 8px;
        font-size: 14px;
        font-weight: bold;
        text-transform: uppercase;
    }

    &__rating {
        margin-bottom: 24px;
    }

    .rating {
        justify-content: flex-start;
        max-width: 50%;

        &__item {
            &:not(:last-child) {
                margin-right: 4px;
            }
        }
    }
}
</style>
