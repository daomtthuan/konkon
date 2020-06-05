<template>
  <div>
    <dashboard-table :fields="fields" api="/api/manage/user" modal="user" />
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
      { key: 'birthday', label: 'Birthday', sortable: true, class: 'text-lg-right' },
      { key: 'phone', label: 'Phone', sortable: true, class: 'text-lg-right' },
      { key: 'address', label: 'Address', sortable: true },
      { key: 'actions', label: 'Actions', class: 'text-center' },
    ];

    public async asyncData(context: Context) {
      context.store.commit('dashboard/navbar/setBreadcrumb', [
        { text: 'Dashboard', to: '/dashboard' },
        { text: 'Manage', active: true },
        { text: 'User', active: true },
      ]);

      try {
        context.store.commit('dashboard/table/setItems', (await context.$axios.get('/api/manage/user')).data);
      } catch {
        context.error({
          statusCode: 500,
          message: 'Oops, something went wrong',
        });
      }
    }
  }
</script>
