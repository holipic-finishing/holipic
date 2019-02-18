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
  		<v-toolbar>
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

	    <v-divider class="no-mg-bottom"></v-divider>
	    
	    <v-list>
	    	<v-alert  v-model="alertStt" :type="alertType" dismissible>{{ alertMes }}</v-alert>
		</v-list>

	    <!-- <v-list>
	    	<v-alert  v-model="alertStt" :type="alertType" dismissible>{{ alertMes }}</v-alert>
			</v-list> -->

			<v-list v-show="check == 'add'" class="heigth-list-title">
		 		<v-form ref="form" @submit.prevent="savePackageAdd">
					<v-list two-line>

	          <v-list-tile class="height-70">
			        <v-list-tile-content class="h-100">
			          <v-list-tile-title class="content-flex-end h-100">
			            <span class="font-weight-bold item-title position-item">Package Name:</span>
			            <span class="contain-text-field">
			              <v-text-field
			                class="font-weight-bold height-input"
			                placeholder="Enter package name"
			                v-model="item.package_name"
			                outline
			                :rules="[rules.required]"
			              ></v-text-field>
			            </span>
			          </v-list-tile-title>
			        </v-list-tile-content>
			    	</v-list-tile>
				    <v-divider class="no-mg-bottom"></v-divider>

				    <v-list-tile class="height-70">
				        <v-list-tile-content class="h-100">
				          <v-list-tile-title class="content-flex-end h-100">
				            <span class="font-weight-bold item-title position-item">Package Price:</span>
				            <span class="contain-text-field">
				              <v-text-field
				                class="font-weight-bold height-input"
				                placeholder="Enter package price"
				                v-model="item.price"
		 			            :rules="[rules.required]"
				                outline       
				              ></v-text-field>
				            </span>
				          </v-list-tile-title>
				        </v-list-tile-content>
				    </v-list-tile>
				    <v-divider class="no-mg-bottom"></v-divider>

				    <v-list-tile class="height-70">
				        <v-list-tile-content class="h-100">
				          <v-list-tile-title class="content-flex-end h-100">
				            <span class="font-weight-bold item-title position-item">Offer Price:</span>
				            <span class="contain-text-field">
				              <v-text-field
				                class="font-weight-bold height-input"
				                placeholder="Enter package offer"
				               	v-model="item.offer"
			                    :rules="[rules.required]"
				                outline                
				              ></v-text-field>
				            </span>
				          </v-list-tile-title>
				        </v-list-tile-content>
				    </v-list-tile>
				    <v-divider class="no-mg-bottom"></v-divider>

				    <v-list-tile class="height-70">
				        <v-list-tile-content class="h-100">
				          <v-list-tile-title class="content-flex-end h-100">
				            <span class="font-weight-bold item-title position-item">Total Photo:</span>
				            <span class="contain-text-field">
				              <v-text-field
				                class="font-weight-bold height-input"
				                placeholder="Enter package offer"
				               	v-model="item.total_photo"
			                    :rules="[rules.required, rules.number]"
				                outline                
				              ></v-text-field>
				            </span>
				          </v-list-tile-title>
				        </v-list-tile-content>
				    </v-list-tile>
				    <v-divider class="no-mg-bottom"></v-divider>

				    <v-list-tile class="height-70">
				        <v-list-tile-content class="h-100">
				          <v-list-tile-title class="content-flex-end h-100">
				            <span class="font-weight-bold item-title position-item">Album:</span>
				            <span class="contain-text-field">
				              <v-text-field
				                class="font-weight-bold height-input"
				                placeholder="Enter package offer"
				               	v-model="item.album"
			                    :rules="[rules.required]"
				                outline                
				              ></v-text-field>
				            </span>
				          </v-list-tile-title>
				        </v-list-tile-content>
				    </v-list-tile>
				    <v-divider class="no-mg-bottom"></v-divider>

				    <v-list-tile class="height-70">
				        <v-list-tile-content class="h-100">
				          <v-list-tile-title class="content-flex-end h-100">
				            <span class="font-weight-bold item-title position-item">Photos on the disc:</span>
				            <span class="contain-text-field">
				              <v-text-field
				                class="font-weight-bold height-input"
				                placeholder="Enter package offer"
				               	v-model="item.photo_on_disc"
			                    :rules="[rules.required, rules.number]"
				                outline                
				              ></v-text-field>
				            </span>
				          </v-list-tile-title>
				        </v-list-tile-content>
				    </v-list-tile>
				    <v-divider class="no-mg-bottom"></v-divider>

				    <v-list-tile class="height-70">
				        <v-list-tile-content class="h-100">
				          <v-list-tile-title class="content-flex-end h-100">
				            <span class="font-weight-bold item-title position-item">Poster (20x30):</span>
				            <span class="contain-text-field">
				              <v-text-field
				                class="font-weight-bold height-input"
				                placeholder="Enter package offer"
				               	v-model="item.poster"
			                    :rules="[rules.required, rules.number]"
				                outline                
				              ></v-text-field>
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

      <v-list v-show="check == 'show'" class="heigth-list-title">

        <v-list-tile class="height-70">
					<v-list-tile-content>
            <v-list-tile-title class="content-flex-end h-100">
	          	<span class="font-weight-bold item-title position-item">Package Name</span>
	          	<span class="contain-text-field">
	          		<v-text-field
	          			class="text-field-padding"
		            	v-model="data.package_name"
		            	readonly
		            	solo
		            >  
			        	</v-text-field>
			        </span>
          	</v-list-tile-title>
					</v-list-tile-content>
				</v-list-tile>
	      <v-divider class="mt-0 mb-0"></v-divider>

	      <v-list-tile class="height-70">
					<v-list-tile-content>
            <v-list-tile-title class="content-flex-end h-100">
	          	<span class="font-weight-bold item-title position-item">Package Price</span>
	          	<span class="contain-text-field">
	          		<v-text-field
	          			class="text-field-padding"
		            	v-model="data.price"
		            	readonly
		            	solo
		            >  
			        	</v-text-field>
			        </span>
          	</v-list-tile-title>
					</v-list-tile-content>
				</v-list-tile>
	      <v-divider class="mt-0 mb-0"></v-divider>

	      <v-list-tile class="height-70">
					<v-list-tile-content>
            <v-list-tile-title class="content-flex-end h-100">
	          	<span class="font-weight-bold item-title position-item">Offer Price</span>
	          	<span class="contain-text-field">
	          		<v-text-field
	          			class="text-field-padding"
		            	v-model="data.offer"
		            	readonly
		            	solo
		            >  
			        	</v-text-field>
			        </span>
          	</v-list-tile-title>
					</v-list-tile-content>
				</v-list-tile>
	      <v-divider class="mt-0 mb-0"></v-divider>

	      <v-list-tile class="height-70">
					<v-list-tile-content>
            <v-list-tile-title class="content-flex-end h-100">
	          	<span class="font-weight-bold item-title position-item">Total Photo</span>
	          	<span class="contain-text-field">
	          		<v-text-field
	          			class="text-field-padding"
		            	v-model="data.total_photo"
		            	readonly
		            	solo
		            >  
			        	</v-text-field>
			        </span>
          	</v-list-tile-title>
					</v-list-tile-content>
				</v-list-tile>
	     	<v-divider class="mt-0 mb-0"></v-divider>

	      <v-list-tile class="height-70">
					<v-list-tile-content>
            <v-list-tile-title class="content-flex-end h-100">
	          	<span class="font-weight-bold item-title position-item">Album</span>
	          	<span class="contain-text-field">
	          		<v-text-field
	          			class="text-field-padding"
		            	v-model="data.album"
		            	readonly
		            	solo
		            >  
			        	</v-text-field>
			        </span>
          	</v-list-tile-title>
					</v-list-tile-content>
				</v-list-tile>
	      <v-divider class="mt-0 mb-0"></v-divider>

        <v-list-tile v-if="data.photo_on_disc != 0" class="height-70">
					<v-list-tile-content>
            <v-list-tile-title class="content-flex-end h-100">
	          	<span class="font-weight-bold item-title position-item">Photos on the disc</span>
	          	<span class="contain-text-field">
	          		<v-text-field
	          			class="text-field-padding"
		            	v-model="data.photo_on_disc"
		            	readonly
		            	solo
		            >  
			        	</v-text-field>
			        </span>
          	</v-list-tile-title>
					</v-list-tile-content>
				</v-list-tile>
        <v-divider class="mt-0 mb-0"></v-divider>

	      <v-list-tile v-if="data.poster != 0" class="height-70">
					<v-list-tile-content>
            <v-list-tile-title class="content-flex-end h-100">
	          	<span class="font-weight-bold item-title position-item">Poster (20x30)</span>
	          	<span class="contain-text-field">
	          		<v-text-field
	          			class="text-field-padding"
		            	v-model="data.poster"
		            	readonly
		            	solo
		            >  
			        	</v-text-field>
			        </span>
          	</v-list-tile-title>
					</v-list-tile-content>
				</v-list-tile>
	      <v-divider class="mt-0 mb-0"></v-divider>
			
      </v-list> 

      <v-list v-show="check == 'edit'" class="heigth-list-title">

				<v-list-tile class="height-70">
					<v-list-tile-content class="h-100">
						<v-list-tile-title class="content-flex-end h-100">
							<span class="font-weight-bold item-title position-item">Package Name:</span>
							<span class="contain-text-field">
								<v-text-field
								class="font-weight-bold height-input"
								placeholder="Enter package name"
								v-model="data.package_name"
								outline
								:rules="[rules.required]"
								@blur="editItem('package_name', data.package_name)"
								@keyup.enter="editItem('package_name', data.package_name)"
								></v-text-field>
							</span>
						</v-list-tile-title>
					</v-list-tile-content>
				</v-list-tile>
				<v-divider class="no-mg-bottom"></v-divider>

				<v-list-tile class="height-70">
					<v-list-tile-content class="h-100">
						<v-list-tile-title class="content-flex-end h-100">
							<span class="font-weight-bold item-title position-item">Package Price:</span>
							<span class="contain-text-field">
								<v-text-field
								class="font-weight-bold height-input"
								placeholder="Enter package price"
								v-model="data.price"
								:rules="[rules.required]"
								outline
								@blur="editItem('price', data.price)"
								@keyup.enter="editItem('price', data.price)"
								></v-text-field>
							</span>
						</v-list-tile-title>
					</v-list-tile-content>
				</v-list-tile>
				<v-divider class="no-mg-bottom"></v-divider>

				<v-list-tile class="height-70">
					<v-list-tile-content class="h-100">
						<v-list-tile-title class="content-flex-end h-100">
							<span class="font-weight-bold item-title position-item">Offer Price:</span>
							<span class="contain-text-field">
								<v-text-field
								class="font-weight-bold height-input"
								placeholder="Enter package offer"
								v-model="data.offer"
								:rules="[rules.required]"
								outline
								@blur="editItem('offer', data.offer)"
								@keyup.enter="editItem('offer', data.offer)"
								></v-text-field>
							</span>
						</v-list-tile-title>
					</v-list-tile-content>
				</v-list-tile>
				<v-divider class="no-mg-bottom"></v-divider>

				<v-list-tile class="height-70">
					<v-list-tile-content class="h-100">
						<v-list-tile-title class="content-flex-end h-100">
							<span class="font-weight-bold item-title position-item">Total Photo:</span>
							<span class="contain-text-field">
								<v-text-field
								class="font-weight-bold height-input"
								placeholder="Enter package offer"
								v-model="data.total_photo"
								:rules="[rules.required, rules.number]"
								outline
								@blur="editItem('total_photo', data.total_photo)"
								@keyup.enter="editItem('total_photo', data.total_photo)"
								></v-text-field>
							</span>					</v-list-tile-title>
					</v-list-tile-content>
				</v-list-tile>
				<v-divider class="no-mg-bottom"></v-divider>

				<v-list-tile class="height-70">
					<v-list-tile-content class="h-100">
						<v-list-tile-title class="content-flex-end h-100">
							<span class="font-weight-bold item-title position-item">Album:</span>
							<span class="contain-text-field">
								<v-text-field
								class="font-weight-bold height-input"
								placeholder="Enter package offer"
								v-model="data.album"
								:rules="[rules.required]"
								outline
								@blur="editItem('album', data.album)"
								@keyup.enter="editItem('album', data.album)"
								></v-text-field>
							</span>
						</v-list-tile-title>
					</v-list-tile-content>
				</v-list-tile>
				<v-divider class="no-mg-bottom"></v-divider>

				<v-list-tile class="height-70">
					<v-list-tile-content class="h-100">
						<v-list-tile-title class="content-flex-end h-100">
							<span class="font-weight-bold item-title position-item">Photos on the disc:</span>
							<span class="contain-text-field">
								<v-text-field
								class="font-weight-bold height-input"
								placeholder="Enter package offer"
								v-model="data.photo_on_disc"
								:rules="[rules.required, rules.number]"
								outline
								@blur="editItem('photo_on_disc', data.photo_on_disc)"
								@keyup.enter="editItem('photo_on_disc', data.photo_on_disc)"
								></v-text-field>
							</span>
						</v-list-tile-title>
					</v-list-tile-content>
				</v-list-tile>
				<v-divider class="no-mg-bottom"></v-divider>

				<v-list-tile class="height-70">
					<v-list-tile-content class="h-100">
						<v-list-tile-title class="content-flex-end h-100">
							<span class="font-weight-bold item-title position-item">Poster (20x30):</span>
							<span class="contain-text-field">
								<v-text-field
								class="font-weight-bold height-input"
								placeholder="Enter package offer"
								v-model="data.poster"
								:rules="[rules.required, rules.number]"
								outline
								@blur="editItem('poster', data.poster)"
								@keyup.enter="editItem('poster', data.poster)"
								></v-text-field>
							</span>
						</v-list-tile-title>
					</v-list-tile-content>
				</v-list-tile>
				<v-divider class="no-mg-bottom"></v-divider>

      </v-list> 
	    
		 	<v-card-actions class="w-100 border border-left-0 border-right-0 border-bottom-0 pr-4 bottom-position flex-end">
				<v-btn @click.stop="stopdrawerRight()">Close</v-btn>
			</v-card-actions>

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
.text-center {
    display: block !important;
}
.style-content {
	margin: 0px !important;
}
.style-flex {
	padding: 5px 12px !important;
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


.text-field-padding {
	padding-left: 30px;
}

</style>
