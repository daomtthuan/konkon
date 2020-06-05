<template>
  <b-sidebar id="dashboard-sidebar" class="border-right border-primary" shadow="lg" backdrop>
    <div class="p-4">
      <logo size="64" tag="h3" subtag="h5" />
      <hr class="bg-primary" />
      <div>
        <b-button block to="/dashboard">Home</b-button>
        <b-button block v-b-toggle.collapse-manage>Manage</b-button>
        <b-collapse id="collapse-manage" class="bg-white border mt-2">
          <b-link class="dropdown-item py-2" to="/dashboard/manage/user">User</b-link>
        </b-collapse>
      </div>
    </div>
  </b-sidebar>
</template>

<script lang="ts">
  import { Component, Vue } from 'nuxt-property-decorator';

  @Component
  export default class DashboardSidebar extends Vue {}
</script>
