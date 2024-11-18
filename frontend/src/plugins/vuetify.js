import Vue from 'vue'
import Vuetify from 'vuetify'
import 'vuetify/dist/vuetify.min.css'
import '@mdi/font/css/materialdesignicons.css'; 
import colors from 'vuetify/lib/util/colors'

Vue.use(Vuetify)

const opts = {
    icons: {
        iconfont: "mdi",
    }, 
    theme: {
        themes : {
            light: {
                primary : colors.shades.black,
            }
        }
    }
}

export default new Vuetify(opts)