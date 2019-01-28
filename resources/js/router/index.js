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

// Dashboard components
import mini from '../container/MiniSidebarLayout.vue'

import PageNotFound from '../views/partials/pages/page404'



Vue.use(Router)

var routers = [];
routers = [
	AuthRoutes,
	SuperAdminRoutes,
	CompanyAdminRoutes,
	BranchAdminRoutes,
	// {
 //    	// Page Not Found
 //    	path: '*',
 //    	component: PageNotFound
 //  	}
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
		if(!authUser || !token) {
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
			if(authUser || token) {
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
		next()
		
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


