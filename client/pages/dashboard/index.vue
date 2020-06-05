<template>
  <div>
    asdadasdasdasdasdadasda
  </div>
</template>

<script lang="ts">
  import { Component, Vue } from 'nuxt-property-decorator';
  import { Context } from '@nuxt/types';

  @Component({
    scrollToTop: true,
  })
  export default class PageDashboardHome extends Vue {
    public asyncData(context: Context) {
      context.store.commit('dashboard/navbar/setBreadcrumb', [
        { text: 'Dashboard', to: '/dashboard' },
        { text: 'Home', active: true },
      ]);
    }
  }
</script>
