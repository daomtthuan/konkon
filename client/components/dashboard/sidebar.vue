<template>
  <b-sidebar
    id="sidebar"
    body-class="border-right border-primary"
    shadow="lg"
    no-close-on-esc
    no-close-on-backdrop
    no-close-on-route-change
    no-header
    :visible="$store.state.dashboard.sidebar.isVisible"
    @change="toggleSidebar"
  >
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
  export default class DashboardSidebar extends Vue {
    public toggleSidebar(visible: boolean) {
      this.$store.commit('dashboard/setVisibleSidebar', visible);
    }
  }
</script>
