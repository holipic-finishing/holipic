// Sidebar Routers
export const menus = {
	'message.general': [
		    /////////////////////////////////////////////
		   ///////								  //////
		  ///////  SIDEBAR ROUTER ADMIN COMPANY  //////
		 ///////							    //////
		/////////////////////////////////////////////
		{
			action: 'zmdi-view-dashboard',
			title: 'message.dashboard',
			active: true,
			path: '/dashboard',
			items:null,
			role_id : 2
		},
		
		 	/////////////////////////////////////////////
		   ///////								  //////
		  ///////  SIDEBAR ROUTER SUPER ADMIN    //////
		 ///////							    //////
		/////////////////////////////////////////////

		{
			action: 'zmdi-view-dashboard',
			title: 'message.dashboard',
			active: true,
			path: '/dashboard',
			items:null,
			role_id : 1
		},
		{
			action: 'zmdi-widgets',
			title: 'message.companymanagement',
			active: false,
			path: '/companies',
			role_id : 1,
			items: null
		},
		{
			action: 'zmdi zmdi-dropbox',
			title: 'message.package',
			active: false,
			items:null,
			role_id : 1,
			path : '/packages'
		},
		{
			action: 'zmdi zmdi-ticket-star',
			title: 'message.couponCode',
			active: false,
			role_id : 1,
			path: '/coupon-codes'
		}
	],
}
