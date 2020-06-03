<template>
  <nuxt-child />
</template>

<script lang="ts">
  import { Component, Vue } from 'nuxt-property-decorator';
  import { Context } from '@nuxt/types';

  @Component({
    scrollToTop: true,
  })
  export default class PageDashboardManage extends Vue {
    public asyncData(context: Context) {
      if (!context.$auth.hasScope('manager')) {
        context.redirect('/dashboard');
      }
    }
  }
</script>
