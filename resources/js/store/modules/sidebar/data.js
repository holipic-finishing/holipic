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
			path: '/company/dashboard/index',
			items:null,
			role_id : 2
		},
		{
			action: 'zmdi zmdi-google-pages',
			title: 'message.sibarContentPages',
			active: true,
			path: '/company/content-pages',
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
			path: '/dashboard/index',
			items:null,
			role_id : 1
		},
		{
			action: 'zmdi-widgets',
			title: 'message.companymanagement',
			active: false,
			path: '/widgets/companies',
			role_id : 1,
			items: null
		},
		{
			action: 'zmdi zmdi-dropbox',
			title: 'message.package',
			active: false,
			items:null,
			role_id : 1,
			path : '/packages/index'
		},
		// {
		// 	action: 'zmdi-settings',
		// 	title: 'message.settings',
		// 	active: false,
		// 	path: '/setting'
		// },
		// {
		// 	action: 'zmdi-card',
		// 	title: 'message.transaction',
		// 	active: false,
		// 	role_id : 1,
		// 	items: [
		// 		{ title: 'message.histories', path: '/transaction/histories' },
		// 	]
		// },
		{
			action: 'zmdi zmdi-ticket-star',
			title: 'message.couponCode',
			active: false,
			role_id : 1,
			path: '/coupon-code/index'
		}
	],
	// 'message.modules': [
	// 	{
	// 		action: 'zmdi-email',
	// 		title: 'message.inbox',
	// 		active: false,
	// 		items: null,
	// 		path: '/inbox'
	// 	},
	// 	{
	// 		action: 'zmdi-comments',
	// 		title: 'message.chat',
	// 		active: false,
	// 		items: null,
	// 		path: '/chat'
	// 	}
	// ],
}
