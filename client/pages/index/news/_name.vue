<template>
  <article>
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
  import { Context } from '@nuxt/types';

  @Component({
    scrollToTop: true,
  })
  export default class PageNews_Name extends Vue {
    private content!: string;

    public async asyncData(context: Context) {
      try {
        if (!context.store.state.news.selected) {
          context.store.commit('news/select', (await context.$axios.get('/api/news', { params: { name: context.route.params.name, status: 1 } })).data);
        }
        return {
          content: (await context.$axios.get(`/assets/news/contents/${context.store.state.news.selected.name}.html`)).data,
        };
      } catch {
        context.error({
          statusCode: 404,
          message: 'This page could not be found',
        });
      }
    }
  }
</script>
