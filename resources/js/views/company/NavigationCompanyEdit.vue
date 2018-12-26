<template>	
	<v-layout row wrap>
	
	
	<v-navigation-drawer
      fixed
      v-model="drawerRight"
      right
      clipped
      app
      :width="400"
      temporary
      class="chat-sidebar-wrap"
      style="overflow: auto;">
      	<v-list dense>
	        <v-list-tile @click.stop="drawerRight = !drawerRight">
		          	<v-list-tile-action>
		            	<v-icon>exit_to_app</v-icon>
		          	</v-list-tile-action>
		          	<v-list-tile-content>
		            	<!-- <v-list-tile-title>Exit Your Drawer</v-list-tile-title> -->
		          	</v-list-tile-content>
	        </v-list-tile>
      	</v-list>
      	<div class="container fix-navigation">
      		<div class="row image-company">
      			<div class="col-sm-12">
			    <img src="images/HOLIPIC-LOGO.png" alt="" width="170px">
      			</div>
			</div>
		    <div class="title-company"> {{company.name}}</div>
		        <v-list two-line>
		        	<div class="container">
			          	<div class="row">
			          		<div class="col-sm-12">
			          			<v-form ref="form" lazy-validation>
							    <v-text-field
							      :rules="nameRules"
							      :counter="10"
							      label="Company name"
							      data-vv-name="name"
							      v-model="company.name"
							      required
							    ></v-text-field>
							     <v-text-field
							      :rules="descriptionRules"
							      label="Address"
							      data-vv-name="address"
							      v-model="company.address"

							      required
							    ></v-text-field>
							    <v-text-field
							      :rules="descriptionRules"
							      label="Description"
							      data-vv-name="description"
							      v-model="company.description"

							      required
							    ></v-text-field>

							    <v-text-field
							      :rules="phoneRules"
							      label="Phone"
							      v-model="company.phone"
							
							      data-vv-name="phone"
							      required
							    ></v-text-field>

							    <v-btn @click="updateCompany">Update</v-btn>
							   
							  </v-form>
			          		</div>
			          		  

			          	</div>
		      		</div>
			          <button class="btn btn-primary btn-company"  type="submit" @click.stop="drawerRight = !drawerRight"> Close </button>
		        </v-list>    
      		</div>
      	
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
        		
      		]

		}
	},
	mounted() {
		this.$root.$on('sendEventCompanyEdit', response => {
			this.drawerRight =  response.showNavigation
			this.company = response.data
		});
	},

	methods: {
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
