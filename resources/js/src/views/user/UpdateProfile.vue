<template>
  <b-row>
    <b-col cols="12">
      <b-card-code title="Update Profile">
        <div v-if="validationErrors">
          <ul class="alert alert-danger">
            <li v-for="(value, key, index) in validationErrors">{{ value }}</li>
          </ul>
        </div>
        <!-- media -->
        <b-media no-body>
          <b-media-aside>
            <b-link v-if="pic">
              <b-img ref :src="pic" rounded height="80"/>
            </b-link>
            <b-link v-else-if="picture">
              <b-img ref :src="`/image/${picture}`" rounded height="80"/>
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
            >Upload Image</b-button>
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
        <br>
        
        <!--/ media -->
        <validation-observer ref="simpleRules">
          <b-form>

            <b-row>
              <b-col md="6">
                <b-form-group>
                  <validation-provider #default="{ errors }" name="first_name" rules="required">
                    <b-form-input
                      v-model="first_name"
                      :state="errors.length > 0 ? false:null"
                      type="text"
                      placeholder="Please Enter First Name"
                    />
                    <small class="text-danger">{{ errors[0] }}</small>
                  </validation-provider>
                </b-form-group>
              </b-col>
              <b-col md="6">
                <b-form-group>
                  <validation-provider #default="{ errors }" name="last_name" rules="required">
                    <b-form-input
                      v-model="last_name"
                      :state="errors.length > 0 ? false:null"
                      type="text"
                      placeholder="Please Enter Last Name"
                    />
                    <small class="text-danger">{{ errors[0] }}</small>
                  </validation-provider>
                </b-form-group>
              </b-col>
              <b-col md="6">
                <b-form-group>
                  <validation-provider #default="{ errors }" name="username" rules="required">
                    <b-form-input
                      v-model="username"
                      :state="errors.length > 0 ? false:null"
                      type="text"
                      placeholder="Please Enter Username"
                    />
                    <small class="text-danger">{{ errors[0] }}</small>
                  </validation-provider>
                </b-form-group>
              </b-col>

              <b-col md="6">
                <b-form-group>
                  <validation-provider #default="{ errors }" name="email" rules="required">
                    <b-form-input
                      disabled="disabled"
                      v-model="email"
                      :state="errors.length > 0 ? false:null"
                      type="email"
                      placeholder="Please Enter Email"
                    />
                    <small class="text-danger">{{ errors[0] }}</small>
                  </validation-provider>
                </b-form-group>
              </b-col>

              <!-- submit button -->
              <b-col>
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
  BFormInput,
  BFormGroup,
  BForm,
  BRow,
  BCol,
  BButton,
  BFormSelect,
  BCard,
  BCardText,
  BMedia,
  BMediaAside,
  BMediaBody,
  BFormFile,
  BLink,
  BImg,
} from "bootstrap-vue";
import Ripple from "vue-ripple-directive";
import { ref } from "@vue/composition-api";
import { required, email, confirmed } from "@validations";
import AdminApi from "../../../api/admin";
import ToastificationContent from "@core/components/toastification/ToastificationContent.vue";

export default {
  components: {
    BCardCode,
    ValidationProvider,
    ValidationObserver,
    BFormInput,
    BFormGroup,
    BForm,
    BRow,
    BCol,
    BButton,
    BFormSelect,
    BCard,
    BCardText,
    BMedia,
    BMediaAside,
    BMediaBody,
    BFormFile,
    BLink,
    BImg,
  },
   directives: {
    Ripple
  },
  data() {
    return {
      required,
      email: "",
      confirmed,
      validationErrors: "",
      info: "",
      first_name: "",
      last_name: "",
      username: "",
      picture: "",
      pic: null,
      file: null
    };
  },
  created() {
    this.getAdminInfo();
  },
  methods: {
    uploadFile(e) {
      this.file = e.target.files[0];
      this.pic = URL.createObjectURL(this.file);
     
    },
    getAdminInfo() {
      AdminApi.getRecords(
        "getAdminInfo",
        data => {
          const resp = data.data;
          this.first_name = resp.first_name;
          this.last_name = resp.last_name;
          this.username = resp.username;
          this.email = resp.email;
          this.picture = resp.image;
        },
        err => {
          console.log(err);
        }
      );
    },
    validationForm() {
      this.$refs.simpleRules.validate().then(success => {
        if (success) {
          this.validationErrors = "";
          const fd = new FormData();
          if (this.file != null) {
            fd.append("image", this.file, this.file.name);
          }
          fd.append("first_name", this.first_name);
          fd.append("last_name", this.last_name);
          fd.append("username", this.username);
          fd.append("email", this.email);
          AdminApi.updateAdminInfo(
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
                //router.push({ name: "user-accounts" });
              } else {
                if (data.status == 422) {
                  this.validationErrors = data.message;
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
              }
            },
            err => {
              console.log(err);
            }
          );
        }
      });
    }
  }
};
</script>