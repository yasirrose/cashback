<template>
  <b-row>
    <b-col cols="12">
      <b-card-code title="Update Password">
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
                    name="Old Password"
                    rules="required"
                >
                    <b-form-input
                    v-model="old_password"
                    type="password"
                    :state="errors.length > 0 ? false:null"
                    placeholder="Old Password"
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
                    vid="password"
                    rules="required|password"
                >
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
                    name="passwordConfirm"
                    rules="required|confirmed:password"
                >
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

            <!-- submit button -->
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
  BFormInput, BFormGroup, BForm, BRow, BCol, BButton,
} from 'bootstrap-vue'
import {
  required, email, confirmed, password,
} from '@validations'
import AdminApi from '../../../api/admin'
import ToastificationContent from '@core/components/toastification/ToastificationContent.vue'

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
  },
  data() {
    return {
      emailValue: '',
      old_password: '',
      passwordConfirm: '',
      required,
      password: '',
      email,
      confirmed,
      info: '',
      validationErrors: ''
    }
  },
  methods: {
    validationForm() {
      this.$refs.simpleRules.validate().then(success => {
        if (success) {
          AdminApi.updatePassword(
            this.info = {
              "old_password" : this.old_password,
              "password" : this.password,
              "confirm_password" : this.passwordConfirm
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
                // this.password='';
                // this.old_password='';
                // this.passwordConfirm='';
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