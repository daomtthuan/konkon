<template>
  <div>
    <dashboard-table :fields="fields" api="/api/manage/scope" modal="scope" stacked="md" />
    <dashboard-edit-scope />
    <dashboard-add-scope />
  </div>
</template>

<script lang="ts">
  import { Component, Vue, Watch } from 'nuxt-property-decorator';
  import { Context } from '@nuxt/types';

  @Component({
    scrollToTop: true,
  })
  export default class PageDashboardManageScope extends Vue {
    private fields = [
      { key: 'id', label: 'Id', sortable: true, class: 'd-none d-md-table-cell align-middle' },
      { key: 'name', label: 'Name', sortable: true, class: 'align-middle' },
      { key: 'actions', label: 'Actions', class: 'text-center align-middle' },
    ];

    public async asyncData(context: Context) {
      if (context.$auth.hasScope('manager')) {
        context.store.commit('dashboard/navbar/setBreadcrumb', [
          { text: 'Dashboard', to: '/dashboard' },
          { text: 'Manage', active: true },
          { text: 'Scope', active: true },
        ]);
        try {
          context.store.commit('dashboard/table/setItems', (await context.$axios.get('/api/manage/scope')).data);
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
