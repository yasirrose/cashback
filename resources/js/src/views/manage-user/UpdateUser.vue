<template>
  <b-row>
    <b-col cols="12">
      <b-card-code title="Update User Profile">
        <div v-if="validationErrors">
            <ul class="alert alert-danger">
                <li v-for="(value, key, index) in validationErrors">{{ value }}</li>
            </ul>
        </div>
        <validation-observer ref="simpleRules">
        <b-form>
            <b-row>
            <b-col md="6">
                <b-form-group>
                <validation-provider
                    #default="{ errors }"
                    name="first_name"
                    rules="required"
                >
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
                <validation-provider
                    #default="{ errors }"
                    name="last_name"
                    rules="required"
                >
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
                <validation-provider
                    #default="{ errors }"
                    name="username"
                    rules="required"
                >
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
                <validation-provider
                    #default="{ errors }"
                    name="email"
                    rules="required"
                >
                    <b-form-input
                    v-model="email"
                    :state="errors.length > 0 ? false:null"
                    type="email"
                    placeholder="Please Enter Email"
                    />
                    <small class="text-danger">{{ errors[0] }}</small>
                </validation-provider>
                </b-form-group>
            </b-col>
          
            
            <b-col>
                <b-button
                variant="primary"
                type="submit"
                @click.prevent="validationForm"
                >
                Submit
                </b-button>
            </b-col>
            </b-row>
        </b-form>
        </validation-observer>
    </b-card-code>
    </b-col>
  </b-row>
</template>
<script>
import BCardCode from '@core/components/b-card-code'
import { ValidationProvider, ValidationObserver } from 'vee-validate'
import {
  BFormInput, BFormGroup, BForm, BRow, BCol, BButton, BFormSelect, BFormCheckbox 
} from 'bootstrap-vue'
import {
  required, email, confirmed,
} from '@validations'
import AdminApi from '../../../api/admin'
import ToastificationContent from '@core/components/toastification/ToastificationContent.vue'
import router from '@/router'

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
    BFormCheckbox
  },
  data() {
    return {
      required,
      email: '',
      confirmed,
      validationErrors: '',
      info: '',
      first_name:'',
      last_name:'',
      username:'',

      isAccountSummary: 0,
      isRandomPassword: 0,
      isChangePassword: 0,
      userId:this.$route.params.id
    }
  },
    created() {
    this.getUserProfile();
  },
  methods: {
      getUserProfile() {
         
      AdminApi.getRow(
          'getUserProfile',
          this.userId,
        data => {
             const resp = data.data;
             this.first_name = resp.first_name;
             this.last_name = resp.last_name;
             this.username = resp.username;
             this.email = resp.email;
        },
        err => {
          console.log(err);
        }
      );
    },
      validationForm() {
      this.$refs.simpleRules.validate().then(success => {
        if (success) {
          this.validationErrors = '';
          AdminApi.updateUserProfile(
            this.info = {
              "first_name" : this.first_name,
              "last_name" : this.last_name,
              "username" : this.username,
              "email" : this.email,
              "id" : this.userId,
    
            //   "isAccountSummary" : this.isAccountSummary,
            //   "isRandomPassword" : this.isRandomPassword,
            //   "isChangePassword" : this.isChangePassword,
              
            },
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
                router.push({ name: 'user-accounts' })
              }else{
                if (data.status == 422){
                  this.validationErrors = data.message;
                } else {
                  this.$toast({
                    component: ToastificationContent,
                    props: {
                      title: 'Failed',
                      text: data.message,
                      icon: 'errorIcon',
                      variant: 'outline-danger',
                    },
                  })
                }
              }
            },
            err=>{
              console.log(err);
            }
          )
        }
      })
    },
  },
}
</script>