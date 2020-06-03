<template>
  <div>
    <b-card
      v-for="post in $store.state.news.posts"
      :key="post.id"
      :title="post.title"
      :img-src="`/assets/news/images/${post.name}.jpg`"
      title-tag="h5"
      :sub-title="new Date(post.date).toDateString()"
      sub-title-tag="small"
      class="my-3 border shadow-sm"
    >
      <b-card-text>
        <small>Posted by {{ post.auth }}</small>
      </b-card-text>
      <b-card-text>
        <hr />
        {{ post.intro }}
      </b-card-text>
      <b-card-text class="text-center">
        <b-button variant="primary" size="sm" :to="`/news/${post.name}`" @click="select(post)">Details</b-button>
      </b-card-text>
    </b-card>

    <infinite-loading spinner="spiral" @infinite="loadNews">
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
    public loadNews(state: StateChanger) {
      (async () => {
        try {
          const news = (await this.$axios.get('/api/news', { params: { status: 1, page: this.$store.state.news.page } })).data;
          if (news.length > 1) {
            this.$store.commit('news/push', news);
            state.loaded();
          } else {
            state.complete();
          }
        } catch {
          state.error();
        }
      })();
    }

    public select(post: any) {
      this.$store.commit('news/select', post);
    }
  }
</script>
