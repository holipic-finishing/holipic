<template>
	<v-layout row wrap>
		<v-navigation-drawer
			fixed
			v-model="drawerRight"
			right
			temporary
			app
			clipped
			:width='widthComputed'
		>
			<v-card class="h-100 position-relative">
				<v-toolbar class="mb-3">
					<v-toolbar-title class="text-capitalize">Edit Photographer</v-toolbar-title>
					<v-spacer></v-spacer>
					<v-toolbar-side-icon @click.stop="drawerRight = !drawerRight">
						<v-icon>
							fas fa-times
						</v-icon>
					</v-toolbar-side-icon>
				</v-toolbar>

				<v-form
					ref="form"
					v-model="valid"
					lazy-validation
				>
					<v-list class="heigth-list-title">

						<v-list-tile class="height-55">
							<v-list-tile-content class="h-100">
								<v-list-tile-title class="content-flex-end h-100">
									<span class="item-title position-item">Select Branch:</span>
									<span class="contain-text-field">
										<v-select
							                class="height-input"
							                :items="branches"
							                item-value="id"
        									item-text="name"
							                v-model="currentSelectBranch"
							                @change="editPhotographer('branch', currentSelectBranch)"
											placeholder="Select Branch"
			              				></v-select>
									</span>
								</v-list-tile-title>
							</v-list-tile-content>
						</v-list-tile>
						<v-divider class="m-0"></v-divider>

						<v-list-tile class="height-55">
							<v-list-tile-content class="h-100">
								<v-list-tile-title class="content-flex-end h-100">
									<span class="item-title position-item">Name:</span>
									<span class="contain-text-field">
										<v-text-field
											class="height-input"
											placeholder="Enter Name"
											v-model="photographer.name"
											:rules="[rules.required]"

											@blur="editPhotographer('name', photographer.name)"
											@keyup.enter="editPhotographer('name', photographer.name)"
										></v-text-field>
									</span>
								</v-list-tile-title>
							</v-list-tile-content>
						</v-list-tile>
						<v-divider class="m-0"></v-divider>

						<v-list-tile class="height-55">
							<v-list-tile-content class="h-100">
								<v-list-tile-title class="content-flex-end h-100">
									<span class="item-title position-item">Phone Number:</span>
									<span class="contain-text-field">
										<v-text-field
											class="height-input"
											placeholder="Enter Phone"
											v-model="photographer.phone_number"
											:rules="[rules.required]"
											@blur="editPhotographer('phone_number', photographer.phone_number)"
											@keyup.enter="editPhotographer('phone_number', photographer.phone_number)"
										></v-text-field>
									</span>
								</v-list-tile-title>
							</v-list-tile-content>
						</v-list-tile>
						<v-divider class="m-0"></v-divider>


						<v-list-tile class="height-55">
							<v-list-tile-content class="h-100">
								<v-list-tile-title class="content-flex-end h-100">
									<span class="item-title position-item">Email:</span>
									<span class="contain-text-field">
										<v-text-field
											class="height-input"
											placeholder="Enter Email"
											v-model="photographer.email"
											
											:rules="[rules.required, rules.email]"
											@blur="editPhotographer('email', photographer.email)"
											@keyup.enter="editPhotographer('email', photographer.email)"
										></v-text-field>
									</span>
								</v-list-tile-title>
							</v-list-tile-content>
						</v-list-tile>
						<v-divider class="m-0"></v-divider>

						<v-list-tile class="height-75 custom-height-75">
							<v-list-tile-content class="h-100">
								<v-list-tile-title class="content-flex-end h-100">
									<span class="font-weight-bold item-title position-item">Avatar:</span>
									<span class="contain-text-field">
										<img class="result" :src="resultURLAvatar" alt="" width="30%">
										<v-dialog v-model="dialog2" persistent max-width="600px">
											<v-btn slot="activator" >Upload avatar</v-btn>

											<v-card>
									        <v-card-title>
									          <span class="headline">Upload Avatar</span>
									        </v-card-title>
									        <v-card-text>
									          <v-container grid-list-md>
									            <v-layout wrap >
									            	 
									            	 <v-flex xs12 sm6 md8>
									            	 	<input type="file" @change="uploadAvatar($event)">
										              </v-flex>

										              <v-flex xs12 sm6 md4>
										                 <v-btn @click="getResultAvatar()" dark color="indigo">crop image</v-btn>
										              </v-flex>

										              <v-flex xs12 sm6 md12>
													    <clipper-basic class="my-clipper basic" ref="clipperAvatar" :src="imgURLAvatar" preview="my-preview" width="30%">
												    	</clipper-basic>
												    </v-flex>
												 
												    <v-flex xs12 sm6 md12>
												        <img class="result" :src="resultURLAvatar" alt="" width="100%">
												    </v-flex>
									            </v-layout>
									          </v-container>
									         
									        </v-card-text>
									        <v-card-actions>
									          <v-spacer></v-spacer>
									           <v-btn color="blue darken-1" flat @click="dialog2 = false">Cancel</v-btn>
									          <v-btn color="blue darken-1" flat @click="updateAvatarOrIdentification('avatar')">Done</v-btn>
									        </v-card-actions>
									      </v-card>
										</v-dialog>
									</span>
								</v-list-tile-title>
							</v-list-tile-content>
						</v-list-tile>
						<v-divider class="m-0"></v-divider>

						<v-list-tile class="height-75">
							<v-list-tile-content class="h-100">
								<v-list-tile-title class="content-flex-end h-100">
									<span class="item-title position-item">Address:</span>
									<span class="contain-text-field">
										<v-textarea
											placeholder="Enter Address"
											v-model="photographer.address"
											@blur="editPhotographer('address', photographer.address)"
											:rules="[rules.required]"
											@keyup.enter="editPhotographer('address', photographer.address)"
											hide-details
											single-line
											rows="2"
										></v-textarea>
					            	</span>
					          	</v-list-tile-title>
					     	</v-list-tile-content>
				      	</v-list-tile>
				      	<v-divider class="m-0"></v-divider>

						<v-list-tile class="height-55">
							<v-list-tile-content class="h-100">
								<v-list-tile-title class="content-flex-end h-100">
									<span class="item-title position-item">Status:</span>
									<span class="contain-text-field">
										<v-select
							                class="height-input"
							                :items="status"
							                v-model="selectStatus"
											@change="editPhotographer('status', selectStatus)"
											placeholder="Select Status"
						        		></v-select>
									</span>
								</v-list-tile-title>
							</v-list-tile-content>
						</v-list-tile>
						<v-divider class="m-0"></v-divider>

						<!-- <v-list-tile class="height-80">
							<v-list-tile-content class="h-100">
								<v-list-tile-title class="content-flex-end h-100">
									<span class="font-weight-bold item-title position-item">ID Copy:</span>
									
									<span class="contain-text-field">
										<img :src="photographer.indenfication_card" width="20%">
										<input
											type="file"
											ref="image"
											accept="images/*"
											@change="onFilePicked($event)"
										>
									</span>
								</v-list-tile-title>
							</v-list-tile-content>
						</v-list-tile>
						<v-divider class="no-mg-bottom"></v-divider> -->

						<v-list-tile class="height-75 custom-height-75">
							<v-list-tile-content class="h-100">
								<v-list-tile-title class="content-flex-end h-100 content-image">
									<span class="font-weight-bold item-title position-item custom-avatar">ID copy:</span>
									<span class="contain-text-field image-filed">
										<img class="result" :src="resultURLCard" alt="" width="30%">
										<v-dialog v-model="dialog" persistent max-width="600px">
											<v-btn slot="activator" >Upload card</v-btn>

											<v-card>
									        <v-card-title>
									          <span class="headline">Upload Identification Card</span>
									        </v-card-title>
									        <v-card-text>
									          <v-container grid-list-md>
									            <v-layout wrap >
									            	 
									            	<v-flex xs12 sm6 md8>
									            	 	<input type="file" @change="uploadIdentification($event)">
										            </v-flex>

										            <v-flex xs12 sm6 md4>
										                 <v-btn @click="getResult()" dark color="indigo">crop image</v-btn>
										            </v-flex>

										            <v-flex xs12 sm6 md12>
  														<clipper-basic class="my-clipper basic" ref="clipper" :src="imgURLCard" preview="my-preview" width="30%">
												    	</clipper-basic>
												    </v-flex>
												    
												    <v-flex xs12 sm6 md12>
												        <img class="result" :src="resultURLCard" alt="" width="100%">
												    </v-flex>
									            </v-layout>
									          </v-container>
									         
									        </v-card-text>
									        <v-card-actions>
									          <v-spacer></v-spacer>
									          <v-btn color="blue darken-1" flat @click="dialog = false">Cancel</v-btn>
									          <v-btn color="blue darken-1" flat @click="updateAvatarOrIdentification('identification')">Done</v-btn>
									        </v-card-actions>
									      </v-card>
										</v-dialog>
									</span>
								</v-list-tile-title>
							</v-list-tile-content>
						</v-list-tile>
						<v-divider class="m-0"></v-divider>
						

					</v-list>
				</v-form>

			</v-card>
		</v-navigation-drawer>
	</v-layout>
</template>

<script>

import  { get, post, put, del, getWithData } from '../../../api/index.js'
import config from '../../../config/index.js'
import { getWithContentWrap } from '../../../helpers/helpers'
import { clipperBasic, clipperPreview, clipperUpload } from 'vuejs-clipper'

export default {

  name: 'PhotographerEdit',

  	data () {
	    return {
	    	drawerRight: false,
	    	photographer: {},
	    	rules: {
		        required: value => !!value || 'This field is required.',
		        email: value => {
            		const abc = /^[^\s@]+@[^\s@]+\.[^\s@]+$/
            		return abc.test(value) || 'Incorrect format email.'
        		}
	    	},
	    	valid: true,
	    	branches: [],
	    	company: JSON.parse(localStorage.getItem('user')),
			status: ['Active', 'Inactive'],
			alertStt:false,
			alertType:'success',
			alertMes: '',
			key: 0,
			currentSelectBranch: {
		        id: '',
		        name: ''
		    },
		    selectStatus:'',
		    width: 0,
		   	drawerHeaderStt: null,
		   	resultURLCard:'',
	    	imgURLCard:'',
	    	resultURLAvatar:'',
	    	imgURLAvatar:'',
	    	dialog: false,
	    	dialog2: false
	    }
  	},
  	components: {
    	clipperBasic,
    	clipperPreview,
    	clipperUpload
  	},
  	computed: {
		widthComputed(){
			return this.width
		}
  	},
	mounted() {
	  	this.$root.$on('showFormEditPhotgrapher', res => {
	  		this.drawerRight = res.showNavigation,
	  		this.photographer = res.data
	  		if(this.photographer.status){
	  			this.selectStatus = 'Active'
	  		} else {
	  			this.selectStatus = 'Inactive'
	  		}
	  		this.currentSelectBranch = {id: res.data.branch.id, name: res.data.branch.name}
	  		this.width = this.getCurrentWithContentWrap()
	  	})
	  	this.getBranchCompany()
	},
	methods: {
		getCurrentWithContentWrap(){
  			return getWithContentWrap(this.drawerHeaderStt)
  		},
		getBranchCompany() {
	  		get(config.API_URL+'company/branches?companyId='+this.company.company_id)
			.then(response => {
				if(response && response.data.success) {
					this.branches = response.data.data
				}
			})
			.catch(error => {
				this.$notify({
		          title: 'Error',
		          message: 'Cannot Load Branches',
		          type: 'error',
        		})
			})
  		},
		checkValue(){
			if(this.photographer.name == '' || this.photographer.address == '' || this.photographer.phone_number == '' || this.selectStatus == '')
			{
				this.alertStt = true
		        this.alertType = 'error'
		        this.alertMes = 'Please type text'
		        setTimeout(() => {
		          this.alertStt = false
		        }, 1500)

				this.$root.$emit('reloadTablePhotographer')
				this.key = 0
				return false
			}
			return true
		},
		unDisableItem(index) {
			this.key = index
		},
		// onFilePicked(e)
		// {
		// 	e.preventDefault();

		// 	const file = e.target.files

		// 	var fd = new FormData();
		// 	fd.append('_method', 'PUT')
			
	 //        fd.append("identification", file[0]);
	      	
		// 	post(config.API_URL+'photographer/'+this.photographer.id, fd)
		// 		.then (response => {
		// 			if(response && response.data.success) {
		// 	          	this.alertType = 'success'
		// 	          	this.alertMes = response.data.message
		// 		        this.$notify({
		// 		          title: 'Success',
		// 		          message: this.alertMes,
		// 		          type: this.alertType,
		// 		          duration: 2000,
		// 		        })
		// 				this.key = 0
		// 				this.$root.$emit('reloadTablePhotographer')
		// 			}
		// 		})
		// 		.catch((e) =>{
		// 	        this.alertType = 'error'
		// 	        this.alertMes = response.data.message
		// 	       	this.$notify({
		// 	          title: 'Error',
		// 	          message: this.alertMes,
		// 	          type: this.alertType,
		// 	          duration: 2000,
		// 	        })
		// 			this.$root.$emit('reloadTablePhotographer')
		// 			this.key = 0
		// 		})
		// },
  		editPhotographer(field, value) {

			let params = {}

			switch(field) {
			 	case "branch" :
					params = {branch_id: value};
					break;
				case "name" :
					params = {name: value};
					break;
				case "phone_number" :
					params = {phone_number: value};
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

			if(this.checkValue()) {
				put(config.API_URL+'photographer/'+this.photographer.id, {params: params})
				.then (response => {
					if(response && response.data.success) {
			          	this.alertType = 'success'
			          	this.alertMes = response.data.message
				        this.$notify({
				          title: 'Success',
				          message: this.alertMes,
				          type: this.alertType,
				          duration: 2000,
				        })
						this.key = 0
						this.$root.$emit('reloadTablePhotographer', {data: response.data.data})
					}
				})
				.catch((e) =>{
			        this.alertType = 'error'
			        this.alertMes = response.data.message
			       	this.$notify({
			          title: 'Error',
			          message: this.alertMes,
			          type: this.alertType,
			          duration: 2000,
			        })
						this.$root.$emit('reloadTablePhotographer', {data: response.data.data})
						this.key = 0
				})
			}
	  	},
	  	decodeImage(image) 
		{
			var blobBin = atob(image.split(',')[1]);
			var array = [];
			for(var i = 0; i < blobBin.length; i++) {
			    array.push(blobBin.charCodeAt(i));
			}
			var file = new Blob([new Uint8Array(array)], {type: 'image/jpg'});

			return file
		},
		getResult()
		{
			const canvas = this.$refs.clipper.clip();
            this.resultURLCard = canvas.toDataURL("image/jpg", 1);
			this.photographer.identification = this.decodeImage(this.resultURLCard)
		},
		getResultAvatar()
		{
			const canvas = this.$refs.clipperAvatar.clip();
            this.resultURLAvatar = canvas.toDataURL("image/jpg", 1);
            this.photographer.avatar = this.decodeImage(this.resultURLAvatar)
		},
		uploadIdentification(e){
			if (e.target.files.length !== 0) {
				if(this.imgURLCard) URL.revokeObjectURL(this.imgURLCard)
				this.imgURLCard = window.URL.createObjectURL(e.target.files[0]);
			}
	    },
	    uploadAvatar(e) {
	    	if (e.target.files.length !== 0) {
		        if(this.imgURLAvatar) URL.revokeObjectURL(this.imgURLAvatar)
		        this.imgURLAvatar = window.URL.createObjectURL(e.target.files[0]);
	      	}
	    },
	    updateAvatarOrIdentification(type)
	    {
	    	var fd = new FormData();
			fd.append('_method', 'PUT')

	    	if(type == 'avatar') {
	    		if(this.resultURLAvatar == '') {
	    			this.alertType = 'error'
			        this.alertMes = 'Please choose image avatar'
			       	this.$notify({
			          title: 'Error',
			          message: this.alertMes,
			          type: this.alertType,
			          duration: 2000,
			        })
			        return
	    		} else {
	    			fd.append("avatar", this.photographer.avatar); 
	    		}
	    	}

	    	if(type == 'identification') {
	    		if(this.resultURLCard == '') {
	    			this.alertType = 'error'
			        this.alertMes = 'Please choose image identification'
			       	this.$notify({
			          title: 'Error',
			          message: this.alertMes,
			          type: this.alertType,
			          duration: 2000,
			        })
			        return

	    		} else {
	    			fd.append("identification", this.photographer.identification); 
	    		}
	    	}

			post(config.API_URL+'photographer/'+this.photographer.id, fd)
				.then (response => {
					if(response && response.data.success) {
			          	this.alertType = 'success'
			          	this.alertMes = response.data.message
				        this.$notify({
				          title: 'Success',
				          message: this.alertMes,
				          type: this.alertType,
				          duration: 2000,
				        })
						this.key = 0
						this.$root.$emit('reloadTablePhotographer', {data: response.data.data})
						this.photographer.avatar = ''
						this.photographer.identification = ''
						this.dialog = false
	    				this.dialog2 = false
					}
				})
				.catch((e) =>{
			        this.alertType = 'error'
			        this.alertMes = response.data.message
			       	this.$notify({
			          title: 'Error',
			          message: this.alertMes,
			          type: this.alertType,
			          duration: 2000,
			        })
					this.$root.$emit('reloadTablePhotographer', {data: response.data.data})

					this.key = 0
					this.photographer.avatar = ''
					this.photographer.identification = ''
				})

	    }
  	}

  	};

</script>

<style lang="scss" scoped>
</style>
