<template>
	<v-navigation-drawer 
	    fixed
	    v-model="drawerRight" 
	    right
	    temporary 
	    app 
	    clipped
	  	:width='widthComputed'	
  	>

	    <v-card class="h-100 position-relative">
			<v-toolbar>
    		<v-toolbar-title class="text-capitalize">Photographer Detail</v-toolbar-title>
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
				<template>

					<v-list-tile>
						<v-list-tile-content>
	          	<v-list-tile-title class="content-flex">
		          	<span class="font-weight-bold item-title">Branch name:</span>
		          	<span v-if="photographer.branch" class="max-value">{{photographer.branch.name}}</span>
        			</v-list-tile-title>
						</v-list-tile-content>
					</v-list-tile>
	     		<v-divider class="no-mg-bottom"></v-divider>

	     		<v-list-tile>
						<v-list-tile-content>
	          	<v-list-tile-title class="content-flex">
		          	<span class="font-weight-bold item-title">Name:</span>
		          	<span class="max-value">{{photographer.name}}</span>
        			</v-list-tile-title>
						</v-list-tile-content>
					</v-list-tile>
	     		<v-divider class="no-mg-bottom"></v-divider>

	     		<v-list-tile>
						<v-list-tile-content>
	          	<v-list-tile-title class="content-flex">
		          	<span class="font-weight-bold item-title">Phone:</span>
		          	<span class="max-value">{{photographer.phone_number}}</span>
        			</v-list-tile-title>
						</v-list-tile-content>
					</v-list-tile>
	     		<v-divider class="no-mg-bottom"></v-divider>


	     		 	<!-- <v-list-tile class="height-address"> -->

	     		<v-list-tile class="v-list-address">

						<v-list-tile-content >
	          	<v-list-tile-title class="content-flex ">
		          	<span class="font-weight-bold item-title">Address:</span>
		          	<span class="max-value">{{photographer.address}}</span>
        			</v-list-tile-title>
						</v-list-tile-content>
					</v-list-tile>
	     		<v-divider class="no-mg-bottom"></v-divider>

	     		<v-list-tile>
						<v-list-tile-content>
	          	<v-list-tile-title class="content-flex">
		          	<span class="font-weight-bold item-title">Added Date:</span>
		          	<span class="max-value">{{photographer.created_at}}</span>
        			</v-list-tile-title>
						</v-list-tile-content>
					</v-list-tile>
	     		<v-divider class="no-mg-bottom"></v-divider>

	     		<v-list-tile>
						<v-list-tile-content>
	          	<v-list-tile-title class="content-flex">
		          	<span class="font-weight-bold item-title">Status:</span>
		          	<span class="max-value">{{photographer.status == true ? 'Active': 'Inactive'}}</span>
        			</v-list-tile-title>
						</v-list-tile-content>
					</v-list-tile>
	     		<v-divider class="no-mg-bottom"></v-divider>

				</template>		
	    </v-list>
	    <!-- End show information -->

	    <!-- Close drawer button -->
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

	name: 'PhotographerDetail',

  	data () {
	    return {
	    	drawerRight: false,
	    	photographer: [],
	    	width: 0,
		   	drawerHeaderStt: null
	    }
  	},
  	computed: {
			widthComputed(){
				return this.width
			}
  	},
  	mounted()
  	{
  		this.$root.$on('showInfoPhototographer', res => {
  			this.photographer = res.data
  			this.drawerRight = res.showNavigation
  			this.width = this.getCurrentWithContentWrap()	
  		})
  	},
  	
	methods: {
  	getCurrentWithContentWrap(){
  		return getWithContentWrap(this.drawerHeaderStt)
  	},
  },
  computed: {
  	widthComputed(){
  		return this.width
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