import Index from '../../views/customer/index.vue'
import Photo from '../../views/customer/partials/SelectPhotoCustomer.vue'

export default{
	path:'/customer',
	component: Index,
	redirect: '/customer/photos',
	children: [
        {
            path:'photos',
			component: Photo,
			meta: {
                requiresAuth: true,
                customerAuth:true,
                title: 'Customer Photos',
	            breadcrumb: 'Customer Photos'
	        }
        },
	]
}
