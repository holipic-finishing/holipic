<template>
<v-container fluid pt-0 grid-list-xl mt-3>
	<v-layout row wrap>
		<v-flex xs12>
			<v-navigation-drawer
		    fixed
		    v-model="drawerRight"
		    right
		    temporary
		    app
		    this.width = this.getCurrentWithContentWrap()
    		:width='widthComputed'
		  	>

		      	<v-card class="h-100 position-relative">
					<v-toolbar>
			      		<v-toolbar-title class="text-capitalize">{{companyName}}</v-toolbar-title>
			      		<v-spacer></v-spacer>
			     		<v-toolbar-side-icon @click.stop="drawerRight = !drawerRight">
				      		<v-icon>
				          		fas fa-times
				        	</v-icon>
			      		</v-toolbar-side-icon>
			    	</v-toolbar>
				    <v-divider class="no-mg-bottom"></v-divider>

				    <v-list class="heigth-list-title">

		      			<v-alert  v-model="alertStt" :type="alertType" dismissible>{{ alertMes }}</v-alert>
		      			<v-form ref="form">
			      			<v-layout row wrap>
				      			<v-flex d-flex xs12 sm12 md12 class="flex-padding">
							    	<v-list-tile class="height-80">
								        <v-list-tile-content class="h-100">
								          <v-list-tile-title class="content-flex-end h-100">
								            <span class="font-weight-bold item-title position-item">Company Name:</span>
								            <span class="contain-text-field">
								              <v-text-field
								                class="font-weight-bold height-input"
								                placeholder="Enter Company Name"
								                v-model="company.name"
								                outline

								                @keyup.enter="updateCompany('name', company.name)"
								                :rules="[rules.required]"
								              ></v-text-field>
								            </span>
								           <!--  <span class="position-item">
								              <v-btn flat icon @click="unDisableItem(1)"><v-icon small>fas fa-marker</v-icon></v-btn>
								            </span> -->
								          </v-list-tile-title>
								        </v-list-tile-content>
							      	</v-list-tile>

						      	</v-flex>
						      	<v-flex d-flex xs12 sm12 md12 class="flex-padding">
						      		<v-divider class="no-mg-bottom"></v-divider>
						      	</v-flex>
						      	<v-flex d-flex xs12 sm12 md12 class="flex-padding">
							      	<v-list-tile class="height-80">
								        <v-list-tile-content class="h-100">
								          <v-list-tile-title class="content-flex-end h-100">
								            <span class="font-weight-bold item-title position-item">Address:</span>
								            <span class="contain-text-field">
								              <v-text-field
								                class="font-weight-bold height-input"
								                placeholder="Enter address"
								                v-model="company.address"
								                outline

								                @keyup.enter="updateCompany('address', company.address)"
								                :rules="[rules.required]"
								              ></v-text-field>
								            </span>
								           <!--  <span class="position-item">
								              <v-btn flat icon @click="unDisableItem(2)"><v-icon small>fas fa-marker</v-icon></v-btn>
								            </span> -->
								          </v-list-tile-title>
								        </v-list-tile-content>
							     	</v-list-tile>
							    </v-flex>
							    <v-flex d-flex xs12 sm12 md12 class="flex-padding">
							      	<v-divider class="no-mg-bottom"></v-divider>
						      	</v-flex>
						      	<v-flex d-flex xs12 sm12 md12 class="flex-padding">
							      	<v-list-tile class="height-80">
								        <v-list-tile-content class="h-100">
								          <v-list-tile-title class="content-flex-end h-100">
								            <span class="font-weight-bold item-title position-item">Description:</span>
								            <span class="contain-text-field">
								              <v-text-field
								                class="font-weight-bold height-input"
								                placeholder="Enter description"
								                v-model="company.description"
								                outline

								                @keyup.enter="updateCompany('description', company.description)"
								                :rules="[rules.required]"

								              ></v-text-field>
								            </span>
								            <!-- <span class="position-item">
								              <v-btn flat icon @click="unDisableItem(3)"><v-icon small>fas fa-marker</v-icon></v-btn>
								            </span> -->
								          </v-list-tile-title>
								        </v-list-tile-content>
							     	</v-list-tile>
							    </v-flex>
							    <v-flex d-flex xs12 sm12 md12 class="flex-padding">
							      	<v-divider class="no-mg-bottom"></v-divider>
						      	</v-flex>

						      	<v-flex d-flex xs12 sm12 md12 class="flex-padding">
							      	<v-list-tile class="height-80">
								        <v-list-tile-content class="h-100">
								          <v-list-tile-title class="content-flex-end h-100">
								            <span class="font-weight-bold item-title position-item">Phone:</span>
								            <span class="contain-text-field">
								              <v-text-field
								                class="font-weight-bold height-input"
								                placeholder="Enter phone"
								                v-model="company.phone"
								                outline

								                @keyup.enter="updateCompany('phone', company.phone)"
								                :rules="[rules.required]"
								              ></v-text-field>
								            </span>
								           <!--  <span class="position-item">
								              <v-btn flat icon @click="unDisableItem(4)"><v-icon small>fas fa-marker</v-icon></v-btn>
								            </span> -->
								          </v-list-tile-title>
								        </v-list-tile-content>
							     	</v-list-tile>
							    </v-flex>
							    <v-flex d-flex xs12 sm12 md12 class="flex-padding">
							      	<v-divider class="no-mg-bottom"></v-divider>
						      	</v-flex>
							</v-layout>
						</v-form>


				    </v-list>

				</v-card>
		    </v-navigation-drawer>
		</v-flex>
	</v-layout>
 </v-container>
</template>
<script>
import config from '../../../config/index.js'
import { getWithContentWrap } from '../../../helpers/helpers'

export default {
	name: 'CompanyEdit',
	data () {
		return {
			company: [],
			drawerRight: false,
			nameRules: [
        		v => !!v || 'Name is required'
      		],
      		descriptionRules: [
        		v => !!v || 'Description is required'
      		],
      		phoneRules: [
        		v =>  /^([0-9]*|\d*\.\d{1}?\d*)$/.test(v) || 'Phone is required and is number'

      		],
      		rules: {
		        required: value => !!value || 'This field is required.'
	    	},
      		alertType: 'success',
      		alertMes: '',
      		key: 0,
      		alertStt: false,
      		companyName: '',
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
		this.$root.$on('sendEventCompanyEdit', response => {
			this.drawerRight =  response.showNavigation
			this.company = response.data
			this.companyName = response.data.name
			this.width = this.getCurrentWithContentWrap()
		});

		this.$root.$on('drawer-status', res => {
  			this.drawerHeaderStt = res
  		})

	},

	methods: {
		getCurrentWithContentWrap(){
  			return getWithContentWrap(this.drawerHeaderStt)
  		},
		unDisableItem(key) {
			this.key = key
		},
		checkValue(){
			if(this.company.name == '' || this.company.address == '' || this.company.description == '' || this.company.phone == '')
			{
				this.alertStt = true
		        this.alertType = 'error'
		        this.alertMes = 'System Error Occurred'
		        setTimeout(() => {
		          this.alertStt = false
		        }, 1500)
				this.$root.$emit('editCompanySuccess')
				this.key = 0
				return false
			}
			return true
		},

		updateCompany(field, value) {

			let params = {}

			switch(field) {
			  case "name":
			    params = {name: this.company.name};
			    break;
			  case "address":
			    params = {address: this.company.address};
			    break;
			  case "description":
			    params = {description: this.company.description};
			    break;
			  default:
			    params = {phone: this.company.phone};
			}

			if(this.checkValue())
			{
				axios.put(config.API_URL+'companies/'+this.company.id, {params: params})
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
						this.$root.$emit('editCompanySuccess')

						 // setTimeout(function(){
						 // 	Vue.notify({
						 // 	 group: 'loggedIn',
						 // 	 type: 'success',
						 // 	 text: 'Update success'
						 // 	});
						 // },500);
					}
				})

				.catch((e) =>{
					this.alertStt = true
			        this.alertType = 'error'
			        this.alertMes = 'System Error Occurred'
			        setTimeout(() => {
			          this.alertStt = false
			        }, 1500)
					this.$root.$emit('editCompanySuccess')
					this.key = 0
				})

			}

		}
	}

}
</script>
