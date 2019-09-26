import AppAuth from '../../views/auth/AppAuth';
import PartialPage from '../../views/auth/CustomerAuth';

///////////////////////////////////////////////////
/////////////   COMPONENTS   //////////////////////
///////////////////////////////////////////////////

// Auth
import Login from '../../views/auth/Login';
import SignUp from '../../views/auth/SignUp';
import ForgotPassword from '../../views/auth/ForgotPassword';
import ResetPassword from '../../views/auth/ResetPassword';
import EmailVerify from '../../views/auth/EmailVerify';

import CustomerLogin from '../../views/customer/Login.vue';
import CustomerResetPassword from '../../views/customer/ResetPassword.vue';

import ShopSellingLogin from '../../views/shop-selling/Login.vue';

export const BaseAuth = {
    path: '/',
    component: AppAuth,
    redirect: '/login',
    children: [{
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
        }
    ]
}
export const CustomerAuth = {
    path: 'customer/',
    component: PartialPage,
    redirect: '/customer/login',
    children: [
        {
            path: '/customer/login',
            name: 'customer-login',
            component: CustomerLogin,
            meta: {
                title: 'Customer Login',
                breadcrumb: 'Customer Login'
            }
        },
        {
            path: '/customer/reset-password',
            name: 'customer-reset-password',
            component: CustomerResetPassword,
            meta: {
                title: 'Customer Reset Password',
                breadcrumb: 'Customer Reset Password'
            }
        }
    ]
}
export const ShopAuth =  {
    path: '/shop/login',
    name: 'shop-login',
    component: ShopSellingLogin,
    meta: {
        title: 'Shop Login',
        breadcrumb: 'Shop Login'
    }
}
