<template>
  <v-client-table :data="dataTable" :columns="['id', 'name', 'age']" />
</template>

<script lang="ts">
  import { Component, Vue } from 'nuxt-property-decorator';
  import App from '~/plugins/app';

  @Component({
    scrollToTop: true,
  })
  export default class PageDashboardManageUser extends Vue {
    private dataTable: any[] = [];

    public mounted() {
      App.ready(this);
    }

    public fetch() {
      this.$store.commit('dashboard/setBreadcrumb', [
        { text: 'Dashboard', to: '/dashboard' },
        { text: 'Manage', active: true },
        { text: 'User', active: true },
      ]);
    }
  }
</script>
