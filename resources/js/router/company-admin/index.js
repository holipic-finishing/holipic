import MiniSidebarLayout from '../../container/MiniSidebarLayout'

///////////////////////////////////////////////////
/////////////   COMPONENTS   //////////////////////
///////////////////////////////////////////////////

// Dashboard
import CompanyDashboard from '../../views/company-admin/dashboard/CompanyDashboard'

// Notifications
import Notifications from '../../views/company-admin/notifications/Notifications'

// Change Password
import ChangePassword from '../../views/partials/users/ChangePassword'

// Content Manager Systems
import CMS from '../../views/company-admin/cms/Index'

// Sales 
import Sales from '../../views/company-admin/sales/Sales'

// CompanyPackages
import CompanyPackages from '../../views/company-admin/packages/Packages';

//Branches
import Branches from '../../views/company-admin/branch/Branches'

//Photographers
import Photographers from '../../views/company-admin/photographer/Photographers'

//Customers
import Customers from '../../views/company-admin/customer/Customers'

//Upload Photos
import UploadPhotos from '../../views/partials/upload-photos/UploadPhotos'

// User Profile
import UserProfile from '../../views/partials/users/UserProfile'

//Email
import Email from '../../views/company-admin/email/Emailes'

export default {
	path: '/company-admin',
   	component: MiniSidebarLayout,
   	redirect: '/company-admin/dashboard',
   	children: [
   		{
	        path: '/company-admin/dashboard',
	        component: CompanyDashboard,
	        meta: {
	        	requiresAuth:true,
         		companyAuth:true,
	            title: 'message.ecommerce',
	            breadcrumb: 'Company / Dashboard'
	        }
	    },
	    {
	        path: '/company-admin/notifications/:userId',
	        component: Notifications,
        	name:'CompnayNotification',
	        meta: {
	        	requiresAuth:true,
         		companyAuth:true,
	            title: 'message.notification',
	            breadcrumb: 'Company / Notifications'
	        }
	    },
	    {
	        path: '/company-admin/change-password',
	        component: ChangePassword,
	        meta: {
	        	requiresAuth:true,
         		companyAuth:true,
	            title: 'message.changePassword',
	            breadcrumb: 'Company / Change Password'
	        }
	    },
	    {
				path: '/company-admin/branches',
		        component: Branches,
		        name : 'branches',
		        meta: {
		            requiresAuth: true,
	         		companyAuth:true,
		            title: 'message.branch'
		        }
		},
		{
				path: '/company-admin/photographers',
		        component: Photographers,
		        name : 'photographers',
		        meta: {
		            requiresAuth: true,
	         		companyAuth:true,
		            title: 'message.photographer'
		        }
		},
		{
				path: '/company-admin/customers',
		        component: Customers,
		        name : 'customers',
		        meta: {
		            requiresAuth: true,
	         		companyAuth:true,
		            title: 'message.customer'
		            
		        }
		},
		{
	        path: '/company-admin/content-pages',
	        component: CMS,
	        name: 'cms',
	        meta: {
	        	requiresAuth:true,
         		companyAuth:true,
	            title: 'message.contenPages',
	            breadcrumb: 'Company / CMS'
	        }
	    },
	    {
	        path: '/company-admin/upload',
	        component: UploadPhotos,
	        name: 'upload',
	        meta: {
	        	requiresAuth:true,
	        	// adminAuth:false,
         		companyAuth:true,
	            title: 'message.sidebarUpload',
	            breadcrumb: 'Company / Upload Photos'
	        }
	    },
	    {
	        path: '/company-admin/packages',
	        component: CompanyPackages,
	    	path: '/company-admin/sales',
	        component: Sales,
	        meta: {
	        	requiresAuth:true,
         		companyAuth:true,
	            title: 'message.sales',
	            breadcrumb: 'Company / Sales'
	        }
	    },
	    {
	        path: '/company-admin/users/user-profile',
	        component: UserProfile,
	        meta: {
	            requiresAuth: true,
	            adminAuth:false,
         		companyAuth:true,
	            title: 'message.changePassword',
	            breadcrumb: 'Change Password'
	        }
	    },
	    {
	    	path: '/company-admin/email-setting',
	        component: Email,
	        meta: {
	        	requiresAuth:true,
         		companyAuth:true,
	            title: 'message.emails',
	            breadcrumb: 'Company / Emails'
	        }
	    },
	    {
	    	path: '/company-admin/packages',
	        component: CompanyPackages,
	        meta: {
	        	requiresAuth:true,
         		companyAuth:true,
		        title: 'message.package',
		        breadcrumb: 'Company / Package'
		    }
	    }
   	]
}