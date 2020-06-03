<template>
  <b-row no-gutters>
    <b-col md="6">
      <b-card-body class="pr-md-0">
        <logo size="128" tag="h1" subtag="h3" class="mt-3 mb-5" />
        <b-button @click="changeInformation()" :variant="isChangeInformation ? 'secondary' : 'primary'" block :disabled="isChangePassword">
          {{ textButton.changeInformation }}
        </b-button>
        <b-button @click="changePassword()" :variant="isChangePassword ? 'secondary' : 'primary'" block :disabled="isChangeInformation">
          {{ textButton.changePassword }}
        </b-button>
        <div class="mt-4" v-if="$auth.user.status == 2">
          <hr class="mb-4" />
          <div class="font-weight-bold text-danger pt-2">
            Email of your account has not been verified.
          </div>
          <form-account-verify class="mt-2" />
        </div>
      </b-card-body>
    </b-col>
    <b-col md="6">
      <b-card-body :title="title">
        <form-account-information v-if="!isChangePassword" />
        <form-account-password v-if="isChangePassword" />
      </b-card-body>
    </b-col>
  </b-row>
</template>

<script lang="ts">
  import { Component, Vue } from 'nuxt-property-decorator';
  import App from '~/plugins/app';

  @Component({
    scrollToTop: true,
  })
  export default class PageUserAccount extends Vue {
    private textButton = {
      changeInformation: 'Change information',
      changePassword: 'Change password',
    };

    public mounted() {
      App.ready(this);
    }

    public changeInformation() {
      this.$store.commit('account/reverseChangeInformation');
      this.textButton.changeInformation = this.isChangeInformation ? 'Cancel change information' : 'Change information';
    }

    public changePassword() {
      this.$store.commit('account/reverseChangePassword');
      this.textButton.changePassword = this.isChangePassword ? 'Cancel change password' : 'Change password';
    }

    public get title() {
      return this.isChangeInformation ? 'Change Information' : this.isChangePassword ? 'Change Password' : 'Account Information';
    }

    public get isChangeInformation() {
      return this.$store.state.account.change.information;
    }

    public get isChangePassword() {
      return this.$store.state.account.change.password;
    }
  }
</script>
