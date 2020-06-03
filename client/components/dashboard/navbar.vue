<template>
  <b-navbar id="navbar" class="shadow-lg border border-primary" variant="light">
    <b-button v-b-toggle.sidebar variant="primary" class="mr-3">
      <font-awesome-icon :icon="['fas', $store.state.dashboard.sidebar.isVisible ? 'times' : 'bars']" />
    </b-button>

    <b-navbar-brand to="/dashboard" class="font-logo" v-show="!$store.state.dashboard.sidebar.isVisible">
      <div class="logo-32 d-inline-block align-top mr-1"></div>
      <span class="text-primary">KonKon</span>
    </b-navbar-brand>

    <b-collapse is-nav>
      <b-navbar-nav class="text-truncate">
        <b-breadcrumb :items="$store.state.dashboard.navbar.breadcrumb" class="m-0 p-0 bg-light" />
      </b-navbar-nav>
      <b-navbar-nav class="ml-auto">
        <b-nav-item @click="logout"><font-awesome-icon class="mr-2" :icon="['fas', 'sign-out-alt']" />Logout</b-nav-item>
      </b-navbar-nav>
    </b-collapse>
  </b-navbar>
</template>

<script lang="ts">
  import { Component, Vue } from 'nuxt-property-decorator';

  @Component
  export default class DashboardNavbar extends Vue {
    public async logout() {
      await this.$auth.logout();
      if (localStorage.session && localStorage.token) {
        localStorage.removeItem('session');
        localStorage.removeItem('token');
      }
    }
  }
</script>
