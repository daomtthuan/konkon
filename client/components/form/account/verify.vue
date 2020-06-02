<template>
  <b-button type="button" variant="primary" block v-if="!isSend" @click="send">Send verification code</b-button>
  <b-form id="form-account-verify" @submit="submit" v-else>
    <b-form-group id="form-account-verify-input-group-code" :state="state">
      <b-form-input id="form-account-verify-input-code" v-model="code" :state="state" placeholder="Verification code" autocomplete="off" />
      <b-form-invalid-feedback :state="state">{{ feedback }}</b-form-invalid-feedback>
    </b-form-group>
    <b-form-group class="text-center">
      <b-button type="submit" variant="primary" :disabled="!state">Verify</b-button>
    </b-form-group>
    <b-form-group class="text-center">
      <b-link @click="send" :disabled="count > 0" :class="{ 'text-muted': count > 0 }">
        Click here to resend the verification code. <span v-if="count > 0">&lpar;after {{ count }} s&rpar;</span>
      </b-link>
    </b-form-group>
  </b-form>
</template>

<script lang="ts">
  import { Component, Vue, Watch } from 'nuxt-property-decorator';
  import Plugins from '~/plugins';

  @Component
  export default class FormAccountVerify extends Vue {
    private count = 0;
    private isSend = false;
    private state = false;
    private code = '';
    private feedback = 'Enter verification code';
    private wrong: string[] = [];

    @Watch('code')
    public watchCode() {
      if (this.code.length > 0)
        if (this.wrong.includes(this.code)) {
          this.state = false;
          this.feedback = 'Wrong verification code';
        } else {
          this.state = true;
        }
      else {
        this.state = false;
        this.feedback = 'Enter verification code';
      }
    }

    @Watch('count')
    public async watchCount() {
      if (this.count > 0) {
        await Plugins.delay(1000);
        this.count--;
      }
    }

    public send() {
      if (this.count == 0) {
        try {
          this.$axios.get('api/verify');
          this.isSend = true;
          this.count = 120;
        } catch {
          this.$bvToast.toast('Send verification code failed', { title: 'Error', variant: 'danger' });
        }
      }
    }

    public async submit(event: Event) {
      event.preventDefault();
      if (this.state) {
        try {
          await this.$axios.post(`/api/verify`, { code: this.code });
          await this.$auth.fetchUser();
        } catch (error) {
          if (error.response.status == 406) {
            this.$bvToast.toast('Wrong verification code', { title: 'Verify failed', variant: 'warning' });
            this.wrong.push(this.code);
            this.state = false;
            this.feedback = 'Wrong verification code';
          } else {
            this.$bvToast.toast('Verify failed', { title: 'Error', variant: 'danger' });
          }
        }
      } else {
        this.$bvToast.toast('Invalid verification code', { title: 'Verify failed', variant: 'warning' });
      }
    }
  }
</script>
