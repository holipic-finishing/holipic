import Vue from 'vue'
import Router from 'vue-router'
import Nprogress from 'nprogress'

/////////////////////////////////////////////////////////////////////
////////////////////////////  ROUTES  ///////////////////////////////
/////////////////////////////////////////////////////////////////////
import AuthRoutes from './auth';
import SuperAdminRoutes from './super-admin';
import CompanyAdminRoutes from './company-admin';
import BranchAdminRoutes from './branch-admin';
import CustomerRoutes from './customer';
import ShopSellingRoutes from './shop-selling';

// Dashboard components
import mini from '../container/MiniSidebarLayout.vue'

import PageNotFound from '../views/partials/pages/page404'

import Room from '../views/shop-selling/room/index.vue'
import BookingConfirm from '../views/shop-selling/BookingConfirm.vue'
import ShopSellingLogin from '../views/shop-selling/Login.vue'
import ShopSellingDashboard from '../views/shop-selling/Dashboard.vue'
import CustomerLogin from '../views/customer/Login.vue'
import CustomerResetPassword from '../views/customer/ResetPassword.vue'

Vue.use(Router)

var routers = [];
routers = [
	ShopSellingRoutes,
	CustomerRoutes,
	AuthRoutes,
	SuperAdminRoutes,
	CompanyAdminRoutes,
	BranchAdminRoutes,
	{
    	path: '/room-tab',
    	component: Room
  	},
  	{
  		path:'/shop-selling/confirm-booking',
  		component: BookingConfirm
  	},
  	{
  		path:'/shop-selling/login',
  		component: ShopSellingLogin
  	},
  	{
  		path:'/shop-selling/dashboard',
  		component: ShopSellingDashboard,
  		meta: {
  			shopSellingAuth: true
  		}
  	},
  	{
  		path:'/customer/login',
  		component: CustomerLogin,
  		name: 'CustomerLogin'
  	},
  	{
  		path:'/customer/reset-password',
  		component: CustomerResetPassword
  	},
	{
    	// Page Not Found
    	path: '*',
    	component: PageNotFound
  	}
];

var router = new Router({
    mode: 'history',
    routes: routers,
});

// ------------------------------------------------------------------------------------
// ------------------ Config Navigations guards before each v2 ------------------------
// ------------------------------------------------------------------------------------

router.beforeEach((to, from, next) => { 
	Nprogress.start()

	if(to.meta.requiresAuth) {
		const authUser = JSON.parse(localStorage.getItem('user'))
		const token = localStorage.getItem('access_token')

		if(!authUser) {
				next({
					path: '/login'
				})
		}
		else if(to.meta.adminAuth) {
			const authUser = JSON.parse(localStorage.getItem('user'))
			if(authUser.role_id == "1" ){
				next()
			} else {
				next({
					path:'/company-admin/dashboard',
				})
			}
		} else if(to.meta.companyAuth) {
			const authUser = JSON.parse(localStorage.getItem('user'))		
			if(authUser.role_id == "2"){
				next()
			} else {
  				next({
					path:'/super-admin/dashboard',
				})
			}
		} else if(to.meta.branchAuth) {
			const authUser = JSON.parse(localStorage.getItem('user'))
			if(authUser.role_id == "3"){
				next()
			} else {
  				next({
					path:'/branch-admin/dashboard',
				})
			}
		} 
	} else {
		if(to.path === '/login'){
			const authUser = JSON.parse(localStorage.getItem('user'))
			const token = localStorage.getItem('access_token')
			if(authUser) {
				if(authUser.role_id == "1" ){
					next({
						path:'/super-admin/dashboard',
					})
				} else if(authUser.role_id == "2") {
					next({
						path:'/company-admin/dashboard',
					})
				} else if(authUser.role_id == "3") {
					next({
						path:'/branch-admin/dashboard',
					})
				}
			}	
		} 
		if(to.path === '/customer/login') {
			const customer = JSON.parse(localStorage.getItem('customer'))
			if(customer && customer.role_id == "4") {
				next({
					path: 'customer/show-photo'
				})
			}
		}
		if(to.path === '/shop-selling/login') {
			const shopSelling = JSON.parse(localStorage.getItem('shopSelling'))
			if(shopSelling && shopSelling.role_id == "5") {
				next({
					path: 'shop-selling/dashboard'
				})
			}
		}
		next()
	}

	if(to.meta.requiresRoom){
		const roomLogin = JSON.parse(localStorage.getItem('roomLogin'))
		if(roomLogin) {
			next({
				path:'/shop-selling/show-photo',
			})
		}else{
			next({
				path:'/shop-selling/dashboard',
			})
		}
	}

	if(to.meta.customerAuth) {
		const customerAuth = JSON.parse(localStorage.getItem('customer'))
		if(customerAuth) {
			if(customerAuth.role_id == '4') {
				next()
			} 
		} else {
			next({
				path: '/customer/login'
			})
		}
	}

	if(to.meta.shopSellingAuth) {
		const shopSellingAuth = JSON.parse(localStorage.getItem('shopSelling'))
		if(shopSellingAuth) {
			if(shopSellingAuth.role_id == '5') {
				next()
			} 
		} else {
			next({
				path: '/shop-selling/login'
			})
		}
	}

  	Nprogress.done()
});

// Navigation guard after each
router.afterEach((to, from) => {
// 	Nprogress.done()
	setTimeout(() => {
		const contentWrapper = document.querySelector(".v-content__wrap");
		if(contentWrapper !== null){
			contentWrapper.scrollTop = 0;
		}
		const boxedLayout = document.querySelector('.app-boxed-layout .app-content');
		if(boxedLayout !==  null){
			boxedLayout.scrollTop = 0;
		}
		const miniLayout = document.querySelector('.app-mini-layout .app-content');
		if(miniLayout !== null){
			miniLayout.scrollTop = 0;
		}
	}, 200);
})

export default router;


