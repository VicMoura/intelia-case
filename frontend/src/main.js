import Vue from 'vue'
import App from './App.vue'
import vuetify from '@/plugins/vuetify'
import router from "./router/router.js";
import VueTheMask from 'vue-the-mask'

import './assets/styles/global.css';
import store from "./store"; 

//helpers
import './helpers/validators'
import './helpers/mask'
import { clearData } from './helpers/clearData';
import './helpers/aviso.js'

Vue.prototype.$clearData = clearData;
Vue.config.productionTip = false
Vue.use(VueTheMask);

new Vue({
  vuetify,
  store, 
  router,
  render: h => h(App),
  data() {
    return {
        //Avisos
        gAviso : false,
        gAvisoError: false,
        gAvisoMsg: ""
    }
  }
}).$mount('#app')
