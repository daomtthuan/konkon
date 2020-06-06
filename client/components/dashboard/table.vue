<template>
  <b-container class="my-2 " fluid>
    <b-row>
      <b-col lg="6" class="my-1">
        <b-form-group label="Sort:" label-cols-sm="3" label-align-sm="right" label-size="sm" label-for="sortBySelect" class="mb-0">
          <b-input-group size="sm">
            <b-form-select v-model="sortBy" id="sortBySelect" :options="options" class="w-75">
              <template v-slot:first>
                <option value="">-- none --</option>
              </template>
            </b-form-select>
            <b-form-select v-model="sortDesc" size="sm" :disabled="!sortBy" class="w-25">
              <option :value="false">Asc</option>
              <option :value="true">Desc</option>
            </b-form-select>
          </b-input-group>
        </b-form-group>
      </b-col>

      <b-col lg="6" class="my-1">
        <b-form-group label="Initial sort:" label-cols-sm="3" label-align-sm="right" label-size="sm" label-for="initialSortSelect" class="mb-0">
          <b-form-select v-model="sortDirection" id="initialSortSelect" size="sm" :options="['asc', 'desc', 'last']"></b-form-select>
        </b-form-group>
      </b-col>

      <b-col lg="6" class="my-1">
        <b-form-group label="Filter:" label-cols-sm="3" label-align-sm="right" label-size="sm" label-for="filterInput" class="mb-0">
          <b-input-group size="sm">
            <b-form-input v-model="filter" type="search" id="filterInput" placeholder="Type to Search" />
            <b-input-group-append>
              <b-button :disabled="!filter" @click="filter = ''">Clear</b-button>
            </b-input-group-append>
          </b-input-group>
        </b-form-group>
      </b-col>

      <b-col lg="6" class="my-1">
        <b-form-group
          label="Filter on:"
          label-cols-sm="3"
          label-align-sm="right"
          label-size="sm"
          description="Leave all unchecked to filter on all data"
          class="mb-0"
        >
          <b-form-checkbox-group v-model="filterOn" :options="options" class="mt-1" />
        </b-form-group>
      </b-col>

      <b-col sm="5" md="6" class="my-1">
        <b-form-group
          label="Per page:"
          label-cols-sm="6"
          label-cols-md="4"
          label-cols-lg="3"
          label-align-sm="right"
          label-size="sm"
          label-for="perPageSelect"
          class="mb-0"
        >
          <b-form-select v-model="perPage" id="perPageSelect" size="sm" :options="pageOptions"></b-form-select>
        </b-form-group>
      </b-col>

      <b-col sm="7" md="6" class="my-1">
        <b-pagination v-model="currentPage" :total-rows="totalRows" :per-page="perPage" align="fill" size="sm" class="my-0"></b-pagination>
      </b-col>
    </b-row>

    <b-row class="my-3 d-flex align-items-center">
      <b-col>
        Status:
        <div class="mx-1 d-inline-block bg-light border" style="height: 1rem; width: 1rem" />
        Enable,
        <div class="mx-1 d-inline-block bg-secondary border" style="height: 1rem; width: 1rem" />
        Disable,
        <div class="mx-1 d-inline-block bg-warning border" style="height: 1rem; width: 1rem" />
        Not authenticated
      </b-col>
      <b-col class="text-right">
        <b-button variant="primary" v-b-modal="`add-${this.modal}`"><font-awesome-icon :icon="['fas', 'plus']" class="mr-1" />Add</b-button>
      </b-col>
    </b-row>
    <div class="my-3 shadow-sm border border-primary">
      <b-table
        hover
        show-empty
        small
        bordered
        responsive="xl"
        :items="$store.getters['dashboard/table/getItems']"
        :fields="fields"
        :current-page="currentPage"
        :per-page="perPage"
        :filter="filter"
        :filterIncludedFields="filterOn"
        :sort-by.sync="sortBy"
        :sort-desc.sync="sortDesc"
        :sort-direction="sortDirection"
        @filtered="onFiltered"
      >
        <template v-slot:cell(actions)="row">
          <b-container fluid class="p-0">
            <b-row no-gutters>
              <b-col xl="4" lg="12" class="p-1">
                <b-button size="sm" @click="info(row.item, row.index, $event.target)" block>
                  <font-awesome-icon :icon="['fas', 'code']" />
                </b-button>
              </b-col>
              <b-col xl="4" lg="6" md="12" class="p-1">
                <b-button size="sm" @click="edit(row.item, row.index, $event.target)" variant="primary" block>
                  <font-awesome-icon :icon="['fas', 'edit']" />
                </b-button>
              </b-col>
              <b-col xl="4" lg="6" md="12" class="p-1">
                <b-overlay :show="busy" rounded opacity="0.7" spinner-small spinner-variant="primary">
                  <b-button size="sm" @click="remove(row.item, row.index)" variant="danger" :disabled="busy" block>
                    <font-awesome-icon :icon="['fas', 'trash-alt']" />
                  </b-button>
                </b-overlay>
              </b-col>
            </b-row>
          </b-container>
        </template>
      </b-table>
    </div>
    <b-modal :id="infoModal.id" :title="infoModal.title" @hide="resetInfoModal" ok-only ok-title="Close" ok-variant="secondary" centered hide-header-close>
      <h6>Data JSON:</h6>
      <pre class="m-0">{{ infoModal.content }}</pre>
    </b-modal>
  </b-container>
</template>

<script lang="ts">
  import { Component, Vue, Prop, Watch } from 'nuxt-property-decorator';

  @Component
  export default class DashboardTable extends Vue {
    @Prop(String)
    private readonly api!: string;

    @Prop(Array)
    private readonly fields!: any[];

    @Prop(String)
    private readonly modal!: string;

    private busy = false;
    private totalRows = this.$store.getters['dashboard/table/getItems'].length;
    private currentPage = 1;
    private perPage = 10;
    private pageOptions = [10, 50, 100];
    private sortBy = '';
    private sortDesc = false;
    private sortDirection = 'asc';
    private filter = null;
    private filterOn = [];
    private infoModal = {
      id: 'info-modal',
      title: '',
      content: '',
    };

    public get options() {
      return this.fields.filter((field) => field.sortable).map((field) => ({ text: field.label, value: field.key }));
    }

    public info(item: any, index: any, button: any) {
      this.infoModal.title = `Row: ${index + 1}`;
      this.infoModal.content = JSON.stringify(item, null, 2);
      this.$root.$emit('bv::show::modal', this.infoModal.id, button);
    }

    public edit(item: any, index: any, button: any) {
      this.$store.commit('dashboard/edit/setIndex', index);
      this.$store.commit('dashboard/edit/setItem', item);
      this.$root.$emit('bv::show::modal', `edit-${this.modal}`, button);
    }

    public async remove(item: any, index: any) {
      if (
        await this.$bvModal.msgBoxConfirm('Data will not be recoverable after deletion. Delete anyway?', {
          title: 'Delete',
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
          await this.$axios.delete(this.api, { params: { id: item.id } });
          this.$store.commit('dashboard/table/removeItem', index);
        } catch {
          this.$bvToast.toast('Delete failed', { title: 'Error', variant: 'danger' });
        }
        this.busy = false;
      }
    }

    public resetInfoModal() {
      this.infoModal.title = '';
      this.infoModal.content = '';
    }

    public onFiltered(filteredItems: any) {
      this.totalRows = filteredItems.length;
      this.currentPage = 1;
    }
  }
</script>
