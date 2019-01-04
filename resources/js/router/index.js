import Vue from 'vue'
import Router from 'vue-router'
import Nprogress from 'nprogress'

// auth components
import AppLogin from '../views/auth/AppLogin.vue';
import SignUpOne from '../views/auth/SignUpOne.vue';
import LoginOne from '../views/auth/LoginOne.vue';

import ForgotPassword from '../views/auth/ForgotPassword.vue';
import ResetPassword from '../views/auth/ResetPassword.vue';

import mini from '../container/MiniSidebarLayout.vue'


//-------------------------------------------------------------------
//----------------  File Component of Super Admin  ------------------
//-------------------------------------------------------------------
//** All File Components will import belo

import Ecommerce   from'../views/super-admin/dashboard/Ecommerce.vue';
import Companies from '../views/super-admin/companies/Companies';
// import CompanyChart from '../views/super-admin/companies/information-chart';
import PackageIndex from '../views/super-admin/package/Index';
import HistoriesTransaction from '../views/super-admin/transactions/Histories.vue'
// Transactions Session
import Transactions from '../views/super-admin/transactions/Histories.vue'
// Coupon Code Session
import CouponCodes from '../views/super-admin/coupon-codes/CouponCodes.vue'


//-------------------------------------------------------------------
//----------------  File Component of Partials  ---------------------
//-------------------------------------------------------------------
//** All File Components will import below

import page404 from '../views/partials/pages/page404'
import UserPass from '../views/partials/users/ChangePassword'



//-------------------------------------------------------------------
//----------------  File Component of Admin Company  ----------------
//-------------------------------------------------------------------
//** All File Components will import below

import DashboardCompany from '../views/company-admin/dashboard/DashboardCompany.vue'
import Notification from '../views/company-admin/notification/notification.vue'
import ContentManagement from '../views/company-admin/content-management-system/Index.vue'



Vue.use(Router)

var routers = [];
routers = [
	{
		path: '/auth/login',
		component:AppLogin,
		children:[
			{
				path:'/auth/login',
				name:'LoginIndex',
				component:LoginOne
			},
			{
				path:'/auth/sign-up',
				name:'Register',
				component: SignUpOne,
				meta: {
					title: 'message.signUp',
					breadcrumb: 'Session / Sign Up'
				}
			},
			{
				path: '/auth/forgot-password',
				component: ForgotPassword,
				meta: {
					title: 'message.forgotPassword',
					breadcrumb: 'Session / Forgot Password'
				}
			},
		]
	},
	{
		path: '/',
   		component: mini,
		redirect: '/default/dashboard/index',
		meta: { requiresAuth: true },
		children: [

			//------------------------------------------------------------------------------------
			//---------------------------- ROUTER COMPANY ADMIN ----------------------------------
			//------------------------------------------------------------------------------------

			{
				path: '/default/company/dashboard/index',
	         	component: DashboardCompany,
	         	meta: {
	         		requiresAuth: true,
	         		adminAuth:false,
	         		companyAuth:true,
		            title: 'message.ecommerce',
		            breadcrumb: 'Dashboard / Ecommerce'
	        	}
			},
			{
		        path: '/default/company/change-password',
		        component: UserPass,
		        meta: {
		            requiresAuth: true,
		            adminAuth:false,
	         		companyAuth:true,
		            title: 'message.changePassword',
		            breadcrumb: 'Users / Change Password'
		        }
		    },
			{
				path: '/default/company/show-notification/:id',
		        component: Notification,
		        name : 'CompnayNotification',
		        meta: {
		            requiresAuth: true,
		            adminAuth:false,
	         		companyAuth:true,
		            title: 'message.notification',
		            breadcrumb: 'Users / Notification'
		        }
			},
			{
				path:'/default/company/content-pages',
				component: ContentManagement,
		        name : 'ContentManagement',
		        meta: {
		            requiresAuth: true,
		            adminAuth:false,
	         		companyAuth:true,
		            title: 'message.contenPages',
		            breadcrumb: 'Users / Content Pages'
		        }
			},


			//--------------------------------------------------------------------------
			//------------------------- ROUTER SUPER ADMIN  ----------------------------
			//--------------------------------------------------------------------------

      		{
	         	path: '/default/dashboard/index',
	         	component: Ecommerce,
	         	meta: {
	         		requiresAuth: true,
	         		adminAuth:true,
	         		companyAuth:false,
		            title: 'message.ecommerce',
		            breadcrumb: 'Dashboard / Ecommerce'
	        	}
      		},
		    {
		        path: '/default/widgets/companies',
		        component: Companies,
		        meta: {
		        	requiresAuth: true,
		        	adminAuth:true,
	         		companyAuth:false,
		            title: 'message.company',
		            breadcrumb: 'Company / List'
		        }
		    },
		    // {
		    //     path: '/default/widgets/mana-company-chart',
		    //     component: CompanyChart,
		    //     meta: {
		    //     	requiresAuth: true,
		    //     	adminAuth:true,
	     //     		companyAuth:false,
		    //         title: 'message.chartCompany',
		    //         breadcrumb: 'Company / Information /Chart'
		    //     }
		    // },
		    {
		        path: '/default/packages/index',
		        component: PackageIndex,
		        meta: {
		        	requiresAuth: true,
		        	adminAuth:true,
	         		companyAuth:false,
		            title: 'message.package',
		            breadcrumb: 'Packages / List'
		        }

		    }, 
		    // {
		    //     path: '/default/setting',
		    //     component: Setting,
		    //     meta: {
		    //     	requiresAuth: true,
		    //         title: 'message.settings',
		    //         breadcrumb: 'Setting / List'
		    //     }
		    // },
		    {
		        path: '/default/users/change-password',
		        component: UserPass,
		        meta: {
		            requiresAuth: true,
		            adminAuth:true,
	         		companyAuth:false,
		            title: 'message.changePassword',
		            breadcrumb: 'Users / Change Password'
		        }
		    },
		    {
		        path: '/default/transaction/histories',
		        component: Transactions,
		        meta: {
		            requiresAuth: true,
		            adminAuth:true,
	         		companyAuth:false,
		            title: 'message.histories',
		            breadcrumb: 'Transaction / Histories List'
		        }
		    },
		    {
		        path: '/default/coupon-codes',
		        component: CouponCodes,
		        meta: {
		            requiresAuth: true,
		            adminAuth:true,
	         		companyAuth:false,
		            title: 'message.couponCode',
		            breadcrumb: 'Coupon Code / Histories List'
		        }
		    },
		 //    {
			// 	path: '/default/users/show-notification/:id',
		 //        component: Notification,
		 //        name : 'AdminNotification',
		 //        meta: {
		 //            requiresAuth: true,
		 //            adminAuth:true,
	  //        		companyAuth:false,
		 //            title: 'message.notification',
		 //            breadcrumb: 'Users / Notification'
		 //        }
			// },
      	]	
	},
	{
    // not found handler
    	path: '*',
    	component: page404
  	}

];

var router = new Router({
    // mode: 'history',
    routes: routers,
});

// navigation guards before each
// router.beforeEach((to, from, next) => { 
// 	Nprogress.start()
// 	// if (to.path !== '/login' && !access_token) {
// 	if (to.matched.some(record => record.meta.requiresAuth) && (localStorage.getItem('access_token') === null)) {
//     	next({
// 				path: '/session/login',
// 				// query: { redirect: to.fullPath }
// 			})
//   	}else if(to.path === '/session/login' && (localStorage.getItem('access_token') !== null)){
//   		next({
// 				path:'/default/dashboard/index',
// 			})
//   	} 
//   	else {
//     	next();
//   	}

//   	Nprogress.done()
// });


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
				path: '/auth/login'
			})
		}
		else if(to.meta.adminAuth) {
			const authUser = JSON.parse(localStorage.getItem('user'))
			if(authUser.role_id == "1"){
				next()
			} else {
				next({
					path:'/default/company/dashboard/index',
				})
			}
		} else if(to.meta.companyAuth) {
			const authUser = JSON.parse(localStorage.getItem('user'))
			if(authUser.role_id == "2"){
				next()
			} else {
  				next({
					path:'/default/dashboard/index',
				})
			}
		}
	} else {
		next()
	}

  	Nprogress.done()
});

// // navigation guard after each
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


