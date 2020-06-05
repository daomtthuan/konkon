<template>
  <div class="text-center mx-auto">
    <div class="mx-auto my-1" :class="`logo-${size}`"></div>
    <div class="font-logo my-1 text-primary" :class="tag">KonKon</div>
    <div class="font-logo my-1 text-dark" :class="subtag">Computer Store</div>
  </div>
</template>

<script lang="ts">
  import { Component, Vue, Prop } from 'nuxt-property-decorator';

  @Component
  export default class Logo extends Vue {
    @Prop(String)
    private readonly size!: string;

    @Prop(String)
    private readonly tag!: string;

    @Prop(String)
    private readonly subtag!: string;
  }
</script>
