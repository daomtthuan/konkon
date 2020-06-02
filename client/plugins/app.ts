import Plugins from './index';

export default {
  async fetchCategory(vue: Vue) {
    vue.$store.commit('sidebar/setCategoryGroups', (await vue.$axios.get(`/api/category-group`, { params: { status: 1 } })).data);
    for (const categoryGroup of vue.$store.state.sidebar.categoryGroups) {
      vue.$store.commit('sidebar/setCategory', {
        categoryGroup,
        category: (await vue.$axios.get(`/api/category`, { params: { categoryGroupId: categoryGroup.id, status: 1 } })).data,
      });
    }
  },

  async fetchNews(vue: Vue) {
    vue.$store.commit('news/push', (await vue.$axios.get('/api/news', { params: { status: 1, page: vue.$store.state.news.page } })).data);
  },

  async fetchUser(vue: Vue) {
    if (localStorage.session && localStorage.token) {
      Plugins.setCookie('session', localStorage.session);
      vue.$auth.setToken('local', localStorage.token);
      await vue.$auth.fetchUser();
    }
  },
};
