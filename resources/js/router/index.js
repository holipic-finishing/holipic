import Vue from 'vue'
import Router from 'vue-router'
import Nprogress from 'nprogress'

// session components

import AppLogin from '../views/session/AppLogin.vue';
import SignUpOne from '../views/session/SignUpOne.vue';
import LoginOne from '../views/session/LoginOne.vue';
// import LockScreen from '../views/session/LockScreen.vue';
import ForgotPassword from '../views/session/ForgotPassword.vue';
import ResetPassword from '../views/session/ResetPassword.vue';
// import Auth0CallBack from '../components/Auth0Callback/Auth0Callback.vue';


// dashboard components
import Full from '../container/Full'
import Ecommerce   from'../views/dashboard/Ecommerce';

// view users 

// import UserWidgets   from'../views/users/UsersList';
import Company from '../views/company/index';
import PackageIndex from '../views/package/Index';


import Setting from '../views/setting/setting'
import UserManagement from '../views/superadmin-user/user-management'



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
   		component: Full,
		redirect: '/default/dashboard/index',
		meta: { requiresAuth: true },
		children: [
      		{
	         	path: '/default/dashboard/index',
	         	component: Ecommerce,
	         	meta: {
	         		requiresAuth: true,
		            title: 'message.ecommerce',
		            breadcrumb: 'Dashboard / Ecommerce'
	        	}
      		},
      // 		{
		    //     path: '/default/users/user-list',
		    //     component: UserWidgets,
		    //     meta: {
		    //     	requiresAuth: true,
		    //         title: 'message.user',
		    //         breadcrumb: 'Users / List'
		    //     }
		    // },
		    {
		        path: '/default/widgets/mana-company',
		        component: Company,
		        meta: {
		        	requiresAuth: true,
		            title: 'message.company',
		            breadcrumb: 'Company / List'
		        }
		    },
		    {
		        path: '/default/packages/index',
		        component: PackageIndex,
		        meta: {
		        	requiresAuth: true,
		            title: 'message.package',
		            breadcrumb: 'Packages / List'
		        }

		    }, 
		    {
		        path: 'default/setting',
		        component: Setting,
		        meta: {
		        	requiresAuth: true,
		            title: 'message.settings',
		            breadcrumb: 'Setting / List'
		        }
		    },
		    {
		        path: 'default/user-management',
		        component: UserManagement,
		        meta: {
		        	requiresAuth: true,
		            title: 'message.userManager',
		            breadcrumb: 'User / Manager'
		        }
		    },
      	]	
	},
	// {
	// 	path:'/',
	// 	name:'Dashboard',
	// 	component: Dashboard,
	// 	meta: { requiresAuth: true },
	// 	children : [
	// 		{
	// 			path:'/users',
	// 			name:'indexUser',
	// 			component:User
	// 		},
	// 		{
	// 			path:'/slide',
	// 			name:'Slide',
	// 			component:Slide
	// 		},
	// 		{
	// 			path:'/user-dash',
	// 			name:'UserDash',
	// 			component:UserDash
	// 		}

	// 	]
	// },
	{
    // not found handler
    	path: '*',
    	redirect: '/session/login'
  	}

];

var router = new Router({
    // mode: 'history',
    routes: routers,
});

// navigation guards before each
router.beforeEach((to, from, next) => { 
	Nprogress.start()
	// if (to.path !== '/login' && !access_token) {
	if (to.matched.some(record => record.meta.requiresAuth) && (localStorage.getItem('access_token') === null)) {
    	next({
				path: '/session/login',
				// query: { redirect: to.fullPath }
			})
  	}else if(to.path === '/session/login' && (localStorage.getItem('access_token') !== null)){
  		next({
				path:'/default/dashboard/index',
			})
  	} 
  	else {
    	next();
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

// export default new Router({
// 	mode: 'history',
// 	routes: [
// 		defaultRoutes,
// 		horizontalRoutes,
// 		boxedRoutes,
// 		mini,
// 		boxedV2,
// 		{
// 			path: '/callback',
// 			component: Auth0CallBack
// 		},
// 		{
// 			path: '/session/sign-up',
// 			component: SignUpOne,
// 			meta: {
// 				title: 'message.signUp',
// 				breadcrumb: 'Session / Sign Up'
// 			}
// 		},
// 		{
// 			path: '/session/login',
// 			component: LoginOne,
// 			meta: {
// 				title: 'message.login',
// 				breadcrumb: 'Session / Login'
// 			}
// 		},
// 		{
// 			path: '	',
// 			component: LockScreen,
// 			meta: {
// 				title: 'Lock Screen',
// 				breadcrumb: 'Session / Lock Screen'
// 			}
// 		},
// 		{
// 			path: '/session/forgot-password',
// 			component: ForgotPassword,
// 			meta: {
// 				title: 'message.forgotPassword',
// 				breadcrumb: 'Session / Forgot Password'
// 			}
// 		},
// 		{
// 			path: '/session/reset-password',
// 			component: ResetPassword,
// 			meta: {
// 				title: 'message.resetPassword',
// 				breadcrumb: 'Session / Reset Password'
// 			}
// 		}
// 	]
// })
