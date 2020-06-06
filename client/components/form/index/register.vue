<template>
  <b-form @submit="submit">
    <b-form-group label="Account:" label-for="form-register-input-account">
      <b-form-input id="form-register-input-account" v-model="user.account" :state="valid.account.state" autocomplete="username" />
      <b-form-invalid-feedback :state="valid.account.state">{{ valid.account.feedback }}</b-form-invalid-feedback>
    </b-form-group>
    <b-form-group label="Password:" label-for="form-register-input-password">
      <b-form-input id="form-register-input-password" v-model="user.password" type="password" :state="valid.password.state" autocomplete="new-password" />
      <b-form-invalid-feedback :state="valid.password.state">{{ valid.password.feedback }}</b-form-invalid-feedback>
    </b-form-group>
    <b-form-group label="Re-password:" label-for="form-register-input-repassword">
      <b-form-input
        id="form-register-input-repassword"
        v-model="repassword"
        type="password"
        :state="valid.repassword.state"
        :disabled="!valid.password.state"
      />
      <b-form-invalid-feedback :state="valid.repassword.state">{{ valid.repassword.feedback }}</b-form-invalid-feedback>
    </b-form-group>
    <b-form-group label="Email:" label-for="form-register-input-email">
      <b-form-input id="form-register-input-email" v-model="user.email" autocomplete="email" :state="valid.email.state" />
      <b-form-invalid-feedback :state="valid.email.state">{{ valid.email.feedback }}</b-form-invalid-feedback>
    </b-form-group>
    <b-form-group label="Fullname:" label-for="form-register-input-name">
      <b-form-input id="form-register-input-name" v-model="user.name" autocomplete="name" :state="valid.name.state" />
      <b-form-invalid-feedback :state="valid.name.state">{{ valid.name.feedback }}</b-form-invalid-feedback>
    </b-form-group>
    <b-form-group label="Gender:">
      <b-form-radio-group v-model="user.gender" :options="genders" name="form-register-input-gender" :state="valid.gender.state" />
      <b-form-invalid-feedback :state="valid.gender.state">{{ valid.gender.feedback }}</b-form-invalid-feedback>
    </b-form-group>
    <b-form-group label="Birthday:">
      <b-form-input type="date" id="form-register-input-birthday" v-model="user.birthday" autocomplete="bday" :state="valid.birthday.state" />
      <b-form-invalid-feedback :state="valid.birthday.state">{{ valid.birthday.feedback }}</b-form-invalid-feedback>
    </b-form-group>
    <b-form-group label="Phone number:" label-for="form-register-input-phone">
      <b-form-input type="tel" id="form-register-input-phone" v-model="user.phone" autocomplete="tel" :state="valid.phone.state" />
      <b-form-invalid-feedback :state="valid.phone.state">{{ valid.phone.feedback }}</b-form-invalid-feedback>
    </b-form-group>
    <b-form-group label="Address:" label-for="form-register-input-address">
      <b-form-input id="form-register-input-address" v-model="user.address" :state="valid.address.state" />
      <b-form-invalid-feedback :state="valid.address.state">{{ valid.address.feedback }}</b-form-invalid-feedback>
    </b-form-group>
    <div class="text-center">
      <b-overlay :show="busy" rounded opacity="0.7" spinner-small spinner-variant="primary" class="d-inline-block">
        <b-button type="submit" variant="primary" :disabled="!isValid || busy">Register</b-button>
      </b-overlay>
    </div>
  </b-form>
</template>

<script lang="ts">
  import { Component, Vue, Watch } from 'nuxt-property-decorator';
  import Plugins from '~/plugins';

  @Component
  export default class FormRegister extends Vue {
    private user = {
      account: '',
      password: '',
      email: '',
      name: '',
      gender: -1,
      birthday: '',
      phone: '',
      address: '',
    };
    private existedAccounts: string[] = [];
    private repassword = '';
    private genders = [
      { text: 'Male', value: 1 },
      { text: 'Female', value: 0 },
    ];
    private valid = {
      account: { state: false, feedback: 'Enter account' },
      password: { state: false, feedback: 'Enter password' },
      repassword: { state: false, feedback: 'Enter password first' },
      email: { state: false, feedback: 'Enter email' },
      name: { state: false, feedback: 'Enter fullname' },
      gender: { state: false, feedback: 'Select gender' },
      birthday: { state: false, feedback: 'Select birthday' },
      phone: { state: false, feedback: 'Enter phone number' },
      address: { state: false, feedback: 'Enter address' },
    };
    private busy = false;

    @Watch('user.account')
    public watchUserAccount() {
      if (this.user.account.length > 0) {
        if (Plugins.isValid(process.env.regex_account!, process.env.regex_length_account!, this.user.account)) {
          if (this.existedAccounts.includes(this.user.account)) {
            this.valid.account = { state: false, feedback: 'Account already exists' };
          } else {
            this.valid.account.state = true;
          }
        } else {
          this.valid.account = { state: false, feedback: 'Invalid account' };
        }
      } else {
        this.valid.account = { state: false, feedback: 'Enter account' };
      }
    }

    @Watch('user.password')
    public watchUserPassword() {
      this.repassword = '';
      if (this.user.password.length > 0) {
        if (Plugins.isValid(process.env.regex_any!, process.env.regex_length_password!, this.user.password)) {
          this.valid.password.state = true;
        } else {
          this.valid.password = { state: false, feedback: 'Invalid password' };
        }
      } else {
        this.valid.password = { state: false, feedback: 'Enter password' };
      }
      this.watchRepassword();
    }

    @Watch('repassword')
    public watchRepassword() {
      if (this.valid.password.state) {
        if (this.repassword.length > 0) {
          if (this.user.password == this.repassword) {
            this.valid.repassword.state = true;
          } else {
            this.valid.repassword = { state: false, feedback: 'Re-password not match' };
          }
        } else {
          this.valid.repassword = { state: false, feedback: 'Enter password again' };
        }
      } else {
        this.valid.repassword = { state: false, feedback: 'Enter password first' };
      }
    }

    @Watch('user.email')
    public watchUserEmail() {
      if (this.user.email.length > 0) {
        if (Plugins.isValid(process.env.regex_email!, process.env.regex_length_email!, this.user.email)) {
          this.valid.email.state = true;
        } else {
          this.valid.email = { state: false, feedback: 'Invalid email' };
        }
      } else {
        this.valid.email = { state: false, feedback: 'Enter email' };
      }
    }

    @Watch('user.name')
    public watchUserName() {
      if (this.user.name.length > 0) {
        if (Plugins.isValid(process.env.regex_name!, process.env.regex_length_name!, this.user.name)) {
          this.valid.name.state = true;
        } else {
          this.valid.name = { state: false, feedback: 'Invalid fullname' };
        }
      } else {
        this.valid.name = { state: false, feedback: 'Enter fullname' };
      }
    }

    @Watch('user.gender')
    public watchUserGender() {
      if (this.user.gender >= 0) {
        if (Plugins.isValid(process.env.regex_number!, process.env.regex_length_gender!, this.user.gender.toString())) {
          this.valid.gender.state = true;
        } else {
          this.valid.gender = { state: false, feedback: 'Invalid gender' };
        }
      } else {
        this.valid.gender = { state: false, feedback: 'Select gender' };
      }
    }

    @Watch('user.birthday')
    public watchUserBirthday() {
      if (this.user.birthday.length > 0) {
        if (Plugins.isValid(process.env.regex_date!, process.env.regex_length_date!, this.user.birthday)) {
          this.valid.birthday.state = true;
        } else {
          this.valid.birthday = { state: false, feedback: 'Invalid birthday' };
        }
      } else {
        this.valid.birthday = { state: false, feedback: 'Enter birthday' };
      }
    }

    @Watch('user.phone')
    public watchUserPhone() {
      if (this.user.phone.length > 0) {
        if (Plugins.isValid(process.env.regex_phone!, process.env.regex_length_phone!, this.user.phone)) {
          this.valid.phone.state = true;
        } else {
          this.valid.phone = { state: false, feedback: 'Invalid phone number' };
        }
      } else {
        this.valid.phone = { state: false, feedback: 'Enter phone number' };
      }
    }

    @Watch('user.address')
    public watchUserAddress() {
      if (this.user.address.length > 0) {
        if (Plugins.isValid(process.env.regex_any!, process.env.regex_length_address!, this.user.address)) {
          this.valid.address.state = true;
        } else {
          this.valid.address = { state: false, feedback: 'Invalid address' };
        }
      } else {
        this.valid.address = { state: false, feedback: 'Enter address' };
      }
    }

    public async submit(event: Event) {
      event.preventDefault();
      if (this.isValid) {
        this.busy = true;
        try {
          await this.$axios.post(`/api/user`, this.user);
          await this.$auth.loginWith('local', { data: this.user });
        } catch (error) {
          if (error.response.status == 406) {
            this.$bvToast.toast('Account already exists', { title: 'Register failed', variant: 'warning' });
            this.existedAccounts.push(this.user.account);
            this.valid.account = { state: false, feedback: 'Account already exists' };
          } else {
            this.$bvToast.toast('Register failed', { title: 'Error', variant: 'danger' });
          }
        }
        this.busy = false;
      } else {
        this.$bvToast.toast('Invalid information', { title: 'Register failed', variant: 'warning' });
      }
    }

    public get isValid() {
      for (const valid of Object.values(this.valid)) {
        if (!valid.state) {
          return false;
        }
      }
      return true;
    }
  }
</script>
