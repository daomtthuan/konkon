<template>
  <b-form @submit="submit">
    <b-form-group label="Account:" label-for="form-account-information-input-account" v-if="!isChange">
      <b-form-input id="form-account-information-input-account" v-model="$auth.user.account" readonly />
    </b-form-group>
    <b-form-group label="Email:" label-for="form-account-information-input-email">
      <b-form-input id="form-account-information-input-email" v-model="user.email" autocomplete="email" :state="valid.email.state" :readonly="!isChange" />
      <b-form-invalid-feedback :state="valid.email.state">{{ valid.email.feedback }}</b-form-invalid-feedback>
    </b-form-group>
    <b-form-group label="Fullname:" label-for="form-account-information-input-name">
      <b-form-input id="form-account-information-input-name" v-model="user.name" autocomplete="name" :state="valid.name.state" :readonly="!isChange" />
      <b-form-invalid-feedback :state="valid.name.state">{{ valid.name.feedback }}</b-form-invalid-feedback>
    </b-form-group>
    <b-form-group label="Gender:" label-for="form-account-information-input-gender">
      <b-form-radio-group class="pt-2 py-1" v-model="user.gender" :options="genders" name="form-account-information-input-gender" :state="valid.gender.state" />
      <b-form-invalid-feedback :state="valid.gender.state">{{ valid.gender.feedback }}</b-form-invalid-feedback>
    </b-form-group>
    <b-form-group label="Birthday:" label-for="form-account-information-input-birthday">
      <b-form-input
        type="date"
        id="form-account-information-input-birthday"
        v-model="user.birthday"
        autocomplete="bday"
        :state="valid.birthday.state"
        :readonly="!isChange"
      />
      <b-form-invalid-feedback :state="valid.birthday.state">{{ valid.birthday.feedback }}</b-form-invalid-feedback>
    </b-form-group>
    <b-form-group label="Phone number:" label-for="form-account-information-input-phone">
      <b-form-input
        type="tel"
        id="form-account-information-input-phone"
        v-model="user.phone"
        autocomplete="tel"
        :state="valid.phone.state"
        :readonly="!isChange"
      />
      <b-form-invalid-feedback :state="valid.phone.state">{{ valid.phone.feedback }}</b-form-invalid-feedback>
    </b-form-group>
    <b-form-group label="Address:" label-for="form-account-information-input-address">
      <b-form-input id="form-account-information-input-address" v-model="user.address" :state="valid.address.state" :readonly="!isChange" />
      <b-form-invalid-feedback :state="valid.address.state">{{ valid.address.feedback }}</b-form-invalid-feedback>
    </b-form-group>
    <b-form-group class="text-center" v-if="isChange">
      <b-overlay :show="busy" rounded opacity="0.7" spinner-small spinner-variant="primary" class="d-inline-block">
        <b-button type="submit" variant="primary" :disabled="!isValid || busy">Change information</b-button>
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
      email: this.$auth.user.email,
      name: this.$auth.user.name,
      gender: this.$auth.user.gender,
      birthday: this.$auth.user.birthday,
      phone: this.$auth.user.phone,
      address: this.$auth.user.address,
    };
    private genders = [
      { text: 'Male', value: 1, disabled: !this.isChange },
      { text: 'Female', value: 0, disabled: !this.isChange },
    ];
    private valid: { [key: string]: { state: boolean | null; feedback: string } } = {
      email: { state: null, feedback: 'Enter email' },
      name: { state: null, feedback: 'Enter fullname' },
      gender: { state: null, feedback: 'Select gender' },
      birthday: { state: null, feedback: 'Select birthday' },
      phone: { state: null, feedback: 'Enter phone number' },
      address: { state: null, feedback: 'Enter address' },
    };
    private busy = false;

    private loadData() {
      this.user = {
        email: this.$auth.user.email,
        name: this.$auth.user.name,
        gender: this.$auth.user.gender,
        birthday: this.$auth.user.birthday,
        phone: this.$auth.user.phone,
        address: this.$auth.user.address,
      };

      this.genders = [
        { text: 'Male', value: 1, disabled: !this.isChange },
        { text: 'Female', value: 0, disabled: !this.isChange },
      ];

      this.valid = {
        email: { state: null, feedback: 'Enter email' },
        name: { state: null, feedback: 'Enter fullname' },
        gender: { state: null, feedback: 'Select gender' },
        birthday: { state: null, feedback: 'Select birthday' },
        phone: { state: null, feedback: 'Enter phone number' },
        address: { state: null, feedback: 'Enter address' },
      };
    }

    @Watch('user.email')
    public watchUserEmail(value: string) {
      if (value != this.$auth.user.email) {
        if (this.user.email.length > 0) {
          if (Plugins.isValid(process.env.regex_email!, process.env.regex_length_email!, this.user.email)) {
            this.valid.email.state = true;
          } else {
            this.valid.email = { state: false, feedback: 'Invalid email' };
          }
        } else {
          this.valid.email = { state: false, feedback: 'Enter email' };
        }
      } else {
        this.valid.email.state = null;
      }
    }

    @Watch('user.name')
    public watchUserName(value: string) {
      if (value != this.$auth.user.name) {
        if (this.user.name.length > 0) {
          if (Plugins.isValid(process.env.regex_name!, process.env.regex_length_name!, this.user.name)) {
            this.valid.name.state = true;
          } else {
            this.valid.name = { state: false, feedback: 'Invalid fullname' };
          }
        } else {
          this.valid.name = { state: false, feedback: 'Enter fullname' };
        }
      } else {
        this.valid.name.state = null;
      }
    }

    @Watch('user.gender')
    public watchUserGender(value: number) {
      if (value != this.$auth.user.gender) {
        if (this.user.gender >= 0) {
          if (Plugins.isValid(process.env.regex_number!, process.env.regex_length_gender!, this.user.gender.toString())) {
            this.valid.gender.state = true;
          } else {
            this.valid.gender = { state: false, feedback: 'Invalid gender' };
          }
        } else {
          this.valid.gender = { state: false, feedback: 'Select gender' };
        }
      } else {
        this.valid.gender.state = null;
      }
    }

    @Watch('user.birthday')
    public watchUserBirthday(value: string) {
      if (value != this.$auth.user.birthday) {
        if (this.user.birthday.length > 0) {
          if (Plugins.isValid(process.env.regex_date!, process.env.regex_length_date!, this.user.birthday)) {
            this.valid.birthday.state = true;
          } else {
            this.valid.birthday = { state: false, feedback: 'Invalid birthday' };
          }
        } else {
          this.valid.birthday = { state: false, feedback: 'Enter birthday' };
        }
      } else {
        this.valid.birthday.state = null;
      }
    }

    @Watch('user.phone')
    public watchUserPhone(value: string) {
      if (value != this.$auth.user.phone) {
        if (this.user.phone.length > 0) {
          if (Plugins.isValid(process.env.regex_phone!, process.env.regex_length_phone!, this.user.phone)) {
            this.valid.phone.state = true;
          } else {
            this.valid.phone = { state: false, feedback: 'Invalid phone number' };
          }
        } else {
          this.valid.phone = { state: false, feedback: 'Enter phone number' };
        }
      } else {
        this.valid.phone.state = null;
      }
    }

    @Watch('user.address')
    public watchUserAddress(value: string) {
      if (value != this.$auth.user.address) {
        if (this.user.address.length > 0) {
          if (Plugins.isValid(process.env.regex_any!, process.env.regex_length_address!, this.user.address)) {
            this.valid.address.state = true;
          } else {
            this.valid.address = { state: false, feedback: 'Invalid address' };
          }
        } else {
          this.valid.address = { state: false, feedback: 'Enter address' };
        }
      } else {
        this.valid.address.state = null;
      }
    }

    @Watch('isChange')
    public watchIsChange() {
      this.loadData();
    }

    public async submit(event: Event) {
      event.preventDefault();
      if (this.isValid) {
        this.busy = true;
        try {
          await this.$axios.put('/api/user', this.user, { params: { mode: 'information' } });
          await this.$auth.fetchUser();
          this.loadData();
          this.$store.commit('account/reverseChangeInformation');
        } catch {
          this.$bvToast.toast('Change information failed', { title: 'Error', variant: 'danger' });
        }
        this.busy = false;
      } else {
        this.$bvToast.toast('Invalid information', { title: 'Change information failed', variant: 'warning' });
      }
    }

    public get isChange() {
      return this.$store.state.account.change.information;
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
