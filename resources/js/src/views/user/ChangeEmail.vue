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
                    name="email,"
                    rules="required"
                >
                    <b-form-input
                    v-model="email"
                    :state="errors.length > 0 ? false:null"
                    type="email"
                    placeholder="Your Email"
                    />
                    <small class="text-danger">{{ errors[0] }}</small>
                </validation-provider>
                </b-form-group>
            </b-col>
            <b-col md="6">
                <b-form-group>
                <validation-provider
                    #default="{ errors }"
                    name="repeatEmail"
                    rules="required"
                >
                    <b-form-input
                    v-model="repeatEmail"
                    type="email"
                    :state="errors.length > 0 ? false:null"
                    placeholder="Repeat email"
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
  required, email, confirmed,
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
      required,
      repeatEmail: '',
      email: '',
      confirmed,
      validationErrors: '',
      info: ''
    }
  },
  methods: {
    validationForm() {
      this.$refs.simpleRules.validate().then(success => {
        if (success) {
          AdminApi.updateEmail(
            this.info = {
              "email" : this.email,
              "repeat_email" : this.repeatEmail,
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
              //   this.form.email='';
              //   this.form.repeat_email='';
              //   this.$nextTick(() => {
              //     this.errors.clear();
              //     this.$nextTick(() => {
              //       this.$validator.reset();
              //     });
              // });
              // this.email='';
              //   this.repeatEmail='';
              //   this.$validator.clean();

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