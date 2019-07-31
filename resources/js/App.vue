<template>
  <div id="app">
    <div class="main-wrapper">
        <router-view/>
    </div>
  </div>
</template>

<style lang="scss">
    .main-wrapper {
        max-width: 980px;
        margin: 15px;
        background-color: #FFF;
        border-radius: 2px;
        box-shadow: 0 4px 8px -4px rgba(0,0,0,0.15),
                    0 0 0 7px rgba(0,0,0,0.05);

        @media (min-width: 768px) {
            margin: 77px 15px 144px;
        }

        @media (min-width: 1100px) {
            margin: 77px auto 144px;
        }
    }
</style>
