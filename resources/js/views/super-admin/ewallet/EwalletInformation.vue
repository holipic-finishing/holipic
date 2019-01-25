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
	      		<v-toolbar-title class="text-capitalize">Ewallet Withdraw Detail</v-toolbar-title>
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
					          	<span class="font-weight-bold item-title">Company name:</span>
					          	<span  class="max-value" v-if="item.company != null ">{{item.company.name}}</span>
		          			</v-list-tile-title>
						</v-list-tile-content>
					</v-list-tile>
	     		 	<v-divider class="no-mg-bottom"></v-divider>

	     		 	<v-list-tile>
						<v-list-tile-content>
				          	<v-list-tile-title class="content-flex">
					          	<span class="font-weight-bold item-title">Bank acount mame:</span>
					          	<span class="max-value">{{item.bank_account_number}}	</span>
		          			</v-list-tile-title>
						</v-list-tile-content>
					</v-list-tile>
	     		 	<v-divider class="no-mg-bottom"></v-divider>

	     		 	<v-list-tile>
						<v-list-tile-content>
				          	<v-list-tile-title class="content-flex">
					          	<span class="font-weight-bold item-title">Bank name:</span>
					          	<span class="max-value">{{item.bank_name}}</span>
		          			</v-list-tile-title>
						</v-list-tile-content>
					</v-list-tile>
	     		 	<v-divider class="no-mg-bottom"></v-divider>

	     		 	<v-list-tile>
						<v-list-tile-content>
				          	<v-list-tile-title class="content-flex">
					          	<span class="font-weight-bold item-title">Account holder name:</span>
					          	<span class="max-value">{{item.account_holder_name}}</span>
		          			</v-list-tile-title>
						</v-list-tile-content>
					</v-list-tile>
	     		 	<v-divider class="no-mg-bottom"></v-divider>

	     		 	<v-list-tile>
						<v-list-tile-content>
				          	<v-list-tile-title class="content-flex">
					          	<span class="font-weight-bold item-title">Iban:</span>
					          	<span class="max-value">{{item.iban}}</span>
		          			</v-list-tile-title>
						</v-list-tile-content>
					</v-list-tile>
	     		 	<v-divider class="no-mg-bottom"></v-divider>

	     		 	<v-list-tile>
						<v-list-tile-content>
				          	<v-list-tile-title class="content-flex">
					          	<span class="font-weight-bold item-title">Swift code:</span>
					          	<span class="max-value">{{item.swift_code}}</span>
		          			</v-list-tile-title>
						</v-list-tile-content>
					</v-list-tile>
	     		 	<v-divider class="no-mg-bottom"></v-divider>

	     		 	<v-list-tile>
						<v-list-tile-content>
				          	<v-list-tile-title class="content-flex">
					          	<span class="font-weight-bold item-title">Status:</span>
					          	<span class="max-value">{{item.status}}</span>
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
export default {

  name: 'EwalletInformation',

  data () {
    return {
    	drawerRight: false,
	    item: {},
	    selectStatus: ['DONE', 'PENDING']
    }
  },
  mounted() {
  	this.$root.$on('showInfoEwallet', res => {
  			this.drawerRight = true
  			this.item = res.data 
  	})
  }
};
</script>

<style lang="css" scoped>
</style>