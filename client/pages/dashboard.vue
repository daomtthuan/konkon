<template>
  <div class="d-flex align-items-center vh-100" v-if="$fetchState.pending">
    <b-container class="text-center">
      <logo size="128" tag="h1" subtag="h3" class="mx-auto" />
      <loading class="mt-3" variant="secondary" />
    </b-container>
  </div>
  <main v-else>
    <navbar class="sticky-top" />
    <div class="background">
      <b-container class="py-5" :fluid="$route.path == '/'">
        <b-card no-body class="overflow-hidden shadow border border-primary">
          <nuxt-child id="page" />
        </b-card>
      </b-container>
    </div>
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
  export default class PageDashboard extends Vue {
    public async fetch() {
      try {
        await App.fetchCategory(this);
        await App.fetchUser(this);
      } catch {
        this.$nuxt.error({
          statusCode: 500,
          message: 'Oops, something went wrong',
        });
      }
    }
  }
</script>
