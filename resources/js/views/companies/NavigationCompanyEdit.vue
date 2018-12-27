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
	      		<v-toolbar-title class="text-capitalize">{{companyName}}</v-toolbar-title>
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
			            <span class="font-weight-bold item-title position-item">Company Name:</span>
			            <span class="contain-text-field">
			              <v-text-field
			                class="font-weight-bold height-input"
			                placeholder="Enter Company Name"
			                v-model="company.name"
			                outline
			                :disabled="key == 1 ? false : true"
			                @keyup.enter="updateCompany('name', company.name)"
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
			            <span class="font-weight-bold item-title position-item">Address:</span>
			            <span class="contain-text-field">
			              <v-text-field
			                class="font-weight-bold height-input"
			                placeholder="Enter address"
			                v-model="company.address"
			                outline
			                :disabled="key == 2 ? false : true"
			                @keyup.enter="updateCompany('address', company.address)"
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
			            <span class="font-weight-bold item-title position-item">Description:</span>
			            <span class="contain-text-field">
			              <v-text-field
			                class="font-weight-bold height-input"
			                placeholder="Enter description"
			                v-model="company.description"
			                outline
			                :disabled="key == 3 ? false : true"
			                @keyup.enter="updateCompany('description', company.description)"
			                
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
			                placeholder="Enter phone"
			                v-model="company.phone"
			                outline
			                :disabled="key == 4 ? false : true"
			                @keyup.enter="updateCompany('phone', company.phone)"
			                
			              ></v-text-field>
			            </span>
			            <span class="position-item">
			              <v-btn flat icon @click="unDisableItem(4)"><v-icon small>fas fa-marker</v-icon></v-btn>
			            </span>
			          </v-list-tile-title>
			        </v-list-tile-content>
		     	</v-list-tile>
		      	<v-divider class="no-mg-bottom"></v-divider>


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
import config from '../../config/index.js'

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
      		alertType: 'success',
      		alertMes: '',
      		key: 0,
      		alertStt: false,
      		companyName: ''

		}
	},
	mounted() {
		this.$root.$on('sendEventCompanyEdit', response => {
			this.drawerRight =  response.showNavigation
			this.company = response.data
			this.companyName = response.data.name
		});
	},

	methods: {
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
