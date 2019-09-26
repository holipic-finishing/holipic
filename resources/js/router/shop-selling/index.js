import Index from '../../views/shop-selling/index.vue';
import SelectPhoto from '../../views/shop-selling/partials/SelectPhoto.vue';

import BookingConfirm from '../../views/shop-selling/BookingConfirm.vue';
import ShopSellingDashboard from '../../views/shop-selling/Dashboard.vue';

export default {
	path: '/shop',
   	component: Index,
   	redirect: '/shop/photos',
   	children: [
   		{
	        path: 'photos',
	        component: SelectPhoto,
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
            component: ShopSellingDashboard,
            meta: {
                requiresAuth: true,
                shopAuth: true,
                title: 'Shop Selling',
	            breadcrumb: 'Shop Selling'
            }
        },
	],

}
