<template>
  <main>
    <dashboard-sidebar />
    <div :class="{ 'sidebar-visible': $store.state.dashboard.sidebar.isVisible }">
      <div class="p-4">
        <dashboard-navbar />
        <b-card no-body class="overflow-hidden shadow border border-primary mt-4">
          <nuxt-child />
        </b-card>
      </div>
    </div>
  </main>
</template>

<script lang="ts">
  import { Component, Vue } from 'nuxt-property-decorator';
  import { Context } from '@nuxt/types';
  import App from '~/plugins/app';

  @Component({
    scrollToTop: true,
  })
  export default class PageDashboard extends Vue {
    public async asyncData(context: Context) {
      if (!(context.$auth.loggedIn && (context.$auth.hasScope('manager') || context.$auth.hasScope('employee')))) {
        context.redirect('/login');
      }
    }
  }
</script>

<style lang="scss">
  .sidebar-visible {
    padding-left: 320px !important;
  }
</style>
