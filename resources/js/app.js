
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');
import 'babel-polyfill';
import Vue from 'vue'

/**
 * Import Vue Plugins
 */
import Vuetify from 'vuetify'
import VueBreadcrumbs from 'vue2-breadcrumbs'
import Notifications from 'vue-notification'
import velocity from 'velocity-animate'
import VueI18n from 'vue-i18n'
import Fullscreen from 'vue-fullscreen'
import VueOffline from 'vue-offline'
import VuejsClipper from 'vuejs-clipper'

import router from './router'
import { store } from './store/store'

import 'material-design-icons-iconfont/dist/material-design-icons.css'
import '@mdi/font/css/materialdesignicons.css'
import '@fortawesome/fontawesome-free/css/all.css'
import 'font-awesome/css/font-awesome.min.css'

import config from './config'
import globalComponents from './globalComponents'
import primaryTheme from './themes/primaryTheme'
// import './lib/vuelyScript';
// import './lib/vuelyCss';

/* ======= All App File Include Here ======= */
// Vuetify Css
import 'vuetify/dist/vuetify.css'

// nprogress
import 'nprogress/nprogress.css'

// Icon Files
import '../assets/themify-icons/themify-icons.css'

// leaflet map css
import 'leaflet/dist/leaflet.css'

// Slick Slider
import "slick-carousel/slick/slick.css";
import "slick-carousel/slick/slick-theme.css";

// animate css
import '../assets/animate.css';

// Global Scss File
import '../assets/scss/_style.scss'


import messages from './lang';
import App from './App.vue'

var access_token = localStorage.getItem('access_token')
axios.defaults.baseURL = config.BASE_URL;
axios.defaults.headers.common['Authorization'] = access_token;
axios.defaults.headers.post['Content-Type'] = 'application/x-www-form-urlencoded';


Vue.use(Vuetify, {
	theme: store.getters.selectedTheme.theme,
	iconfont: 'md' || 'mdi' || 'fa' || 'fa4'
});
Vue.use(VueI18n)
Vue.use(VueBreadcrumbs)
Vue.use(Notifications, { velocity })
Vue.use(Fullscreen);
Vue.use(require('vue-moment'))
Vue.use(VueOffline)
Vue.use(VuejsClipper)
Vue.use(globalComponents);


// Create VueI18n instance with options
const i18n = new VueI18n({
	locale: store.getters.selectedLocale.locale, // set locale
	messages, // set locale messages
})

/* eslint-disable no-new */
new Vue({
	store,
	i18n,
	router,
	template: '<app></app>',
	// render: h => h(App),
	components: { App }
}).$mount('#app')
