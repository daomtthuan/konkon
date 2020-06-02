<template>
  <b-sidebar id="sidebar" title="Categories List" text-variant="primary" bg-variant="light" backdrop shadow>
    <aside class="px-2 py-2">
      <b-dropdown
        v-for="categoryGroup in $store.state.app.categoryGroups"
        :key="categoryGroup.id"
        :text="categoryGroup.name"
        class="m-md-2"
        menu-class="mt-2 shadow w-min-100 border border-primary"
        block
      >
        <b-dropdown-item v-for="category in $store.state.app.categories[categoryGroup.id]" :key="category.id">
          {{ category.name }}
        </b-dropdown-item>
      </b-dropdown>
    </aside>
  </b-sidebar>
</template>

<script lang="ts">
  import { Component, Vue } from 'nuxt-property-decorator';

  @Component
  export default class Sidebar extends Vue {}
</script>
