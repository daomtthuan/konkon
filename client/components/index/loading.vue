<template>
  <div class="mx-auto text-center">
    <b-spinner class="mr-1 mb-1" :variant="variant" small></b-spinner>
    <strong :class="`text-${variant}`" class="mt-1">Loading data...</strong>
  </div>
</template>

<script lang="ts">
  import { Component, Vue, Prop } from 'nuxt-property-decorator';

  @Component
  export default class Loading extends Vue {
    @Prop(String)
    private readonly variant!: string;
  }
</script>
