import Vue from 'vue'
import Vuex from 'vuex'

// modules
import auth from './modules/auth';
// import chat from './modules/chat';
import settings from './modules/settings';
import ecommerce from './modules/ecommerce';
import mail from './modules/mail';
import sidebar from './modules/sidebar';
import webnotification from './modules/push-notification'

Vue.use(Vuex);

export const store = new Vuex.Store({
    modules: {
        auth,   
        settings,
        ecommerce,
        mail,
        sidebar,
        webnotification
    }
})
