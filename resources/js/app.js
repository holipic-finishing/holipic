
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

import 'babel-polyfill';
import Vue from 'vue'
import Vuetify from 'vuetify'
import * as VueGoogleMaps from 'vue2-google-maps'
import { Vue2Dragula } from 'vue2-dragula'
import VueQuillEditor from 'vue-quill-editor'
import wysiwyg from 'vue-wysiwyg'
import VueBreadcrumbs from 'vue2-breadcrumbs'
import VueResource from 'vue-resource'
import Notifications from 'vue-notification'
import velocity from 'velocity-animate'
import AmCharts from 'amcharts3'
import AmSerial from 'amcharts3/amcharts/serial'
import AmAngularGauge from 'amcharts3/amcharts/gauge'
import Nprogress from 'nprogress'
import VueI18n from 'vue-i18n'
import VueTour from 'vue-tour'
import fullscreen from 'vue-fullscreen'
import InstantSearch from 'vue-instantsearch'
import VueVideoPlayer from 'vue-video-player';
import Croppa from 'vue-croppa';
import VeeValidate from 'vee-validate';


// Import config api URL
import config from './config'

// Import global components
import GlobalComponents from './globalComponents'

// Import App.vue
import App from './App.vue'

// Import router
import router from './router'

// Import themes
import primaryTheme from './themes/primaryTheme';

// Import store
import { store } from './store/store';

// Import firebase
// import './firebase'

// Include script file
import './lib/VuelyScript'

// Include all css files
import './lib/VuelyCss'

// messages
import messages from './lang';

// Header
var access_token = localStorage.getItem('access_token')

// Import Icon
import 'material-design-icons-iconfont/dist/material-design-icons.css'
import '@mdi/font/css/materialdesignicons.css'
import '@fortawesome/fontawesome-free/css/all.css'
import 'font-awesome/css/font-awesome.min.css'

axios.defaults.baseURL = config.BASE_URL;
axios.defaults.headers.common['Authorization'] = access_token;
axios.defaults.headers.post['Content-Type'] = 'application/x-www-form-urlencoded';


// navigation guards before each
// router.beforeEach((to, from, next) => {
// 	Nprogress.start()
// 	if (to.matched.some(record => record.meta.requiresAuth)) {
// 		// this route requires auth, check if logged in
// 		// if not, redirect to login page.
// 		if (localStorage.getItem('user') === null) {
// 			next({
// 				path: '/session/login',
// 				query: { redirect: to.fullPath }
// 			})
// 		} else {
// 			next()
// 		}
// 	} else {
// 		next() // make sure to always call next()!
// 	}
// })

// navigation guard after each
// router.afterEach((to, from) => {
// 	Nprogress.done()
// 	setTimeout(() => {
// 		const contentWrapper = document.querySelector(".v-content__wrap");
// 		if(contentWrapper !== null){
// 			contentWrapper.scrollTop = 0;
// 		}
// 		const boxedLayout = document.querySelector('.app-boxed-layout .app-content');
// 		if(boxedLayout !==  null){
// 			boxedLayout.scrollTop = 0;
// 		}
// 		const miniLayout = document.querySelector('.app-mini-layout .app-content');
// 		if(miniLayout !== null){
// 			miniLayout.scrollTop = 0;
// 		}
// 	}, 200);
// })


// Use Plugins
Vue.use(Vuetify, {
	theme: store.getters.selectedTheme.theme,
	iconfont: 'md' || 'mdi' || 'fa' || 'fa4'
});
Vue.use(InstantSearch);
Vue.use(VueI18n)
Vue.use(AmCharts)
Vue.use(AmSerial)
Vue.use(VueTour)
Vue.use(AmAngularGauge)
Vue.use(Vue2Dragula)
Vue.use(VueQuillEditor)
Vue.use(VueResource)
Vue.use(wysiwyg, {})
Vue.use(VueBreadcrumbs)
Vue.use(Notifications, { velocity })
Vue.use(fullscreen);
Vue.use(GlobalComponents);
Vue.use(VueVideoPlayer);
Vue.use(Croppa);
Vue.use(VueGoogleMaps, {
	load: {
		key: 'AIzaSyBtdO5k6CRntAMJCF-H5uZjTCoSGX95cdk' // Add your here your google map api key
	}
})
Vue.use(VeeValidate);
Vue.use(require('vue-moment'))

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
