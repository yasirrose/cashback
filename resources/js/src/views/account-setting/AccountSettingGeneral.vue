<template>
  <b-card>
    <!-- media -->
       <b-media no-body>
      <b-media-aside>
        <b-link>
          <b-img
            ref="previewEl"
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
        >
          Upload
        </b-button>
        <b-form-file
          ref="refInputEl"
          accept=".jpg, .png, .gif"
          :hidden="true"
          plain
          @input="inputImageRenderer"
        />
        <!--/ upload button -->

        <!-- reset -->
        <b-button
          v-ripple.400="'rgba(186, 191, 199, 0.15)'"
          variant="outline-secondary"
          size="sm"
          class="mb-75 mr-75"
        >
          Reset
        </b-button>
        <!--/ reset -->
        <b-card-text>Allowed JPG, GIF or PNG. Max size of 800kB</b-card-text>
      </b-media-body>
    </b-media>
    <!--/ media -->

    <!-- form -->
     <validation-observer ref="updateInfoValidate" #default="{invalid}">
      <b-form class="mt-2" @submit.prevent>
        <b-row>
          <b-col sm="6">
            <b-form-group
              label="Username"
              label-for="account-username"
            >
            <validation-provider
              #default="{ errors }"
              name="username"
              rules="required"
            >
              <b-form-input
                v-model="profileInfo.username"
                placeholder="Username"
                name="username"
                :state="errors.length > 0 ? false:null"
              />
              <small class="text-danger">{{ errors[0] }}</small>
            </validation-provider>
            </b-form-group>
          </b-col>
          <b-col sm="6">
            <b-form-group
              label="Name"
              label-for="account-name"
            >
            <validation-provider
              #default="{ errors }"
              name="name"
              rules="required"
            >
              <b-form-input
                v-model="profileInfo.name"
                name="name"
                placeholder="Name"
                :state="errors.length > 0 ? false:null"
              />
              <small class="text-danger">{{ errors[0] }}</small>
            </validation-provider>
            </b-form-group>
          </b-col>
          <b-col sm="6">
            <b-form-group
              label="E-mail"
              label-for="account-e-mail"
            >
            <validation-provider
              #default="{ errors }"
              name="email"
              rules="required|email"
            >
              <b-form-input
                v-model="profileInfo.email"
                name="email"
                placeholder="Email"
                :state="errors.length > 0 ? false:null"
              />
              <small class="text-danger">{{ errors[0] }}</small>
            </validation-provider>
            </b-form-group>
          </b-col>
          <b-col cols="12">
            <b-button
              v-ripple.400="'rgba(255, 255, 255, 0.15)'"
              variant="primary"
              class="mt-2 mr-1"
              @click="validationForm"
            >
              Save changes
            </b-button>
            <b-button
              v-ripple.400="'rgba(186, 191, 199, 0.15)'"
              variant="outline-secondary"
              type="reset"
              class="mt-2"
              @click.prevent="resetForm"
            >
              Reset
            </b-button>
          </b-col>
        </b-row>
      </b-form>
    </validation-observer>
  </b-card>
</template>

<script>
import { ValidationProvider, ValidationObserver } from 'vee-validate'
import { required, email } from '@validations'
import {
  BFormFile, BButton, BForm, BFormGroup, BFormInput, BRow, BCol, BAlert, BCard, BCardText, BMedia, BMediaAside, BMediaBody, BLink, BImg,
} from 'bootstrap-vue'
import Ripple from 'vue-ripple-directive'
import { useInputImageRenderer } from '@core/comp-functions/forms/form-utils'
import { ref } from '@vue/composition-api'
import ToastificationContent from '@core/components/toastification/ToastificationContent.vue'
import Admin from '../../../api/admin' 
export default {
  components: {
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
    ValidationObserver,
  },
  directives: {
    Ripple,
  },
  data() {
    return {
      // optionsLocal: JSON.parse(JSON.stringify(this.generalData)),
      profileFile: null,
      profileInfo : {},
      status: '',
      // validation rules
      required,
      email,
    }
  },
  created(){
    this.getProfileInfo();
  },
  methods: {
    getProfileInfo(){
      Admin.getAdminInfo(
        data =>{
          if(data.success){
            this.profileInfo = data.data;
          }else{
            this.$toast({
              component: ToastificationContent,
              props: {
                title: 'You are not authorized to view this page',
                message: 'You are not authorized to view this page',
                icon: 'errorIcon',
                variant: 'error',
              },
            });
            this.$router.push({ name: 'home'});
          }
        },
        err=>{
          console.log(err);
        }
      )

    },
    validationForm() {
      this.$refs.updateInfoValidate.validate().then(success => {
        if (success) {
          var info = {
            "email" :this.profileInfo.email,
            "name" :this.profileInfo.name,
            "username" :this.profileInfo.username,
          };
          Admin.updateAdminInfo(
            info, 
            data=>{
              if(data.success){
                this.$toast({
                  component: ToastificationContent,
                  props: {
                    title: 'Success!',
                    text: data.message,
                    icon: 'UserIcon',
                    variant: 'success',
                  },
                })
              }else{
                this.$toast({
                  component: ToastificationContent,
                  props: {
                    title: 'Error!',
                    text: 'Cannot update profile.',
                    icon: 'UserIcon',
                    variant: 'danger',
                  },
                })
              }
            },
            err=>{
              this.$toast({
                component: ToastificationContent,
                props: {
                  title: 'Error!',
                  text: err,
                  icon: 'UserIcon',
                  variant: 'danger',
                },
              })
            }
          )
        }
      })
    },
    resetForm() {
      this.profileInfo = "";
    },

  },
  setup() {
    const refInputEl = ref(null)
    const previewEl = ref(null)

    const { inputImageRenderer } = useInputImageRenderer(refInputEl, previewEl)

    return {
      refInputEl,
      previewEl,
      inputImageRenderer,
    }
  },
}
</script>
