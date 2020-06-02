<template>
  <loading variant="secondary" class="my-3" v-if="$fetchState.pending" />
  <div v-else-if="$fetchState.error" class="text-danger">Loading failed</div>
  <article class="p-5" v-else>
    <h2>News and Sale</h2>
    <hr />
    <h4>{{ news.title }}</h4>
    <b-img :src="news.image" fluid thumbnail rounded center class="shadow-sm my-4" />
    <div v-html="content"></div>
    <hr />
    <small class="text-muted"> Posted on {{ new Date(news.date).toDateString() }} by {{ news.auth }}</small>
  </article>
</template>

<script lang="ts">
  import { Component, Vue } from 'nuxt-property-decorator';

  @Component
  export default class PageNews_Name extends Vue {
    // private news!: any;
    // private content: string = '';

    // public async fetch() {
    //   try {
    //     this.news = (await this.$axios.get('/api/news', { params: { name: this.$route.params.name, status: 1 } })).data[0];
    //     this.content = (await this.$axios.get(this.news.content)).data;
    //   } catch (error) {
    //     this.$nuxt.error({ statusCode: 404, message: 'This page could not be found' });
    //   }
    // }
  }
</script>
