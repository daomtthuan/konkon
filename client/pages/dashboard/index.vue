<template>
  <div>
    asdadasdasdasdasdadasda
  </div>
</template>

<script lang="ts">
  import { Component, Vue } from 'nuxt-property-decorator';
  import App from '~/plugins/app';

  @Component({
    scrollToTop: true,
  })
  export default class PageDashboardHome extends Vue {
    public mounted() {
      App.ready(this);
    }

    public fetch() {
      this.$store.commit('dashboard/setBreadcrumb', [
        { text: 'Dashboard', to: '/dashboard' },
        { text: 'Home', active: true },
      ]);
    }
  }
</script>
