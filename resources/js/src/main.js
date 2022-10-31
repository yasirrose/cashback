import _ from 'lodash'
import Vue from 'vue'
import { ToastPlugin, ModalPlugin } from 'bootstrap-vue'
import VueCompositionAPI from '@vue/composition-api'
import VueSweetalert2 from 'vue-sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';

import router from './router'
import store from './store'
import App from './App.vue'
import '../axios'
// import axios from 'axios'

// Global Components
import './global-components'

// 3rd party plugins
import '@/libs/portal-vue'
import '@/libs/toastification'


// BSV Plugin Registration
Vue.use(ToastPlugin)
Vue.use(ModalPlugin)
Vue.use(VueSweetalert2)

// Composition API
Vue.use(VueCompositionAPI)

Vue.use(axios)
// import core styles
require('@core/scss/core.scss')

// import assets styles
require('@/assets/scss/style.scss')

Vue.config.productionTip = false

window._ = _
const getUrl = window.location;
// remove last section for running project as virtual host
const baseUrl =
    getUrl.protocol + '//' + getUrl.host ;
    window.API_URL = baseUrl + '/api/'

new Vue({
  router,
  store,
  axios,
  render: h => h(App),
}).$mount('#app')
