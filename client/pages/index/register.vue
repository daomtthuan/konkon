<template>
  <b-row no-gutters>
    <b-col md="6">
      <b-card-body class="d-flex align-items-center h-100">
        <logo size="128" tag="h1" subtag="h3" />
      </b-card-body>
    </b-col>
    <b-col md="6">
      <b-card-body title="Register">
        <form-register />
      </b-card-body>
    </b-col>
  </b-row>
</template>

<script lang="ts">
  import { Component, Vue } from 'nuxt-property-decorator';
  import { Context } from '@nuxt/types';

  @Component({
    scrollToTop: true,
  })
  export default class PageRegister extends Vue {
    public asyncData(context: Context) {
      if (context.$auth.loggedIn) {
        context.redirect('/account');
      }
    }
  }
</script>
