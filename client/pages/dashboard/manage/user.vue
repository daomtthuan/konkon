<template>
  <vuetable ref="vuetable" api-url="https://vuetable.ratiw.net/api/users" :fields="['name', 'email', 'birthdate']" />
</template>

<script lang="ts">
  import { Component, Vue } from 'nuxt-property-decorator';
  import { Context } from '@nuxt/types';

  @Component({
    scrollToTop: true,
  })
  export default class PageDashboardManageUser extends Vue {
    public async asyncData(context: Context) {
      context.store.commit('dashboard/setBreadcrumb', [
        { text: 'Dashboard', to: '/dashboard' },
        { text: 'Manage', active: true },
        { text: 'User', active: true },
      ]);

      const data = (await context.$axios.get('/api/user')).data;

      return {
        dataTable: data.concat(
          data.concat(
            data.concat(
              data.concat(
                data.concat(
                  data.concat(
                    data.concat(
                      data.concat(
                        data.concat(
                          data.concat(
                            data.concat(
                              data.concat(data.concat(data.concat(data.concat(data.concat(data.concat(data.concat(data.concat(data.concat(data)))))))))
                            )
                          )
                        )
                      )
                    )
                  )
                )
              )
            )
          )
        ),
        columns: Object.keys(data[0]),
        options: {
          selectable: {
            mode: 'single', // or 'multiple'
            only: function(row: any) {
              return true; // any condition
            },
          },
        },
      };
    }
  }
</script>

<style lang="scss">
  .VueTables__wrapper {
    max-height: 500px; // or whatever suits your needs
  }
</style>
