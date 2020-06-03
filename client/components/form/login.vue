<template>
  <b-form @submit="submit">
    <b-form-group label="Account:" label-for="form-login-input-account" :state="valid.account.state">
      <b-form-input id="form-login-input-account" v-model="user.account" autocomplete="username" :state="valid.account.state" />
      <b-form-invalid-feedback :state="valid.account.state">{{ valid.account.feedback }}</b-form-invalid-feedback>
    </b-form-group>
    <b-form-group label="Password:" label-for="form-login-input-password" :state="valid.password.state">
      <b-form-input id="form-login-input-password" v-model="user.password" type="password" autocomplete="current-password" :state="valid.password.state" />
      <b-form-invalid-feedback :state="valid.password.state">{{ valid.password.feedback }}</b-form-invalid-feedback>
    </b-form-group>
    <b-form-group>
      <b-form-checkbox id="form-login-input-remember" v-model="remember" :value="true" :unchecked-value="false">Remember account</b-form-checkbox>
    </b-form-group>
    <div class="text-center">
      <b-overlay :show="busy" rounded opacity="0.7" spinner-small spinner-variant="primary" class="d-inline-block">
        <b-button type="submit" variant="primary" :disabled="!isValid || busy">Login</b-button>
      </b-overlay>
    </div>
  </b-form>
</template>

<script lang="ts">
  import { Component, Vue, Watch } from 'nuxt-property-decorator';
  import Plugins from '~/plugins';

  @Component
  export default class FormLogin extends Vue {
    private user = {
      account: '',
      password: '',
    };
    private remember = false;
    private valid = {
      account: { state: false, feedback: 'Enter account' },
      password: { state: false, feedback: 'Enter password' },
    };
    private busy = false;

    public async submit(event: Event) {
      event.preventDefault();
      if (this.isValid) {
        this.busy = true;
        try {
          const response: any = await this.$auth.loginWith('local', { data: this.user });
          if (this.remember) {
            localStorage.session = Plugins.getCookie('session');
            localStorage.token = response.data.token;
          }
        } catch {
          this.$bvToast.toast('Wrong account or password', { title: 'Login failed', variant: 'warning' });
          this.busy = false;
        }
      } else {
        this.$bvToast.toast('Invalid account', { title: 'Login failed', variant: 'warning' });
      }
    }

    @Watch('user.account')
    public watchUserAccount() {
      if (this.user.account.length > 0) {
        if (Plugins.isValid(process.env.regex_account!, process.env.regex_length_account!, this.user.account)) {
          this.valid.account.state = true;
        } else {
          this.valid.account = { state: false, feedback: 'Invalid account' };
        }
      } else {
        this.valid.account = { state: false, feedback: 'Enter account' };
      }
    }

    @Watch('user.password')
    public watchUserPassword() {
      if (this.user.password.length > 0) {
        if (Plugins.isValid(process.env.regex_any!, process.env.regex_length_password!, this.user.password)) {
          this.valid.password.state = true;
        } else {
          this.valid.password = { state: false, feedback: 'Invalid password' };
        }
      } else {
        this.valid.password = { state: false, feedback: 'Enter password' };
      }
    }

    @Watch('remember')
    public watchRemember(remember: boolean) {
      if (remember) {
        this.$bvToast.toast('Only remember account on the device that you trust', { title: 'Notification', variant: 'warning' });
      }
    }

    private get isValid() {
      return this.valid.account.state && this.valid.password.state;
    }
  }
</script>
