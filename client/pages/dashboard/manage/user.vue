<template>
  <div>
    <dashboard-table api="/api/user" :fields="fields" modal="user" />
    <dashboard-edit-user />
  </div>
</template>

<script lang="ts">
  import { Component, Vue, Watch } from 'nuxt-property-decorator';
  import { Context } from '@nuxt/types';

  @Component({
    scrollToTop: true,
  })
  export default class PageDashboardManageUser extends Vue {
    private fields = [
      { key: 'account', label: 'Account', sortable: true },
      { key: 'name', label: 'Name', sortable: true },
      {
        key: 'gender',
        label: 'Gender',
        formatter: (gender: number) => (gender == 1 ? 'Male' : 'Fefale'),
        sortable: true,
        sortByFormatted: true,
        filterByFormatted: true,
        stickyColumn: true,
      },
      { key: 'birthday', label: 'Birthday', sortable: true, class: 'text-right', stickyColumn: true },
      { key: 'phone', label: 'Phone', sortable: true, class: 'text-right', stickyColumn: true },
      { key: 'address', label: 'Address', sortable: true },
      { key: 'actions', label: 'Actions' },
    ];

    public async asyncData(context: Context) {
      context.store.commit('dashboard/setBreadcrumb', [
        { text: 'Dashboard', to: '/dashboard' },
        { text: 'Manage', active: true },
        { text: 'User', active: true },
      ]);
    }
  }
</script>
