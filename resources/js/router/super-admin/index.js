import MiniSidebarLayout from '../../container/MiniSidebarLayout'

///////////////////////////////////////////////////
/////////////   COMPONENTS   //////////////////////
///////////////////////////////////////////////////

// Dashboard
import Dashboard from'../../views/dashboard/Dashboard';

// Company manager
import Companies from '../../views/companies/Companies';

// Packages
import Packages from '../../views/packages/Packages';

// Coupon Codes
import CouponCodes from '../../views/coupon-codes/CouponCodes'

// Change Password
import ChangePassword from '../../views/users/ChangePassword'

export default {
	path: '/super-admin',
   	component: MiniSidebarLayout,
   	redirect: '/super-admin/dashboard',
   	children: [
   		{
	        path: '/super-admin/dashboard',
	        component: Dashboard,
	        meta: {
	        	requiresAuth: true,
	        	adminAuth:true,
         		companyAuth:false,
	            title: 'message.ecommerce',
	            breadcrumb: 'Dashboard'
	        }
	    },
      	{
	        path: '/super-admin/companies',
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
	        path: '/super-admin/coupon-codes',
	        component: CouponCodes,
	        meta: {
	            requiresAuth: true,
	            adminAuth:true,
         		companyAuth:false,
	            title: 'message.couponCode',
	            breadcrumb: 'Coupon Code / List'
	        }
	    },
      	{
	        path: '/super-admin/packages',
	        component: Packages,
	        meta: {
	            requiresAuth: true,
	            adminAuth:true,
         		companyAuth:false,
	            title: 'message.package',
	            breadcrumb: 'Packages / List'
	        }
	    },
	    {
	        path: '/super-admin/change-password',
	        component: ChangePassword,
	        meta: {
	            requiresAuth: true,
	            adminAuth:true,
         		companyAuth:false,
	            title: 'message.changePassword',
	            breadcrumb: 'Change Password'
	        }
	    },
   	]
}