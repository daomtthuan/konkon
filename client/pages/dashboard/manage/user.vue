<template>
  <div>
    <dashboard-table :fields="fields" api="/api/manage/user" modal="user" stacked="xl" />
    <dashboard-edit-user />
    <dashboard-add-user />
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
      { key: 'id', label: 'Id', sortable: true, class: 'd-none' },
      { key: 'account', label: 'Account', sortable: true, class: 'align-middle' },
      { key: 'name', label: 'Name', sortable: true, class: 'align-middle' },
      {
        key: 'gender',
        label: 'Gender',
        formatter: (gender: number) => (gender == 1 ? 'Male' : 'Fefale'),
        sortable: true,
        sortByFormatted: true,
        filterByFormatted: true,
        stickyColumn: true,
        class: 'align-middle',
      },
      { key: 'birthday', label: 'Birthday', sortable: true, class: 'text-xl-right align-middle' },
      { key: 'email', label: 'Email', sortable: true, class: 'd-none' },
      { key: 'phone', label: 'Phone', sortable: true, class: 'text-xl-right align-middle' },
      { key: 'address', label: 'Address', sortable: true, class: 'align-middle' },
      { key: 'actions', label: 'Actions', class: 'text-center align-middle' },
    ];

    public async asyncData(context: Context) {
      if (context.$auth.hasScope('manager')) {
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
      } else {
        context.redirect('/dashboard');
      }
    }
  }
</script>
