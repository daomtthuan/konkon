<template>
  <div></div>
</template>

<script lang="ts">
  import { Component, Vue } from 'nuxt-property-decorator';
  import App from '~/plugins/app';

  @Component({
    scrollToTop: true,
  })
  export default class PageHome extends Vue {
    public mounted() {
      App.ready(this);
    }
  }
</script>
