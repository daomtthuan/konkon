<template>
  <main>
    <navbar class="sticky-top" />
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
  import App from '~/plugins/app';

  @Component({
    fetchOnServer: false,
    scrollToTop: true,
  })
  export default class PageIndex extends Vue {
    public async fetch() {
      try {
        await App.fetchCategory(this);
        await App.fetchUser(this);
        await App.fetchNews(this);
      } catch {
        this.$nuxt.error({
          statusCode: 500,
          message: 'Oops, something went wrong',
        });
      }
    }
  }
</script>
