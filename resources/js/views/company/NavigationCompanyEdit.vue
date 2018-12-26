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
	      		<v-toolbar-title class="text-capitalize">{{company.name}}</v-toolbar-title>
	      		<v-spacer></v-spacer>
	     		<v-toolbar-side-icon @click.stop="drawerRight = !drawerRight">
		      		<v-icon>
		          		fas fa-times
		        	</v-icon>
	      		</v-toolbar-side-icon>
	    	</v-toolbar>
		    <v-divider class="no-mg-bottom"></v-divider>

		    <v-list>

		      <v-alert  v-model="alertStt" type="success" dismissible>......</v-alert>

		    	<v-list-tile class="height-80">
			        <v-list-tile-content class="h-100">
			          <v-list-tile-title class="content-flex-end h-100">
			            <span class="font-weight-bold item-title position-item">Company Name</span>
			            <span class="contain-text-field">
			              <v-text-field
			                class="font-weight-bold height-input"
			                placeholder="Enter Company Name"
			                v-model="company.name"
			                outline
			                :disabled="key == 1 ? false : true"
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
			            <span class="font-weight-bold item-title position-item">Address</span>
			            <span class="contain-text-field">
			              <v-text-field
			                class="font-weight-bold height-input"
			                placeholder="Enter Invoice"
			                v-model="company.address"
			                outline
			                :disabled="key == 2 ? false : true"
			                
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
			                placeholder="Enter Invoice"
			                v-model="company.description"
			                outline
			                :disabled="key == 3 ? false : true"
			                
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
			                placeholder="Enter Invoice"
			                v-model="company.phone"
			                outline
			                :disabled="key == 4 ? false : true"
			                
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
        		v =>  /^[0-9]+$/.test(v) || 'Phone is required and is number'
        		
      		],
      		alertStt:false,
      		key: 0

		}
	},
	mounted() {
		this.$root.$on('sendEventCompanyEdit', response => {
			this.drawerRight =  response.showNavigation
			this.company = response.data
		});
	},

	methods: {
		unDisableItem(key) {
			this.key = key
		},

		updateCompany() {
			if (this.$refs.form.validate()) {
  				axios.put(config.API_URL+'companies/'+this.company.id, {params: {name: this.company.name, address: this.company.address, description: this.company.description, phone: this.company.phone}})
  				.then (response => {
  					if(response && response.data.success) {
	  					this.company = response.data.data
	  					 setTimeout(function(){	
	  					 	Vue.notify({
	  					 	 group: 'loggedIn',
	  					 	 type: 'success',
	  					 	 text: 'Update success'
	  					 	});
	  					 },500);

  				}
  				})
  			} else {
  				setTimeout(function(){	
	  					 	Vue.notify({
	  					 	 group: 'loggedIn',
	  					 	 type: 'error',
	  					 	 text: 'Please check textfield'
	  					 	});
	  			},500);
  			}	
		}
	}
	
}
</script>
