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
					<v-toolbar-title class="text-capitalize">Add Photographer</v-toolbar-title>
					<v-spacer></v-spacer>
					<v-toolbar-side-icon @click.stop="drawerRight = !drawerRight">
						<v-icon>
							fas fa-times
						</v-icon>
					</v-toolbar-side-icon>
				</v-toolbar>
				<v-divider class="no-mg-bottom"></v-divider>
				<v-form
				ref="form"
				v-model="valid"
				lazy-validation
				>
					<v-list class="heigth-list-title">

						<v-alert  v-model="alertStt" :type="alertType" dismissible>{{ alertMes }}</v-alert>

						<v-list-tile class="height-80">
							<v-list-tile-content class="h-100">
								<v-list-tile-title class="content-flex-end h-100">
									<span class="font-weight-bold item-title position-item">Select Branch:</span>
									<span class="contain-text-field">
										<v-select
						                class="font-weight-bold height-input"
						                outline
						                :items="branches"
						                item-value="id"
		              					item-text="name"
						                v-model="photographer.branch_id"
						                :rules="[rules.required]"
						              ></v-select>
									</span>
								</v-list-tile-title>
							</v-list-tile-content>
						</v-list-tile>
						<v-divider class="no-mg-bottom"></v-divider>

						<v-list-tile class="height-80">
							<v-list-tile-content class="h-100">
								<v-list-tile-title class="content-flex-end h-100">
									<span class="font-weight-bold item-title position-item">Name:</span>
									<span class="contain-text-field">
										<v-text-field
										class="font-weight-bold height-input"
										placeholder="Enter Name"
										v-model="photographer.name"
										outline
										:rules="[rules.required]"

										></v-text-field>
									</span>
								</v-list-tile-title>
							</v-list-tile-content>
						</v-list-tile>
						<v-divider class="no-mg-bottom"></v-divider>

						<v-list-tile class="height-80">
							<v-list-tile-content class="h-100">
								<v-list-tile-title class="content-flex-end h-100">
									<span class="font-weight-bold item-title position-item">Phone Number:</span>
									<span class="contain-text-field">
										<v-text-field
										class="font-weight-bold height-input"
										placeholder="Enter Phone"
										v-model="photographer.phone_number"
										outline
										:rules="[rules.required]"
										
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
										v-model="photographer.address"
										outline
										:rules="[rules.required]"
										
										></v-text-field>
									</span>
								</v-list-tile-title>
							</v-list-tile-content>
						</v-list-tile>
						<v-divider class="no-mg-bottom"></v-divider>

						<v-list-tile class="height-80">
							<v-list-tile-content class="h-100">
								<v-list-tile-title class="content-flex-end h-100">
									<span class="font-weight-bold item-title position-item">Status:</span>
									<span class="contain-text-field">
										<v-select
						                class="font-weight-bold height-input"
						                outline
						                :items="status"
						                v-model="photographer.status"
						                :rules="[rules.required]"
						              ></v-select>
									</span>
								</v-list-tile-title>
							</v-list-tile-content>
						</v-list-tile>

					</v-list>
				</v-form>
						<v-spacer></v-spacer>

						<v-card-actions class="w-100 border border-left-0 border-right-0 border-bottom-0 pr-4 bottom-position flex-end">
							<v-btn dark color="indigo" class="add-btn" @click="savePhotographer()">
								Save
							</v-btn>
							<v-btn @click.stop="drawerRight = !drawerRight">Close</v-btn>
						</v-card-actions>

			</v-card>      	
		</v-navigation-drawer>
	</v-layout>
</template>

<script>
import  { get, post, put, del, getWithData } from '../../../api/index.js'
import config from '../../../config/index.js'

export default {

  name: 'PhotographerAdd',

  	data () {
	    return {
	    	drawerRight: false,
	    	photographer: {},
	    	rules: {
		        required: value => !!value || 'This field is required.'
	    	},
	    	valid: true,
	    	branches: [],
	    	company: JSON.parse(localStorage.getItem('user')),
			status: ['Active', 'Inactive'],
			alertStt:false,
			alertType:'success',
			alertMes: ''
	    }
  	},
  	mounted() {
  		this.$root.$on('showPhotographerAdd', res => {
  			this.photographer = {}
  			this.$refs.form.reset()
  			this.drawerRight = res.showNavigation
  		});

  		this.getBranchCompany()
  	},
  	methods: {
  		getBranchCompany()
  		{
  			get(config.API_URL+'company/branches?companyId='+this.company.company_id)
			.then(response => {
				if(response && response.data.success) {

					this.branches = response.data.data
				}			
				
			})
			.catch(error => {
				console.log(error)
			})
  		},
  		savePhotographer()
  		{
  			if (this.$refs.form.validate()) {

	  			let params = {information: this.photographer, userId: this.company.id}
	  			post(config.API_URL+'photographer', params)	
	  			.then(response =>{
	  				if(response && response.data.success) {
	  					this.$root.$emit('reloadTablePhotographer')
	  					this.alertStt = true
					    this.alertMes = response.data.message

					    setTimeout(() => {
					          this.alertStt = false
					          this.drawerRight = false
					    }, 2000)
	  				}
	  			})
	  			.catch(error => {
	  				console.log(error)
	  			})
	  		}
  		}
  	}
}
</script>

<style lang="css" scoped>
</style>