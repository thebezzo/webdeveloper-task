<template>
    <div class="header">
        <h1 class="header__title">
            Where your money goes
        </h1>
        <p class="header__subtitle">
            Payments made by Chichester District Council to individual suppliers with a value over £500 made within October.
        </p>
    </div>
</template>

<style lang="scss">
.header {
    position: relative;
    display: flex;
    flex-flow: row wrap;
    padding-bottom: 14px;

    @media (min-width: 768px) {
        padding-bottom: 17px;
    }

    &::after {
        content: '';
        position: relative;
        top: 100%;
        left: 0;
        width: 100%;
        height: 1px;
        background-color: #E0E0E0;
    }

    &__title {
        flex: 0 0 100%;
        max-width: 100%;
        margin-bottom: 15px;
        color: #2288B7;
        font-size: 30px;
        font-weight: 300;
        text-align: center;
        word-spacing: 0.001em;

        @media (min-width: 768px) {
            flex: 0 0 100%;
            margin-bottom: 8px;
            font-size: 60px;
        }

        @media (min-width: 1024px) {
            flex: 0 0 auto;
            margin-right: auto;
            margin-left: 17.78%;
        }
    }

    &__subtitle {
        margin-bottom: 14px;
        padding: 0 15px;
        font-size: 13px;
        line-height: 1.2;
        text-align: center;
        word-spacing: 0.001em;

        @media (min-width: 768px) {
            margin-bottom: 26px;
            font-size: 17px;
        }

        @media (min-width: 1024px) {
            margin-right: auto;
            margin-left: 5.95%;
        }
    }
}
</style>

