import Index from '../../views/customer/index.vue'
import Photo from '../../views/customer/partials/SelectPhotoCustomer.vue'

export default{
	path:'/customer',
	component: Index,
	redirect: 'customer/show-photo',
	children: [
		{
			path:'/customer/show-photo',
			component: Photo
		}
	]
}