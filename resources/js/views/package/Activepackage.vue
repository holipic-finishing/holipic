<template>
	<v-card class="h-100 position-relative">
	<v-navigation-drawer
      fixed
      v-model="drawerRight"
      right
      clipped
      app
	  :width="450"
	  temporary
    >
  		<v-toolbar>
		    <!-- <v-toolbar-title class="text-capitalize">{{ check ? 'Add Package' : 'Update Package'}}</v-toolbar-title> -->
		    <v-toolbar-title v-if="check == 'add'" class="text-capitalize">Add Package</v-toolbar-title>
		    <v-toolbar-title v-if="check == 'setting'" class="text-capitalize">Setting Package</v-toolbar-title>
		    <v-toolbar-title v-if="check == 'edit'" class="text-capitalize">Update Package</v-toolbar-title>
		    <v-spacer></v-spacer>
		    <v-toolbar-side-icon @click.stop="stopdrawerRight()">
		      	<v-icon>
		          fas fa-times
		        </v-icon>
		    </v-toolbar-side-icon>
	    </v-toolbar>
	    <v-divider class="no-mg-bottom"></v-divider>
	 	<!-- <v-list two-line>
          <h4><v-icon>{{ check ? 'add' : 'edit'}}</v-icon> &nbsp;{{ check ? 'Add Package Admin' : 'Update Package Admin'}}</h4>
        </v-list>  -->
        <v-list v-show="check == 'add'" class="heigth-list-title">
	 		<v-form ref="form" @submit.prevent="savePackageAdd">
				<v-list two-line>
		           	<v-list-tile class="height-80">
				        <v-list-tile-content class="h-100">
				          <v-list-tile-title class="content-flex-end h-100">
				            <span class="font-weight-bold item-title position-item">Fee:</span>
				            <span class="contain-text-field">
				              <v-text-field
				                class="font-weight-bold height-input"
				                placeholder="Enter fee"
				                v-model="item.fee"
				                outline
				                :rules="[rules.required, rules.decimal]"
				              ></v-text-field>
				            </span>
				           <!--  <span class="position-item">
				              <v-btn flat icon><v-icon small>fas fa-marker</v-icon></v-btn>
				            </span> -->
				          </v-list-tile-title>
				        </v-list-tile-content>
				    </v-list-tile>
				    <v-divider class="no-mg-bottom"></v-divider>

				    <v-list-tile class="height-80">
				        <v-list-tile-content class="h-100">
				          <v-list-tile-title class="content-flex-end h-100">
				            <span class="font-weight-bold item-title position-item">Package name:</span>
				            <span class="contain-text-field">
				              <v-text-field
				                class="font-weight-bold height-input"
				                placeholder="Enter package name"
				                v-model="item.package_name"
		 			            :rules="[rules.required]"
				                outline       
				              ></v-text-field>
				            </span>
				          </v-list-tile-title>
				        </v-list-tile-content>
				    </v-list-tile>
				    <v-divider class="no-mg-bottom"></v-divider>

				    <v-list-tile class="height-80">
				        <v-list-tile-content class="h-100">
				          <v-list-tile-title class="content-flex-end h-100">
				            <span class="font-weight-bold item-title position-item">Secure Storage:</span>
				            <span class="contain-text-field">
				              <v-text-field
				                class="font-weight-bold height-input"
				                placeholder="Enter secure storage"
				               	v-model="item.secure_storage"
			                    :rules="[rules.required]"
				                outline                
				              ></v-text-field>
				            </span>
				          </v-list-tile-title>
				        </v-list-tile-content>
				    </v-list-tile>
				    <v-divider class="no-mg-bottom"></v-divider>

				    <v-list-tile class="height-80">
				        <v-list-tile-content class="h-100">
				          <v-list-tile-title class="content-flex-end h-100">
				            <span class="font-weight-bold item-title position-item">File upload:</span>
				            <span class="contain-text-field">
				              <v-text-field
				                class="font-weight-bold height-input"
				                placeholder="Enter file upload"
				               	v-model="item.file_upload"
		                    	:rules="[rules.required, rules.number]"
				                outline                
				              ></v-text-field>
				            </span>
				          </v-list-tile-title>
				        </v-list-tile-content>
				    </v-list-tile>
				    <v-divider class="no-mg-bottom"></v-divider>

				    <v-list-tile class="height-80">
				        <v-list-tile-content class="h-100">
				          <v-list-tile-title class="content-flex-end h-100">
				            <span class="font-weight-bold item-title position-item">Minimum User:</span>
				            <span class="contain-text-field">
				              <v-text-field
				                class="font-weight-bold height-input"
				                placeholder="Minimum user"
				              	v-model="item.minimum_user"
			                    :rules="[rules.required, rules.number]"
				                outline               
				              ></v-text-field>
				            </span>
				          </v-list-tile-title>
				        </v-list-tile-content>
				    </v-list-tile>
				    <v-divider class="no-mg-bottom"></v-divider>

				    <v-list-tile class="height-80">
				        <v-list-tile-content class="h-100">
				          <v-list-tile-title class="content-flex-end h-100">
				            <span class="font-weight-bold item-title position-item">Maximum User:</span>
				            <span class="contain-text-field">
				              <v-text-field
				                class="font-weight-bold height-input"
				                placeholder="Minimum user"
				              	v-model="item.max_user"
			                    :rules="[rules.required]"
				                outline
				                			                
				              ></v-text-field>
				            </span>
				          </v-list-tile-title>
				        </v-list-tile-content>
				    </v-list-tile>
				    <v-divider class="no-mg-bottom"></v-divider>

				    <v-list-tile class="height-80">
				        <v-list-tile-content class="h-100">
				          <v-list-tile-title class="content-flex-end h-100">
				            <span class="font-weight-bold item-title position-item">Short Description:</span>
				            <span class="contain-text-field">
				              <v-text-field
				                class="font-weight-bold height-input"
				                placeholder="Minimum user"
				              	v-model="item.short_description"
				                :rules="[rules.required]"
				                outline          
				              ></v-text-field>
				            </span>
				          </v-list-tile-title>
				        </v-list-tile-content>
				    </v-list-tile>
				    <v-divider class="no-mg-bottom"></v-divider>

				    <v-list-tile class="height-80">
				        <v-list-tile-content class="h-100">
				          <v-list-tile-title class="content-flex-end h-100">
				            <span class="font-weight-bold item-title position-item">Expiry for deleting images files:</span>
				            <span class="contain-text-field fix-contain-text-field">
				              <v-text-field
				                class="font-weight-bold height-input"
				                placeholder="0"
				              	:rules="[rules.required, rules.number]"	
					            v-model="item.expiration_date"
				                outline               
				              ></v-text-field>
				            </span>
				          </v-list-tile-title>
				        </v-list-tile-content>
				    </v-list-tile>
				    <v-divider class="no-mg-bottom"></v-divider>

				    <v-list-tile class="height-80">
				        <v-list-tile-content class="h-100">
				          <v-list-tile-title class="content-flex-end h-100">
				            <span class="font-weight-bold item-title position-item">Manage Credit Card fees:</span>
				            <span class="contain-text-field fix-contain-text-field">
				              <v-text-field
				                class="font-weight-bold height-input"
				               placeholder="0.00"
				              	:rules="[rules.required, rules.decimal]"
					            v-model="item.card_fee"
				                outline           
				              ></v-text-field>
				            </span>
				          </v-list-tile-title>
				        </v-list-tile-content>
				    </v-list-tile>
				    <v-divider class="no-mg-bottom"></v-divider>

				    <v-list-tile class="height-80">
				        <v-list-tile-content class="h-100">
				          <v-list-tile-title class="content-flex-end h-100">
				            <span class="font-weight-bold item-title position-item">Complimentary bonus to TopUp:</span>
				            <span class="contain-text-field fix-contain-text-field">
				              <v-text-field
				                class="font-weight-bold height-input"
				                placeholder="0.00"
				              	:rules="[rules.required, rules.decimal]"
					            v-model="item.bonus"
				                outline         
				              ></v-text-field>
				            </span>
				          </v-list-tile-title>
				        </v-list-tile-content>
				    </v-list-tile>
				    <v-divider class="no-mg-bottom"></v-divider>

				    <v-list-tile class="height-80">
				        <v-list-tile-content class="h-100">
				          <v-list-tile-title class="content-flex-end h-100">
				            <span class="font-weight-bold item-title position-item">On/off SMS services Basic:</span>
				            <span class="contain-text-field fix-contain-text-field fix-switch">
				            	<v-switch
					              v-model="item.sms"
					              color="red"
					              hide-details>
					            </v-switch>
				            </span>
				          </v-list-tile-title>
				        </v-list-tile-content>
				    </v-list-tile>
				    <v-divider class="no-mg-bottom"></v-divider>

				    <v-list-tile class="height-80">
				        <v-list-tile-content class="h-100">
				          <v-list-tile-title class="content-flex-end h-100">
				            <span class="font-weight-bold item-title position-item">On/off Email services Basic:</span>
				            <span class="contain-text-field fix-contain-text-field fix-switch">
				            	<v-switch
					              v-model="item.email_service"
					              color="red"
					              hide-details>
					            </v-switch>
				            </span>
				          </v-list-tile-title>
				        </v-list-tile-content>
				    </v-list-tile>
				    <v-divider class="no-mg-bottom"></v-divider>
				   	
				    <v-flex xs12 sm12 class="style-flex fix-style-flex">
						<v-btn color="info" type="submit">SAVE</v-btn>	
					</v-flex>

		        </v-list>  
	   		</v-form>
   		</v-list>

		<v-list v-show="check == 'setting'" class="heigth-list-title">
	        <v-list two-line>
	        	<v-alert  v-model="alertStt" :type="alertType" dismissible>{{ alertMes }}</v-alert>
				<v-list-tile class="height-80">
					<v-list-tile-content class="h-100">
						<v-list-tile-title class="content-flex-end h-100">
							<span class="font-weight-bold item-title position-item">Expiry for deleting images files:</span>
							<span class="contain-text-field fix-contain-text-field2 edit-text-field">
								<v-text-field
								class="font-weight-bold height-input"
								placeholder="0.00"
								:rules="[rules.required, rules.number]"	
								v-model="data.expiration_date"
								:disabled="key == 1 ? false : true"
								@blur="editSetting('expiration_date', data.expiration_date)"
								@keyup.enter="editSetting('expiration_date', data.expiration_date)"
								outline
								></v-text-field>	
							</span>
							<span class="position-item fix-position-item">
								<v-btn flat icon @click="unDisableItem(1)"><v-icon small>fas fa-marker</v-icon></v-btn>
							</span>
						</v-list-tile-title>
					</v-list-tile-content>
				</v-list-tile>
				<v-divider class="no-mg-bottom"></v-divider>

				<v-list-tile class="height-80">
					<v-list-tile-content class="h-100">
						<v-list-tile-title class="content-flex-end h-100">
							<span class="font-weight-bold item-title position-item">Manage Credit Card fees:</span>
							<span class="contain-text-field fix-contain-text-field2 edit-text-field">
								<v-text-field
								class="font-weight-bold height-input"
								placeholder="0.00"
								:rules="[rules.required, rules.decimal]"
								v-model="data.card_fee"
								:disabled="key == 2 ? false : true"
								@blur="editSetting('card_fee', data.card_fee)"
								@keyup.enter="editSetting('card_fee', data.card_fee)"
								outline
								></v-text-field>
							</span>
							<span class="position-item fix-position-item">
								<v-btn flat icon @click="unDisableItem(2)"><v-icon small>fas fa-marker</v-icon></v-btn>
							</span>
						</v-list-tile-title>
					</v-list-tile-content>
				</v-list-tile>
				<v-divider class="no-mg-bottom"></v-divider>

				<v-list-tile class="height-80">
					<v-list-tile-content class="h-100">
						<v-list-tile-title class="content-flex-end h-100">
							<span class="font-weight-bold item-title position-item">Complimentary bonus to TopUp:</span>
							<span class="contain-text-field fix-contain-text-field2 ">
								<v-text-field
								class="font-weight-bold height-input"
								placeholder="0.00"
								:rules="[rules.required, rules.decimal]"
								v-model="data.bonus"
								:disabled="key == 3 ? false : true"
								@blur="editSetting('bonus', data.bonus)"
								@keyup.enter="editSetting('bonus', data.bonus)"
								outline
								></v-text-field>
							</span>
							<span class="position-item fix-position-item">
								<v-btn flat icon @click="unDisableItem(3)"><v-icon small>fas fa-marker</v-icon></v-btn>
							</span>
						</v-list-tile-title>
					</v-list-tile-content>
				</v-list-tile>
				<v-divider class="no-mg-bottom"></v-divider>

				<v-list-tile class="height-80">
					<v-list-tile-content class="h-100">
						<v-list-tile-title class="content-flex-end h-100">
							<span class="font-weight-bold item-title position-item">On/off SMS services Basic:</span>
							<span class="contain-text-field fix-contain-text-field2 fix-switch">
								<v-switch
								v-model="data.sms"
								color="red"
								hide-details
								:disabled="key == 4 ? false : true"
								@change="editSetting('sms', data.sms)"
								>
								</v-switch>
							</span>
							<span class="position-item fix-position-item">
								<v-btn flat icon @click="unDisableItem(4)"><v-icon small>fas fa-marker</v-icon></v-btn>
							</span>
						</v-list-tile-title>
					</v-list-tile-content>
				</v-list-tile>
				<v-divider class="no-mg-bottom"></v-divider>

				<v-list-tile class="height-80">
					<v-list-tile-content class="h-100">
						<v-list-tile-title class="content-flex-end h-100">
							<span class="font-weight-bold item-title position-item">On/off Email services Basic:</span>
							<span class="contain-text-field fix-contain-text-field2 fix-switch">
								<v-switch
								v-model="data.email_service"
								color="red"
								hide-details
								:disabled="key == 5 ? false : true"
								@change="editSetting('email_service', data.email_service)"
								>
								</v-switch>
							</span>
							<span class="position-item fix-position-item">
								<v-btn flat icon @click="unDisableItem(5)"><v-icon small>fas fa-marker</v-icon></v-btn>
							</span>
						</v-list-tile-title>
					</v-list-tile-content>
				</v-list-tile>
				<v-divider class="no-mg-bottom"></v-divider>

	        </v-list> 
	    </v-list>
		
		<v-list v-show="check == 'edit'" class="heigth-list-title">
	        <v-list two-line>
	        	<v-alert  v-model="alertStt" :type="alertType" dismissible>{{ alertMes }}</v-alert>
				<v-list-tile class="height-80">
					<v-list-tile-content class="h-100">
						<v-list-tile-title class="content-flex-end h-100">
							<span class="font-weight-bold item-title position-item">Fee:</span>
							<span class="contain-text-field">
								<v-text-field
								class="font-weight-bold height-input"
								placeholder="Enter fee"
								v-model="data.fee"
								outline
								:disabled="key == 1 ? false : true"
								:rules="[rules.required, rules.decimal]"
								@blur="editItem('fee', data.fee)"
								@keyup.enter="editItem('fee', data.fee)"
								></v-text-field>
							</span>
							<span class="position-item">
								<v-btn flat icon  @click="unDisableItem(1)"><v-icon small>fas fa-marker</v-icon></v-btn>
							</span>
						</v-list-tile-title>
					</v-list-tile-content>
				</v-list-tile>
				<v-divider class="no-mg-bottom"></v-divider>

				<v-list-tile class="height-80">
					<v-list-tile-content class="h-100">
						<v-list-tile-title class="content-flex-end h-100">
							<span class="font-weight-bold item-title position-item">Package name:</span>
							<span class="contain-text-field">
								<v-text-field
								class="font-weight-bold height-input"
								placeholder="Enter package name"
								v-model="data.package_name"
								:rules="[rules.required]"
								:disabled="key == 2 ? false : true"
								outline
								@blur="editItem('package_name', data.package_name)"
								@keyup.enter="editItem('package_name', data.package_name)"
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
							<span class="font-weight-bold item-title position-item">Secure Storage:</span>
							<span class="contain-text-field">
								<v-text-field
								class="font-weight-bold height-input"
								placeholder="Enter secure storage"
								v-model="data.secure_storage"
								:rules="[rules.required]"
								:disabled="key == 3 ? false : true"
								outline
								@blur="editItem('secure_storage', data.secure_storage)"
								@keyup.enter="editItem('secure_storage', data.secure_storage)"
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
							<span class="font-weight-bold item-title position-item">File upload:</span>
							<span class="contain-text-field">
								<v-text-field
								class="font-weight-bold height-input"
								placeholder="Enter file upload"
								v-model="data.file_upload"
								:rules="[rules.required, rules.number]"
								:disabled="key == 4 ? false : true"
								outline
								@blur="editItem('file_upload', data.file_upload)"
								@keyup.enter="editItem('file_upload', data.file_upload)"
								></v-text-field>
							</span>
							<span class="position-item">
								<v-btn flat icon @click="unDisableItem(4)"><v-icon small>fas fa-marker</v-icon></v-btn>
							</span>
						</v-list-tile-title>
					</v-list-tile-content>
				</v-list-tile>
				<v-divider class="no-mg-bottom"></v-divider>

				<v-list-tile class="height-80">
					<v-list-tile-content class="h-100">
						<v-list-tile-title class="content-flex-end h-100">
							<span class="font-weight-bold item-title position-item">Minimum User:</span>
							<span class="contain-text-field">
								<v-text-field
								class="font-weight-bold height-input"
								placeholder="Minimum user"
								v-model="data.minimum_user"
								:rules="[rules.required, rules.number]"
								:disabled="key == 5 ? false : true"
								outline
								@blur="editItem('minimum_user', data.minimum_user)"
								@keyup.enter="editItem('minimum_user', data.minimum_user)"
								></v-text-field>
							</span>
							<span class="position-item">
								<v-btn flat icon @click="unDisableItem(5)"><v-icon small>fas fa-marker</v-icon></v-btn>
							</span>
						</v-list-tile-title>
					</v-list-tile-content>
				</v-list-tile>
				<v-divider class="no-mg-bottom"></v-divider>

				<v-list-tile class="height-80">
					<v-list-tile-content class="h-100">
						<v-list-tile-title class="content-flex-end h-100">
							<span class="font-weight-bold item-title position-item">Maximum User:</span>
							<span class="contain-text-field">
								<v-text-field
								class="font-weight-bold height-input"
								placeholder="Minimum user"
								v-model="data.max_user"
								:rules="[rules.required]"
								:disabled="key == 6 ? false : true"
								outline
								@blur="editItem('max_user', data.max_user)"
								@keyup.enter="editItem('max_user', data.max_user)"
								></v-text-field>
							</span>
							<span class="position-item">
								<v-btn flat icon @click="unDisableItem(6)"><v-icon small>fas fa-marker</v-icon></v-btn>
							</span>
						</v-list-tile-title>
					</v-list-tile-content>
				</v-list-tile>
				<v-divider class="no-mg-bottom"></v-divider>

				<v-list-tile class="height-80">
					<v-list-tile-content class="h-100">
						<v-list-tile-title class="content-flex-end h-100">
							<span class="font-weight-bold item-title position-item">Short Description:</span>
							<span class="contain-text-field">
								<v-text-field
								class="font-weight-bold height-input"
								placeholder="Minimum user"
								v-model="data.short_description"
								:rules="[rules.required]"
								:disabled="key == 7 ? false : true"
								outline
								@blur="editItem('short_description', data.short_description)"
								@keyup.enter="editItem('short_description', data.short_description)"
								></v-text-field>
							</span>
							<span class="position-item">
								<v-btn flat icon @click="unDisableItem(7)"><v-icon small>fas fa-marker</v-icon></v-btn>
							</span>
						</v-list-tile-title>
					</v-list-tile-content>
				</v-list-tile>
				<v-divider class="no-mg-bottom"></v-divider>

	        </v-list>   
	    </v-list> 
        <!-- <v-list dense>

	        <v-list-tile @click.stop="stopdrawerRight()">
		          	<v-list-tile-action>
		            	<v-icon>exit_to_app</v-icon>
		          	</v-list-tile-action>
	        </v-list-tile>
	 	</v-list> -->
	 	<v-card-actions class="w-100 border border-left-0 border-right-0 border-bottom-0 pr-4 bottom-position flex-end">						
			<v-btn @click.stop="stopdrawerRight()">Close</v-btn>
		</v-card-actions>

 </v-navigation-drawer>
</v-card>
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
		    check: '',
	    	rules: {
		        required: value => !!value || 'Required.',
	          	number: value => {
		            const abc = /^[0-9]\d*$/
		            return abc.test(value) || 'Please input number.'
	          	},
	          	decimal: value => {
		            const abc = /^[0-9]\d*(\.\d+)?$/
		            return abc.test(value) || 'Please input number.'
	          	},
	        },
	        item:{
	        	sms: false,
	        	email_service: false
	        },
	        data:{},
	        alertStt: false,
	     	alertType: 'success',
	      	alertMes: '',
	      	key: 0
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
				                text: 'Add Package Success!'
				            });
					    },500);
	                    this.drawerRight = false
	                    this.$root.$emit('reload-table', true)
	                    this.item = {
	                    	sms: false,
	        				email_service: false
	                    }
                	}
      		 	})
      		 	.catch((err) =>{
      		 		console.log(err)
      		 	})
      		}
      	},

      	unDisableItem(key){
      		this.key = key
      	},

      	editItem(field_name, value){

	      var field = {
	        field_name: field_name,
	        value: value
	      }

	      // if(field_name === 'dated'){
	      //   let date = new Date(value)
	      //   let dateFormated = this.$moment(date).format('YYYY-MM-DD')
	      //   field.value = dateFormated
	      //   this.menu = false
	      // }

	      this.fetchData(field)

	    },
      	
	    fetchData(field){
	    	post(config.API_URL + 'edit/package/' + this.data.id, field)
			.then((res) => {
				if(res.data && res.data.success){
		            this.alertStt = true
		            this.alertType = 'success'
		            this.alertMes = 'Update Successfully'					
		            setTimeout(() => {this.alertStt = false}, 1500)
		            this.key = 0
							this.$root.$emit('editItemSucess')
							// this.$root.$emit('closeDrawerItem', false)
						}
					})
			.catch((e) =>{
						this.alertStt = true
		                this.alertType = 'error'
		                this.alertMes = 'System Error Occurred'         
		        		setTimeout(() => {this.alertStt = false}, 1500)
					})

	    },

	    editSetting(field_name, value){
	    	var field = {
	    		field_name: field_name,
	    		value: value
	    	}

	    	this.fetchDataSetting(field)
	    },

	    fetchDataSetting(field){
	    	post(config.API_URL + 'edit/setting/' + this.data.id, field)
			.then((res) => {
				if(res.data && res.data.success){
		            this.alertStt = true
		            this.alertType = 'success'
		            this.alertMes = 'Update Successfully'					
		            setTimeout(() => {this.alertStt = false}, 1500)
		            this.key = 0
							this.$root.$emit('editItemSucess')
							// this.$root.$emit('closeDrawerItem', false)
						}
					})
			.catch((e) =>{
						this.alertStt = true
		                this.alertType = 'error'
		                this.alertMes = 'System Error Occurred'         
		        		setTimeout(() => {this.alertStt = false}, 1500)
					})
	    },

      	// savePackagesSetting(){
      	// 	if (this.$refs.form1.validate()) {
      	// 		let url = config.API_URL+'packages/'+this.data.id
      	// 	 	put(url,this.data)
      	// 	 	.then((res) => {
      	// 	 		 if(res.data && res.data.success){
	      //               setTimeout(function(){
				   //          Vue.notify({
				   //              group: 'loggedIn',
				   //              type: 'success',
				   //              text: 'Setting Package Success!'
				   //          });
					  //   },500);
	      //               this.drawerRight = false
	      //               this.$root.$emit('reload-table', true)
	      //               this.alertMes = 'Setting Package Success!'
       //          	}
      	// 	 	})
      	// 	 	.catch((err) =>{
      	// 	 		console.log(err)
      	// 	 	})
      	// 	}
      	// },
      
      	// savePackagesUpdate(field, value){
      		
      	// 	if (this.$refs.form2.validate()) {
      	// 		let url = config.API_URL+'packages/'+this.data.id
      	// 	 	put(url,this.data)
      	// 	 	.then((res) => {
      	// 	 		 if(res.data && res.data.success){
	      //               setTimeout(function(){
				   //          Vue.notify({
				   //              group: 'loggedIn',
				   //              type: 'success',
				   //              text: 'Update Packages Success!'
				   //          });
					  //   },500);
	      //               this.drawerRight = false
	      //               this.$root.$emit('reload-table', true)
	      //               this.alertMes = 'Update Packages Success!'
       //          	}
      	// 	 	})
      	// 	 	.catch((err) =>{
      	// 	 		console.log(err)
      	// 	 	})
      	// 	}
      	// }
	},
	mounted(){
		this.$root.$on('change-status', res => {
          	this.drawerRight = res.showDialog
    		this.check = res.check
    		// this.item = {
    		// }
      	})

      	this.$root.$on('data-packages', res => {
    		this.data = res
    		// console.log(this.setting)
    		console.log(this.data)

 
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
	padding: 15px 12px !important;
	font-weight: 500 !important;
}
h4 {
	padding-left : 10px
}
.style-flex p{
	margin-bottom: 0px !important;
}
.fix-contain-text-field{
	display: block;
    right: 0px;
    position: absolute;
    width: 150px;
}
.position-item{
    margin-top: 20px;
}
.fix-switch{
	top:0px;
}
.fix-style-flex{
	float: right;
}

.height-80{
  .v-list__tile{
    height: 0px !important;
  }
}

.fix-contain-text-field2{
	display: block;
    position: absolute;
    width: 100px;
    margin-left: 252px;
    left: 0px;
}

.fix-position-item{
	right: 0px;
    position: absolute;
}

.content-flex-end {
    display: flex;
    justify-content: start;
    align-items: baseline;
    padding-top: 6px;
    position: relative;
}

</style>
