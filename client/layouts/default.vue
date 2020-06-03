<template>
  <div class="background">
    <nuxt id="page" v-show="$store.state.app.isReady" />
    <div class="d-flex align-items-center vh-100" v-if="!$store.state.app.isReady">
      <b-container class="text-center">
        <logo size="128" tag="h1" subtag="h3" class="mx-auto" />
        <loading class="mt-3" variant="secondary" />
      </b-container>
    </div>
  </div>
</template>

<script lang="ts">
  import { Component, Vue } from 'nuxt-property-decorator';

  @Component
  export default class LayoutDefault extends Vue {}
</script>
