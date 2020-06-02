<template>
  <div class="text-justify p-5">
    <logo size="128" tag="h1" subtag="h3" class="mx-auto mb-5" />
    <nuxt-child />
  </div>
</template>

<script lang="ts">
  import { Component, Vue } from 'nuxt-property-decorator';

  @Component
  export default class PagePolicyGuide extends Vue {}
</script>
