<template>
	<v-card class="h-100 position-relative">
		<v-navigation-drawer
      		fixed
      		v-model="drawerRight"
    		right
      		clipped
      		app
      		:width='widthComputed'
	    	temporary
    	>
	  		<v-toolbar class="mb-3">
			    <v-toolbar-title v-if="check == 'add'" class="text-capitalize">Add Package</v-toolbar-title>
			    <v-toolbar-title v-if="check == 'show'" class="text-capitalize">View Detail Package</v-toolbar-title>
			    <v-toolbar-title v-if="check == 'edit'" class="text-capitalize">Update Package</v-toolbar-title>
			    <v-spacer></v-spacer>
			    <v-toolbar-side-icon @click.stop="stopdrawerRight()">
			      	<v-icon>
			          fas fa-times
			        </v-icon>
			    </v-toolbar-side-icon>
		    </v-toolbar>

		    <v-list>
		    	<v-alert  v-model="alertStt" :type="alertType" dismissible>{{ alertMes }}</v-alert>
			</v-list>

			<v-list v-show="check == 'add'" class="heigth-list-title">
		 		<v-form ref="form" @submit.prevent="savePackageAdd">
					<v-list two-line>

	          			<v-list-tile class="height-65">
			        		<v-list-tile-content class="h-100">
			          			<v-list-tile-title class="content-flex-end h-100">
			            			<span class="item-title position-item">Package Name:</span>
						            <span class="contain-text-field">
						              	<v-text-field
						                	class="height-input"
						                	placeholder="Enter package name"
						                	v-model="item.package_name"
						                	:rules="[rules.required]"
						              	></v-text-field>
						            </span>
		          				</v-list-tile-title>
			        		</v-list-tile-content>
			    		</v-list-tile>
				    	<v-divider class="m-0"></v-divider>

					    <v-list-tile class="height-65">
					        <v-list-tile-content class="h-100">
					          	<v-list-tile-title class="content-flex-end h-100">
						            <span class="item-title position-item">Package Price:</span>
						            <span class="contain-text-field">
						              	<v-text-field
							                class="height-input"
							                placeholder="Enter package price"
							                v-model="item.price"
					 			            :rules="[rules.required]"
						              	></v-text-field>
						            </span>
					          	</v-list-tile-title>
					        </v-list-tile-content>
					    </v-list-tile>
					    <v-divider class="m-0"></v-divider>

					    <v-list-tile class="height-65">
					        <v-list-tile-content class="h-100">
					          	<v-list-tile-title class="content-flex-end h-100">
					            	<span class="item-title position-item">Offer Price:</span>
						            <span class="contain-text-field">
						              	<v-text-field
							                class="height-input"
							                placeholder="Enter package offer"
							               	v-model="item.offer"
						                    :rules="[rules.required]"
						              	></v-text-field>
						            </span>
					          	</v-list-tile-title>
					        </v-list-tile-content>
					    </v-list-tile>
					    <v-divider class="m-0"></v-divider>

					    <v-list-tile class="height-65">
					        <v-list-tile-content class="h-100">
					          	<v-list-tile-title class="content-flex-end h-100">
						            <span class="item-title position-item">Total Photo:</span>
						            <span class="contain-text-field">
						              	<v-text-field
						                	class="height-input"
						                	placeholder="Enter package offer"
						               		v-model="item.total_photo"
					                    	:rules="[rules.required, rules.number]"
						              	></v-text-field>
						            </span>
					          	</v-list-tile-title>
					        </v-list-tile-content>
					    </v-list-tile>
					    <v-divider class="m-0"></v-divider>

				    	<v-list-tile class="height-65">
				        	<v-list-tile-content class="h-100">
				          		<v-list-tile-title class="content-flex-end h-100">
						            <span class="item-title position-item">Album:</span>
						            <span class="contain-text-field">
						              	<v-text-field
							                class="height-input"
							                placeholder="Enter package offer"
							               	v-model="item.album"
						                    :rules="[rules.required]"
						              	></v-text-field>
						            </span>
				          		</v-list-tile-title>
				        	</v-list-tile-content>
					    </v-list-tile>
					    <v-divider class="m-0"></v-divider>

					    <v-list-tile class="height-65">
					        <v-list-tile-content class="h-100">
						   		<v-list-tile-title class="content-flex-end h-100">
						            <span class="item-title position-item">Photos on the disc:</span>
						            <span class="contain-text-field">
						              	<v-text-field
							                class="height-input"
							                placeholder="Enter package offer"
							               	v-model="item.photo_on_disc"
						                    :rules="[rules.required, rules.number]"
						              	></v-text-field>
						            </span>
						    	</v-list-tile-title>
					        </v-list-tile-content>
					    </v-list-tile>
					    <v-divider class="m-0"></v-divider>

					    <v-list-tile class="height-65">
					        <v-list-tile-content class="h-100">
					          	<v-list-tile-title class="content-flex-end h-100">
						            <span class="item-title position-item">Poster (20x30):</span>
						            <span class="contain-text-field">
						              	<v-text-field
							                class="height-input"
							                placeholder="Enter package offer"
							               	v-model="item.poster"
						                    :rules="[rules.required, rules.number]"
						              	></v-text-field>
						            </span>
					          	</v-list-tile-title>
					        </v-list-tile-content>
					    </v-list-tile>
					    <v-divider class="m-0"></v-divider>
				    	<v-flex xs12 sm12 class="style-flex fix-style-flex">
							<v-btn color="indigo" dark type="submit">SAVE</v-btn>
						</v-flex>
		      		</v-list>
	   			</v-form>
   			</v-list>

      		<v-list v-show="check == 'show'" class="heigth-list-title">

        		<v-list-tile class="height-55">
					<v-list-tile-content>
			            <v-list-tile-title class="content-flex-end h-100">
				       		<span class="item-title position-item">Package Name</span>
				          	<span class="contain-text-field">
				          		<v-text-field
				          			class="custom-border-bottom-0"
					            	v-model="data.package_name"
					            	readonly
					            ></v-text-field>
							</span>
			          	</v-list-tile-title>
					</v-list-tile-content>
				</v-list-tile>
	      		<v-divider class="mt-0 mb-0"></v-divider>

	      		<v-list-tile class="height-55">
					<v-list-tile-content>
			            <v-list-tile-title class="content-flex-end h-100">
				          	<span class="item-title position-item">Package Price</span>
				          	<span class="contain-text-field">
				          		<v-text-field
				          			class="custom-border-bottom-0"
					            	v-model="data.price"
					            	readonly
					            ></v-text-field>
							</span>
			          	</v-list-tile-title>
					</v-list-tile-content>
				</v-list-tile>
	      		<v-divider class="mt-0 mb-0"></v-divider>

	      		<v-list-tile class="height-55">
					<v-list-tile-content>
			            <v-list-tile-title class="content-flex-end h-100">
				          	<span class="item-title position-item">Offer Price</span>
				          	<span class="contain-text-field">
				          		<v-text-field
				          			class="custom-border-bottom-0"
					            	v-model="data.offer"
					            	readonly
					            ></v-text-field>
						    </span>
			          	</v-list-tile-title>
					</v-list-tile-content>
				</v-list-tile>
	      		<v-divider class="mt-0 mb-0"></v-divider>

	      		<v-list-tile class="height-55">
					<v-list-tile-content>
			            <v-list-tile-title class="content-flex-end h-100">
				          	<span class="item-title position-item">Total Photo</span>
				          	<span class="contain-text-field">
				          		<v-text-field
				          			class="custom-border-bottom-0"
					            	v-model="data.total_photo"
					            	readonly
					            ></v-text-field>
						        </span>
			          	</v-list-tile-title>
					</v-list-tile-content>
				</v-list-tile>
	     		<v-divider class="mt-0 mb-0"></v-divider>

	      		<v-list-tile class="height-55">
					<v-list-tile-content>
			            <v-list-tile-title class="content-flex-end h-100">
				          	<span class="item-title position-item">Album</span>
				          	<span class="contain-text-field">
				          		<v-text-field
				          			class="custom-border-bottom-0"
					            	v-model="data.album"
					            	readonly
					            ></v-text-field>
							</span>
			          	</v-list-tile-title>
					</v-list-tile-content>
				</v-list-tile>
	      		<v-divider class="mt-0 mb-0"></v-divider>

        		<v-list-tile v-if="data.photo_on_disc != 0" class="height-55">
					<v-list-tile-content>
			            <v-list-tile-title class="content-flex-end h-100">
				          	<span class="item-title position-item">Photos on the disc</span>
				          	<span class="contain-text-field">
				          		<v-text-field
				          			class="custom-border-bottom-0"
					            	v-model="data.photo_on_disc"
					            	readonly
					            ></v-text-field>
							</span>
			          	</v-list-tile-title>
					</v-list-tile-content>
				</v-list-tile>
    			<v-divider class="mt-0 mb-0"></v-divider>

	      		<v-list-tile v-if="data.poster != 0" class="height-55">
					<v-list-tile-content>
			            <v-list-tile-title class="content-flex-end h-100">
				          	<span class="item-title position-item">Poster (20x30)</span>
				          	<span class="contain-text-field">
				          		<v-text-field
				          			class="custom-border-bottom-0"
					            	v-model="data.poster"
					            	readonly
					            ></v-text-field>
							</span>
			          	</v-list-tile-title>
					</v-list-tile-content>
				</v-list-tile>
	      		<v-divider class="mt-0 mb-0"></v-divider>
      		</v-list>

      		<v-list v-show="check == 'edit'" class="heigth-list-title">

				<v-list-tile class="height-65">
					<v-list-tile-content class="h-100">
						<v-list-tile-title class="content-flex-end h-100">
							<span class="item-title position-item">Package Name:</span>
							<span class="contain-text-field">
								<v-text-field
									class="height-input"
									placeholder="Enter package name"
									v-model="data.package_name"
									:rules="[rules.required]"
									@blur="editItem('package_name', data.package_name)"
									@keyup.enter="editItem('package_name', data.package_name)"
								></v-text-field>
							</span>
						</v-list-tile-title>
					</v-list-tile-content>
				</v-list-tile>
				<v-divider class="m-0"></v-divider>

				<v-list-tile class="height-65">
					<v-list-tile-content class="h-100">
						<v-list-tile-title class="content-flex-end h-100">
							<span class="item-title position-item">Package Price:</span>
							<span class="contain-text-field">
								<v-text-field
									class="height-input"
									placeholder="Enter package price"
									v-model="data.price"
									:rules="[rules.required]"
									@blur="editItem('price', data.price)"
									@keyup.enter="editItem('price', data.price)"
								></v-text-field>
							</span>
						</v-list-tile-title>
					</v-list-tile-content>
				</v-list-tile>
				<v-divider class="m-0"></v-divider>

				<v-list-tile class="height-65">
					<v-list-tile-content class="h-100">
						<v-list-tile-title class="content-flex-end h-100">
							<span class="item-title position-item">Offer Price:</span>
							<span class="contain-text-field">
								<v-text-field
									class="height-input"
									placeholder="Enter package offer"
									v-model="data.offer"
									:rules="[rules.required]"
									@blur="editItem('offer', data.offer)"
									@keyup.enter="editItem('offer', data.offer)"
								></v-text-field>
							</span>
						</v-list-tile-title>
					</v-list-tile-content>
				</v-list-tile>
				<v-divider class="m-0"></v-divider>

				<v-list-tile class="height-65">
					<v-list-tile-content class="h-100">
						<v-list-tile-title class="content-flex-end h-100">
							<span class="item-title position-item">Total Photo:</span>
							<span class="contain-text-field">
								<v-text-field
									class="height-input"
									placeholder="Enter package offer"
									v-model="data.total_photo"
									:rules="[rules.required, rules.number]"
									@blur="editItem('total_photo', data.total_photo)"
									@keyup.enter="editItem('total_photo', data.total_photo)"
								></v-text-field>
							</span>
						</v-list-tile-title>
					</v-list-tile-content>
				</v-list-tile>
				<v-divider class="m-0"></v-divider>

				<v-list-tile class="height-65">
					<v-list-tile-content class="h-100">
						<v-list-tile-title class="content-flex-end h-100">
							<span class="item-title position-item">Album:</span>
							<span class="contain-text-field">
								<v-text-field
									class="height-input"
									placeholder="Enter package offer"
									v-model="data.album"
									:rules="[rules.required]"
									@blur="editItem('album', data.album)"
									@keyup.enter="editItem('album', data.album)"
								></v-text-field>
							</span>
						</v-list-tile-title>
					</v-list-tile-content>
				</v-list-tile>
				<v-divider class="m-0"></v-divider>

				<v-list-tile class="height-65">
					<v-list-tile-content class="h-100">
						<v-list-tile-title class="content-flex-end h-100">
							<span class="item-title position-item">Photos on the disc:</span>
							<span class="contain-text-field">
								<v-text-field
									class="height-input"
									placeholder="Enter package offer"
									v-model="data.photo_on_disc"
									:rules="[rules.required, rules.number]"
									@blur="editItem('photo_on_disc', data.photo_on_disc)"
									@keyup.enter="editItem('photo_on_disc', data.photo_on_disc)"
								></v-text-field>
							</span>
						</v-list-tile-title>
					</v-list-tile-content>
				</v-list-tile>
				<v-divider class="m-0"></v-divider>

				<v-list-tile class="height-65">
					<v-list-tile-content class="h-100">
						<v-list-tile-title class="content-flex-end h-100">
							<span class="item-title position-item">Poster (20x30):</span>
							<span class="contain-text-field">
								<v-text-field
									class="height-input"
									placeholder="Enter package offer"
									v-model="data.poster"
									:rules="[rules.required, rules.number]"
									@blur="editItem('poster', data.poster)"
									@keyup.enter="editItem('poster', data.poster)"
								></v-text-field>
							</span>
						</v-list-tile-title>
					</v-list-tile-content>
				</v-list-tile>
				<v-divider class="m-0"></v-divider>
      		</v-list>
 		</v-navigation-drawer>
	</v-card>
</template>

<script>
import config from '../../../config/index.js'
import { post, put } from '../../../api/index.js'
import { getWithContentWrap } from '../../../helpers/helpers'

export default {

	name: 'PackageItem',

	data () {
    return {
    	drawerRight: false,
	    check: '',
    	rules: {
        required: value => !!value || 'Required.',
      	number: value => {
          const pt = /^[0-9]\d*$/
          return pt.test(value) || 'Please input number.'
      	},
      	decimal: value => {
          const pt = /^[0-9]\d*(\.\d+)?$/
          return pt.test(value) || 'Please input number.'
      	},
      },
      item:{
      	company_id: ''
      },
      data:{},
      alertStt: false,
   		alertType: 'success',
    	alertMes: '',
    	key: 0,
    	drawerHeaderStt: null,
    	width: 0,
    }
	},
	methods:{

		getCurrentWithContentWrap(){
  		return getWithContentWrap(this.drawerHeaderStt)
  	},

		stopdrawerRight(){
			this.drawerRight = false
		},

		savePackageAdd(){
  		if (this.$refs.form.validate()) {
  			let url = config.API_URL+'add/companyPackage'
  		 	post(url,this.item)
  		 	.then((res) => {
  		 		if(res.data && res.data.success){
	          this.$notify({
		          title: 'Success',
		          message: 'Add Item Successfully.',
		          type: 'success',
		          duration: 2000,
		        })
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
	    post(config.API_URL + 'edit/companyPackage/' + this.data.id, field)
			.then((res) => {
				if(res.data && res.data.success){
          this.alertType = 'success'
          this.alertMes = 'Update Item Successfully'
          this.$notify({
	          title: 'Success',
	          message: this.alertMes,
	          type: this.alertType,
	          duration: 2000,
	        })
          this.key = 0
					this.$root.$emit('editItemSucess')
				}
			})
			.catch((e) =>{
        this.alertType = 'error'
        this.alertMes = 'System Error Occurred'
        this.$notify({
          title: 'Error',
          message: this.alertMes,
          type: this.alertType,
          duration: 2000,
        })
			})
	  },

	},
	mounted(){
		this.$root.$on('drawer-status', res => {
  		this.drawerHeaderStt = res
  	})

		this.$root.$on('change-status', res => {
      this.drawerRight = res.showDialog
  		this.check = res.check
  		this.item.company_id = res.company_id
  		this.$refs.form.reset()
  		this.width = this.getCurrentWithContentWrap()
    })

    this.$root.$on('data-packages', res => {
    	this.data = res
  		if(res.poster == '0'){
  			this.data.poster = '0'
  		}
    })
	},
	computed: {
  	widthComputed(){
  		return this.width
  	}
  },

};
</script>

<style lang="scss" scoped>
.style-flex {
	padding: 5px 12px !important;
	font-weight: 500 !important;
}
.style-flex p{
	margin-bottom: 0px !important;
}

.fix-style-flex{
	float: right;
}



.text-field-padding {
	padding-left: 30px;
}

</style>
