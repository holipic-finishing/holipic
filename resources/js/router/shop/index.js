import Index from '../../views/shop/index.vue';
import Photos from '../../views/shop/Photos';

import BookingConfirm from '../../views/shop/BookingConfirm.vue';
import Dashboard from '../../views/shop/Dashboard.vue';

export default {
	path: '/shop',
   	component: Index,
   	redirect: '/shop/dashboard',
   	children: [
   		{
	        path: 'photos/:roomId',
            component: Photos,
	        name: 'shop-photos',
	        meta: {
                requiresAuth: true,
                shopAuth: true,
                title: 'Shop Photos',
	            breadcrumb: 'Shop Photos'
		    }
        },
        {
            path: 'confirm-booking',
            name: 'shop-confirm-booking',
            component: BookingConfirm,
            meta: {
                requiresAuth: true,
                shopAuth: true,
                title: 'Shop Confirm Booking',
	            breadcrumb: 'Shop Confirm Booking'
		    }
        },
        {
            path: 'dashboard',
            component: Dashboard,
            meta: {
                requiresAuth: true,
                shopAuth: true,
                title: 'Shop Selling',
	            breadcrumb: 'Shop Selling'
            }
        },
	],

}
