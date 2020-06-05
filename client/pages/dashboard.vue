<template>
  <main>
    <dashboard-sidebar />
    <div class="p-4">
      <dashboard-navbar />
      <b-card no-body class="overflow-hidden shadow border border-primary mt-4">
        <nuxt-child />
      </b-card>
    </div>
  </main>
</template>

<script lang="ts">
  import { Component, Vue } from 'nuxt-property-decorator';
  import { Context } from '@nuxt/types';
  import App from '~/plugins/app';

  @Component({
    scrollToTop: true,
  })
  export default class PageDashboard extends Vue {
    public asyncData(context: Context) {
      if (!(context.$auth.loggedIn && (context.$auth.hasScope('manager') || context.$auth.hasScope('employee')))) {
        context.redirect('/login');
      }
    }
  }
</script>
