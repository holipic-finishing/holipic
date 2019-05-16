import Index from '../../views/customer/index.vue'
import Photo from '../../views/customer/partials/SelectPhotoCustomer.vue'

export default{
	path:'/customer-page',
	component: Index,
	redirect: '/customer/show-photo',
	children: [
		{
			path:'/customer/show-photo',
			component: Photo,
			meta: {
         		customerAuth:true
	        }
		}
	]
}