<template>
	<v-layout row wrap>
		<v-navigation-drawer
			fixed
	    	v-model="drawerRight"
	  		right
	    	clipped
	    	app
	    	:width='widthComputed'
	    	temporary
	  	>
      		<v-card class="h-100 position-relative">
				<v-toolbar class="mb-3">
		      		<v-toolbar-title class="text-capitalize">
						Edit Branch
					</v-toolbar-title>
		      		<v-spacer></v-spacer>
		     		<v-toolbar-side-icon @click.stop="drawerRight = !drawerRight">
			      		<v-icon>
			          		fas fa-times
			        	</v-icon>
		      		</v-toolbar-side-icon>
		    	</v-toolbar>

			    <v-list class="heigth-list-title">

			    	<v-list-tile class="height-55">
				        <v-list-tile-content class="h-100">
				       		<v-list-tile-title class="content-flex-end h-100">
				            	<span class="item-title position-item">Branch Name:</span>
				            	<span class="contain-text-field">
					              	<v-text-field
					                	class="height-input"
					                	placeholder="Enter Branch Name"
					                	v-model="branch.name"
					                	@blur="updateBranch('name', branch.name)"
					                	@keyup.enter="updateBranch('name', branch.name)"
										hide-details
										single-line
					              	></v-text-field>
				            	</span>
				          	</v-list-tile-title>
				    	</v-list-tile-content>
			      	</v-list-tile>
			      	<v-divider class="m-0"></v-divider>

			      	<v-list-tile class="height-55">
				    	<v-list-tile-content class="h-100">
				          	<v-list-tile-title class="content-flex-end h-100">
				            	<span class="item-title position-item">Password:</span>
				            	<span class="contain-text-field">
				              		<v-text-field
				                		class="height-input"
				                		placeholder="Enter Password"
						                v-model="branch.branch_password"
						                @blur="updateBranch('password', branch.branch_password)"
						                @keyup.enter="updateBranch('password', branch.branch_password)"
										hide-details
										single-line
				              		></v-text-field>
				            	</span>
				          	</v-list-tile-title>
				    	</v-list-tile-content>
			      	</v-list-tile>
			      	<v-divider class="m-0"></v-divider>

			      	<v-list-tile class="height-75">
				    	<v-list-tile-content class="h-100">
				          	<v-list-tile-title class="content-flex-end h-100">
				            	<span class="item-title">Address:</span>
				            	<span class="contain-text-field">
									<v-textarea
										placeholder="Enter Address"
										v-model="branch.branch_address"
						                @blur="updateBranch('address', branch.branch_address)"
						                @keyup.enter="updateBranch('address', branch.branch_address)"
										hide-details
										single-line
										rows="2"
									></v-textarea>
				            	</span>
				          	</v-list-tile-title>
				     	</v-list-tile-content>
			      	</v-list-tile>
			      	<v-divider class="m-0"></v-divider>

			      	<v-list-tile class="height-55">
				       	<v-list-tile-content class="h-100">
				          	<v-list-tile-title class="content-flex-end h-100">
				            	<span class="item-title position-item">Phone:</span>
					            <span class="contain-text-field">
					              	<v-text-field
						                class="height-input"
						                placeholder="Enter Phone"
						                v-model="branch.branch_phone_number"
						                @blur="updateBranch('phone', branch.branch_phone_number)"
						                @keyup.enter="updateBranch('phone', branch.branch_phone_number)"
										hide-details
										single-line
					              	></v-text-field>
					            </span>
				          	</v-list-tile-title>
				    	</v-list-tile-content>
			      	</v-list-tile>
			      	<v-divider class="m-0"></v-divider>

			    </v-list>
			</v-card>
    	</v-navigation-drawer>
	</v-layout>
</template>

<script>
import  { get, post, put, del, getWithData } from '../../../api/index.js'
import config from '../../../config/index.js'
import { getWithContentWrap } from '../../../helpers/helpers'
export default {

  name: 'branch-edit',

	data () {
	    return {
	    	drawerRight: false,
	    	branch: [],
	    	key: 0,
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
	  	this.$root.$on('sendEventBranchEdit', response => {
	  		this.drawerRight =  response.showNavigation
	  		this.branch = response.data
	  		this.width = this.getCurrentWithContentWrap()
	  	});
	},
	methods: {
		getCurrentWithContentWrap(){
  		return getWithContentWrap(this.drawerHeaderStt)
  	},
		unDisableItem(index)
		{
			this.key = index
		},
		checkValue(){
			if(this.branch.name == '' || this.branch.branch_address == '' || this.branch.branch_password == '' || this.branch.branch_phone_number == '')
			{
				this.$notify({
					title: "Error",
					message: "This Field Should Not Be Empty",
					duration: 1500,
					type: "error",
					showClose: true,
				})
				this.$root.$emit('reloadTableBranch')
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
						this.$notify({
							title: "Success",
							message: "Update Successfully",
							duration: 1500,
							type: "success",
							showClose: true,
						})
						this.key = 0
						this.$root.$emit('reloadTableBranch')

					}
				})

				.catch((e) =>{
					this.$notify({
						title: "Error",
						message: "System Error Occurred",
						duration: 1500,
						type: "success",
						showClose: true,
					})
					this.$root.$emit('reloadTableBranch')
					this.key = 0
				})

			}
		}
	}
};
</script>

<style lang="css" scoped>
</style>
