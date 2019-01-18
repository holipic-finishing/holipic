// Sidebar Routers
export const menus = {
	'message.general': [
		    /////////////////////////////////////////////
		   ///////								  //////
		  ///////  SIDEBAR ROUTER BRANCH ADMIN   //////
		 ///////							    //////
		/////////////////////////////////////////////
		{
			action: 'zmdi-view-dashboard',
			title: 'message.dashboard',
			active: true,
			path: '/dashboard',
			items:null,
			role_id : 3
		},
		{
			action: 'zmdi zmdi-account-add',
			title: 'message.photographers',
			active: false,
			path: '/photographers',
			items:null,
			role_id : 3
		},
		{
			action: 'fas fa-donate',
			title: 'message.sales',
			active: false,
			path: '/sales',
			items:null,
			role_id : 3
		},
		{
			action: 'zmdi-pin-assistant',
			title: 'message.customer',
			active: false,
			path: '/customers',
			items:null,
			role_id : 3
		},

		    /////////////////////////////////////////////
		   ///////								  //////
		  ///////  SIDEBAR ROUTER COMPANY ADMIN  //////
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
		{

			action: 'zmdi-assignment-account',
			title: 'message.branch',
			active: false,
			path: '/branches',
			items:null,
			role_id : 2
		},
		{
			action: 'zmdi-pin-assistant',
			title: 'message.photographer',
			active: false,
			path: '/photographers',
			items:null,
			role_id : 2
		},
		{
			action: 'zmdi zmdi-account-box-mail',
			title: 'message.customer',
			active: false,
			path: '/customers',
			items:null,
			role_id : 2
		},
		{
			action: 'zmdi zmdi-google-pages',
			title: 'message.sibarContentPages',
			active: true,
			path: '/content-pages',
			items:null,
			role_id : 2
		},
		{
			action: 'zmdi zmdi-chart',
			title: 'message.sales',
			active: true,
			path: '/sales',
			items:null,
			role_id : 2
		},
		{
			action: 'zmdi zmdi-email',
			title: 'message.emails',
			active: true,
			path: '/email-setting',
			items: null,
			role_id: 2
		},	
		{
			action: 'zmdi-comment-list',
			title: 'message.package',
			active: true,
			path: '/packages',
			items: null,
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
