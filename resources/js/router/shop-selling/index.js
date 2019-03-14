import Index from '../../views/company-admin/shop-selling/index.vue'
import SelectPhoto from '../../views/company-admin/shop-selling/partials/SelectPhoto.vue'


export default {
	path: '/shop-selling',
   	component: Index,
   	redirect: '/shop-selling/show-photo',
   	children: [
   		{
	        path: '/shop-selling/show-photo',
	        component: SelectPhoto
	        
	    }
	]
}