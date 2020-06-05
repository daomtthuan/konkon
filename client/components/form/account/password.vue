<template>
  <b-form @submit="submit">
    <b-form-group label="Current password:" label-for="form-account-password-input-oldpassword">
      <b-form-input id="form-account-password-input-oldpassword" type="password" autocomplete="current-password" v-model="user.old" :state="valid.old.state" />
      <b-form-invalid-feedback :state="valid.old.state">{{ valid.old.feedback }}</b-form-invalid-feedback>
    </b-form-group>
    <b-form-group label="New password:" label-for="form-account-password-input-newpassword">
      <b-form-input id="form-account-password-input-newpassword" type="password" autocomplete="new-password" v-model="user.new" :state="valid.new.state" />
      <b-form-invalid-feedback :state="valid.new.state">{{ valid.new.feedback }}</b-form-invalid-feedback>
    </b-form-group>
    <b-form-group label="Re-enter new password:" label-for="form-account-password-input-repassword">
      <b-form-input id="form-account-password-input-repassword" type="password" v-model="re" :state="valid.re.state" :disabled="!valid.new.state" />
      <b-form-invalid-feedback :state="valid.re.state">{{ valid.re.feedback }}</b-form-invalid-feedback>
    </b-form-group>
    <b-form-group class="text-center">
      <b-overlay :show="busy" rounded opacity="0.7" spinner-small spinner-variant="primary" class="d-inline-block">
        <b-button type="submit" variant="primary" :disabled="!isValid || busy">Change password</b-button>
      </b-overlay>
    </b-form-group>
  </b-form>
</template>

<script lang="ts">
  import { Component, Vue, Prop, Watch } from 'nuxt-property-decorator';
  import Plugins from '~/plugins';

  @Component
  export default class FormAccountInformation extends Vue {
    private user = {
      old: '',
      new: '',
    };
    private re = '';
    private valid = {
      old: { state: false, feedback: 'Enter current password' },
      new: { state: false, feedback: 'Enter new password' },
      re: { state: false, feedback: 'Eneter new password first' },
    };
    private busy = false;

    @Watch('user.old')
    public watchOld() {
      if (this.user.old.length > 0) {
        if (Plugins.isValid(process.env.regex_any!, process.env.regex_length_password!, this.user.old)) {
          this.valid.old.state = true;
        } else {
          this.valid.old = { state: false, feedback: 'Invalid current password' };
        }
      } else {
        this.valid.old = { state: false, feedback: 'Enter current password' };
      }
    }

    @Watch('user.new')
    public watchNew() {
      this.re = '';
      if (this.user.new.length > 0) {
        if (Plugins.isValid(process.env.regex_any!, process.env.regex_length_password!, this.user.new)) {
          this.valid.new.state = true;
        } else {
          this.valid.new = { state: false, feedback: 'Invalid new password' };
        }
      } else {
        this.valid.new = { state: false, feedback: 'Enter new password' };
      }
      this.watchRe();
    }

    @Watch('re')
    public watchRe() {
      if (this.valid.new.state) {
        if (this.re.length > 0) {
          if (this.user.new == this.re) {
            this.valid.re.state = true;
          } else {
            this.valid.re = { state: false, feedback: 'Re-password not match' };
          }
        } else {
          this.valid.re = { state: false, feedback: 'Enter new password again' };
        }
      } else {
        this.valid.re = { state: false, feedback: 'Enter new password first' };
      }
    }

    public async submit(event: Event) {
      event.preventDefault();
      if (this.isValid) {
        this.busy = true;
        try {
          await this.$axios.put('/api/user', this.user, { params: { mode: 'password' } });
          this.$store.commit('account/reverseChangePassword');
        } catch (error) {
          this.$bvToast.toast('Change password failed', { title: 'Error', variant: 'danger' });
        }
        this.busy = false;
      } else {
        this.$bvToast.toast('Invalid information', { title: 'Change password failed', variant: 'warning' });
      }
    }

    public get isValid() {
      const valids = Object.values(this.valid);
      for (const valid of valids) {
        if (valid.state === false) {
          return false;
        }
      }
      return true;
    }
  }
</script>
