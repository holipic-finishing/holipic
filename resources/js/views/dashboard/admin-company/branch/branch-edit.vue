<template>
	<v-layout row wrap>

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
	      		<v-toolbar-title class="text-capitalize">Edit Branch</v-toolbar-title>
	      		<v-spacer></v-spacer>
	     		<v-toolbar-side-icon @click.stop="drawerRight = !drawerRight">
		      		<v-icon>
		          		fas fa-times
		        	</v-icon>
	      		</v-toolbar-side-icon>
	    	</v-toolbar>
		    <v-divider class="no-mg-bottom"></v-divider>

		    <v-list>

      			<v-alert  v-model="alertStt" :type="alertType" dismissible>{{ alertMes }}</v-alert>

		    	<v-list-tile class="height-80">
			        <v-list-tile-content class="h-100">
			          <v-list-tile-title class="content-flex-end h-100">
			            <span class="font-weight-bold item-title position-item">Branch Name:</span>
			            <span class="contain-text-field">
			              <v-text-field
			                class="font-weight-bold height-input"
			                placeholder="Enter Branch Name"
			                v-model="branch.branch_name"
			                outline
			                :disabled="key == 1 ? false : true"
			                 @keyup.enter="updateBranch('name', branch.branch_name)"
			              ></v-text-field>
			            </span>
			            <span class="position-item">
			              <v-btn flat icon @click="unDisableItem(1)"><v-icon small>fas fa-marker</v-icon></v-btn>
			            </span>
			          </v-list-tile-title>
			        </v-list-tile-content>
		      	</v-list-tile>
		      	<v-divider class="no-mg-bottom"></v-divider>

		      	<v-list-tile class="height-80">
			        <v-list-tile-content class="h-100">
			          <v-list-tile-title class="content-flex-end h-100">
			            <span class="font-weight-bold item-title position-item">Password:</span>
			            <span class="contain-text-field">
			              <v-text-field
			                class="font-weight-bold height-input"
			                placeholder="Enter Password"
			                v-model="branch.password"
			                outline
			                :disabled="key == 2 ? false : true"
			                 @keyup.enter="updateBranch('password', branch.password)"
			                
			              ></v-text-field>
			            </span>
			            <span class="position-item">
			              <v-btn flat icon @click="unDisableItem(2)"><v-icon small>fas fa-marker</v-icon></v-btn>
			            </span>
			          </v-list-tile-title>
			        </v-list-tile-content>
		      	</v-list-tile>
		      	<v-divider class="no-mg-bottom"></v-divider>

		      	<v-list-tile class="height-80">
			        <v-list-tile-content class="h-100">
			          <v-list-tile-title class="content-flex-end h-100">
			            <span class="font-weight-bold item-title position-item">Address:</span>
			            <span class="contain-text-field">
			              <v-text-field
			                class="font-weight-bold height-input"
			                placeholder="Enter Address"
			                v-model="branch.branch_address"
			                outline
			                :disabled="key == 3 ? false : true"
			                 @keyup.enter="updateBranch('address', branch.branch_address)"
			                
			              ></v-text-field>
			            </span>
			            <span class="position-item">
			              <v-btn flat icon @click="unDisableItem(3)"><v-icon small>fas fa-marker</v-icon></v-btn>
			            </span>
			          </v-list-tile-title>
			        </v-list-tile-content>
		      	</v-list-tile>
		      	<v-divider class="no-mg-bottom"></v-divider>

		      	<v-list-tile class="height-80">
			        <v-list-tile-content class="h-100">
			          <v-list-tile-title class="content-flex-end h-100">
			            <span class="font-weight-bold item-title position-item">Phone:</span>
			            <span class="contain-text-field">
			              <v-text-field
			                class="font-weight-bold height-input"
			                placeholder="Enter Phone"
			                v-model="branch.branch_phone_number"
			                outline
			                :disabled="key == 4 ? false : true"
			                 @keyup.enter="updateBranch('phone', branch.branch_phone_number)"
			                
			              ></v-text-field>
			            </span>
			            <span class="position-item">
			              <v-btn flat icon @click="unDisableItem(4)"><v-icon small>fas fa-marker</v-icon></v-btn>
			            </span>
			          </v-list-tile-title>
			        </v-list-tile-content>
		      	</v-list-tile>


		      <v-spacer></v-spacer>
		      	<v-card-actions class="w-100 border border-left-0 border-right-0 border-bottom-0 pr-4 bottom-position flex-end">
			      <v-btn @click.stop="drawerRight = !drawerRight">Close</v-btn>
			    </v-card-actions>

		    </v-list>
		</v-card>      	
    </v-navigation-drawer>
</v-layout>
</template>

<script>
import  { get, post, put, del, getWithData } from '../../../../api/index.js'
import config from '../../../../config/index.js'

export default {

  name: 'branch-edit',

	data () {
	    return {
	    	drawerRight: false,
	    	branch: [],
	    	key: 0,
	    	alertStt: false,
	    	alertType: 'success',
	    	alertMes: ''
	    }
	},
	mounted() {
	  	this.$root.$on('sendEventBranchEdit', response => {
	  		this.drawerRight =  response.showNavigation
	  		this.branch = response.data
	  	});
	},
	methods: {
		unDisableItem(index) 
		{
			this.key = index
		},
		checkValue(){
			if(this.branch.branch_name == '' || this.branch.branch_address == '' || this.branch.password == '' || this.branch.branch_phone_number == '')
			{
				this.alertStt = true
		        this.alertType = 'error'
		        this.alertMes = 'System Error Occurred'         
		        setTimeout(() => {
		          this.alertStt = false
		        }, 1500)
				this.$root.$emit('editBranchSuccess')
				this.key = 0
				return false
			}
			return true
		},
		updateBranch(field, value)
		{
			let params = {}

			switch(field) {
			  case "name":
			    params = {branch_name: this.branch.branch_name};
			    break;
			  case "address":
			    params = {branch_address: this.branch.branch_address};
			    break;
			  case "password":
			     params = {password: this.branch.password};
			    break;
			  default:
			    params = {branch_phone_number: this.branch.branch_phone_number};
			}

			if(this.checkValue())
			{
				put(config.API_URL+'branches/'+this.branch.id, {params: params})
				.then (response => {
					if(response && response.data.success) {
						this.company = response.data.data
						this.alertStt = true
			          	this.alertType = 'success'
			          	this.alertMes = 'Update Successfully'					
			          	setTimeout(() => {
			            	this.alertStt = false
						}, 1500)
						this.key = 0
						this.$root.$emit('editBranchSuccess')
						
					}
				})

				.catch((e) =>{
					this.alertStt = true
			        this.alertType = 'error'
			        this.alertMes = 'System Error Occurred'         
			        setTimeout(() => {
			          this.alertStt = false
			        }, 1500)
					this.$root.$emit('editBranchSuccess')
					this.key = 0
				})	

			}	
		}
	}
}
</script>

<style lang="css" scoped>
</style>