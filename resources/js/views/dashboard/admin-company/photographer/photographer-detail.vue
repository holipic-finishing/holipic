<template>
	 <v-navigation-drawer 
    fixed
    v-model="drawerRight" 
    right
    temporary 
    app 
    class="chat-sidebar-wrap"
    width="450"
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
		    <v-list>
				<template>
					
					<v-list-tile>
						<v-list-tile-content>
				          	<v-list-tile-title class="content-flex">
					          	<span class="font-weight-bold item-title">Branch name:</span>
					          	<span v-if="photographer.branch" class="max-value">{{photographer.branch.branch_name}}</span>
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

	     		 	<v-list-tile>
						<v-list-tile-content>
				          	<v-list-tile-title class="content-flex">
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
	    
	</v-layout>
</template>

<script>
export default {

  	name: 'photographer-detail',

  	data () {
	    return {
	    	drawerRight: false,
	    	photographer: []
	    }
  	},
  	mounted()
  	{
  		this.$root.$on('showInfoPhototographer', res => {
  			this.photographer = res.data
  			this.drawerRight = res.showNavigation
  		})
  	}
}
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