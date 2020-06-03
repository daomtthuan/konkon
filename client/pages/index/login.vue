<template>
  <b-row no-gutters>
    <b-col md="6">
      <b-card-body class="d-flex align-items-center h-100">
        <logo size="128" tag="h1" subtag="h3" />
      </b-card-body>
    </b-col>
    <b-col md="6">
      <b-card-body title="Login">
        <form-login />
      </b-card-body>
    </b-col>
  </b-row>
</template>

<script lang="ts">
  import { Component, Vue } from 'nuxt-property-decorator';

  @Component({
    scrollToTop: true,
  })
  export default class PageLogin extends Vue {}
</script>
