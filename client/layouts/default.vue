<template>
  <div class="background">
    <div class="d-flex align-items-center vh-100" v-if="$fetchState.pending">
      <b-container class="text-center">
        <logo size="128" tag="h1" subtag="h3" class="mx-auto" />
        <loading class="mt-3" variant="secondary" />
      </b-container>
    </div>
    <nuxt id="page" v-else />
  </div>
</template>

<script lang="ts">
  import { Component, Vue } from 'nuxt-property-decorator';
  import App from '~/plugins/app';
  import Plugins from '~/plugins';

  @Component({
    fetchOnServer: false,
    scrollToTop: true,
  })
  export default class LayoutDefault extends Vue {
    public async fetch() {
      try {
        await App.fetchUser(this);
        await Plugins.delay(100);
      } catch {
        this.$nuxt.error({
          statusCode: 500,
          message: 'Oops, something went wrong',
        });
      }
    }
  }
</script>
