<template>
  <b-card>
    <div v-if="validationErrors">
            <ul class="alert alert-danger">
                <li v-for="(value, key, index) in validationErrors">{{ value }}</li>
            </ul>
      </div>
    <!-- media -->
       <b-media no-body>
      <b-media-aside>
        <b-link v-if="pic">
              <b-img ref=""
              :src="pic"
               rounded height="80"/>
            </b-link>
            <b-link v-else-if="picture">
              <b-img ref=""
               :src="require(`../../../../../public/image/${picture}`)"
               rounded height="80"/>
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
          Upload App Logo
        </b-button>
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
    <!--/ media -->

    <!-- form -->
     <validation-observer ref="simpleRules">
      <b-form class="mt-2" @submit.prevent>
        <b-row>
          
          <b-col cols="12">
            <b-button
                variant="primary"
                type="submit"
                @click.prevent="validationForm"
                >
                Save Changes
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
//import { useInputImageRenderer } from '@core/comp-functions/forms/form-utils'
import { ref } from '@vue/composition-api'
import ToastificationContent from '@core/components/toastification/ToastificationContent.vue'
import AdminApi from '../../../api/admin'
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
      required,
      validationErrors: '',
      picture:'',
      pic:null,
      file:null,
    }
  },
  created(){
    this.getAppSetting();
  },
  methods: {
    uploadFile(e)
    {
      //console.log(e)
      this.file = e.target.files[0];
      this.pic = URL.createObjectURL(this.file);
      console.log(this.file);
    },
    getAppSetting(){
      AdminApi.getRow(
        'getAppSetting',
        1,
        data =>{
          if(data.success){
            this.picture = data.data.logo;
          }else{
            this.$toast({
              component: ToastificationContent,
              props: {
                title: 'Error',
                message: 'Something went wrong',
                icon: 'errorIcon',
                variant: 'error',
              },
            });
            //this.$router.push({ name: 'home'});
          }
        },
        err=>{
          console.log(err);
        }
      )

    },
    validationForm() {
      this.$refs.simpleRules.validate().then(success => {
        if (success) {
          this.validationErrors = '';
          const fd = new FormData();
          fd.append('image', this.file, this.file.name);
          fd.append('test', 'testing');
          AdminApi.updateRecord(
            'updateAppSetting',
            fd, 
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
                //router.push({ name: 'user-accounts' })
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
