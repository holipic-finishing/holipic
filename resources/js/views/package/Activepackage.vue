<template>
	<v-navigation-drawer
      fixed
      v-model="drawerRight"
      right
      clipped
      app
	  :width="400"
	  temporary
      >
  		<v-list dense>
	        <v-list-tile @click.stop="stopdrawerRight()">
		          	<v-list-tile-action>
		            	<v-icon>exit_to_app</v-icon>
		          	</v-list-tile-action>
		          	<v-list-tile-content>
		            	<v-list-tile-title>Exit Your Drawer</v-list-tile-title>
		          	</v-list-tile-content>
	        </v-list-tile>
	 	</v-list>
	 	<v-list two-line>
          <h4><v-icon>{{ check ? 'add' : 'edit'}}</v-icon> &nbsp;{{ check ? 'Add Package Admin' : 'Update Package Admin'}}</h4>
        </v-list> 
 		<v-form ref="form" @submit.prevent="savePackageAdd" v-show="check">
			<v-list two-line>
	            <v-list-tile>
	              <v-list-tile-content>
	  			        <v-flex xs12 sm12>
				          <v-text-field
				            label="Fee" 
				            v-model="item.fee"
		                    :rules="[rules.required, rules.decimal]"
				          ></v-text-field>
				        </v-flex>
	              </v-list-tile-content>

	              <v-list-tile-content>
	                	<v-flex xs12 sm12>
	 				        <v-text-field
					            label="Package Name" 
	 				            v-model="item.package_name"
	 			                :rules="[rules.required]"
	 				          ></v-text-field>
	 				        </v-flex>
	                
	              </v-list-tile-content>
	            </v-list-tile>

	            <v-list-tile>
	              <v-list-tile-content>
	                <v-flex xs12 sm12>
				          <v-text-field
				            label="Secure Storage" 
				            v-model="item.secure_storage"
		                    :rules="[rules.required]"
				          ></v-text-field>
				        </v-flex>
	              </v-list-tile-content>
	  
	               <v-list-tile-content>
			         <v-flex xs12 sm12>
			          	<v-text-field
		            		label="File Upload" 
			            	v-model="item.file_upload"
	                    	:rules="[rules.required, rules.number]"
			          	></v-text-field>
			        </v-flex>
	              </v-list-tile-content>
	            </v-list-tile>

	             <v-list-tile>
	              <v-list-tile-content>
			        <v-flex xs12 sm12>
			          <v-text-field
			            label="Minimum User" 
			            v-model="item.minimum_user"
	                    :rules="[rules.required, rules.number]"
			          ></v-text-field>
			        </v-flex>
	              </v-list-tile-content>
	  
	               <v-list-tile-content>
						<v-flex xs12 sm12>
				          <v-text-field
				            label="Max User" 
				            v-model="item.max_user"
		                    :rules="[rules.required]"
				          ></v-text-field>
				        </v-flex>
	              </v-list-tile-content>
	            </v-list-tile>
				<v-layout wrap class="style-content">
					<v-flex xs12 sm12 class="style-flex">
				         	<v-textarea label="Short Description" 
			                 	v-model="item.short_description"
			                   :rules="[rules.required]"
			                   auto-grow
			                   rows="3"
			                 >
			                </v-textarea>
				     </v-flex>
				     <v-flex xs12 sm12  class="style-flex">
			         	<v-textarea label="Full Description" 
		                 	v-model="item.full_description"       
							auto-grow
			                rows="3"		         
		                   	>
		                </v-textarea>
				        </v-flex>   
					<h4><v-icon>settings</v-icon> &nbsp;Setting Packages System</h4>
					<v-flex xs12 sm12 class="style-flex">
						<p>1.Cronjob expiry timing for deleting images files from company clouds to reduce space Packages (Day)</p>	
						<v-text-field
				            solo
				            :rules="[rules.required, rules.number]"	
				            v-model="item.expiration_date"
				            placeholder="Day"
				            counter="4"
				            maxlength="4"
				            append-outer-icon="edit"
				          ></v-text-field>		
					</v-flex>

					<v-flex xs12 sm12 class="style-flex">
						<p>2.Manage Credit Card fees Packages</p>	
						<v-text-field
				            solo
				            :rules="[rules.required, rules.decimal]"
				            v-model="item.card_fee"
				             placeholder="0.00"
				             append-outer-icon="edit"	
				          ></v-text-field>
					</v-flex>

					<v-flex xs12 sm12 class="style-flex">
						<p>3.Manage complimentary bonus to TopUp Packages</p>	
						<v-text-field
				            solo
				            :rules="[rules.required, rules.decimal]"
				            v-model="item.bonus"
				             placeholder="0.00"
				             append-outer-icon="edit"	
				          ></v-text-field>
					</v-flex>

					<v-flex xs12 sm12 class="style-flex">
						<p>4.On/off sms services Basic</p>	
						<v-switch
			              v-model="item.sms"
			              color="red"
			              hide-details></v-switch>
					</v-flex>

					<v-flex xs12 sm12 class="style-flex">
						<v-btn color="info" type="submit">SAVE</v-btn>
					</v-flex>
				</v-layout>	
	        </v-list> 
   		 </v-form>
   		<v-form ref="form1" @submit.prevent="savePackagesUpdate" v-show="!check"> 
	        <v-list two-line>
	            <v-list-tile>
	              <v-list-tile-content>
	  			        <v-flex xs12 sm12>
				          <v-text-field
				            label="Fee" 
				            v-model="data.fee"
		                    :rules="[rules.required, rules.decimal]"
				          ></v-text-field>
				        </v-flex>
	              </v-list-tile-content>

	              <v-list-tile-content>
	                	<v-flex xs12 sm12>
	 				        <v-text-field
					            label="Package Name" 
	 				            v-model="data.package_name"
	 			                :rules="[rules.required]"
	 				          ></v-text-field>
	 				        </v-flex>
	                
	              </v-list-tile-content>
	            </v-list-tile>

	            <v-list-tile>
	              <v-list-tile-content>
	                <v-flex xs12 sm12>
				          <v-text-field
				            label="Secure Storage" 
				            v-model="data.secure_storage"
		                    :rules="[rules.required]"
				          ></v-text-field>
				        </v-flex>
	              </v-list-tile-content>
	  
	               <v-list-tile-content>
			         <v-flex xs12 sm12>
			          	<v-text-field
		            		label="File Upload" 
			            	v-model="data.file_upload"
	                    	:rules="[rules.required, rules.number]"
			          	></v-text-field>
			        </v-flex>
	              </v-list-tile-content>
	            </v-list-tile>

	             <v-list-tile>
	              <v-list-tile-content>
			        <v-flex xs12 sm12>
			          <v-text-field
			            label="Minimum User" 
			            v-model="data.minimum_user"
	                    :rules="[rules.required, rules.number]"
			          ></v-text-field>
			        </v-flex>
	              </v-list-tile-content>
	  
	               <v-list-tile-content>
						<v-flex xs12 sm12>
				          <v-text-field
				            label="Max User" 
				            v-model="data.max_user"
		                    :rules="[rules.required]"
				          ></v-text-field>
				        </v-flex>
	              </v-list-tile-content>
	            </v-list-tile>
				<v-layout wrap class="style-content">
					<v-flex xs12 sm12 class="style-flex">
				         	<v-textarea label="Short Description" 
			                 	v-model="data.short_description"
			                   :rules="[rules.required]"
			                   auto-grow
			                   rows="3"
			                 >
			                </v-textarea>
				     </v-flex>
				     <v-flex xs12 sm12  class="style-flex">
			         	<v-textarea label="Full Description" 
		                 	v-model="data.full_description"       
							auto-grow
			                rows="3"		         
		                   	>
		                </v-textarea>
				        </v-flex>   
					<h4><v-icon>settings</v-icon> &nbsp;Setting Packages System</h4>
					<v-flex xs12 sm12 class="style-flex">
						<p>1.Cronjob expiry timing for deleting images files from company clouds to reduce space Packages (Day)</p>	
						<v-text-field
				            solo
				            :rules="[rules.required, rules.number]"	
				            v-model="data.expiration_date"
				            placeholder="Day"
				            counter="4"
				            maxlength="4"
				            append-outer-icon="edit"
				          ></v-text-field>		
					</v-flex>

					<v-flex xs12 sm12 class="style-flex">
						<p>2.Manage Credit Card fees Packages</p>	
						<v-text-field
				            solo
				            :rules="[rules.required, rules.decimal]"
				            v-model="data.card_fee"
				             placeholder="0.00"
				             append-outer-icon="edit"	
				          ></v-text-field>
					</v-flex>

					<v-flex xs12 sm12 class="style-flex">
						<p>3.Manage complimentary bonus to TopUp Packages</p>	
						<v-text-field
				            solo
				            :rules="[rules.required, rules.decimal]"
				            v-model="data.bonus"
				             placeholder="0.00"
				             append-outer-icon="edit"	
				          ></v-text-field>
					</v-flex>

					<v-flex xs12 sm12 class="style-flex">
						<p>4.On/off sms services Basic</p>	
						<v-switch
			              v-model="data.sms"
			              color="red"
			              hide-details></v-switch>
					</v-flex>

					<v-flex xs12 sm12 class="style-flex">
						<v-btn color="info" type="submit">SAVE</v-btn>
					</v-flex>
				</v-layout>	
	        </v-list> 
	    </v-form>    
        <v-list dense>
	        <v-list-tile @click.stop="stopdrawerRight()">
		          	<v-list-tile-action>
		            	<v-icon>exit_to_app</v-icon>
		          	</v-list-tile-action>
	        </v-list-tile>
	 	</v-list>
 </v-navigation-drawer>

</template>

<script>
import config from '../../config/index.js'
import { post, put } from '../../api/index.js'	
import Vue from 'vue'
export default {

	name: 'Activepackage',

	data () {
	    return {
	    	drawerRight: false,
		    check: false,
	    	rules: {
		        required: value => !!value || 'Required.',
	          	number: value => {
		            const abc = /^[0-9]\d*$/
		            return abc.test(value) || 'Please input number.'
	          	},
	          	decimal: value => {
		            const abc = /^[1-9]\d*(\.\d+)?$/
		            return abc.test(value) || 'Please input number.'
	          	},

	        },
	        item:{},
	        data:{}
	    }
	},
	methods:{
		stopdrawerRight(){
			this.drawerRight = false
		},

		savePackageAdd(){
      		if (this.$refs.form.validate()) {
      			let url = config.API_URL+'packages'
      		 	post(url,this.item)
      		 	.then((res) => {
      		 		 if(res.data && res.data.success){
	                    setTimeout(function(){
				            Vue.notify({
				                group: 'loggedIn',
				                type: 'success',
				                text: 'Add Success!'
				            });
					    },500);
	                    this.drawerRight = false
	                    this.$root.$emit('reload-table', true)
                	}
      		 	})
      		 	.catch((err) =>{
      		 		console.log(err)
      		 	})
      		}
      	},

      	savePackagesUpdate(){
      		if (this.$refs.form1.validate()) {
      			let url = config.API_URL+'packages/'+this.data.id
      		 	put(url,this.data)
      		 	.then((res) => {
      		 		 if(res.data && res.data.success){
	                    setTimeout(function(){
				            Vue.notify({
				                group: 'loggedIn',
				                type: 'success',
				                text: 'Update Packages Success!'
				            });
					    },500);
	                    this.drawerRight = false
	                    this.$root.$emit('reload-table', true)
                	}
      		 	})
      		 	.catch((err) =>{
      		 		console.log(err)
      		 	})
      		}
      	}
	},
	mounted(){
		this.$root.$on('change-status', res => {
          	this.drawerRight = res.showDialog
    		this.check = res.check
    		this.item = {
    		}
      	})

      	this.$root.$on('data-packages', res => {
    		this.data = res
    		console.log(this.setting)
 
    	})
	}
}
</script>

<style lang="css" scoped>
.text-center {
    display: block !important;
}
.style-content {
	margin: 0px !important;
}
.style-flex {
	padding: 0px 12px !important;
	font-weight: 500 !important;
}
h4 {
	padding-left : 10px
}
.style-flex p{
	margin-bottom: 0px !important;
}
</style>
