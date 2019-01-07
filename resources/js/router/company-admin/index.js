import MiniSidebarLayout from '../../container/MiniSidebarLayout'

///////////////////////////////////////////////////
/////////////   COMPONENTS   //////////////////////
///////////////////////////////////////////////////

// Dashboard
import CompanyDashboard from '../../views/dashboard/admin-company/CompanyDashboard'

// Notifications
import Notifications from '../../views/notifications/Notifications'

// Change Password
import ChangePassword from '../../views/users/ChangePassword'

//Branches
import Branch from '../../views/dashboard/admin-company/BranchCompany'

//Customers
import Customer from '../../views/dashboard/admin-company/Customer'

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
	        	adminAuth:false,
         		companyAuth:true,
	            title: 'message.ecommerce',
	            breadcrumb: 'Company / Dashboard'
	        }
	    },
	    {
	        path: '/company-admin/notifications/:userId',
	        component: Notifications,
	        meta: {
	        	requiresAuth:true,
	        	adminAuth:false,
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
	        	adminAuth:false,
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
		            // breadcrumb: 'Users / Notification'
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
		

   	]
}