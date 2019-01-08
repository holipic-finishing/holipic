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

// CompanyPackages
import CompanyPackages from '../../views/company-admin/packages/Packages';

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
        	name:'CompnayNotification',
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
	        path: '/company-admin/content-pages',
	        component: ContentManSystem,
	        meta: {
	        	requiresAuth:true,
	        	adminAuth:false,
         		companyAuth:true,
	            title: 'message.contenPages',
	            breadcrumb: 'Company / CMS'
	        }
	    },
	    {
	        path: '/company-admin/packages',
	        component: CompanyPackages,
	        meta: {
	        	requiresAuth:true,
	        	adminAuth:false,
         		companyAuth:true,
	            title: 'message.package',
	            breadcrumb: 'Company / Package'
	        }
	    },
   	]
}