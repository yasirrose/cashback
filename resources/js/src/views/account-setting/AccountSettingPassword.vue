<template>
  <b-card>
    <!-- form -->
    <validation-observer ref="updatePasswordValidate" #default="{invalid}">
      <b-form @submit.prevent>
        <b-row>
          <!-- old password -->
          <b-col md="6">
           
            <b-form-group
              label="Old Password"
              label-for="account-old-password"
            >
            <validation-provider
              #default="{ errors }"
              name="old Password"
              rules="required"
            >
              <b-input-group class="input-group-merge">
             
                <b-form-input
                  id="account-old-password"
                  v-model="passwordValueOld"
                  name="old-password"
                  :type="passwordFieldTypeOld"
                  placeholder="Old Password"
                />
               
                <b-input-group-append is-text>
                  <feather-icon
                    :icon="passwordToggleIconOld"
                    class="cursor-pointer"
                    @click="togglePasswordOld"
                  />
                </b-input-group-append>
              </b-input-group>
              <small class="text-danger">{{ errors[0] }}</small>
            </validation-provider>
            </b-form-group>
             
          </b-col>
          <!--/ old password -->
        </b-row>
        <b-row>
          <!-- new password -->
          <b-col md="6">
            <b-form-group
              label-for="account-new-password"
              label="New Password"
            >
            <validation-provider
              #default="{ errors }"
              name="new password"
              rules="required"
            >
              <b-input-group class="input-group-merge">
                <b-form-input
                  id="account-new-password"
                  v-model="newPasswordValue"
                  :type="passwordFieldTypeNew"
                  name="new-password"
                  placeholder="New Password"
                />
                <b-input-group-append is-text>
                  <feather-icon
                    :icon="passwordToggleIconNew"
                    class="cursor-pointer"
                    @click="togglePasswordNew"
                  />
                </b-input-group-append>
              </b-input-group>
              <small class="text-danger">{{ errors[0] }}</small>
            </validation-provider>
            </b-form-group>
          </b-col>
          <!--/ new password -->

          <!-- retype password -->
          <b-col md="6">
            <b-form-group
              label-for="account-retype-new-password"
              label="Retype New Password"
            >
            <validation-provider
              #default="{ errors }"
              name="retype password"
              rules="required"
            >
              <b-input-group class="input-group-merge">
                <b-form-input
                  id="account-retype-new-password"
                  v-model="retypePassword"
                  :type="passwordFieldTypeRetype"
                  name="retype-password"
                  placeholder="New Password"
                />
                <b-input-group-append is-text>
                  <feather-icon
                    :icon="passwordToggleIconRetype"
                    class="cursor-pointer"
                    @click="togglePasswordRetype"
                  />
                </b-input-group-append>
              </b-input-group>
              <small class="text-danger">{{ errors[0] }}</small>
            </validation-provider>
            </b-form-group>
          </b-col>
          <!--/ retype password -->

          <!-- buttons -->
          <b-col cols="12">
            <b-button
              v-ripple.400="'rgba(255, 255, 255, 0.15)'"
              variant="primary"
              class="mt-1 mr-1"
              @click="validationForm"
            >
              Save changes
            </b-button>
            <b-button
              v-ripple.400="'rgba(186, 191, 199, 0.15)'"
              type="reset"
              variant="outline-secondary"
              class="mt-1"
            >
              Reset
            </b-button>
          </b-col>
          <!--/ buttons -->
        </b-row>
      </b-form>
    </validation-observer>
  </b-card>
</template>

<script>
import { ValidationProvider, ValidationObserver } from 'vee-validate'
import { required, length } from '@validations'
import {
  BButton, BForm, BFormGroup, BFormInput, BRow, BCol, BCard, BInputGroup, BInputGroupAppend,
} from 'bootstrap-vue'
import Ripple from 'vue-ripple-directive'
import ToastificationContent from '@core/components/toastification/ToastificationContent.vue'
import Admin from '../../../api/admin' 

export default {
  components: {
    BButton,
    BForm,
    BFormGroup,
    BFormInput,
    BRow,
    BCol,
    BCard,
    BInputGroup,
    BInputGroupAppend,
    ValidationProvider,
    ValidationObserver,
  },
  directives: {
    Ripple,
  },
  data() {
    return {
      passwordValueOld: '',
      newPasswordValue: '',
      retypePassword: '',
      passwordFieldTypeOld: 'password',
      passwordFieldTypeNew: 'password',
      passwordFieldTypeRetype: 'password',
    }
  },
  computed: {
    passwordToggleIconOld() {
      return this.passwordFieldTypeOld === 'password' ? 'EyeIcon' : 'EyeOffIcon'
    },
    passwordToggleIconNew() {
      return this.passwordFieldTypeNew === 'password' ? 'EyeIcon' : 'EyeOffIcon'
    },
    passwordToggleIconRetype() {
      return this.passwordFieldTypeRetype === 'password' ? 'EyeIcon' : 'EyeOffIcon'
    },
  },
  methods: {
    togglePasswordOld() {
      this.passwordFieldTypeOld = this.passwordFieldTypeOld === 'password' ? 'text' : 'password'
    },
    togglePasswordNew() {
      this.passwordFieldTypeNew = this.passwordFieldTypeNew === 'password' ? 'text' : 'password'
    },
    togglePasswordRetype() {
      this.passwordFieldTypeRetype = this.passwordFieldTypeRetype === 'password' ? 'text' : 'password'
    },
    validationForm() {
      this.$refs.updatePasswordValidate.validate().then(success => {
        if (success) {
          var info = {
            "oldPassword" :this.passwordValueOld,
            "newPassword" :this.newPasswordValue,
            "confirmPassword" :this.retypePassword,
          };
          Admin.updatePassword(
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
                    text: data.data,
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
  },
}
</script>
