<template>
  <b-modal id="add-user" @show="show" title="Add" ok-title="Close" ok-variant="secondary" ok-only centered hide-header-close>
    <b-form>
      <b-form-group label="Account:" label-for="add-user-input-account">
        <b-input-group>
          <b-form-input id="add-user-input-account" v-model="user.account" autocomplete="username" :state="valid.account.state" />
          <b-form-invalid-feedback :state="valid.account.state">{{ valid.account.feedback }}</b-form-invalid-feedback>
        </b-input-group>
      </b-form-group>
      <b-form-group label="Email:" label-for="add-user-input-email">
        <b-form-input id="add-user-input-email" v-model="user.email" autocomplete="email" :state="valid.email.state" />
        <b-form-invalid-feedback :state="valid.email.state">{{ valid.email.feedback }}</b-form-invalid-feedback>
      </b-form-group>
      <b-form-group label="Fullname:" label-for="add-user-input-name">
        <b-form-input id="add-user-input-name" v-model="user.name" autocomplete="name" :state="valid.name.state" />
        <b-form-invalid-feedback :state="valid.name.state">{{ valid.name.feedback }}</b-form-invalid-feedback>
      </b-form-group>
      <b-form-group label="Gender:" label-for="add-user-input-gender">
        <b-form-radio-group
          class="pt-2 py-1"
          v-model="user.gender"
          :options="genders"
          name="add-user-input-gender"
          autocomplete="sex"
          :state="valid.gender.state"
        />
        <b-form-invalid-feedback :state="valid.gender.state">{{ valid.gender.feedback }}</b-form-invalid-feedback>
      </b-form-group>
      <b-form-group label="Birthday:" label-for="add-user-input-birthday">
        <b-form-input type="date" id="add-user-input-birthday" v-model="user.birthday" autocomplete="bday" :state="valid.birthday.state" />
        <b-form-invalid-feedback :state="valid.birthday.state">{{ valid.birthday.feedback }}</b-form-invalid-feedback>
      </b-form-group>
      <b-form-group label="Phone number:" label-for="add-user-input-phone">
        <b-form-input type="tel" id="add-user-input-phone" v-model="user.phone" autocomplete="tel" :state="valid.phone.state" />
        <b-form-invalid-feedback :state="valid.phone.state">{{ valid.phone.feedback }}</b-form-invalid-feedback>
      </b-form-group>
      <b-form-group label="Address:" label-for="add-user-input-address">
        <b-form-input id="add-user-input-address" v-model="user.address" :state="valid.address.state" />
        <b-form-invalid-feedback :state="valid.address.state">{{ valid.address.feedback }}</b-form-invalid-feedback>
      </b-form-group>
      <b-form-group label="Status:">
        <b-form-radio-group
          class="pt-2 py-1"
          v-model="user.status"
          :options="status"
          name="add-user-input-status"
          autocomplete="sex"
          :state="valid.status.state"
        />
        <b-form-invalid-feedback :state="valid.status.state">{{ valid.status.feedback }}</b-form-invalid-feedback>
      </b-form-group>
    </b-form>

    <template v-slot:modal-footer="{ cancel }">
      <b-button @click="cancel()">Close</b-button>
      <b-overlay :show="busy" rounded opacity="0.7" spinner-small spinner-variant="primary" class="d-inline-block">
        <b-button @click="submit" variant="primary" :disabled="!isValid || busy">Save</b-button>
      </b-overlay>
    </template>
  </b-modal>
</template>

<script lang="ts">
  import { Component, Vue, Watch } from 'nuxt-property-decorator';
  import Plugins from '~/plugins';

  @Component
  export default class DashboardAddUser extends Vue {
    private user = {
      id: '',
      account: '',
      email: '',
      name: '',
      gender: -1,
      birthday: '',
      phone: '',
      address: '',
      status: -1,
    };
    private genders = [
      { text: 'Male', value: 1 },
      { text: 'Female', value: 0 },
    ];
    private status = [
      { text: 'Enable', value: 1 },
      { text: 'Disable', value: 0 },
      { text: 'Not authenticated', value: 2 },
    ];
    private valid: { [key: string]: { state: boolean | null; feedback: string } } = {
      account: { state: false, feedback: 'Enter account' },
      email: { state: false, feedback: 'Enter email' },
      name: { state: false, feedback: 'Enter fullname' },
      gender: { state: false, feedback: 'Select gender' },
      birthday: { state: false, feedback: 'Select birthday' },
      phone: { state: false, feedback: 'Enter phone number' },
      address: { state: false, feedback: 'Enter address' },
      status: { state: false, feedback: 'Select status' },
    };
    private busy = false;

    @Watch('user.account')
    public watchUserAccount(value: string) {
      if (this.user.account.length > 0) {
        if (!this.$nuxt.$store.state.dashboard.table.items.some((item: any) => item.account == this.user.account)) {
          if (Plugins.isValid(process.env.regex_account!, process.env.regex_length_account!, this.user.account)) {
            this.valid.account.state = true;
          } else {
            this.valid.account = { state: false, feedback: 'Invalid account' };
          }
        } else {
          this.valid.account = { state: false, feedback: 'Account already exists' };
        }
      } else {
        this.valid.account = { state: false, feedback: 'Enter account' };
      }
    }

    @Watch('user.email')
    public watchUserEmail(value: string) {
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
    public watchUserName(value: string) {
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
    public watchUserGender(value: number) {
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
    public watchUserBirthday(value: string) {
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
    public watchUserPhone(value: string) {
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
    public watchUserAddress(value: string) {
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

    @Watch('user.status')
    public watchUserStatus(value: number) {
      if (this.user.status >= 0) {
        if (Plugins.isValid(process.env.regex_number!, process.env.regex_length_status!, this.user.status.toString())) {
          this.valid.status.state = true;
        } else {
          this.valid.status = { state: false, feedback: 'Invalid status' };
        }
      } else {
        this.valid.status = { state: false, feedback: 'Select status' };
      }
    }

    public async submit() {
      if (this.isValid) {
        this.busy = true;
        try {
          const user = (await this.$axios.post('/api/manage/user', this.user)).data;
          this.user.id = user.id;
          this.$store.commit('dashboard/table/addItem', this.user);
          await this.$bvModal.msgBoxOk(user.password, {
            title: 'New Account Password',
            size: 'sm',
            buttonSize: 'sm',
            footerClass: 'p-2',
            hideHeaderClose: true,
            centered: true,
            bodyClass: 'text-center font-weight-bold text-danger',
          });
          this.$root.$emit('bv::hide::modal', 'add-user');
        } catch {
          this.$bvToast.toast('Add failed', { title: 'Error', variant: 'danger' });
        }
        this.busy = false;
      } else {
        this.$bvToast.toast('Invalid information', { title: 'Add failed', variant: 'warning' });
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

    public show() {
      this.busy = false;
      this.user = {
        id: '',
        account: '',
        email: '',
        name: '',
        gender: -1,
        birthday: '',
        phone: '',
        address: '',
        status: -1,
      };
      this.valid = {
        account: { state: false, feedback: 'Enter account' },
        email: { state: false, feedback: 'Enter email' },
        name: { state: false, feedback: 'Enter fullname' },
        gender: { state: false, feedback: 'Select gender' },
        birthday: { state: false, feedback: 'Select birthday' },
        phone: { state: false, feedback: 'Enter phone number' },
        address: { state: false, feedback: 'Enter address' },
        status: { state: false, feedback: 'Select status' },
      };
    }
  }
</script>
