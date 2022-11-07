<template>
  <div class="auth-wrapper auth-v1 px-2">
    <div class="auth-inner py-2">

      <!-- Forgot Password v1 -->
      <b-card class="mb-0">
        <b-link class="brand-logo">
          <!-- logo -->
          <!-- <b-img
          :src="appLogoImage"
          alt="logo"
        /> -->
        </b-link>
        
        <b-card-title class="mb-1">
          Forgot Password? 🔒
        </b-card-title>
        <b-card-text class="mb-2">
          Enter your email and we'll send you instructions to reset your password
        </b-card-text>

        <!-- form -->
        <validation-observer ref="simpleRules">
          <b-form
            class="auth-forgot-password-form mt-2"
            @submit.prevent="validationForm"
          >
            <!-- email -->
            <b-form-group
              label="Email"
              label-for="forgot-password-email"
            >
              <validation-provider
                #default="{ errors }"
                name="Email"
                rules="required|email"
              >
                <b-form-input
                  id="forgot-password-email"
                  v-model="userEmail"
                  :state="errors.length > 0 ? false:null"
                  name="forgot-password-email"
                  placeholder="john@example.com"
                />
                <small class="text-danger">{{ errors[0] }}</small>
              </validation-provider>
            </b-form-group>

            <!-- submit button -->
            <b-button
              variant="primary"
              block
              type="submit"
            >
              Send reset link
            </b-button>
          </b-form>
        </validation-observer>

        <b-card-text class="text-center mt-2">
          <b-link :to="{name:'login'}">
            <feather-icon icon="ChevronLeftIcon" /> Back to login
          </b-link>
        </b-card-text>

      </b-card>
    <!-- /Forgot Password v1 -->
    </div>
  </div>
</template>

<script>
import { ValidationProvider, ValidationObserver } from 'vee-validate'
import VuexyLogo from '@core/layouts/components/Logo.vue'
import { BCard, BLink, BImg, BCardText, BCardTitle, BFormGroup, BFormInput, BForm, BButton } from 'bootstrap-vue'
import { required, email } from '@validations'
import AdminApi from "../../api/admin";
export default {
  components: {
    VuexyLogo,
    BCard,
    BLink,
    BImg,
    BCardText,
    BCardTitle,
    BFormGroup,
    BFormInput,
    BButton,
    BForm,
    ValidationProvider,
    ValidationObserver,
  },
  data() {
    return {
      appLogoImage: require('@/assets/images/logo/logo.png'),
      userEmail: '',
      // validation
      required,
      email,
      validationErrors: "",
    }
  },
  methods: {
    validationForm() {
      this.$refs.simpleRules.validate().then(success => {
        if (success) {
          
          this.validationErrors = "";
          
          AdminApi.forgotPassword(
            (this.info = {
              email: this.userEmail,
            }),
            data => {
              if (data) {
                this.$toast({
                  component: ToastificationContent,
                  props: {
                    title: "Success!",
                    text: 'we have sent you an email with password reset link',
                    icon: "UserIcon",
                    variant: "success"
                  }
                });
                //router.push({ name: "reset-password" });
               } 
              //else {
              //   if (data.status == 422) {
              //     this.validationErrors = data.message;
              //   } else {
              //     this.$toast({
              //       component: ToastificationContent,
              //       props: {
              //         title: "Failed",
              //         text: 'Something went Wrong',
              //         icon: "errorIcon",
              //         variant: "outline-danger"
              //       }
              //     });
              //   }
              // }
            },
            err => {
              console.log(err);
            }
          );

          
        }
        else{
          //this.$router.push({ name: 'reset-password' })
        }
      })
    },
  },
}
</script>

<style lang="scss">
@import '~@core/scss/vue/pages/page-auth.scss';
</style>
