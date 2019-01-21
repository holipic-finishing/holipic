import AppAuth from '../../views/auth/AppAuth';

///////////////////////////////////////////////////
/////////////   COMPONENTS   //////////////////////
///////////////////////////////////////////////////

// Auth
import Login from '../../views/auth/Login';
import SignUp from '../../views/auth/SignUp';
import ForgotPassword from '../../views/auth/ForgotPassword';
import ResetPassword from '../../views/auth/ResetPassword';

export default {
	path: '/',
   	component: AppAuth,
   	redirect: '/login',
   	children: [
   		{
	        path: '/login',
	        name: 'login',
	        component: Login,
	        meta: {
				title: 'message.login',
				breadcrumb: 'Login'
	        }
	    },
	    {
	        path: '/sign-up',
	        name: 'sign-up',
	        component: SignUp,
	        meta: {
				title: 'message.signUp',
				breadcrumb: 'Sign Up'
	        }
	    },
	    {
	        path: '/forgot-password',
	        name: 'forgot-password',
	        component: ForgotPassword,
	        meta: {
				title: 'message.forgotPassword',
				breadcrumb: 'Forgot Password'
	        }
	    },
   	]
}