import AppAuth from '../../views/auth/AppAuth';

///////////////////////////////////////////////////
/////////////   COMPONENTS   //////////////////////
///////////////////////////////////////////////////

// Auth
import Login from '../../views/auth/Login';
import SignUp from '../../views/auth/SignUp';
import ForgotPassword from '../../views/auth/ForgotPassword';
import ResetPassword from '../../views/auth/ResetPassword';
import EmailVerify from '../../views/auth/EmailVerify';

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
	        path: '/register',
	        name: 'register',
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
        {
	        path: '/email/verify',
	        name: 'email-verify',
	        component: EmailVerify,
	        meta: {
				title: 'message.emailVerify',
				breadcrumb: 'Forgot Password'
	        }
	    },
   	]
}
