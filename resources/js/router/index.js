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
//import Ecommerce   from'../views/dashboard/Ecommerce';

// Companies Component

// import Companies from '../views/companies/Companies';
// import CompanyChart from '../views/companies/information-chart';
// import PackageIndex from '../views/package/Index';
// import UserManagement from '../views/superadmin-user/user-management'
// import page404 from '../views/pages/page404'
// import UserPass from '../views/users/ChangePassword'
// import HistoriesTransaction from '../views/transactions/Histories.vue'
// import IndexCoupon from '../views/coupon-code/Index.vue'


//-----------------------------------------
//----  File Component of Admin Company  --
//-----------------------------------------
//** All File Components will import below

// import DashboardCompany from '../views/dashboard/admin-company/DashboardCompany.vue'
// import Notification from '../views/notification/notification.vue'
import Branch from '../views/dashboard/admin-company/BranchCompany.vue'
import Photographer from '../views/dashboard/admin-company/Photographer.vue'

// import PageNotFound from '../views/pages/page404'

import PageNotFound from '../views/partials/pages/page404'



Vue.use(Router)

var routers = [];
routers = [
	AuthRoutes,
	SuperAdminRoutes,
	CompanyAdminRoutes,
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
				} else {
					if(authUser.role_id == "2"){
						next({
							path:'/company-admin/dashboard',
						})
					}
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


