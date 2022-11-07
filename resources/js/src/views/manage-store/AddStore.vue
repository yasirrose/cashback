<template>
  <b-row>
    <b-col cols="12">
      <b-card-code title="Add Cashback">
        <div v-if="validationErrors">
          <ul class="alert alert-danger">
            <li v-for="(value, key, index) in validationErrors">{{ value }}</li>
          </ul>
        </div>
        <!-- media -->
              <b-col md="12">
                <b-media no-body>
                  <b-media-aside>
                    <b-link v-if="pic">
                      <b-img ref :src="pic" rounded height="80"/>
                    </b-link>
                    <b-link v-else-if="picture">
                      <b-img
                        ref
                        :src="`/image/${picture}`"
                        rounded
                        height="80"
                      />
                    </b-link>
                    <!--/ avatar -->
                  </b-media-aside>

                  <b-media-body class="mt-75 ml-75">
                    <!-- upload button -->
                    <b-button
                      v-ripple.400="'rgba(255, 255, 255, 0.15)'"
                      variant="primary"
                      size="sm"
                      class="mb-75 mr-75"
                      @click="$refs.refInputEl.$el.click()"
                    >Upload App Logo</b-button>
                    <b-form-file
                      
                      ref="refInputEl"
                      accept=".jpg, .png, .gif"
                      :hidden="true"
                      plain
                      v-on:change="uploadFile($event)"
                    />
                    <!--/ upload button -->
                    <b-card-text>Allowed JPG, GIF or PNG. Max size of 800kB</b-card-text>
                  </b-media-body>
                </b-media>
              </b-col>
              <!--/ media -->
              <br>
        <validation-observer ref="simpleRules">
          <b-form>
            <b-row>
              <b-col md="6">
                <b-form-group>
                  <validation-provider #default="{ errors }" name="Store Name" rules="required">
                    <b-form-input
                      v-model="name"
                      :state="errors.length > 0 ? false:null"
                      type="text"
                      placeholder="Please Enter Store Name"
                    />
                    <small class="text-danger">{{ errors[0] }}</small>
                  </validation-provider>
                </b-form-group>
              </b-col>
              <b-col md="6">
                <b-form-group>
                  <validation-provider #default="{ errors }" name="Store Title" rules="required">
                    <b-form-input
                      v-model="title"
                      :state="errors.length > 0 ? false:null"
                      type="text"
                      placeholder="Please Enter Store Title"
                    />
                    <small class="text-danger">{{ errors[0] }}</small>
                  </validation-provider>
                </b-form-group>
              </b-col>
              <b-col md="6">
                <b-form-group>
                  <validation-provider #default="{ errors }" name="Percentage" rules="required">
                    <b-form-input
                      v-model="percentage"
                      :state="errors.length > 0 ? false:null"
                      type="number"
                      placeholder="Please Enter Percentage"
                    />
                    <small class="text-danger">{{ errors[0] }}</small>
                  </validation-provider>
                </b-form-group>
              </b-col>

              <b-col md="6">
                <b-form-group>
                  <validation-provider #default="{ errors }" name="Featured" rules="required">
                    <b-form-select
                      :state="errors.length > 0 ? false:null"
                      v-model="featured"
                      :options="options"
                    />
                    <small class="text-danger">{{ errors[0] }}</small>
                  </validation-provider>
                </b-form-group>
              </b-col>

              <b-col md="12">
                <b-button variant="primary" type="submit" @click.prevent="validationForm">Submit</b-button>
              </b-col>
            </b-row>
          </b-form>
        </validation-observer>
      </b-card-code>
    </b-col>
  </b-row>
</template>
<script>
import BCardCode from "@core/components/b-card-code";
import { ValidationProvider, ValidationObserver } from "vee-validate";
import {
  BFormFile,
  BButton,
  BForm,
  BFormGroup,
  BFormInput,
  BRow,
  BCol,
  BAlert,
  BCard,
  BCardText,
  BMedia,
  BMediaAside,
  BMediaBody,
  BLink,
  BImg,
  BFormSelect
} from "bootstrap-vue";
import Ripple from "vue-ripple-directive";
//import { useInputImageRenderer } from '@core/comp-functions/forms/form-utils'
import { ref } from "@vue/composition-api";
import { required, email, confirmed } from "@validations";
import AdminApi from "../../../api/admin";
import ToastificationContent from "@core/components/toastification/ToastificationContent.vue";
import router from "@/router";

export default {
  components: {
    BCardCode,
    BFormSelect,
    BButton,
    BForm,
    BImg,
    BFormFile,
    BFormGroup,
    BFormInput,
    BRow,
    BCol,
    BAlert,
    BCard,
    BCardText,
    BMedia,
    BMediaAside,
    BMediaBody,
    BLink,
    ValidationProvider,
    ValidationObserver
  },
  directives: {
    Ripple
  },
  data() {
    return {
      required,
      validationErrors: "",
      picture: "",
      pic: null,
      file: null,
      info: "",
      name: "",
      title: "",
      percentage: "",
      featured: null,
      options: [
        { value: null, text: "Please select an option" },
        { value: 1, text: "Feature the store" },
        { value: 0, text: "Don't feature" }
      ]
    };
  },
  created() {
    
  },
  methods: {
    uploadFile(e) {
      this.file = e.target.files[0];
      this.pic = URL.createObjectURL(this.file);
    },
    validationForm() {
      if(this.file==null)
      {
        this.$toast({
          component: ToastificationContent,
          props: {
            title: "Failed",
            text: "Please upload image",
            icon: "errorIcon",
            variant: "outline-danger"
          }
        });
        return;
      }
      this.$refs.simpleRules.validate().then(success => {
        if (success) {
          this.validationErrors = "";
          const fd = new FormData();
          fd.append("image", this.file, this.file.name);
          fd.append("name", this.name);
          fd.append("title", this.title);
          fd.append("percentage", this.percentage);
          fd.append("featured", this.featured);
          AdminApi.addRecord(
            "addStore",
            fd,
            data => {
              if (data.success) {
                this.$toast({
                  component: ToastificationContent,
                  props: {
                    title: "Success!",
                    text: data.message,
                    icon: "UserIcon",
                    variant: "success"
                  }
                });
                router.push({ name: "stores" });
              } else {
                if (data.status == 422) {
                  this.validationErrors = data.message;
                } else {
                  this.$toast({
                    component: ToastificationContent,
                    props: {
                      title: "Failed",
                      text: data.message,
                      icon: "errorIcon",
                      variant: "outline-danger"
                    }
                  });
                }
              }
            },
            err => {
              this.$toast({
                component: ToastificationContent,
                props: {
                  title: "Error!",
                  text: err,
                  icon: "UserIcon",
                  variant: "danger"
                }
              });
            }
          );
        }
      });
    }
  }
};
</script>