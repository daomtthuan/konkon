<template>
  <v-client-table :data="dataTable" :columns="['id', 'name', 'age']" />
</template>

<script lang="ts">
  import { Component, Vue } from 'nuxt-property-decorator';
  import { Context } from '@nuxt/types';

  @Component({
    scrollToTop: true,
  })
  export default class PageDashboardManageUser extends Vue {
    public asyncData(context: Context) {
      context.store.commit('dashboard/setBreadcrumb', [
        { text: 'Dashboard', to: '/dashboard' },
        { text: 'Manage', active: true },
        { text: 'User', active: true },
      ]);

      return {
        dataTable: [],
      };
    }
  }
</script>
