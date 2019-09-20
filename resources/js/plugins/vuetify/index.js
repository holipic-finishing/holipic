import 'material-design-icons-iconfont/dist/material-design-icons.css'
import '@mdi/font/css/materialdesignicons.css'
import '@fortawesome/fontawesome-free/css/all.css'
import 'font-awesome/css/font-awesome.min.css'

import Vue from 'vue'
import Vuetify from 'vuetify'
import 'vuetify/dist/vuetify.min.css'
import { store } from '../../store/store'

Vue.use(Vuetify)

const opts = {
    iconfont: 'md' || 'mdi' || 'fa' || 'fa4',
    theme: store.getters.selectedTheme.theme,

}

export default new Vuetify(opts)


