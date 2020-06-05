<template>
  <b-modal id="edit-user" @show="show">
    {{ edit }}
  </b-modal>
</template>

<script lang="ts">
  import { Component, Vue } from 'nuxt-property-decorator';

  @Component
  export default class DashboardEditUser extends Vue {
    private edit = null;

    public show() {
      this.edit = this.$store.state.dashboard.edit;
    }
  }
</script>
