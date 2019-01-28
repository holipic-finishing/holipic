<template>
	<v-navigation-drawer
    fixed
    v-model="drawerRight"
    right
    clipped
    app
	  :width="450"
	  temporary
  >
		<v-card class="h-100 position-relative">
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
			<v-divider class="mt-0 mb-0"></v-divider>

			<!-- Add Package -->
 			<v-form ref="form" @submit.prevent="savePackageAdd" v-show="check == 'add'" class="heigth-list-title">
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
			        </v-list-tile-title>
			      </v-list-tile-content>
			    </v-list-tile>
			    <v-divider class="mt-0 mb-0"></v-divider>

			    <v-list-tile class="height-80">
		        <v-list-tile-content class="h-100">
		          <v-list-tile-title class="content-flex-end h-100">
		            <span class="font-weight-bold item-title position-item">Package Name:</span>
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
			    <v-divider class="mt-0 mb-0"></v-divider>

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
			    <v-divider class="mt-0 mb-0"></v-divider>

			    <v-list-tile class="height-80">
		        <v-list-tile-content class="h-100">
		          <v-list-tile-title class="content-flex-end h-100">
		            <span class="font-weight-bold item-title position-item">File Upload:</span>
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
			    <v-divider class="mt-0 mb-0"></v-divider>

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
			    <v-divider class="mt-0 mb-0"></v-divider>

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
			    <v-divider class="mt-0 mb-0"></v-divider>

			    <v-list-tile class="height-150">
						<v-list-tile-content class="h-100">
							<v-list-tile-title class="content-flex-end h-100 align-items-center">
								<span class="font-weight-bold item-title position-item">Description:</span>
								<span class="contain-text-field h-100">
									<v-textarea
					          outline
					          placeholder="Minimum user"
					          v-model="item.short_description"
										class="font-weight-bold height-area"
					          :rules="[rules.required]"
					        ></v-textarea>
								</span>
							</v-list-tile-title>
						</v-list-tile-content>
					</v-list-tile>
					<v-divider class="mt-0 mb-0"></v-divider>

			    <v-list-tile class="height-80">
						<v-list-tile-content class="h-100">
							<v-list-tile-title class="content-flex-end h-100">
								<span class="font-weight-bold item-title-setting position-item">Expiration Date Numbers:</span>
								<span class="contain-text-field-setting">
									<v-text-field
										class="font-weight-bold height-input"
										:rules="[rules.required, rules.number]"
										v-model="item.expiration_date"
										outline
										placeholder="0"
									></v-text-field>	
								</span>
							</v-list-tile-title>
						</v-list-tile-content>
					</v-list-tile>
					<v-divider class="mt-0 mb-0"></v-divider>

			    <v-list-tile class="height-80">
						<v-list-tile-content class="h-100">
							<v-list-tile-title class="content-flex-end h-100">
								<span class="font-weight-bold item-title-setting position-item">Manage Credit Card Fees:</span>
								<span class="contain-text-field-setting">
									<v-text-field
										placeholder="$"
										class="font-weight-bold height-input"
										:rules="[rules.required, rules.decimal]"
										v-model="item.card_fee"
										outline
									></v-text-field>
								</span>
							</v-list-tile-title>
						</v-list-tile-content>
					</v-list-tile>
					<v-divider class="mt-0 mb-0"></v-divider>

			    <v-list-tile class="height-80">
						<v-list-tile-content class="h-100">
							<v-list-tile-title class="content-flex-end h-100">
								<span class="font-weight-bold item-title-setting position-item">Complimentary Bonus To TopUp:</span>
								<span class="contain-text-field-setting">
									<v-text-field
										placeholder="$"
										class="font-weight-bold height-input"
										:rules="[rules.required, rules.decimal]"
										v-model="item.bonus"
										outline
									></v-text-field>
								</span>
							</v-list-tile-title>
						</v-list-tile-content>
					</v-list-tile>
					<v-divider class="mt-0 mb-0"></v-divider>

			    <v-list-tile>
						<v-list-tile-content>
							<v-list-tile-title class="d-flex">
								<span class="font-weight-bold item-title-setting">SMS Services Basic:</span>
								<span class="contain-text-field-setting">
									<v-switch v-model="item.sms">
									</v-switch>
								</span>
							</v-list-tile-title>
						</v-list-tile-content>
					</v-list-tile>
					<v-divider class="mt-0 mb-0"></v-divider>

			    <v-list-tile>
						<v-list-tile-content>
							<v-list-tile-title class="d-flex">
								<span class="font-weight-bold item-title-setting">Email Services Basic:</span>
								<span class="contain-text-field-setting">
									<v-switch v-model="item.email_service">
									</v-switch>
								</span>
							</v-list-tile-title>
						</v-list-tile-content>
					</v-list-tile>
					<v-divider class="mt-0 mb-0"></v-divider>

					<v-list-tile class="height-50">
	          <v-list-tile-content class="h-100 align-items-end">
	            <v-list-tile-title class="d-flex h-100 align-items-center">
	              <v-btn small @click="resetData">Reset</v-btn>
	              <v-btn small color="success" type="submit">Save</v-btn>
	            </v-list-tile-title>
	          </v-list-tile-content>
	        </v-list-tile>
	        <v-divider class="mt-0 mb-0"></v-divider>

	      </v-list>  
   		</v-form>
			<!-- End Add Package -->
			
			<!-- Setting Package -->
   		<v-form ref="form1" @submit.prevent="savePackagesSetting" v-show="check == 'setting'" class="heigth-list-title"> 
	      <v-list two-line>
	        <v-alert  v-model="alertStt" :type="alertType" dismissible>{{ alertMes }}</v-alert>

					<v-list-tile class="height-80">
						<v-list-tile-content class="h-100">
							<v-list-tile-title class="content-flex-end h-100">
								<span class="font-weight-bold item-title-setting position-item">Expiration Date Numbers:</span>
								<span class="contain-text-field-setting">
									<v-text-field
										class="font-weight-bold height-input"
										:rules="[rules.number]"
										v-model="data.expiration_date"
										@blur="editSetting('expiration_date', data.expiration_date)"
										@keyup.enter="editSetting('expiration_date', data.expiration_date)"
										outline
									></v-text-field>	
								</span>
								<!-- <span class="position-item">
									<v-btn flat icon @click="unDisableItem(1)"><v-icon small>fas fa-marker</v-icon></v-btn>
								</span> -->
							</v-list-tile-title>
						</v-list-tile-content>
					</v-list-tile>
					<v-divider class="mt-0 mb-0"></v-divider>

					<v-list-tile class="height-80">
						<v-list-tile-content class="h-100">
							<v-list-tile-title class="content-flex-end h-100">
								<span class="font-weight-bold item-title-setting position-item">Manage Credit Card Fees:</span>
								<span class="contain-text-field-setting">
									<v-text-field
										placeholder="$"
										class="font-weight-bold height-input"
										:rules="[rules.decimal]"
										v-model="data.card_fee"
										@blur="editSetting('card_fee', data.card_fee)"
										@keyup.enter="editSetting('card_fee', data.card_fee)"
										outline
									></v-text-field>
								</span>
							</v-list-tile-title>
						</v-list-tile-content>
					</v-list-tile>
					<v-divider class="mt-0 mb-0"></v-divider>

					<v-list-tile class="height-80">
						<v-list-tile-content class="h-100">
							<v-list-tile-title class="content-flex-end h-100">
								<span class="font-weight-bold item-title-setting position-item">Complimentary Bonus To TopUp:</span>
								<span class="contain-text-field-setting">
									<v-text-field
										class="font-weight-bold height-input"
										:rules="[rules.decimal]"
										v-model="data.bonus"
										@blur="editSetting('bonus', data.bonus)"
										@keyup.enter="editSetting('bonus', data.bonus)"
										outline
									></v-text-field>
								</span>
							</v-list-tile-title>
						</v-list-tile-content>
					</v-list-tile>
					<v-divider class="mt-0 mb-0"></v-divider>

					<v-list-tile>
						<v-list-tile-content>
							<v-list-tile-title class="d-flex">
								<span class="font-weight-bold item-title-setting">SMS Services Basic:</span>
								<span class="contain-text-field-setting">
									<v-switch
										v-model="data.sms"
										@change="editSetting('sms', data.sms)"
									>
									</v-switch>
								</span>
<!-- 								<span class="position-item">
									<v-btn flat icon @click="unDisableItem(4)"><v-icon small>fas fa-marker</v-icon></v-btn>
								</span> -->
							</v-list-tile-title>
						</v-list-tile-content>
					</v-list-tile>
					<v-divider class="mt-0 mb-0"></v-divider>

					<v-list-tile>
						<v-list-tile-content>
							<v-list-tile-title class="d-flex">
								<span class="font-weight-bold item-title-setting">Email Services Basic:</span>
								<span class="contain-text-field-setting">
									<v-switch
										v-model="data.email_service"
										@change="editSetting('email_service', data.email_service)"
									>
									</v-switch>
								</span>
								<!-- <span class="position-item">
									<v-btn flat icon @click="unDisableItem(5)"><v-icon small>fas fa-marker</v-icon></v-btn>
								</span> -->
							</v-list-tile-title>
						</v-list-tile-content>
					</v-list-tile>
					<v-divider class="mt-0 mb-0"></v-divider>

	      </v-list> 
	    </v-form>
	    <!-- End setting package -->
			
			<!-- Edit package -->
	    <v-form ref="form2"  v-show="check == 'edit'" class="heigth-list-title"> 
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
										:rules="[rules.required, rules.decimal]"
										@blur="editItem('fee', data.fee)"
										@keyup.enter="editItem('fee', data.fee)"
									></v-text-field>
								</span>
							</v-list-tile-title>
						</v-list-tile-content>
					</v-list-tile>
					<v-divider class="mt-0 mb-0"></v-divider>

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
										outline
										@blur="editItem('package_name', data.package_name)"
										@keyup.enter="editItem('package_name', data.package_name)"
									></v-text-field>
								</span>
							</v-list-tile-title>
						</v-list-tile-content>
					</v-list-tile>
					<v-divider class="mt-0 mb-0"></v-divider>

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
										outline
										@blur="editItem('secure_storage', data.secure_storage)"
										@keyup.enter="editItem('secure_storage', data.secure_storage)"
									></v-text-field>
								</span>
							</v-list-tile-title>
						</v-list-tile-content>
					</v-list-tile>
					<v-divider class="mt-0 mb-0"></v-divider>

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
										outline
										@blur="editItem('file_upload', data.file_upload)"
										@keyup.enter="editItem('file_upload', data.file_upload)"
									></v-text-field>
								</span>
							</v-list-tile-title>
						</v-list-tile-content>
					</v-list-tile>
					<v-divider class="mt-0 mb-0"></v-divider>

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
										outline
										@blur="editItem('minimum_user', data.minimum_user)"
										@keyup.enter="editItem('minimum_user', data.minimum_user)"
									></v-text-field>
								</span>
							</v-list-tile-title>
						</v-list-tile-content>
					</v-list-tile>
					<v-divider class="mt-0 mb-0"></v-divider>

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
										outline
										@blur="editItem('max_user', data.max_user)"
										@keyup.enter="editItem('max_user', data.max_user)"
									></v-text-field>
								</span>
							</v-list-tile-title>
						</v-list-tile-content>
					</v-list-tile>
					<v-divider class="mt-0 mb-0"></v-divider>

					<v-list-tile class="height-150">
						<v-list-tile-content class="h-100">
							<v-list-tile-title class="content-flex-end h-100 align-items-center">
								<span class="font-weight-bold item-title position-item">Description:</span>
								<span class="contain-text-field h-100">
									<v-textarea
							            outline
							            placeholder="Minimum user"
							            v-model="data.short_description"
										class="font-weight-bold height-area"
							            :rules="[rules.required]"
							            @blur="editItem('short_description', data.short_description)"
										@keyup.enter="editItem('short_description', data.short_description)"
							        ></v-textarea>
								</span>
							</v-list-tile-title>
						</v-list-tile-content>
					</v-list-tile>
					<v-divider class="mt-0 mb-0"></v-divider>

	      </v-list> 
	    </v-form>
	    <!-- End Edit Package -->

		 	<v-card-actions class="w-100 border border-left-0 border-right-0 border-bottom-0 pr-4 bottom-position flex-end">						
				<v-btn @click.stop="stopdrawerRight()">Close</v-btn>
			</v-card-actions>

		</v-card>
	</v-navigation-drawer>
</template>

<script>
import config from '../../../config/index.js'
import { post, put } from '../../../api/index.js'	
import Vue from 'vue'

export default {

	name: 'PackageItem',
	data () {
    return {
    	drawerRight: false,
	    check: '',
    	rules: {
        required: value => !!value || 'Required.',
        decimal: value => {
          const pattern = /^[\d]+[\.][\d]{2}$/
          return pattern.test(value) || 'E.g:1.00'
      	},
      	number: value => {
          const pattern = /^[0-9]\d*$/
          return pattern.test(value) || 'Pls input number.'
      	},
      },
      item:{
      	sms: false,
      	email_service: false
      },
      alertStt: false,
     	alertType: 'success',
     	alertMes: '',
      key: 0,
      data:{}
    }
	},
	methods:{
		resetData(){
			this.$refs.form.reset()
		},
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
    	post(config.API_URL + 'edit/setting/' + this.data.setting_id, field)
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
	},
	mounted(){
		this.$root.$on('change-status', res => {
      this.drawerRight = res.showDialog
			this.check = res.check
			this.resetData()
  	})

  	this.$root.$on('data-packages', res => {
			this.data = res
    })
	}
};
</script>

<style lang="scss" scoped>
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

.fix-style-flex{
	float: right;
}

</style>
