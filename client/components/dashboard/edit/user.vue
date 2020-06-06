<template>
  <b-modal id="edit-user" @show="show" title="Edit" ok-title="Close" ok-variant="secondary" ok-only centered hide-header-close>
    <b-form>
      <b-form-group label="Account:" label-for="edit-user-input-account">
        <b-input-group>
          <b-form-input id="edit-user-input-account" v-model="this.$store.state.dashboard.edit.item.account" readonly />
          <b-input-group-append>
            <b-overlay :show="busyReset" rounded opacity="0.7" spinner-small spinner-variant="primary" class="d-inline-block">
              <b-button type="button" @click="resetPassword" :disabled="busyReset">Reset Password</b-button>
            </b-overlay>
          </b-input-group-append>
        </b-input-group>
      </b-form-group>
      <b-form-group label="Email:" label-for="edit-user-input-email">
        <b-form-input id="edit-user-input-email" v-model="user.email" autocomplete="email" :state="valid.email.state" />
        <b-form-invalid-feedback :state="valid.email.state">{{ valid.email.feedback }}</b-form-invalid-feedback>
      </b-form-group>
      <b-form-group label="Fullname:" label-for="edit-user-input-name">
        <b-form-input id="edit-user-input-name" v-model="user.name" autocomplete="name" :state="valid.name.state" />
        <b-form-invalid-feedback :state="valid.name.state">{{ valid.name.feedback }}</b-form-invalid-feedback>
      </b-form-group>
      <b-form-group label="Gender:" label-for="edit-user-input-gender">
        <b-form-radio-group
          class="pt-2 py-1"
          v-model="user.gender"
          :options="genders"
          name="edit-user-input-gender"
          autocomplete="sex"
          :state="valid.gender.state"
        />
        <b-form-invalid-feedback :state="valid.gender.state">{{ valid.gender.feedback }}</b-form-invalid-feedback>
      </b-form-group>
      <b-form-group label="Birthday:" label-for="edit-user-input-birthday">
        <b-form-input type="date" id="edit-user-input-birthday" v-model="user.birthday" autocomplete="bday" :state="valid.birthday.state" />
        <b-form-invalid-feedback :state="valid.birthday.state">{{ valid.birthday.feedback }}</b-form-invalid-feedback>
      </b-form-group>
      <b-form-group label="Phone number:" label-for="edit-user-input-phone">
        <b-form-input type="tel" id="edit-user-input-phone" v-model="user.phone" autocomplete="tel" :state="valid.phone.state" />
        <b-form-invalid-feedback :state="valid.phone.state">{{ valid.phone.feedback }}</b-form-invalid-feedback>
      </b-form-group>
      <b-form-group label="Address:" label-for="edit-user-input-address">
        <b-form-input id="edit-user-input-address" v-model="user.address" :state="valid.address.state" />
        <b-form-invalid-feedback :state="valid.address.state">{{ valid.address.feedback }}</b-form-invalid-feedback>
      </b-form-group>
      <b-form-group label="Status:">
        <b-form-radio-group
          class="pt-2 py-1"
          v-model="user.status"
          :options="status"
          name="edit-user-input-status"
          autocomplete="sex"
          :state="valid.status.state"
        />
        <b-form-invalid-feedback :state="valid.status.state">{{ valid.status.feedback }}</b-form-invalid-feedback>
      </b-form-group>
    </b-form>

    <template v-slot:modal-footer="{ cancel }">
      <b-button @click="cancel()">Close</b-button>
      <b-overlay :show="busySave" rounded opacity="0.7" spinner-small spinner-variant="primary" class="d-inline-block">
        <b-button @click="submit" variant="primary" :disabled="!isValid || busySave">Save</b-button>
      </b-overlay>
    </template>
  </b-modal>
</template>

<script lang="ts">
  import { Component, Vue, Watch } from 'nuxt-property-decorator';
  import Plugins from '~/plugins';

  @Component
  export default class DashboardEditUser extends Vue {
    private user = {
      id: '',
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
      email: { state: null, feedback: 'Enter email' },
      name: { state: null, feedback: 'Enter fullname' },
      gender: { state: null, feedback: 'Select gender' },
      birthday: { state: null, feedback: 'Select birthday' },
      phone: { state: null, feedback: 'Enter phone number' },
      address: { state: null, feedback: 'Enter address' },
      status: { state: null, feedback: 'Select status' },
    };
    private busySave = false;
    private busyReset = false;

    @Watch('user.email')
    public watchUserEmail(value: string) {
      if (value != this.$store.state.dashboard.edit.item.email) {
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
      if (value != this.$store.state.dashboard.edit.item.name) {
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
      if (value != this.$store.state.dashboard.edit.item.gender) {
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
      if (value != this.$store.state.dashboard.edit.item.birthday) {
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
      if (value != this.$store.state.dashboard.edit.item.phone) {
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
      if (value != this.$store.state.dashboard.edit.item.address) {
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

    @Watch('user.status')
    public watchUserStatus(value: number) {
      if (value != this.$store.state.dashboard.edit.item.status) {
        if (this.user.status >= 0) {
          if (Plugins.isValid(process.env.regex_number!, process.env.regex_length_status!, this.user.status.toString())) {
            this.valid.status.state = true;
          } else {
            this.valid.status = { state: false, feedback: 'Invalid status' };
          }
        } else {
          this.valid.status = { state: false, feedback: 'Select status' };
        }
      } else {
        this.valid.status.state = null;
      }
    }

    public async submit() {
      if (this.isValid) {
        this.busySave = true;
        try {
          await this.$axios.put('/api/manage/user', this.user, { params: { mode: 'information' } });
          this.$store.commit('dashboard/table/editItem', {
            index: this.$store.state.dashboard.edit.index,
            item: this.user,
          });
          this.$root.$emit('bv::hide::modal', 'edit-user');
        } catch {
          this.$bvToast.toast('Edit failed', { title: 'Error', variant: 'danger' });
        }
        this.busySave = false;
      } else {
        this.$bvToast.toast('Invalid information', { title: 'Edit failed', variant: 'warning' });
      }
    }

    public async resetPassword() {
      if (
        await this.$bvModal.msgBoxConfirm('Please confirm that you want to reset password this account', {
          title: 'Reset Password',
          size: 'sm',
          buttonSize: 'sm',
          okVariant: 'danger',
          okTitle: 'Yes',
          cancelTitle: 'No',
          footerClass: 'p-2',
          hideHeaderClose: true,
          centered: true,
        })
      ) {
        this.busyReset = true;
        try {
          await this.$bvModal.msgBoxOk((await this.$axios.put('/api/manage/user', this.user, { params: { mode: 'password' } })).data.password, {
            title: 'New Password',
            size: 'sm',
            buttonSize: 'sm',
            footerClass: 'p-2',
            hideHeaderClose: true,
            centered: true,
            bodyClass: 'text-center font-weight-bold text-danger',
          });
        } catch {
          this.$bvToast.toast('Reset password failed', { title: 'Error', variant: 'danger' });
        }
        this.busyReset = false;
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
      this.busySave = false;
      this.user = {
        id: this.$store.state.dashboard.edit.item.id,
        email: this.$store.state.dashboard.edit.item.email,
        name: this.$store.state.dashboard.edit.item.name,
        gender: this.$store.state.dashboard.edit.item.gender,
        birthday: this.$store.state.dashboard.edit.item.birthday,
        phone: this.$store.state.dashboard.edit.item.phone,
        address: this.$store.state.dashboard.edit.item.address,
        status: this.$store.state.dashboard.edit.item.status,
      };
    }
  }
</script>
