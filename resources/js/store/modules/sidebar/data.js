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
			action: 'zmdi zmdi-account-add',
			title: 'message.sales',
			active: false,
			path: '/photographers',
			items:null,
			role_id : 3
		},


		    /////////////////////////////////////////////
		   ///////								  //////
		  ///////  SIDEBAR ROUTER COMPANY ADMIN  //////
		 ///////							    //////
		/////////////////////////////////////////////
		
		{
			action: 'fas fa-tachometer-alt',
			title: 'message.dashboard',
			active: true,
			path: '/dashboard',
			items:null,
			role_id : 2
		},
		{

			action: 'fas fa-code-branch',
			title: 'message.branch',
			active: false,
			path: '/branches',
			items:null,
			role_id : 2
		},
		{
			action: 'fas fa-user-friends',
			title: 'message.photographer',
			active: false,
			path: '/photographers',
			items:null,
			role_id : 2
		},
		{
			action: 'fas fa-users',
			title: 'message.customer',
			active: false,
			path: '/customers',
			items:null,
			role_id : 2
		},
		{
			action: 'fas fa-newspaper',
			title: 'message.sibarContentPages',
			active: true,
			path: '/content-pages',
			items:null,
			role_id : 2
		},
		{
			action: 'fas fa-cloud-upload-alt',
			title: 'message.sidebarUpload',
			active: true,
			path: '/upload',
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
