<template>
	<v-navigation-drawer 
	    fixed
	    v-model="drawerRight" 
	    right
	    temporary 
	    app 
	    this.width = this.getCurrentWithContentWrap()
  		:width='widthComputed'
  		>

	    <v-card class="h-100 position-relative">
			<v-toolbar>
	      		<v-toolbar-title class="text-capitalize">Order ID: {{order.id}}</v-toolbar-title>
	      		<v-spacer></v-spacer>
	     			<v-toolbar-side-icon @click.stop="drawerRight = !drawerRight">
		      		<v-icon>
		          		fas fa-times
		        	</v-icon>
	      		</v-toolbar-side-icon>
	    </v-toolbar>
		    <v-divider class="no-mg-bottom"></v-divider>
			  
			  <!-- Show information -->
		    <v-list class="heigth-list-title">
				
				<v-list-tile>
					<v-list-tile-content>
			          	<v-list-tile-title class="content-flex">
				          	<span class="font-weight-bold item-title"> Branch:</span>
				          	<span class="max-value">{{order.branch.name}}</span>
	          			</v-list-tile-title>
					</v-list-tile-content>
				</v-list-tile>
	     		 <v-divider class="no-mg-bottom"></v-divider>

				
				<v-list-tile>
					<v-list-tile-content>
			          	<v-list-tile-title class="content-flex">
				          	<span class="font-weight-bold item-title">Photographer:</span>
				          	<span class="max-value" v-if="order.photographer != null">{{order.photographer.name}}</span>
				          	<span class="max-value" v-else>No photographer</span>
			         	</v-list-tile-title>
					</v-list-tile-content>
				</v-list-tile>
	      		<v-divider class="no-mg-bottom"></v-divider>


				<v-list-tile>
					<v-list-tile-content>
			         	<v-list-tile-title class="content-flex">
				          	<span class="font-weight-bold item-title">Room:</span>
				          	<span class="max-value" v-if="order.customer && order.customer.room">{{order.customer.room.room_hash}}</span>
				          	<span class="max-value" v-else>No room</span>

			          	</v-list-tile-title>
					</v-list-tile-content>
				</v-list-tile>
	      		<v-divider class="no-mg-bottom"></v-divider>

	      		<v-list-tile>
					<v-list-tile-content>
			         	<v-list-tile-title class="content-flex">
				          	<span class="font-weight-bold item-title">Total amount:</span>
				          	<span class="max-value">{{order.total_amount_to_dollar}}</span>
			          	</v-list-tile-title>
					</v-list-tile-content>
				</v-list-tile>
	      		<v-divider class="no-mg-bottom"></v-divider>

	      		<v-list-tile>
					<v-list-tile-content>
			         	<v-list-tile-title class="content-flex">
				          	<span class="font-weight-bold item-title">Purchase date:</span>
				          	<span class="max-value">{{order.purchase_date}}</span>
			          	</v-list-tile-title>
					</v-list-tile-content>
				</v-list-tile>
	      		<v-divider class="no-mg-bottom"></v-divider>

	      		<v-list-tile>
					<v-list-tile-content>
			         	<v-list-tile-title class="content-flex">
				          	<span class="font-weight-bold item-title">Download date:</span>
				          	<span class="max-value">{{order.download_date}}</span>
			          	</v-list-tile-title>
					</v-list-tile-content>
				</v-list-tile>
	      		<v-divider class="no-mg-bottom"></v-divider>	

	      		<v-list-tile>
					<v-list-tile-content>
			         	<v-list-tile-title class="content-flex">
				          	<span class="font-weight-bold item-title">Order date :</span>
				          	<span class="max-value">{{order.updated_at}}</span>
			          	</v-list-tile-title>
					</v-list-tile-content>
				</v-list-tile>
	      		<v-divider class="no-mg-bottom"></v-divider>

	      		<v-list-tile>
					<v-list-tile-content>
			         	<v-list-tile-title class="content-flex">
				          	<span class="font-weight-bold item-title">Customer email :</span>
				          	<span class="max-value" v-if="order.customer != null && order.customer.user">{{order.customer.user.email}}</span>
				          	<span class="max-value" v-else>No email</span>
			          	</v-list-tile-title>
					</v-list-tile-content>
				</v-list-tile>
	      		<v-divider class="no-mg-bottom"></v-divider>	

	      		<v-list-tile>
					<v-list-tile-content>
			         	<v-list-tile-title class="content-flex">
				          	<span class="font-weight-bold item-title">Payment method :</span>
				          	<span class="max-value">{{order.payment_method}}</span>
			          	</v-list-tile-title>
					</v-list-tile-content>
				</v-list-tile>
	      		<v-divider class="no-mg-bottom"></v-divider>	

	    	</v-list>

		    <v-card-actions class="w-100 border border-left-0 border-right-0 border-bottom-0 pr-4 bottom-position flex-end">
		      <v-btn @click.stop="drawerRight = !drawerRight">Close</v-btn>
		    </v-card-actions>
		    <!-- End close drawer button -->
		</v-card>
  	</v-navigation-drawer>
</template>

<script>
import { getWithContentWrap } from '../../../helpers/helpers'
export default {

  name: 'OrderDetail',

  data () {
    return {
    	drawerRight: false,
	    order: [],
	    width: 0,
		drawerHeaderStt: null
    }
  },
  computed: {
		widthComputed(){
			return this.width
		}
  },
  mounted() {
  	this.$root.$on('showDetailOrder', res => {
  		this.drawerRight = res.showNavigation
  		this.order = res.data
  		this.width = this.getCurrentWithContentWrap()
  	})
  },
  methods: {
  	getCurrentWithContentWrap(){
  		return getWithContentWrap(this.drawerHeaderStt)
  	}
  }
};
</script>

<style lang="scss" scoped>
.content-flex{
	height: auto !important;
	white-space: inherit !important;
}
.max-value{
	max-width: 63%;
	flex: 0 0 63%;
}
</style>