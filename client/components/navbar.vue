<template>
  <div class="shadow-lg border-bottom border-primary">
    <b-navbar toggleable="lg" variant="light">
      <b-navbar-brand to="/" class="font-logo">
        <div class="logo-32 d-inline-block align-top mr-1"></div>
        <span class="text-primary">KonKon</span>
      </b-navbar-brand>

      <b-dropdown menu-class="mt-2 shadow w-min-100 border border-primary menu" class="d-lg-none" no-caret variant="primary" right>
        <template v-slot:button-content>
          <font-awesome-icon :icon="['fas', 'bars']" />
        </template>
        <b-dropdown-item to="/" :active="$route.path == '/'"><font-awesome-icon class="mr-2" :icon="['fas', 'home']" />Home</b-dropdown-item>
        <b-dropdown-item to="/news" :active="$route.path == '/news'"><font-awesome-icon class="mr-2" :icon="['fas', 'newspaper']" />News</b-dropdown-item>
        <b-dropdown-divider />
        <b-dropdown-group header="Policy - Guide">
          <b-dropdown-item to="/policy-guide/payment" :active="$route.path == '/policy-guide/payment'">
            <font-awesome-icon class="mr-2" :icon="['fas', 'file-invoice-dollar']" />Pay Guide
          </b-dropdown-item>
          <b-dropdown-item to="/policy-guide/installment" :active="$route.path == '/policy-guide/installment'">
            <font-awesome-icon class="mr-2" :icon="['fas', 'money-check-alt']" />Installment Guide
          </b-dropdown-item>
          <b-dropdown-item to="/policy-guide/warranty" :active="$route.path == '/policy-guide/warranty'">
            <font-awesome-icon class="mr-2" :icon="['fas', 'thumbs-up']" />Warranty Policy
          </b-dropdown-item>
          <b-dropdown-item to="/policy-guide/transport" :active="$route.path == '/policy-guide/transport'">
            <font-awesome-icon class="mr-2" :icon="['fas', 'shipping-fast']" />Transport Policy
          </b-dropdown-item>
        </b-dropdown-group>
        <b-dropdown-divider />
        <b-dropdown-group v-if="$auth.loggedIn" header="Account">
          <b-dropdown-item to="/account" :active="$route.path == '/account'">
            <font-awesome-icon class="mr-2" :icon="['fas', 'user-cog']" />Settings
          </b-dropdown-item>
          <b-dropdown-item v-if="$auth.hasScope('manager') || $auth.hasScope('employee')" to="/dashboard" :active="$route.path == '/dashboard'">
            <font-awesome-icon class="mr-2" :icon="['fas', 'tools']" />Dashboard
          </b-dropdown-item>
          <b-dropdown-item @click="logout"><font-awesome-icon class="mr-2" :icon="['fas', 'sign-out-alt']" />Logout</b-dropdown-item>
        </b-dropdown-group>
        <b-dropdown-group v-if="!$auth.loggedIn" header="Account">
          <b-dropdown-item to="/register" :active="$route.path == '/register'">
            <font-awesome-icon class="mr-2" :icon="['fas', 'address-card']" />Register
          </b-dropdown-item>
          <b-dropdown-item to="/login" :active="$route.path == '/login'">
            <font-awesome-icon class="mr-2" :icon="['fas', 'sign-in-alt']" />Login
          </b-dropdown-item>
        </b-dropdown-group>
      </b-dropdown>

      <b-collapse is-nav>
        <b-navbar-nav class="ml-auto">
          <b-nav-item to="/" :active="$route.path == '/'"><font-awesome-icon class="mr-2" :icon="['fas', 'home']" />Home</b-nav-item>
          <b-nav-item to="/news" :active="$route.path == '/news'"><font-awesome-icon class="mr-2" :icon="['fas', 'newspaper']" />News</b-nav-item>
          <b-nav-item-dropdown menu-class="mt-2 shadow w-min-100 border border-primary" :class="{ active: $route.path.search('/policy-guide') == 0 }" no-caret>
            <template v-slot:button-content><font-awesome-icon class="mr-2" :icon="['fas', 'book']" />Policy - Guide</template>
            <b-dropdown-item to="/policy-guide/payment" :active="$route.path == '/policy-guide/payment'">
              <font-awesome-icon class="mr-2" :icon="['fas', 'file-invoice-dollar']" />Pay Guide
            </b-dropdown-item>
            <b-dropdown-item to="/policy-guide/installment" :active="$route.path == '/policy-guide/installment'">
              <font-awesome-icon class="mr-2" :icon="['fas', 'money-check-alt']" />Installment Guide
            </b-dropdown-item>
            <b-dropdown-item to="/policy-guide/warranty" :active="$route.path == '/policy-guide/warranty'">
              <font-awesome-icon class="mr-2" :icon="['fas', 'thumbs-up']" />Warranty Policy
            </b-dropdown-item>
            <b-dropdown-item to="/policy-guide/transport" :active="$route.path == '/policy-guide/transport'">
              <font-awesome-icon class="mr-2" :icon="['fas', 'shipping-fast']" />Transport Policy
            </b-dropdown-item>
          </b-nav-item-dropdown>
        </b-navbar-nav>

        <b-navbar-nav class="ml-auto" v-if="$auth.loggedIn">
          <b-nav-item-dropdown
            menu-class="mt-2 shadow w-min-100 border border-primary menu"
            :class="{ active: $route.path.search('/account') == 0 }"
            no-caret
            right
          >
            <template v-slot:button-content><font-awesome-icon class="mr-2" :icon="['fas', 'user']" />Account</template>
            <b-dropdown-item to="/account" :active="$route.path == '/account'">
              <font-awesome-icon class="mr-2" :icon="['fas', 'user-cog']" />Settings
            </b-dropdown-item>
            <b-dropdown-item v-if="$auth.hasScope('manager') || $auth.hasScope('employee')" to="/dashboard" :active="$route.path == '/dashboard'">
              <font-awesome-icon class="mr-2" :icon="['fas', 'tools']" />Dashboard
            </b-dropdown-item>
            <b-dropdown-item @click="logout"><font-awesome-icon class="mr-2" :icon="['fas', 'sign-out-alt']" />Logout</b-dropdown-item>
          </b-nav-item-dropdown>
        </b-navbar-nav>
        <b-navbar-nav class="ml-auto" v-else>
          <b-nav-item to="/register" :active="$route.path == '/register'">
            <font-awesome-icon class="mr-2" :icon="['fas', 'address-card']" />Register
          </b-nav-item>
          <b-nav-item to="/login" :active="$route.path == '/login'"><font-awesome-icon class="mr-2" :icon="['fas', 'sign-in-alt']" />Login</b-nav-item>
        </b-navbar-nav>
      </b-collapse>
    </b-navbar>

    <b-container class="bg-light" fluid>
      <b-row no-gutters>
        <b-col lg="3" md="4" class="pb-2">
          <b-button variant="primary" size="sm" block v-b-toggle.sidebar>Categories List</b-button>
        </b-col>
        <b-col lg="9" md="8" class="pl-sm-3 pb-2">
          <b-form>
            <b-input-group>
              <b-form-input type="search" size="sm" placeholder="Search for products" autocomplete required></b-form-input>
              <b-input-group-append class="ml-2">
                <b-button variant="primary" type="submit" size="sm" class="px-3">
                  <font-awesome-icon class="mr-2" :icon="['fas', 'search']" />
                </b-button>
              </b-input-group-append>
            </b-input-group>
          </b-form>
        </b-col>
      </b-row>
    </b-container>
  </div>
</template>

<script lang="ts">
  import { Component, Vue } from 'nuxt-property-decorator';

  @Component
  export default class Navbar extends Vue {
    public async logout() {
      await this.$auth.logout();
      window.localStorage.removeItem('session');
      window.localStorage.removeItem('token');
    }
  }
</script>

<style lang="scss" scoped>
  .nav-item.active {
    .nav-link {
      color: var(--primary) !important;
      font-weight: bold !important;
    }
  }

  .nav-link.active {
    color: var(--primary) !important;
    font-weight: bold !important;
  }

  .dropdown-item.active {
    color: var(--primary) !important;
    font-weight: bold !important;
    background-color: transparent !important;
  }

  .menu {
    min-width: 230px;
  }
</style>
