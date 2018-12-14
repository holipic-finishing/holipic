<template>
	<div>
<v-dialog v-model="dialog" max-width="500px" @keydown.esc="close()">
        <v-card>
          <v-card-title class="text-center">
          	 <!-- <v-spacer></v-spacer> -->
            <span class="headline">{{ check ? 'Add Package Admin' : 'Update Package Admin'}}</span>
          </v-card-title>
          <v-card-text>
           <div>
	       <v-form ref="form" @submit.prevent="savePackageAdd" v-show="check">
			 	<v-container grid-list-md>
	                <v-layout wrap>
	                  	<v-flex xs12 sm6>
				          <v-text-field
				            label="Package Name" 
				            v-model="item.package_name"
			                :rules="[rules.required]"
				          ></v-text-field>
				        </v-flex>

				        <v-flex xs12 sm6>
				          <v-text-field
				            label="Fee" 
				            v-model="item.fee"
		                    :rules="[rules.required, rules.number]"
				          ></v-text-field>
				        </v-flex>

				         <v-flex xs12 sm6>
				          <v-text-field
				            label="Secure Storage" 
				            v-model="item.secure_storage"
		                    :rules="[rules.required]"
				          ></v-text-field>
				        </v-flex>

				         <v-flex xs12 sm6>
				          <v-text-field
				            label="File Upload" 
				            v-model="item.file_upload"
		                    :rules="[rules.required, rules.number]"
				          ></v-text-field>
				        </v-flex>
				        
				        <v-flex xs12 sm6>
				          <v-text-field
				            label="Minimum User" 
				            v-model="item.minimum_user"
		                    :rules="[rules.required, rules.number]"
				          ></v-text-field>
				        </v-flex>

				         <v-flex xs12 sm6>
				          <v-text-field
				            label="Max User" 
				            v-model="item.max_user"
		                    :rules="[rules.required]"
				          ></v-text-field>
				        </v-flex>

				        <v-flex xs12 sm12>
				         	<v-textarea label="Short Description" 
		                     	v-model="item.short_description"
		                       :rules="[rules.required]"
		                       	class="style-rextarea">
		                    </v-textarea>
				        </v-flex>

				         <v-flex xs12 sm12>
				         	<v-textarea label="Full Description" 
		                     	v-model="item.full_description"
		                       :rules="[rules.required]"
		                       	class="style-rextarea">
		                    </v-textarea>
				        </v-flex>
	                  
	              
	                  	<v-flex xs12 sm12 class="row style">
	                  	 <v-btn color="primary" type="submit">SAVE</v-btn> 
	                	</v-flex>
	                </v-layout>
            	</v-container>
			</v-form>
			</div>
			<div>
	       <v-form ref="form1" @submit.prevent="savePackagesUpdate" v-show="!check">
			 	<v-container grid-list-md>
	                <v-layout wrap>
	                  	<v-flex xs12 sm6>
				          <v-text-field
				            label="Package Name" 
				            v-model="data.package_name"
			                :rules="[rules.required]"
				          ></v-text-field>
				        </v-flex>

				        <v-flex xs12 sm6>
				          <v-text-field
				            label="Fee" 
				            v-model="data.fee"
		                    :rules="[rules.required, rules.number]"
				          ></v-text-field>
				        </v-flex>

				         <v-flex xs12 sm6>
				          <v-text-field
				            label="Secure Storage" 
				            v-model="data.secure_storage"
		                    :rules="[rules.required]"
				          ></v-text-field>
				        </v-flex>

				         <v-flex xs12 sm6>
				          <v-text-field
				            label="File Upload" 
				            v-model="data.file_upload"
		                    :rules="[rules.required, rules.number]"
				          ></v-text-field>
				        </v-flex>
				        
				        <v-flex xs12 sm6>
				          <v-text-field
				            label="Minimum User" 
				            v-model="data.minimum_user"
		                    :rules="[rules.required, rules.number]"
				          ></v-text-field>
				        </v-flex>

				         <v-flex xs12 sm6>
				          <v-text-field
				            label="Max User" 
				            v-model="data.max_user"
		                    :rules="[rules.required]"
				          ></v-text-field>
				        </v-flex>

				        <v-flex xs12 sm12>
				         	<v-textarea label="Short Description" 
		                     	v-model="data.short_description"
		                       :rules="[rules.required]"
		                       	class="style-rextarea">
		                    </v-textarea>
				        </v-flex>

				         <v-flex xs12 sm12>
				         	<v-textarea label="Full Description" 
		                     	v-model="data.full_description"
		                       :rules="[rules.required]"
		                       	class="style-rextarea">
		                    </v-textarea>
				        </v-flex>
	                  
	              
	                  	<v-flex xs12 sm12 class="row style">
	                  	 <v-btn color="primary" type="submit">SAVE</v-btn> 
	                	</v-flex>
	                </v-layout>
            	</v-container>
			</v-form>
			</div>
          </v-card-text>
          <v-card-actions>
              <v-spacer></v-spacer>
          </v-card-actions>

        </v-card>
</v-dialog>  
</div>
</template>

<script>
import config from '../../config/index.js'
import { post, put } from '../../api/index.js'	
import Vue from 'vue'
export default {

	name: 'Activepackage',

	data () {
	    return {
	    	dialog: false,
		    check: false,
	    	rules: {
		        required: value => !!value || 'Required.',
	          	number: value => {
		            const abc = /^[1-9]\d*(\.\d+)?$/
		            return abc.test(value) || 'Please input number.'
	          	},

	        },
	        item:{},
	        data:{}
	    }
	},
	methods:{
		close(){
        	this.dialog = false;
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
	                    this.dialog = false
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
	                    this.dialog = false
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
          	this.dialog = res.showDialog
    		this.check = res.check
    		this.item = {
    		}
      	})

      	this.$root.$on('data-packages', res => {
    		this.data = res
    	})
	}
}
</script>

<style lang="css" scoped>
.text-center {
    display: block !important;
}
</style>