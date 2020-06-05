<template>
  <b-navbar class="shadow-lg border border-primary" variant="light">
    <b-button v-b-toggle.dashboard-sidebar variant="primary" class="mr-3">
      <font-awesome-icon :icon="['fas', 'bars']" />
    </b-button>

    <b-navbar-brand to="/dashboard" class="font-logo mr-lg-3">
      <div class="logo-32 d-inline-block align-top mr-1"></div>
      <span class="text-primary">KonKon</span>
    </b-navbar-brand>

    <b-nav class="d-none d-md-block">
      <b-navbar-nav class="text-truncate">
        <b-breadcrumb :items="$store.state.dashboard.navbar.breadcrumb" class="m-0 p-0 bg-light" />
      </b-navbar-nav>
    </b-nav>

    <b-nav class="ml-auto">
      <b-navbar-nav>
        <b-nav-item to="/"><font-awesome-icon class="mr-2" :icon="['fas', 'home']" />Home</b-nav-item>
        <b-nav-item @click="logout"><font-awesome-icon class="mr-2" :icon="['fas', 'sign-out-alt']" />Logout</b-nav-item>
      </b-navbar-nav>
    </b-nav>
  </b-navbar>
</template>

<script lang="ts">
  import { Component, Vue } from 'nuxt-property-decorator';

  @Component
  export default class DashboardNavbar extends Vue {
    public async logout() {
      await this.$auth.logout();
      window.localStorage.removeItem('session');
      window.localStorage.removeItem('token');
    }
  }
</script>
