<template>
  <b-row>
    <b-col cols="12">
      <b-card-code title="Add Cashback">
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
                  <validation-provider #default="{ errors }" name="User" rules="required">
                    <b-form-select
                      :state="errors.length > 0 ? false:null"
                      v-model="userId"
                      :options="users"
                    />
                  </validation-provider>
                </b-form-group>
              </b-col>
              <b-col md="6">
                <b-form-group>
                  <validation-provider
                    #default="{ errors }"
                    name="Cashback Amount"
                    rules="required"
                  >
                    <b-form-input
                      v-model="amount"
                      :state="errors.length > 0 ? false:null"
                      type="number"
                      placeholder="Please Enter Cashback Amount"
                    />
                    <small class="text-danger">{{ errors[0] }}</small>
                  </validation-provider>
                </b-form-group>
              </b-col>

              <b-col md="6">
                <b-form-group>
                  <validation-provider #default="{ errors }" name="Affiliate URL" rules="required">
                    <b-form-textarea
                      v-model="affiliateUrl"
                      :state="errors.length > 0 ? false:null"
                      size="sm"
                      placeholder="Please Enter Affiliate URL"
                    ></b-form-textarea>
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
  BFormInput,
  BFormGroup,
  BForm,
  BRow,
  BCol,
  BButton,
  BFormSelect,
  BFormCheckbox,
  BFormTextarea
} from "bootstrap-vue";
import { required, email, confirmed } from "@validations";
import AdminApi from "../../../api/admin";
import ToastificationContent from "@core/components/toastification/ToastificationContent.vue";
import router from "@/router";

export default {
  components: {
    BCardCode,
    ValidationProvider,
    ValidationObserver,
    BFormInput,
    BFormTextarea,
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
      userId: null,
      amount: "",
      affiliateUrl: "",
      users: [{ value: null, text: "Please select a user" }],
      validationErrors: "",
      info: ""
    };
  },
  created() {
    this.getUsers();
  },
  methods: {
    getUsers() {
      AdminApi.getUsers(
        data => {
          
          const users = data.data;
          const length = users.length;
          for (let i = 0; i < length; i++) {
            this.users.push({
              value: users[i]["id"],
              text: users[i]["username"]
            });
          }
          
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
          //   this.info = {
          //       user_id: this.userId,
          //       amount: this.amount,
          //       affiliate_url: this.affiliateUrl,
          //     }
          //     console.log(this.info);
          //     return;
          AdminApi.addRecord(
            "addCashback",
            (this.info = {
              user_id: this.userId,
              amount: this.amount,
              affiliate_url: this.affiliateUrl
            }),
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
                router.push({ name: "cashbacks" });
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
              console.log(err);
            }
          );
        }
      });
    }
  }
};
</script>