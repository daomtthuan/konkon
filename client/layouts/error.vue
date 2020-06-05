<template>
  <main class="d-flex align-items-center vh-100">
    <b-container class="text-center">
      <logo size="128" tag="h1" subtag="h3" class="mx-auto" />
      <div class="py-5">
        <h4 class="text-danger">Error {{ error.statusCode }}</h4>
        <h6 class="text-muted">{{ error.message }}</h6>
        <b-link href="/">Go back home</b-link>
      </div>
    </b-container>
  </main>
</template>

<script lang="ts">
  import { Component, Vue, Prop } from 'nuxt-property-decorator';

  @Component
  export default class LayoutError extends Vue {
    @Prop(Error)
    private readonly error!: Error;
  }
</script>
