<template>
  <b-modal id="edit-news" @show="show" title="Add" ok-title="Close" ok-variant="secondary" ok-only centered hide-header-close>
    <b-form>
      <b-form-group label="Name:" label-for="edit-mews-input-name">
        <b-form-input id="edit-mews-input-name" v-model="news.name" :state="valid.name.state" />
        <b-form-invalid-feedback :state="valid.name.state">{{ valid.name.feedback }}</b-form-invalid-feedback>
      </b-form-group>
      <b-form-group label="Title:" label-for="edit-mews-input-title">
        <b-form-input id="edit-mews-input-title" v-model="news.title" :state="valid.title.state" />
        <b-form-invalid-feedback :state="valid.title.state">{{ valid.title.feedback }}</b-form-invalid-feedback>
      </b-form-group>
      <b-form-group label="Date:" label-for="edit-mews-input-date">
        <b-form-input type="date" id="edit-mews-input-date" v-model="news.date" :state="valid.date.state" />
        <b-form-invalid-feedback :state="valid.date.state">{{ valid.date.feedback }}</b-form-invalid-feedback>
      </b-form-group>
      <b-form-group label="Intro:" label-for="edit-mews-input-intro">
        <b-form-input id="edit-mews-input-intro" v-model="news.intro" :state="valid.intro.state" />
        <b-form-invalid-feedback :state="valid.intro.state">{{ valid.intro.feedback }}</b-form-invalid-feedback>
      </b-form-group>
      <b-form-group label="Auth:" label-for="edit-mews-input-auth">
        <b-form-input id="edit-mews-input-auth" v-model="news.auth" readonly />
      </b-form-group>
      <b-form-group>
        <label class="d-block" @click="focus">Content:</label>
        <vue-editor v-model="news.content" :class="valid.content.state === true ? 'is-valid' : valid.content.state === false ? 'is-invalid' : ''" />
        <b-form-invalid-feedback :state="valid.content.state">{{ valid.content.feedback }}</b-form-invalid-feedback>
      </b-form-group>
      <b-form-group label="Image:" label-for="edit-mews-input-image">
        <b-form-file v-model="image" placeholder="Choose a image or drop it here..." drop-placeholder="Drop image here..." accept="image/jpeg" />
      </b-form-group>
      <b-form-group label="Status:">
        <b-form-radio-group class="pt-2 py-1" v-model="news.status" :options="status" name="edit-mews-input-status" :state="valid.status.state" />
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
  export default class DashboardAddNews extends Vue {
    private news = {
      id: '',
      name: '',
      title: '',
      date: '',
      intro: '',
      content: '',
      status: -1,
      auth: '',
    };
    private image = null;

    private status = [
      { text: 'Enable', value: 1 },
      { text: 'Disable', value: 0 },
    ];

    private valid: { [key: string]: { state: boolean | null; feedback: string } } = {
      name: { state: false, feedback: 'Enter name' },
      title: { state: false, feedback: 'Enter title' },
      date: { state: false, feedback: 'Select date' },
      intro: { state: false, feedback: 'Enter intro' },
      content: { state: false, feedback: 'Enter content' },
      status: { state: false, feedback: 'Select status' },
    };

    private busy = false;

    @Watch('news.name')
    public watchNewsName(value: string) {
      if (this.news.name.length > 0) {
        if (Plugins.isValid(process.env.regex_nameUrl!, process.env.regex_length_nameUrl!, this.news.name)) {
          this.valid.name.state = true;
        } else {
          this.valid.name = { state: false, feedback: 'Invalid name' };
        }
      } else {
        this.valid.name = { state: false, feedback: 'Enter name' };
      }
    }

    @Watch('news.title')
    public watchNewsTitle(value: string) {
      if (this.news.title.length > 0) {
        if (Plugins.isValid(process.env.regex_any!, process.env.regex_length_title!, this.news.title)) {
          this.valid.title.state = true;
        } else {
          this.valid.title = { state: false, feedback: 'Invalid title' };
        }
      } else {
        this.valid.title = { state: false, feedback: 'Enter title' };
      }
    }

    @Watch('news.date')
    public watchNewsDate(value: string) {
      if (this.news.date.length > 0) {
        if (Plugins.isValid(process.env.regex_date!, process.env.regex_length_date!, this.news.date)) {
          this.valid.date.state = true;
        } else {
          this.valid.date = { state: false, feedback: 'Invalid date' };
        }
      } else {
        this.valid.date = { state: false, feedback: 'Enter date' };
      }
    }

    @Watch('news.intro')
    public watchNewsIntro(value: string) {
      if (this.news.intro.length > 0) {
        if (Plugins.isValid(process.env.regex_any!, process.env.regex_length_intro!, this.news.intro)) {
          this.valid.intro.state = true;
        } else {
          this.valid.intro = { state: false, feedback: 'Invalid intro' };
        }
      } else {
        this.valid.intro = { state: false, feedback: 'Enter intro' };
      }
    }

    @Watch('news.content')
    public watchNewsContent(value: string) {
      if (this.news.content.length > 0) {
        this.valid.content.state = true;
      } else {
        this.valid.content = { state: false, feedback: 'Enter content' };
      }
    }

    @Watch('news.status')
    public watchNewsStatus(value: number) {
      if (this.news.status >= 0) {
        if (Plugins.isValid(process.env.regex_number!, process.env.regex_length_status!, this.news.status.toString())) {
          this.valid.status.state = true;
        } else {
          this.valid.status = { state: false, feedback: 'Invalid status' };
        }
      } else {
        this.valid.status = { state: false, feedback: 'Select status' };
      }
    }

    public focus() {
      (<any>document.getElementsByClassName('ql-editor ql-blank')[0]).focus();
    }

    public async submit() {
      if (this.isValid) {
        if (
          await this.$bvModal.msgBoxConfirm('Please confirm that you want to edit this news', {
            title: 'Edit news',
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
          this.busy = true;
          try {
            await this.$axios.put('/api/manage/news', this.news);
            if (Boolean(this.image)) {
              let formData = new FormData();
              formData.append('file', this.image!);
              await this.$axios.post('/api/manage/news', formData, {
                headers: { 'Content-Type': 'multipart/form-data' },
                params: { mode: 'image', name: this.news.name },
              });
            }
            this.$store.commit('dashboard/table/editItem', {
              index: this.$store.state.dashboard.edit.index,
              item: this.news,
            });
            this.$root.$emit('bv::hide::modal', 'edit-news');
          } catch {
            this.$bvToast.toast('Edit failed', { title: 'Error', variant: 'danger' });
          }
          this.busy = false;
        }
      } else {
        this.$bvToast.toast('Invalid information', { title: 'Edit failed', variant: 'warning' });
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
      this.news = {
        id: this.$store.state.dashboard.edit.item.id,
        name: this.$store.state.dashboard.edit.item.name,
        title: this.$store.state.dashboard.edit.item.title,
        date: this.$store.state.dashboard.edit.item.date,
        intro: this.$store.state.dashboard.edit.item.intro,
        content: this.$store.state.dashboard.edit.item.content,
        status: this.$store.state.dashboard.edit.item.status,
        auth: this.$store.state.dashboard.edit.item.auth,
      };
    }
  }
</script>

<style lang="scss">
  @import './assets/theme/vue-editor.scss';
</style>
