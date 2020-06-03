<template>
  <nuxt-child />
</template>

<script lang="ts">
  import { Component, Vue } from 'nuxt-property-decorator';

  @Component({
    scrollToTop: true,
  })
  export default class PageDashboardManage extends Vue {
    public fetch() {
      if (!this.$auth.hasScope('manager')) {
        this.$router.replace('/dashboard');
      }
    }
  }
</script>
