import Dotenv from 'dotenv';
import Path from 'path';

Dotenv.config({ path: Path.resolve(process.cwd(), '../.env') });

export default {
  mode: 'universal',
  server: {
    host: process.env.client_host,
    port: process.env.client_port,
  },
  head: {
    title: 'KonKon - Computer Store',
    meta: [
      { charset: 'utf-8' },
      { name: 'viewport', content: 'width=device-width, initial-scale=1' },
      {
        hid: 'description',
        name: 'description',
        content: 'KonKon - Computer Store',
      },
    ],
    link: [{ rel: 'icon', type: 'image/x-icon', href: '/favicon.ico' }],
  },
  loading: {
    color: '#2980b9',
    failedColor: '#e74c3c',
    throttle: 0,
    continuous: true,
    height: '0.25rem',
  },
  css: ['~/assets/fonts', '~/assets/theme'],
  plugins: ['~plugins/vue-tables-2'],
  modules: ['@nuxt/components', '@nuxtjs/proxy', 'bootstrap-vue/nuxt', '@nuxtjs/axios', '@nuxtjs/dotenv', '@nuxtjs/auth', 'nuxt-fontawesome'],
  components: {
    dirs: [
      '~/components',
      { path: '~/components/form', prefix: 'form' },
      { path: '~/components/form/account', prefix: 'form-account' },
      { path: '~/components/dashboard', prefix: 'dashboard' },
    ],
  },
  proxy: {
    '/api': {
      target: `http://${process.env.server_host}:${process.env.server_port}/api`,
      pathRewrite: {
        '^/api': '/',
      },
    },
    '/assets': {
      target: `http://${process.env.server_host}:${process.env.server_port}/assets`,
      pathRewrite: {
        '^/assets': '/',
      },
    },
  },
  bootstrapVue: { bootstrapCSS: false, bootstrapVueCSS: false },
  dotenv: { path: Path.resolve(process.cwd(), '../') },
  auth: {
    redirect: {
      login: '/login',
      logout: '/login',
      callback: '/login',
      home: '/',
    },
    localStorage: false,
    strategies: {
      local: {
        endpoints: {
          login: { url: `/api/auth`, method: 'post' },
          logout: { url: `/api/auth`, method: 'delete' },
          user: { url: `/api/auth`, method: 'get' },
        },
        tokenRequired: true,
        tokenType: false,
        autoFetchUser: true,
      },
    },
    cookie: { prefix: 'auth_' },
    token: { prefix: 'token_' },
  },
  fontawesome: {
    imports: [
      { icons: ['fas'], set: '@fortawesome/free-solid-svg-icons' },
      { icons: ['fab'], set: '@fortawesome/free-brands-svg-icons' },
    ],
  },
  buildModules: ['@nuxt/typescript-build'],
  build: {
    extend(config: any) {
      config.node = {
        fs: 'empty',
      };
    },
    babel: {
      presets() {
        return [['@nuxt/babel-preset-app', { loose: true }]];
      },
    },
  },
  watch: ['~/../.env'],
};
