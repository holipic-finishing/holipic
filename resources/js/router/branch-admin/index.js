import MiniSidebarLayout from '../../container/MiniSidebarLayout'

///////////////////////////////////////////////////
/////////////   COMPONENTS   //////////////////////
///////////////////////////////////////////////////

// Dashboard
import CompanyDashboard from '../../views/branch-admin/dashboard/BranchDashboard.vue'

// Change Password
import ChangePassword from '../../views/partials/users/ChangePassword'

//photographers
import Photographers from '../../views/branch-admin/photographers/Photographers'

//sales
import Sales from '../../views/branch-admin/sale/Sales'

//customers
import Customers from '../../views/branch-admin/customer/Customers'

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
	    {
	    	path:'/branch-admin/change-password',
	    	component: ChangePassword,
	        meta: {
	        	requiresAuth:true,
         		branchAuth:true,
	            title: 'message.changePassword',
	            breadcrumb: 'Branch / Change Password'
	        }
	    },
	    {
	    	path:'/branch-admin/photographers',
	    	component: Photographers,
	    	meta : {
	    		requiresAuth:true,
         		branchAuth:true,
	            title: 'message.photographers',
	            breadcrumb: 'Branch / Photographers'
	    	}
	    },
	    {
	    	path:'/branch-admin/sales',
	    	component: Sales,
	    	meta : {
	    		requiresAuth:true,
         		branchAuth:true,
	            title: 'message.sales',
	            breadcrumb: 'Branch / Sales'
	    	}
	    },
		{
	    	path:'/branch-admin/customers',
	    	component: Customers,
	    	meta : {
	    		requiresAuth:true,
         		branchAuth:true,
	            title: 'message.customers',
	            breadcrumb: 'Branch / Customers'
	    	}
	    }

   	]
}