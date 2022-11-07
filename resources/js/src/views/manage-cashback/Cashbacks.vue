<template>
  <b-row>
    <b-col cols="12">
      <b-card-code>
        <b-link :to="{ path: 'add-cashback' }" class="custom-btn">Add Cashback</b-link>
        <!-- <b-link :to="{ path: 'create-user' }" class="custom-btn">Start User Import Wizard</b-link> -->
        <b-link
          v-if="isSelected"
          class="custom-btn-danger"
          @click="confirmation(idArray,'batchDelete')"
        >
          Delete {{ idArray.length }} Record
          <span v-if="idArray.length > 1">s</span>
        </b-link>
        <!-- search input -->
        <div class="custom-search d-flex justify-content-end">
          <b-form-group>
            <div class="d-flex align-items-center">
              <label class="mr-1">Search</label>
              <b-form-input
                v-model="serverParams.searchTerm"
                placeholder="Search"
                type="text"
                class="d-inline-block"
              />
            </div>
          </b-form-group>
           <b-button id="search-btn" variant="primary" type="submit" @click.prevent="onSearch">Search</b-button>
        </div>

        <!-- table -->
        <vue-good-table
          mode="remote"
          @on-page-change="onPageChange"
          @on-sort-change="onSortChange"
          @on-column-filter="onColumnFilter"
          @on-per-page-change="onPerPageChange"
          :totalRows="totalRecords"
          :isLoading.sync="isLoading"
          :pagination-options="{
          enabled: true,
          }"
          :rows="rows"
          :columns="columns"
        >
          <template slot="table-row" slot-scope="props">
            <!-- Column: Name -->
            <span v-if="props.column.field === 'email'" class="text-nowrap">
              <span class="text-nowrap">{{ props.row.email }}</span>
            </span>

            <!-- Column: Action -->
            <span v-else-if="props.column.field === 'action'">
              <span>
                  <b-link :to="{ path: `update-cashback/${props.row.id}` }" title="Edit Product"><feather-icon icon="Edit2Icon"/></b-link>
                  <b-link v-on:click="confirmation(props.row.id,'singleDelete')" title="Delete Product"><feather-icon icon="DeleteIcon" class="text-danger"/></b-link>
              </span>
            </span>

            <!-- Column: Common -->
            <span v-else>{{ props.formattedRow[props.column.field] }}</span>
          </template>

          <!-- pagination -->
          <template slot="pagination-bottom" slot-scope="props">
            <div class="d-flex justify-content-between flex-wrap">
              <div class="d-flex align-items-center mb-0 mt-1">
                <span class="text-nowrap">Showing 1 to</span>
                <b-form-select
                  v-model="serverParams.perPage"
                  :options="['3','5','10']"
                  class="mx-1"
                  @input="(value)=>props.perPageChanged({currentPerPage:value})"
                />
                <span class="text-nowrap">of {{ totalRecords }} entries</span>
                <!-- <span class="text-nowrap">of {{ props.total }} entries</span> -->
              </div>

              <div>
                <b-pagination
                  :value="1"
                  :total-rows="totalRecords"
                  :per-page="serverParams.perPage"
                  first-number
                  last-number
                  align="right"
                  prev-class="prev-item"
                  next-class="next-item"
                  class="mt-1 mb-0"
                  @input="(value)=>props.pageChanged({currentPage:value})"
                >
                  <template #prev-text>
                    <feather-icon icon="ChevronLeftIcon" size="18"/>
                  </template>
                  <template #next-text>
                    <feather-icon icon="ChevronRightIcon" size="18"/>
                  </template>
                </b-pagination>
              </div>
            </div>
          </template>
        </vue-good-table>
      </b-card-code>
    </b-col>
  </b-row>
</template>

<script>
import BCardCode from "@core/components/b-card-code/BCardCode.vue";
import {
  BAvatar,
  BBadge,
  BPagination,
  BFormGroup,
  BFormInput,
  BFormSelect,
  BDropdown,
  BDropdownItem,
  BRow,
  BCol,
  BLink,
  BButton
} from "bootstrap-vue";
import { VueGoodTable } from "vue-good-table";
import store from "@/store/index";
import Admin from "../../../api/admin";
import ToastificationContent from "@core/components/toastification/ToastificationContent.vue";

export default {
  components: {
    BCardCode,
    VueGoodTable,
    BAvatar,
    BBadge,
    BPagination,
    BFormGroup,
    BFormInput,
    BFormSelect,
    BDropdown,
    BDropdownItem,
    BRow,
    BCol,
    BLink,
    BButton
  },
  data() {
    return {
      serverParams: {
        // a map of column filters example: {name: 'john', age: '20'}
        columnFilters: {},
        sort: [
          {
            field: "id", // example: 'name'
            type: "desc" // 'asc' or 'desc'
          }
        ],

        page: 1, // what page I want to show
        perPage: 3, // how many items I'm showing per page
        searchTerm: "",
      },
      totalRecords:0,
      isLoading: false,
      rows: [],



      pageLength: 10,
      dir: false,
      idArray: [],
      isSelected: false,
      columns: [
        {
          label: "Cashback ID",
          field: "id"
        },
        {
          label: "Cashback Amount",
          field: "amount"
        },
        {
          label: "User Email",
          field: "email"
        },
        {
          label: "Affiliate URL",
          field: "affiliate_url"
        },

        {
          label: "action",
          field: "action"
        }
      ],
      
      //searchTerm: "",
      status: [
        {
          1: "1",
          2: "0"
        },
        {
          1: "light-primary",
          2: "light-success",
          3: "light-danger",
          4: "light-warning",
          5: "light-info"
        }
      ]
    };
  },
  computed: {
    statusVariant() {
      const statusColor = {
        /* eslint-disable key-spacing */
        1: "light-primary",
        0: "light-danger"
      };

      return status => statusColor[status];
    },
    direction() {
      if (store.state.appConfig.isRTL) {
        // eslint-disable-next-line vue/no-side-effects-in-computed-properties
        this.dir = true;
        return this.dir;
      }
      // eslint-disable-next-line vue/no-side-effects-in-computed-properties
      this.dir = false;
      return this.dir;
    }
  },
  created() {
    //this.getCashbacks();
    this.loadItems();
  },
  methods: {
    // vue-goog-table server side functions start

    updateParams(newProps) {
      this.serverParams = Object.assign({}, this.serverParams, newProps);
    },
    
    onSearch() {
      this.loadItems();
    },
    onPageChange(params) {
      this.updateParams({page: params.currentPage});
      this.loadItems();
    },

    onPerPageChange(params) {
      this.updateParams({perPage: params.currentPerPage});
      this.loadItems();
    },

    onSortChange(params) {
      this.updateParams({
        sort: [{
          type: params[0].type,
          field: params[0].field,
        }],
      });
      this.loadItems();
    },
    
    onColumnFilter(params) {
      this.updateParams(params);
      this.loadItems();
    },

    // load items is what brings back the rows from server
    loadItems() {
      Admin.getServerRecords(
        'getCashbacksS',
        this.serverParams,
        data => {
          this.rows = data.data.rows;
          this.totalRecords = data.data.total_records.count;
        },
        err => {
          console.log(err);
        }
      );
    },

    // vue-goog-table server side functions end

    getCashbacks() {
      Admin.getRecords(
        "getCashbacks",
        data => {
          this.rows = data.data;
        },
        err => {
          console.log(err);
        }
      );
    },
    confirmation(data, type) {
      this.$swal({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Yes, delete it!",
        customClass: {
          confirmButton: "btn btn-primary",
          cancelButton: "btn btn-outline-danger ml-1"
        },
        buttonsStyling: false
      }).then(result => {
        if (result.value) {
          if (type == "batchDelete") {
            this.deleteMultiCashbacks(data);
          } else if (type == "singleDelete") {
            this.deleteCashback(data);
          }
        }
      });
    },
    selectionChanged(params) {
      this.idArray = params.selectedRows;
      if (this.idArray.length > 0) {
        this.isSelected = true;
      } else {
        this.isSelected = false;
      }
    },
    deleteCashback(id) {
      Admin.deleteRecord(
        "deleteCashback",
        id,
        resp => {
          if (resp.success) {
            this.$toast({
              component: ToastificationContent,
              props: {
                title: "Success!",
                text: resp.message,
                icon: "UserIcon",
                variant: "success"
              }
            });
          }
          this.getCashbacks();
        },
        err => {
          this.$toast({
            component: ToastificationContent,
            props: {
              title: "Failed",
              text: err.message,
              icon: "errorIcon",
              variant: "outline-danger"
            }
          });
        }
      );
    },
    deleteMultiCashbacks(data) {
      Admin.deleteMultiCashbacks(
        data,
        resp => {
          if (resp.success) {
            this.$toast({
              component: ToastificationContent,
              props: {
                title: "Success!",
                text: resp.message,
                icon: "UserIcon",
                variant: "success"
              }
            });
          }
          this.getCashbacks();
        },
        err => {
          this.$toast({
            component: ToastificationContent,
            props: {
              title: "Failed",
              text: err.message,
              icon: "errorIcon",
              variant: "outline-danger"
            }
          });
        }
      );
    }
  }
};
</script>

<style lang="scss">
@import "~@core/scss/vue/libs/vue-good-table.scss";
.custom-btn {
  border-color: #7367f0 !important;
  background-color: #7367f0 !important;
  color: white;
  text-align: center;
  border: 1px solid transparent;
  padding: 0.786rem 1.5rem;
  border-radius: 0.358rem;
  cursor: pointer;
}
.custom-btn:hover {
  box-shadow: 0 8px 25px -8px #7367f0;
  color: white;
}
.custom-btn-danger {
  border-color: #ee4b4b !important;
  background-color: #ee4b4b !important;
  color: white;
  text-align: center;
  border: 1px solid transparent;
  padding: 0.786rem 1.5rem;
  border-radius: 0.358rem;
  cursor: pointer;
}
.custom-btn-danger:hover {
  box-shadow: 0 8px 25px -8px #ee4b4b;
  color: white;
}
#search-btn{
  height:39px;
  margin-left: 6px;
}
</style>