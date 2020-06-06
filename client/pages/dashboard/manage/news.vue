<template>
  <div>
    <dashboard-table :fields="fields" api="/api/manage/news" modal="news" stacked="md" />
    <dashboard-edit-news />
    <dashboard-add-news />
  </div>
</template>

<script lang="ts">
  import { Component, Vue, Watch } from 'nuxt-property-decorator';
  import { Context } from '@nuxt/types';

  @Component({
    scrollToTop: true,
  })
  export default class PageDashboardManageNews extends Vue {
    private content = '';
    private fields = [
      { key: 'id', label: 'Id', sortable: true, class: 'd-none d-md-table-cell align-middle' },
      { key: 'name', label: 'Name', sortable: true, class: 'd-none' },
      { key: 'title', label: 'Title', sortable: true, class: 'align-middle' },
      { key: 'date', label: 'Date', sortable: true, class: 'text-md-right align-middle' },
      { key: 'intro', label: 'Intro', sortable: true, class: 'd-none align-middle' },
      { key: 'auth', label: 'Auth', sortable: true, class: 'align-middle' },
      { key: 'url', label: 'Url', class: 'align-middle' },
      { key: 'actions', label: 'Actions', class: 'text-center align-middle' },
    ];

    public async asyncData(context: Context) {
      if (context.$auth.hasScope('manager')) {
        context.store.commit('dashboard/navbar/setBreadcrumb', [
          { text: 'Dashboard', to: '/dashboard' },
          { text: 'Manage', active: true },
          { text: 'News', active: true },
        ]);
        try {
          context.store.commit('dashboard/table/setItems', (await context.$axios.get('/api/manage/news')).data);
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
