<template>
  <b-row>
    <b-col cols="12">
      <b-card-code title="Update Profile">
        <validation-observer ref="simpleRules">
        <b-form>
            <b-row>
            <b-col md="12">
                <b-form-group>
                <validation-provider
                    #default="{ errors }"
                    name="name"
                    rules="required|name"
                >
                    <b-form-input
                    v-model="name"
                    :state="errors.length > 0 ? false:null"
                    type="text"
                    placeholder="Your Name"
                    />
                    <small class="text-danger">{{ errors[0] }}</small>
                </validation-provider>
                </b-form-group>
            </b-col>
            <b-col md="12">
                <b-form-group>
                <validation-provider
                    #default="{ errors }"
                    name="email"
                    vid="email"
                    rules="required|email"
                >
                    <b-form-input
                    v-model="email"
                    type="text"
                    :state="errors.length > 0 ? false:null"
                    placeholder="your Email"
                    />
                    <small class="text-danger">{{ errors[0] }}</small>
                </validation-provider>
                </b-form-group>
            </b-col>
            <b-col md="12">
                <b-form-group>
                <validation-provider
                    #default="{ errors }"
                    name="comment"
                    vid="comment"
                    rules="required|comment"
                >
                    <b-form-input
                    v-model="comment"
                    type="textarea"
                    :state="errors.length > 0 ? false:null"
                    placeholder="your Comment"
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
        name: '',
        email: '',
        comment: '',
        }
    },
    methods: {
        validationForm() {
        this.$refs.simpleRules.validate().then(success => {
            if (success) {
            alert('form submitted!')
            }
        })
        },
    },
    }
</script>