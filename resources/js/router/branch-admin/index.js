import MiniSidebarLayout from '../../container/MiniSidebarLayout'

///////////////////////////////////////////////////
/////////////   COMPONENTS   //////////////////////
///////////////////////////////////////////////////

// Dashboard
import CompanyDashboard from '../../views/branch-admin/dashboard/BranchDashboard.vue'


export default {
	path: '/branch-admin',
   	component: MiniSidebarLayout,
   	redirect: '/branch-admin/dashboard',
   	children: [
   		{
	        path: '/branch-admin/dashboard',
	        component: CompanyDashboard,
	        meta: {
	        	requiresAuth:true,
         		branchAuth:true,
	            title: 'message.ecommerce',
	            breadcrumb: 'Branch / Dashboard'
	        }
	    },
   	]
}