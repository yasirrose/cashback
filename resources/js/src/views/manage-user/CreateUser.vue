<template>
  <b-row>
    <b-col cols="12">
      <b-card-code title="Update Email Address">
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
            <b-col md="6">
                <b-form-group>
                <validation-provider
                    #default="{ errors }"
                    name="password"
                    vid="password">
                    <b-form-input
                    v-model="password"
                    type="password"
                    :state="errors.length > 0 ? false:null"
                    placeholder="Your Password"
                    />
                    <small class="text-danger">{{ errors[0] }}</small>
                </validation-provider>
                </b-form-group>
            </b-col>
            <b-col md="6">
                <b-form-group>
                <validation-provider
                    #default="{ errors }"
                    name="passwordConfirm">
                    <b-form-input
                    v-model="passwordConfirm"
                    :state="errors.length > 0 ? false:null"
                    type="password"
                    placeholder="Confirm Password"
                    />
                    <small class="text-danger">{{ errors[0] }}</small>
                </validation-provider>
                </b-form-group>
            </b-col>
            <b-col md="6">
                <b-form-group>
                    <div>
                        <b-form-select
                            v-model="status"
                            :options="options"
                        />
                    </div>
                </b-form-group>
            </b-col>
            <b-col md="12">
                <b-form-group>
                    <b-form-checkbox v-model="isChangePassword">Forces the user to change their Password on next login</b-form-checkbox>
                </b-form-group>
            </b-col>
            <b-col md="12">
                <b-form-group>
                    <b-form-checkbox v-model="isRandomPassword">Generate a random Password which will be emailed to the user automatically</b-form-checkbox>
                </b-form-group>
            </b-col>
            <b-col md="12">
                <b-form-group>
                    <b-form-checkbox v-model="isAccountSummary">Send account summary to user</b-form-checkbox>
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
      passwordConfirm: '',
      password: '',
      email: '',
      confirmed,
      validationErrors: '',
      info: '',
      first_name:'',
      last_name:'',
      username:'',
      options: [
        { value: null, text: 'Please select an option' },
        { value: 1, text: 'Enabled' },
        { value: 0, text: 'Disabled' },
      ],
      status: null,
      isAccountSummary: 0,
      isRandomPassword: 0,
      isChangePassword: 0,
    }
  },
  methods: {
      validationForm() {
      this.$refs.simpleRules.validate().then(success => {
        if (success) {
          this.validationErrors = '';
          AdminApi.createUser(
            this.info = {
              "first_name" : this.first_name,
              "last_name" : this.last_name,
              "username" : this.username,
              "email" : this.email,
              "password" : this.password,
              "confirm_password" : this.passwordConfirm,
              "isAccountSummary" : this.isAccountSummary,
              "isRandomPassword" : this.isRandomPassword,
              "isChangePassword" : this.isChangePassword,
              "status" : this.status,
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