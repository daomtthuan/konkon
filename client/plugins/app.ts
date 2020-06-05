import { Context } from '@nuxt/types';
import Plugins from './index';

export default {
  async fetchCategory(context: Context) {
    try {
      context.store.commit('sidebar/setCategoryGroups', (await context.$axios.get(`/api/category-group`, { params: { status: 1 } })).data);
      for (const categoryGroup of context.store.state.sidebar.categoryGroups) {
        context.store.commit(
          'sidebar/setCategory',
          (await context.$axios.get(`/api/category`, { params: { categoryGroupId: categoryGroup.id, status: 1 } })).data
        );
      }
    } catch {
      context.error({
        statusCode: 500,
        message: 'Oops, something went wrong',
      });
    }
  },

  async fetchNews(context: Context) {
    try {
      context.store.commit('news/push', (await context.$axios.get('/api/news', { params: { status: 1, page: context.store.state.news.page } })).data);
    } catch {
      context.error({
        statusCode: 500,
        message: 'Oops, something went wrong',
      });
    }
  },

  async fetchUser(vue: Vue) {
    if (window.localStorage.session && window.localStorage.token) {
      Plugins.setCookie('session', window.localStorage.session);
      vue.$auth.setToken('local', window.localStorage.token);
      await vue.$auth.fetchUser();
    }
  },

  ready(vue: Vue) {
    vue.$store.commit('app/ready');
  },
};
