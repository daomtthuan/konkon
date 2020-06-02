<template>
  <loading variant="secondary" class="my-3" v-if="$fetchState.pending" />
  <div v-else-if="$fetchState.error" class="text-danger">Loading failed</div>
  <article v-else>
    <h4>{{ $store.state.news.selected.title }}</h4>
    <b-img :src="`/assets/news/images/${$store.state.news.selected.name}.jpg`" fluid thumbnail rounded center class="shadow-sm my-4" />
    <div v-html="content"></div>
    <hr />
    <small class="text-muted">
      Posted on {{ new Date($store.state.news.selected.date).toDateString() }}<br />
      By {{ $store.state.news.selected.auth }}
    </small>
  </article>
</template>

<script lang="ts">
  import { Component, Vue } from 'nuxt-property-decorator';

  @Component({
    scrollToTop: true,
  })
  export default class PageNews_Name extends Vue {
    private content!: string;

    public async fetch() {
      try {
        if (!this.$store.state.news.selected) {
          this.$store.commit('news/select', (await this.$axios.get('/api/news', { params: { name: this.$route.params.name, status: 1 } })).data);
        }
        this.content = (await this.$axios.get(`/assets/news/contents/${this.$store.state.news.selected.name}.html`)).data;
      } catch (error) {
        this.$nuxt.error({ statusCode: 404, message: 'This page could not be found' });
        return;
      }
    }
  }
</script>
