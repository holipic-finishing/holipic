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
import ContentManSystem from '../../views/company-admin/cms/Index'

// Sales 
import Sales from '../../views/company-admin/sales/Sales'

//Branches
import Branch from '../../views/company-admin/branch/Branch'

//Photographers
import Photographer from '../../views/company-admin/photographer/Photographer'

//Customers
import Customer from '../../views/company-admin/customer/Customer'


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
	        	// adminAuth:false,
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
	        	// adminAuth:false,
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
	        	// adminAuth:false,
         		companyAuth:true,
	            title: 'message.changePassword',
	            breadcrumb: 'Company / Change Password'
	        }
	    },
	    {
				path: '/company-admin/branches',
		        component: Branch,
		        name : 'CompanyBranch',
		        meta: {
		            requiresAuth: true,
		            adminAuth:false,
	         		companyAuth:true,
		            title: 'message.branch'
		        }
		},
		{
				path: '/company-admin/photographers',
		        component: Photographer,
		        name : 'CompanyBranchPhotographer',
		        meta: {
		            requiresAuth: true,
		            adminAuth:false,
	         		companyAuth:true,
		            title: 'message.photographer'
		        }
		},
		{
				path: '/company-admin/customers',
		        component: Customer,
		        name : 'Customer',
		        meta: {
		            requiresAuth: true,
		            adminAuth:false,
	         		companyAuth:true,
		            title: 'message.customer'
		            
		        }
		},
		{
	        path: '/company-admin/content-pages',
	        component: ContentManSystem,
	        meta: {
	        	requiresAuth:true,
	        	// adminAuth:false,
         		companyAuth:true,
	            title: 'message.contenPages',
	            breadcrumb: 'Company / CMS'
	        }
	    },
	    {
	    	path: '/company-admin/sales',
	        component: Sales,
	        meta: {
	        	requiresAuth:true,
	        	adminAuth:false,
         		companyAuth:true,
	            title: 'message.sales',
	            breadcrumb: 'Company / Sales'
	        }
	    }
   	]
}