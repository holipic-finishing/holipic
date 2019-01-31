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

				<v-toolbar>
					<v-toolbar-title class="text-capitalize">Edit Photographer</v-toolbar-title>
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
			                v-model="currentSelectBranch"
			                @change="editPhotographer('branch', currentSelectBranch)"
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
											@blur="editPhotographer('name', photographer.name)"
											@keyup.enter="editPhotographer('name', photographer.name)"
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
											@blur="editPhotographer('phone_number', photographer.phone_number)"
											@keyup.enter="editPhotographer('phone_number', photographer.phone_number)"
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
											@blur="editPhotographer('address', photographer.address)"
											@keyup.enter="editPhotographer('address', photographer.address)"
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
			                v-model="selectStatus"
											@change="editPhotographer('status', selectStatus)"
						        ></v-select>
									</span>
								</v-list-tile-title>
							</v-list-tile-content>
						</v-list-tile>
						<v-divider class="no-mg-bottom"></v-divider>

					</v-list>
				</v-form>
				<v-spacer></v-spacer>

				<v-card-actions class="w-100 border border-left-0 border-right-0 border-bottom-0 pr-4 bottom-position flex-end">
					<v-btn @click.stop="drawerRight = !drawerRight">Close</v-btn>
				</v-card-actions>

			</v-card>      	
		</v-navigation-drawer>
	</v-layout>
</template>

<script>
import  { get, post, put, del, getWithData } from '../../../api'
import config from '../../../config'
import { getWithContentWrap } from '../../../helpers/helpers'

export default {

  name: 'PhotographerEdit',

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
			alertMes: '',
			key: 0,
			currentSelectBranch: {
        id: '',
        name: '' 
	    },
	    selectStatus:'',
	   	drawerHeaderStt: null,
  		width: 0,
    }
	},
	mounted() {
		this.$root.$on('drawer-status', res => {
  		this.drawerHeaderStt = res
  	})

  	this.$root.$on('showFormEditPhotgrapher', res => {
  		this.drawerRight = res.showNavigation
  		this.photographer = res.data
  		if(this.photographer.status){
  			this.selectStatus = 'Active'
  		} else {
  			this.selectStatus = 'Inactive'
  		}
  		this.currentSelectBranch = {id: res.data.branch.id, name: res.data.branch.name}
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
		unDisableItem(index) {
			this.key = index
		},
  	checkValue() {
			if(this.photographer.name == '' || this.photographer.address == '' || this.photographer.phone_number == '' || this.selectStatus == '') {
        this.alertType = 'error'
        this.alertMes = 'Please type text'         
        this.$notify({
          title: 'Error',
          message: this.alertMes,
          type: this.alertType,
          duration: 2000,
        })

				this.$root.$emit('reloadTablePhotographer')	
				this.key = 0
				return false
			}
			return true
		},
  	editPhotographer(field, value) {
			let params = {}

			switch(field) {
			 	case "branch" :
					params = {branch_id: value};
					break;
				case "name" :
					params = {name: value};
					break;
				case "phone_number" :
					params = {phone_number: value};
					break;
				case "address" :
					params = {address: value};
					break;
				case "status" :
					params = {status: value};
					break;
					default:
			}
  			
			if(this.checkValue()) {
				put(config.API_URL+'photographer/'+this.photographer.id, {params: params})
				.then (response => {
					if(response && response.data.success) {
          	this.alertType = 'success'
          	this.alertMes = response.data.message					
		        this.$notify({
		          title: 'Success',
		          message: this.alertMes,
		          type: this.alertType,
		          duration: 2000,
		        })
						this.key = 0
						this.$root.$emit('reloadTablePhotographer')	
					}
				})
				.catch((e) =>{
	        this.alertType = 'error'
	        this.alertMes = response.data.message         
	       	this.$notify({
	          title: 'Error',
	          message: this.alertMes,
	          type: this.alertType,
	          duration: 2000,
	        })
					this.$root.$emit('reloadTablePhotographer')
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