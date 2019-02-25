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
			<!-- Toolbar Header -->
			<v-toolbar class="mb-3">
				<v-toolbar-title class="text-capitalize">
					Add Branch
				</v-toolbar-title>
				<v-spacer></v-spacer>
				<v-toolbar-side-icon @click.stop="drawerRight = !drawerRight">
					<v-icon>
						fas fa-times
					</v-icon>
				</v-toolbar-side-icon>
			</v-toolbar>
			<!--End Toolbar Header -->
			<!-- Form Add New Branch -->
			<v-form
				ref="form"
				v-model="valid"
				lazy-validation
			>
				<v-list class="heigth-list-title">

					<v-list-tile class="height-65">
						<v-list-tile-content class="h-100">
							<v-list-tile-title class="content-flex-end h-100">
								<span class="item-title position-item">Branch Name:</span>
								<span class="contain-text-field">
									<v-text-field
										class="height-input"
										placeholder="Input Your Branch Name"
										v-model="branch.branchName"
										:rules="[rules.required]"
									></v-text-field>
								</span>
							</v-list-tile-title>
						</v-list-tile-content>
					</v-list-tile>
					<v-divider class="m-0"></v-divider>

					<v-list-tile class="height-65">
						<v-list-tile-content class="h-100">
							<v-list-tile-title class="content-flex-end h-100">
								<span class="item-title position-item">Username:</span>
								<span class="contain-text-field">
									<v-text-field
										class="height-input"
										placeholder="Input Your Username"
										v-model="branch.username"
										:rules="[rules.required]"
									></v-text-field>
								</span>
							</v-list-tile-title>
						</v-list-tile-content>
					</v-list-tile>
					<v-divider class="m-0"></v-divider>

					<v-list-tile class="height-65">
						<v-list-tile-content class="h-100">
							<v-list-tile-title class="content-flex-end h-100">
								<span class="item-title position-item">Password:</span>
								<span class="contain-text-field">
									<v-text-field
										class="height-input"
										placeholder="Input Your Password"
										v-model="branch.password"
										:rules="[rules.required]"
									></v-text-field>
								</span>
							</v-list-tile-title>
						</v-list-tile-content>
					</v-list-tile>
					<v-divider class="m-0"></v-divider>

					<v-list-tile class="height-65">
						<v-list-tile-content class="h-100">
							<v-list-tile-title class="content-flex-end h-100">
								<span class="item-title position-item">Address:</span>
								<span class="contain-text-field">
									<v-text-field
										class="height-input"
										placeholder="Input Your Address"
										v-model="branch.address"
										:rules="[rules.required]"
									></v-text-field>
								</span>
							</v-list-tile-title>
						</v-list-tile-content>
					</v-list-tile>
					<v-divider class="m-0"></v-divider>

					<v-list-tile class="height-65">
						<v-list-tile-content class="h-100">
							<v-list-tile-title class="content-flex-end h-100">
								<span class="item-title position-item">Phone:</span>
								<span class="contain-text-field">
									<v-text-field
										class="height-input"
										placeholder="Input Your Phone"
										v-model="branch.phone"
										:rules="[rules.required]"
									></v-text-field>
								</span>
							</v-list-tile-title>
						</v-list-tile-content>
					</v-list-tile>
					<v-divider class="m-0"></v-divider>

					<v-flex xs12 sm12 class="style-flex fix-style-flex">
						<v-btn dark color="indigo" class="add-btn" @click="saveBranch()">
							Save
						</v-btn>
					</v-flex>

				</v-list>
			</v-form>
		</v-card>
	</v-navigation-drawer>
</template>

<script>

import  { get, post, put, del, getWithData } from '../../../api/index.js'
import config from '../../../config/index.js'
import Vue from 'vue'
import { getWithContentWrap } from '../../../helpers/helpers'

export default {

  name: 'BranchAdd',

  data () {
    return {
    	branch: {},
    	drawerRight: false,
    	rules: {
	        required: value => !!value || 'This field is required.'
    	},
    	valid: true,
    	company: JSON.parse(localStorage.getItem('user')),
    	alertStt:false,
			alertType:'success',
			alertMes: '',
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
  	this.$root.$on('drawer-status', res => {
  		this.drawerHeaderStt = res
  	})

  	this.$root.$on('sendEventBranchAdd', response => {
  		this.branch = {}
  		this.$refs.form.reset()
  		this.drawerRight =  response.showNavigation
  		this.width = this.getCurrentWithContentWrap()

  	})
  },
  methods: {
  	getCurrentWithContentWrap(){
  		return getWithContentWrap(this.drawerHeaderStt)
  	},
  	saveBranch() {
  		if (this.$refs.form.validate()) {
  			let params = {information: this.branch, companyId: this.company.company_id}
  			post(config.API_URL+'company/branch', params)
  			.then(response => {
  				if(response && response.data.success) {
  					this.$root.$emit('reloadTableBranch')
  					this.alertType = 'success'
						this.alertMes = response.data.message

						this.$notify({
		          title: 'Success',
		          message: this.alertMes,
		          type: this.alertType,
		          duration: 2000,
		        })
  				}
  			})
  			.catch(error => {
  				this.alertType = 'error'
					this.alertMes = error.response.data.message
					this.$notify({
	          title: 'Error',
	          message: this.alertMes,
	          type: this.alertType,
	          duration: 2000,
	        })
  			})
  		}
  	}
  }
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
