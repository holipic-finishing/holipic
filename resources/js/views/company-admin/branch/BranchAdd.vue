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
				<v-toolbar-title class="text-capitalize">Add Branch</v-toolbar-title>
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

					<!-- <v-alert v-model="alertStt" :type="alertType" dismissible>{{ alertMes }}</v-alert> -->

					<v-list-tile class="height-80">
						<v-list-tile-content class="h-100">
							<v-list-tile-title class="content-flex-end h-100">
								<span class="font-weight-bold item-title position-item">Branch Name:</span>
								<span class="contain-text-field">
									<v-text-field
										class="font-weight-bold height-input"
										placeholder="Enter Branch Name"
										v-model="branch.branchName"
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
								<span class="font-weight-bold item-title position-item">Username:</span>
								<span class="contain-text-field">
									<v-text-field
										class="font-weight-bold height-input"
										placeholder="Enter Username"
										v-model="branch.username"
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
								<span class="font-weight-bold item-title position-item">Password:</span>
								<span class="contain-text-field">
									<v-text-field
										class="font-weight-bold height-input"
										placeholder="Enter Password"
										v-model="branch.password"
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
										v-model="branch.address"
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
								<span class="font-weight-bold item-title position-item">Phone:</span>
								<span class="contain-text-field">
									<v-text-field
										class="font-weight-bold height-input"
										placeholder="Enter Phone"
										v-model="branch.phone"
										outline
										:rules="[rules.required]"
									></v-text-field>
								</span>
							</v-list-tile-title>
						</v-list-tile-content>
					</v-list-tile>
					<v-divider class="no-mg-bottom"></v-divider>

				</v-list>

				<!-- <v-spacer></v-spacer> -->

				<v-card-actions class="w-100 border border-left-0 border-right-0 border-bottom-0 pr-4 bottom-position flex-end fix-flex-end">
					<v-btn dark color="indigo" class="add-btn" @click="saveBranch()">
						Save
					</v-btn>
					<v-btn @click.stop="drawerRight = !drawerRight">Close</v-btn>
				</v-card-actions>
				
			</v-form>
		</v-card>      	
	</v-navigation-drawer>
</template>

<script>
import  { get, post, put, del, getWithData } from '../../../api'
import config from '../../../config'
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
  },
  computed: {
  	widthComputed(){
  		return this.width
  	}
  }
};
</script>

<style lang="scss" scoped>
	.fix-flex-end{
		margin-bottom: 0px;
		position:absolute;
		bottom: 0px;
	}
</style>