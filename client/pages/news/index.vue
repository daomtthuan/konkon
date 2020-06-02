<template>
  <loading variant="secondary" class="my-3" v-if="$fetchState.pending" />
  <div v-else-if="$fetchState.error" class="text-danger">Loading failed</div>
  <div class="p-5" v-else>
    <h2>News and Sale</h2>
    <hr />

    <b-card
      v-for="(element, index) in news"
      :key="index"
      :title="element.title"
      :img-src="element.image"
      title-tag="h5"
      :sub-title="new Date(element.date).toDateString()"
      sub-title-tag="small"
      class="my-3 border shadow-sm"
    >
      <b-card-text>
        <small>Posted by {{ element.auth }}</small>
      </b-card-text>
      <b-card-text>
        <hr />
        {{ element.intro }}
      </b-card-text>
      <b-card-text class="text-center">
        <b-button variant="primary" size="sm" :to="element.url">Details</b-button>
      </b-card-text>
    </b-card>

    <infinite-loading v-if="news.length" spinner="spiral" @infinite="loadNews">
      <template slot="spinner">
        <loading variant="secondary" class="mt-3" />
      </template>
      <template slot="no-more">
        <div class="small text-muted mt-5">No more news</div>
      </template>
      <template slot="no-results">
        <div class="small text-muted mt-5">No results news</div>
      </template>
    </infinite-loading>
  </div>
</template>

<script lang="ts">
  import { Component, Vue } from 'nuxt-property-decorator';
  import InfiniteLoading, { StateChanger } from 'vue-infinite-loading';

  @Component({
    components: { InfiniteLoading },
  })
  export default class PageNews extends Vue {
    // private news = [];
    // private page = 1;

    // private async getNews(page: number) {
    //   try {
    //     return (await this.$axios.get('/api/news', { params: { status: 1, page } })).data;
    //   } catch (error) {
    //     this.$bvToast.toast('Load news failed', { title: 'Error', variant: 'danger' });
    //     throw error;
    //   }
    // }

    // public loadNews(state: StateChanger) {
    //   (async () => {
    //     try {
    //       const news = await this.getNews(++this.page);
    //       if (news.length > 1) {
    //         for (const item of news) {
    //           this.news.push(item);
    //         }
    //         state.loaded();
    //       } else {
    //         state.complete();
    //       }
    //     } catch {
    //       state.error();
    //     }
    //   })();
    // }

    // public async fetch() {
    //   this.news = await this.getNews(1);
    // }

    // public getEven(index: number) {
    //   return 2 * index - 2;
    // }
  }
</script>
