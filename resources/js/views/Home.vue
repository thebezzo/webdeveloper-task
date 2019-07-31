<template>
  <div class="home">
      <header-component></header-component>
      <search-component></search-component>
      <results-component></results-component>
      <pagination-component></pagination-component>
  </div>
</template>

<script>
import { mapGetters } from 'vuex';

export default {
    created () {
        this.$store.dispatch('fetchData')
    },
}
</script>

<style lang="scss">
.home {
    padding: 15px 20px 22px;
}
</style>
