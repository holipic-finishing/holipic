<template>
	<v-layout row wrap>
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
					<v-toolbar-title class="text-capitalize">Edit Customer</v-toolbar-title>
					<v-spacer></v-spacer>
					<v-toolbar-side-icon @click="stopdrawerRight()">
						<v-icon>
							fas fa-times
						</v-icon>
					</v-toolbar-side-icon>
				</v-toolbar>
				<v-divider class="no-mg-bottom"></v-divider>
				<v-form
				ref="form"
				v-model="valid"
				lazy-validation
				>
					<v-list class="heigth-list-title">

						<v-alert  v-model="alertStt" :type="alertType" dismissible>{{ alertMes }}</v-alert>

						<v-list-tile class="height-80">
							<v-list-tile-content class="h-100">
								<v-list-tile-title class="content-flex-end h-100">
									<span class="font-weight-bold item-title position-item">Name:</span>
									<span class="contain-text-field">
										<v-text-field
											class="font-weight-bold height-input"
											placeholder="Enter Name"
											v-model="customer.name"
											:rules="[rules.required]"
											outline
											@blur="editCustomer('name', customer.name)"
											@keyup.enter="editCustomer('name', customer.name)"
										></v-text-field>
									</span>
									<!-- <span class="position-item">
						              <v-btn flat icon @click="unDisableItem(1)"><v-icon small>fas fa-marker</v-icon></v-btn>
						            </span> -->
								</v-list-tile-title>
							</v-list-tile-content>
						</v-list-tile>
						<v-divider class="no-mg-bottom"></v-divider>

						<v-list-tile class="height-80">
							<v-list-tile-content class="h-100">
								<v-list-tile-title class="content-flex-end h-100">
									<span class="font-weight-bold item-title position-item">Email:</span>
									<span class="contain-text-field" >
										<template v-if="customer.user">
											<v-text-field
											class="font-weight-bold height-input"
											placeholder="Enter Email"
											v-model="customer.user.email"
											:rules="[rules.required, rules.email]"
											outline
											@blur="editCustomer('email', customer.user.email)"
											@keyup.enter="editCustomer('email', customer.user.email)"
											></v-text-field>
										</template>
									</span>
								</v-list-tile-title>
							</v-list-tile-content>
						</v-list-tile>
						<v-divider class="no-mg-bottom"></v-divider>

						<v-list-tile class="height-80 ">
							<v-list-tile-content class="h-100">
								<v-list-tile-title class="content-flex-end h-100">
									<span class="font-weight-bold item-title position-item">Avatar:</span>
									<span class="contain-text-field image-filed">
										<v-text-field 
											v-model='imageName' 
											@click='pickFile' 
											prepend-icon='attach_file' 
											outline class="font-weight-bold height-input" 
											readonly 
										></v-text-field>
										<input
											type="file"
											style="display: none"
											ref="image"
											accept="images/*"
											@change="onFilePicked($event)"
										>
									</span>
								</v-list-tile-title>
							</v-list-tile-content>
						</v-list-tile>

						<v-list-tile class="height-80" v-if="imageUrl">
							<v-list-tile-content class="h-100">
								<v-list-tile-title class="content-flex-end h-100">
									<span class="font-weight-bold item-title position-item"></span>
									<span class="contain-text-field text-xs-center text-sm-center text-md-center text-lg-center">
										<img :src="imageUrl" height="60" v-if="imageUrl"/>
									</span>
									<span class="position-item">
						              
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
										placeholder="Enter Address"
										v-model="customer.address"
										:rules="[rules.required]"
										outline
										@blur="editCustomer('address', customer.address)"
										@keyup.enter="editCustomer('address', customer.address)"
										></v-text-field>
									</span>
								</v-list-tile-title>
							</v-list-tile-content>
						</v-list-tile>
						<v-divider class="no-mg-bottom"></v-divider>

						<v-list-tile class="height-80">
							<v-list-tile-content class="h-100">
								<v-list-tile-title class="content-flex-end h-100">
									<span class="font-weight-bold item-title position-item">Status:</span>
									<span class="contain-text-field">
										<v-select
						                class="font-weight-bold height-input"
						                outline
						                :items="status"
						                v-model="selectStatus"
										@change="editCustomer('status', selectStatus)"
						              ></v-select>
									</span>
								</v-list-tile-title>
							</v-list-tile-content>
						</v-list-tile>
						</v-list>
					</v-form>	
						<v-spacer></v-spacer>

						<v-card-actions class="w-100 border border-left-0 border-right-0 border-bottom-0 pr-4 bottom-position flex-end">
							
							<v-btn @click.stop="drawerRight = !drawerRight">Close</v-btn>
						</v-card-actions>

					
			</v-card>      	
		</v-navigation-drawer>
	</v-layout>
</template>

<script>
import  { get, post, put, del, getWithData } from '../../../api/index.js'
import config from '../../../config/index.js'
import { getWithContentWrap } from '../../../helpers/helpers'

export default {

  name: 'CustomerEdit',

  data () {
    return {
    	drawerRight: false,
    	customer: [],
    	rules: {
	        required: value => !!value || 'Required.',
	        email: value => /^\w+([.-]?\w+)*@\w+([.-]?\w+)*(\.\w{2,3})+$/.test(value) || "E-mail must be valid"
	    },
	    valid: true,
	    alertStt:false,
		alertType:'success',
		alertMes: '',
		key:0,
		status: ['Active', 'Inactive'],
		selectStatus:'',
		imageName: '',
		imageUrl: '',
		imageFile: '',
		dialog:'',
		width: 0,
		drawerHeaderStt: null
    }
  },
  mounted() {
  	this.$root.$on('showFormEditCustomer', res => {
  		this.drawerRight = res.showNavigation
  		this.customer = res.data
  		if(res.data.status == 1) {
  			this.selectStatus = 'Active'
  		} else {
  			this.selectStatus = 'Inactive'
  		}
  		this.width = this.getCurrentWithContentWrap()
  	})
  },
  computed:{
  	widthComputed(){
			return this.width
	}
  },
  methods: {
  	getCurrentWithContentWrap(){
  		return getWithContentWrap(this.drawerHeaderStt)
  	},
  	unDisableItem(index) 
  	{
  		this.key = index
  	},
  	pickFile()
  	{
  		 this.$refs.image.click()

  	},
  	onFilePicked (e) {

		e.preventDefault();

		var file = e.target.files
		console.log(file)
		 
		if(file[0] !== undefined) {
			this.imageName = file[0].name

			if(this.imageName.lastIndexOf('.') <= 0) {
				return
			}

			const fr = new FileReader ()
			fr.readAsDataURL(file[0])
			fr.addEventListener('load', () => {
				this.imageUrl = fr.result
				this.imageFile = file[0] // this is an image file that can be sent to server...
			})

			var fd = new FormData();
			fd.append('_method', 'PATCH')
			fd.append("avatar", file[0]);
			
			axios.post(config.API_URL+'branch/customer/'+this.customer.id, fd)
				.then (response => {
					if(response && response.data.success) {
						this.alertStt = true
			          	this.alertType = 'success'
			          	this.alertMes = response.data.message					
			          	setTimeout(() => {
			            	this.alertStt = false
						}, 2000)
						this.key = 0
						this.$root.$emit('reloadTableCustomer')	
						
					}
				})
				.catch((e,value) =>{
					this.alertStt = true
			        this.alertType = 'error'
			        this.alertMes = 'Please upload with file image'         
			        setTimeout(() => {
			          this.alertStt = false
			        }, 1500)
					this.$root.$emit('reloadTableCustomer')
					this.key = 0
				})	


		} else {
			this.imageName = ''
			this.imageFile = ''
			this.imageUrl = ''
			 
		}
	},
	editCustomer(field, value) {
		let params = {}

  		switch(field) {
  			 	
			case "name" :
				params = {name: value};
				break;
			case "email" :
				params = {email: value};
				break;	
			case "address" :
				params = {address: value};
				break;
			case "status" :
				params = {status: value};
				break;
				default:   	
  		}
  		
  		
	  		axios.patch(config.API_URL+'branch/customer/'+this.customer.id, {params: params})
				.then (response => {
					if(response && response.data.success) {
						this.alertStt = true
			          	this.alertType = 'success'
			          	this.alertMes = response.data.message					
			          	setTimeout(() => {
			            	this.alertStt = false
						}, 2000)
						this.key = 0
						this.$root.$emit('reloadTableCustomer')	
					}
				})

				.catch((e) =>{
					this.alertStt = true
			        this.alertType = 'error'
			        this.alertMes = response.data.message         
			        setTimeout(() => {
			          this.alertStt = false
			        }, 1500)
					this.$root.$emit('reloadTableCustomer')
					this.key = 0
				})
			
  		
	},
	stopdrawerRight(){
		this.drawerRight = false
		this.key = 0
		this.imageUrl = ''
	},
}
}
</script>

<style lang="scss" scoped>
	.fix-height-80{
		height: 200px !important;
	}
	.image-filed{
		display:flex;
	}
</style>