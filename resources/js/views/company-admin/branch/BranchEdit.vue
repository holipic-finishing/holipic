<template>
	<v-navigation-drawer 
    fixed
    v-model="drawerRight" 
    right
    temporary 
    app 
    class="chat-sidebar-wrap"
    :width='widthComputed'
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

		  <v-list class="heigth-list-title">

      	<!-- <v-alert  v-model="alertStt" :type="alertType" dismissible>{{ alertMes }}</v-alert> -->

	    	<v-list-tile class="height-80">
	        <v-list-tile-content class="h-100">
	          <v-list-tile-title class="content-flex-end h-100">
	            <span class="font-weight-bold item-title position-item">Branch Name:</span>
	            <span class="contain-text-field">
	              <v-text-field
	                class="font-weight-bold height-input"
	                placeholder="Enter Branch Name"
	                v-model="branch.name"
	                outline
	                @blur="updateBranch('name', branch.name)"
	                @keyup.enter="updateBranch('name', branch.name)"
	              ></v-text-field>
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
	                v-model="branch.branch_password"
	                outline
	                @blur="updateBranch('password', branch.branch_password)"
	                @keyup.enter="updateBranch('password', branch.branch_password)"
	              ></v-text-field>
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
	                @blur="updateBranch('address', branch.branch_address)"
	                @keyup.enter="updateBranch('address', branch.branch_address)"
	              ></v-text-field>
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
	                @blur="updateBranch('phone', branch.branch_phone_number)"
	                @keyup.enter="updateBranch('phone', branch.branch_phone_number)"
	              ></v-text-field>
	            </span>
	          </v-list-tile-title>
	        </v-list-tile-content>
      	</v-list-tile>
      	<v-divider class="no-mg-bottom"></v-divider>

		  </v-list>

      <v-card-actions class="w-100 border border-left-0 border-right-0 border-bottom-0 pr-4 bottom-position flex-end">
	      <v-btn @click.stop="drawerRight = !drawerRight">Close</v-btn>
	    </v-card-actions>
		</v-card>      	
  </v-navigation-drawer>
</template>

<script>
import  { get, post, put, del, getWithData } from '../../../api'
import config from '../../../config'
import { getWithContentWrap } from '../../../helpers/helpers'

export default {

  name: 'BranchEdit',

	data () {
    return {
    	drawerRight: false,
    	branch: [],
    	key: 0,
    	alertType: 'success',
    	alertMes: '',
    	drawerHeaderStt: null,
    	width: 0,
    }
	},
	mounted() {
		this.$root.$on('drawer-status', res => {
  		this.drawerHeaderStt = res
  	})

  	this.$root.$on('sendEventBranchEdit', response => {
  		this.drawerRight =  response.showNavigation
  		this.branch = response.data
  		this.width = this.getCurrentWithContentWrap()
  	})
	},
	methods: {
		getCurrentWithContentWrap(){
  		return getWithContentWrap(this.drawerHeaderStt)
  	},
		unDisableItem(index) {
			this.key = index
		},
		checkValue(){
			if(this.branch.name == '' || this.branch.branch_address == '' || this.branch.branch_password == '' || this.branch.branch_phone_number == '') {

        this.alertType = 'error'
        this.alertMes = 'Please type text'
        this.$notify({
          title: 'Error',
          message: this.alertMes,
          type: this.alertType,
          duration: 2000,
        })      
				this.$root.$emit('reloadTableBranch')
				this.key = 0
				return false
			}
			return true
		},
		updateBranch(field, value){
			let params = {}

			switch(field) {
			  case "name":
			    params = {name: value};
			    break;
			  case "address":
			    params = {branch_address: value};
			    break;
			  case "password":
			     params = {branch_password: value};
			    break;
			  default:
			    params = {branch_phone_number: value};
			}

			if(this.checkValue())
			{
				put(config.API_URL+'branches/'+this.branch.id, {params: params})
				.then (response => {
					if(response && response.data.success) {
						this.company = response.data.data
          	this.alertType = 'success'
          	this.alertMes = 'Update Item Successfully'					
          	this.$notify({
		          title: 'Success',
		          message: this.alertMes,
		          type: this.alertType,
		          duration: 2000,
		        }) 
						this.key = 0
						this.$root.$emit('reloadTableBranch')
					}
				})

				.catch((e) =>{
	        this.alertType = 'error'
	        this.alertMes = 'System Error Occurred'         
	        this.$notify({
	          title: 'Error',
	          message: this.alertMes,
	          type: this.alertType,
	          duration: 2000,
		      }) 
					this.$root.$emit('reloadTableBranch')
					this.key = 0
				})	

			}	
		}
	},
	computed: {
  	widthComputed(){
  		return this.width
  	}
  }
};
</script>

<style lang="scss" scoped>
</style>