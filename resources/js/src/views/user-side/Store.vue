<template>
  <b-row>
    
    <b-col cols="4" offset="4">
      <b-card-code>
        <center>
        <b-img :src="`/image/${row.image}`" height="60"/>
        <br>
        <br>
        <h3>Congratulations get {{row.percentage}}% off on {{row.name}}</h3>
        </center>
      </b-card-code>
    </b-col>
    
  </b-row>
  <!-- Changed -->
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
  BButton,
  BImg
} from "bootstrap-vue";
import { VueGoodTable } from "vue-good-table";
import store from "@/store/index";
import ToastificationContent from "@core/components/toastification/ToastificationContent.vue";

import clientApi from "../../../api/client";

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
    BButton,
    BImg
  },
  data() {
    return {
      store:[],
      row:[]
    }
  },
  computed: {
    
  },
  created() {
    const store = this.$route.params.store;
    this.store = store.split("_");
    console.log(this.store);
    this.getStore();
  },
  methods: {
  getStore(){
        clientApi.getRow(
            'getStore',
            this.store[1],
            data=>{
                console.log('the client api response for getStore', data.data);
                this.row = data.data;
            },
            err=>{
                console.log(err);
            }
        )
      },
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
  border-color: #ee4b4b!important;
  background-color: #ee4b4b!important;
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