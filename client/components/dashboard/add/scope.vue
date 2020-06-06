<template>
  <b-modal id="add-scope" @show="show" title="Add" ok-title="Close" ok-variant="secondary" ok-only centered hide-header-close>
    <b-form>
      <b-form-group label="Name:" label-for="add-scope-input-name">
        <b-form-input id="add-scope-input-name" v-model="scope.name" autocomplete="name" :state="valid.name.state" />
        <b-form-invalid-feedback :state="valid.name.state">{{ valid.name.feedback }}</b-form-invalid-feedback>
      </b-form-group>
      <b-form-group label="Status:">
        <b-form-radio-group
          class="pt-2 py-1"
          v-model="scope.status"
          :options="status"
          name="add-scope-input-status"
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
  export default class DashboardAddScope extends Vue {
    private scope = {
      id: '',
      name: '',
      status: -1,
    };
    private status = [
      { text: 'Enable', value: 1 },
      { text: 'Disable', value: 0 },
    ];
    private valid: { [key: string]: { state: boolean | null; feedback: string } } = {
      name: { state: false, feedback: 'Enter fullname' },
      status: { state: false, feedback: 'Select status' },
    };
    private busy = false;

    @Watch('scope.name')
    public watchScopeName(value: string) {
      if (this.scope.name.length > 0) {
        if (Plugins.isValid(process.env.regex_name!, process.env.regex_length_name!, this.scope.name)) {
          this.valid.name.state = true;
        } else {
          this.valid.name = { state: false, feedback: 'Invalid fullname' };
        }
      } else {
        this.valid.name = { state: false, feedback: 'Enter fullname' };
      }
    }

    @Watch('scope.status')
    public watchScopeStatus(value: number) {
      if (this.scope.status >= 0) {
        if (Plugins.isValid(process.env.regex_number!, process.env.regex_length_status!, this.scope.status.toString())) {
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
          const scope = (await this.$axios.post('/api/manage/scope', this.scope)).data;
          this.scope.id = scope.id;
          this.$store.commit('dashboard/table/addItem', this.scope);
          this.$root.$emit('bv::hide::modal', 'add-scope');
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
      this.scope = {
        id: '',
        name: '',
        status: -1,
      };
      this.valid = {
        name: { state: false, feedback: 'Enter fullname' },
        status: { state: false, feedback: 'Select status' },
      };
    }
  }
</script>
