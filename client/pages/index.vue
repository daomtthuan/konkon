<template>
  <main>
    <navbar class="sticky-top" />
    <sidebar />
    <b-container class="py-5 vh-min-100">
      <b-card no-body class="overflow-hidden shadow border border-primary">
        <nuxt-child />
      </b-card>
    </b-container>
    <footbar />
  </main>
</template>

<script lang="ts">
  import { Component, Vue } from 'nuxt-property-decorator';
  import { Context } from '@nuxt/types';
  import App from '~/plugins/app';

  @Component({
    scrollToTop: true,
  })
  export default class PageIndex extends Vue {
    public async asyncData(context: Context) {
      try {
        await App.fetchCategory(context);
        await App.fetchNews(context);
      } catch {
        context.error({
          statusCode: 500,
          message: 'Oops, something went wrong',
        });
      }
    }
  }
</script>
