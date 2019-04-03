import Index from '../../views/shop-selling/index.vue'
import SelectPhoto from '../../views/shop-selling/partials/SelectPhoto.vue'

export default {
	path: '/shop-selling',
   	component: Index,
   	redirect: '/shop-selling/show-photo',
   	children: [
   		{
	        path: '/shop-selling/show-photo',
	        component: SelectPhoto
	        
	    }
	],
	
}