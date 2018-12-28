import Vue from 'vue'
import Router from 'vue-router'
import Nprogress from 'nprogress'
// session components
import AppLogin from '../views/session/AppLogin.vue';
import SignUpOne from '../views/session/SignUpOne.vue';
import LoginOne from '../views/session/LoginOne.vue';

import ForgotPassword from '../views/session/ForgotPassword.vue';
import ResetPassword from '../views/session/ResetPassword.vue';

// Dashboard components
import mini from '../container/MiniSidebarLayout.vue'
import Ecommerce   from'../views/dashboard/Ecommerce';

// Companies Component

import Companies from '../views/companies/Companies';
import CompanyChart from '../views/companies/information-chart';

import PackageIndex from '../views/package/Index';


import UserManagement from '../views/superadmin-user/user-management'
import page404 from '../views/pages/page404'
import UserPass from '../views/users/ChangePassword'
import HistoriesTransaction from '../views/transactions/Histories.vue'
import IndexCoupon from '../views/coupon-code/Index.vue'


//-----------------------------------------
//----  File Component of Admin Company  --
//-----------------------------------------
//** All File Components will import below

import DashboardCompany from '../views/dashboard/admin-company/DashboardCompany.vue'
import Notification from '../views/notification/notification.vue'

Vue.use(Router)

var routers = [];
routers = [
	{
		path: '/session/login',
		component:AppLogin,
		children:[
			{
				path:'/session/login',
				name:'LoginIndex',
				component:LoginOne
			},
			{
				path:'/session/sign-up',
				name:'Register',
				component: SignUpOne,
				meta: {
					title: 'message.signUp',
					breadcrumb: 'Session / Sign Up'
				}
			},
			{
				path: '/session/forgot-password',
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
		    {
		        path: '/default/widgets/mana-company-chart',
		        component: CompanyChart,
		        meta: {
		        	requiresAuth: true,
		        	adminAuth:true,
	         		companyAuth:false,
		            title: 'message.chartCompany',
		            breadcrumb: 'Company / Information /Chart'
		        }
		    },
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
		        path: '/default/user-management',
		        component: UserManagement,
		        meta: {
		        	requiresAuth: true,
		        	adminAuth:true,
	         		companyAuth:false,
		            title: 'message.userManager',
		            breadcrumb: 'User / Manager'
		        }
		    },
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
		        component: HistoriesTransaction,
		        meta: {
		            requiresAuth: true,
		            adminAuth:true,
	         		companyAuth:false,
		            title: 'message.histories',
		            breadcrumb: 'Transaction / Histories List'
		        }
		    },
		    {
		        path: '/default/coupon-code/index',
		        component: IndexCoupon,
		        meta: {
		            requiresAuth: true,
		            adminAuth:true,
	         		companyAuth:false,
		            title: 'message.couponCode',
		            breadcrumb: 'Coupon Code / Histories List'
		        }
		    },
		    {
				path: '/default/users/show-notification/:id',
		        component: Notification,
		        name : 'AdminNotification',
		        meta: {
		            requiresAuth: true,
		            adminAuth:true,
	         		companyAuth:false,
		            title: 'message.notification',
		            breadcrumb: 'Users / Notification'
		        }
			},
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
				path: '/session/login'
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


