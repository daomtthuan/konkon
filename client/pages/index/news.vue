<template>
  <div class="text-justify p-5">
    <logo size="128" tag="h1" subtag="h3" class="mx-auto mb-5" />
    <h2>News and Sale</h2>
    <hr />
    <nuxt-child />
  </div>
</template>

<script lang="ts">
  import { Component, Vue } from 'nuxt-property-decorator';

  @Component({
    scrollToTop: true,
  })
  export default class PageNews extends Vue {}
</script>
