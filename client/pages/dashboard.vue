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
  import App from '~/plugins/app';

  @Component({
    fetchOnServer: false,
    scrollToTop: true,
  })
  export default class PageDashboard extends Vue {
    public async fetch() {
      try {
        await App.fetchUser(this);
        if (!(this.$auth.loggedIn && (this.$auth.hasScope('manager') || this.$auth.hasScope('employee')))) {
          this.$router.replace('/login');
        }
      } catch {
        this.$nuxt.error({
          statusCode: 500,
          message: 'Oops, something went wrong',
        });
      }
    }
  }
</script>

<style lang="scss">
  .sidebar-visible {
    padding-left: 320px !important;
  }
</style>
