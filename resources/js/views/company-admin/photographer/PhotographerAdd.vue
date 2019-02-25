<template>
	<v-layout row wrap>
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

						<!-- <v-alert  v-model="alertStt" :type="alertType" dismissible>{{ alertMes }}</v-alert> -->

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
						<v-divider></v-divider>
						<v-flex xs12 sm12 class="style-flex fix-style-flex">
							<v-btn dark color="indigo" class="add-btn" @click="savePhotographer()">
								Save
							</v-btn>
						</v-flex>

					</v-list>
				</v-form>

			</v-card>
		</v-navigation-drawer>
	</v-layout>
</template>

<script>

import  { get, post, put, del, getWithData } from '../../../api/index.js'
import config from '../../../config/index.js'
import { getWithContentWrap } from '../../../helpers/helpers'

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
			alertType:'success',
			alertMes: '',
			drawerHeaderStt: null,
  		width: 0,
    }
	},
	mounted() {
		this.$root.$on('drawer-status', res => {
  		this.drawerHeaderStt = res
  	})

		this.$root.$on('showPhotographerAdd', res => {
			this.photographer = {}
			this.$refs.form.reset()
			this.drawerRight = res.showNavigation
			this.width = this.getCurrentWithContentWrap()
		})

		this.getBranchCompany()
	},
  methods: {
  	getCurrentWithContentWrap(){
  		return getWithContentWrap(this.drawerHeaderStt)
  	},
		getBranchCompany() {
			get(config.API_URL+'company/branches?companyId='+this.company.company_id)
			.then(response => {
				if(response && response.data.success) {
					this.branches = response.data.data
				}

			})
			.catch(error => {
				this.$notify({
          title: 'Error',
          message: 'Cannot Load Branches',
          type: 'error',
        })
			})
		},
		savePhotographer() {
			if (this.$refs.form.validate()) {

  			let params = {information: this.photographer, userId: this.company.id}
  			post(config.API_URL+'photographer', params)
  			.then(response =>{
  				if(response && response.data.success) {
  					this.$root.$emit('reloadTablePhotographer')
				    this.alertMes = response.data.message
				    this.alertType = 'success'

				    this.$notify({
		          title: 'Success',
		          message: this.alertMes,
		          type: this.alertType,
		          duration: 2000,
		        })
  				}
  			})
  			.catch(error => {
  				this.$notify({
	          title: 'Error',
	          message: 'System Error Occurred',
	          type: 'error',
	          duration: 2000,
	        })
  			})
  		}
		}
	},
	computed: {
  	widthComputed(){
  		return this.width
  	}
  },
};
</script>

<style lang="scss" scoped>
.fix-style-flex{
	float: right;
}
.style-flex {
	padding: 5px 12px !important;
	font-weight: 500 !important;
}
</style>
