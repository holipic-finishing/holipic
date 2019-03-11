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
					<v-toolbar-title class="text-capitalize">Add Photographer</v-toolbar-title>
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

						<v-list-tile class="height-65">
							<v-list-tile-content class="h-100">
								<v-list-tile-title class="content-flex-end h-100">
									<span class="item-title position-item">Select Branch:</span>
									<span class="contain-text-field">
										<v-select
											clearable
							                :items="branches"
							                item-value="id"
			            					item-text="name"
						                	v-model="photographer.branch_id"
						                	:rules="[rules.required]"
						                	placeholder="Select Branch"
						                	class="height-input"
						              	></v-select>
									</span>
								</v-list-tile-title>
							</v-list-tile-content>
						</v-list-tile>
						<v-divider class="m-0"></v-divider>

						<v-list-tile class="height-65">
							<v-list-tile-content class="h-100">
								<v-list-tile-title class="content-flex-end h-100">
									<span class="item-title position-item">Name:</span>
									<span class="contain-text-field">
										<v-text-field
											class="height-input"
											placeholder="Input Your Name"
											v-model="photographer.name"
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
									<span class="item-title position-item">Phone Number:</span>
									<span class="contain-text-field">
										<v-text-field
											class="height-input"
											placeholder="Input Your Phone"
											v-model="photographer.phone_number"
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
									<span class="item-title position-item">Email:</span>
									<span class="contain-text-field">
										<v-text-field
											class="height-input"
											placeholder="Enter Email"
											v-model="photographer.email"
											
											:rules="[rules.required, rules.email]"
										></v-text-field>
									</span>
								</v-list-tile-title>
							</v-list-tile-content>
						</v-list-tile>
						<v-divider class="m-0"></v-divider>

						<v-list-tile class="height-75 custom-height-75">
							<v-list-tile-content class="h-100">
								<v-list-tile-title class="content-flex-end h-100">
									<span class="item-title position-item">Avatar:</span>
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
									          <v-btn color="blue darken-1" flat @click="dialog2 = false">Done</v-btn>
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
					            	<span class="item-title">Address:</span>
					            	<span class="contain-text-field">
										<v-textarea
											placeholder="Input Your Address"
											v-model="photographer.address"
											:rules="[rules.required]"
											rows="1"
										></v-textarea>
					            	</span>
					          	</v-list-tile-title>
					     	</v-list-tile-content>
				      	</v-list-tile>
				      	<v-divider class="m-0"></v-divider>

						<v-list-tile class="height-65">
							<v-list-tile-content class="h-100">
								<v-list-tile-title class="content-flex-end h-100">
									<span class="item-title position-item">Status:</span>
									<span class="contain-text-field">
										<v-select
											clearable
							                :items="status"
							                v-model="photographer.status"
							                :rules="[rules.required]"
							                placeholder="Select Status"
							                class="height-input"
							         	></v-select>
									</span>
								</v-list-tile-title>
							</v-list-tile-content>
						</v-list-tile>

						<v-divider class="m-0"></v-divider>

						<v-list-tile class="height-75 custom-height-75">
							<v-list-tile-content class="h-100">
								<v-list-tile-title class="content-flex-end h-100 content-image">
									<span class="font-weight-bold item-title position-item custom-avatar">ID copy:</span>
									<span class="contain-text-field image-filed">
										<!-- <input
											type="file"
											ref="image"
											accept="images/*"
											@change="onFilePicked($event)"
											:rules="[rules.required]"
										> -->
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
										              
												        <!-- <div class="placeholder" slot="placeholder">No image</div> -->
												    </clipper-basic>
												    </v-flex>
												    
												      <!--   <div>preview:</div>
												        <clipper-preview name="my-preview" class="my-clipper">
												             <div class="placeholder" slot="placeholder">preview area</div>
												        </clipper-preview>
												    	</div> -->
												    <!-- <div> -->
												    <v-flex xs12 sm6 md12>
												        <img class="result" :src="resultURLCard" alt="" width="100%">
												    </v-flex>
									            </v-layout>
									          </v-container>
									         
									        </v-card-text>
									        <v-card-actions>
									          <v-spacer></v-spacer>
									          <v-btn color="blue darken-1" flat @click="dialog = false">Done</v-btn>
									        </v-card-actions>
									      </v-card>
										</v-dialog>
									</span>
								</v-list-tile-title>
							</v-list-tile-content>
						</v-list-tile>
						
						<v-divider class="m-0"></v-divider>

						<v-flex xs12 sm12 class="style-flex fix-style-flex">
							<v-btn dark color="indigo" class="add-btn" @click="savePhotographer()">
								Save
							</v-btn>
						</v-flex>

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
import Vue from 'vue'
import VuejsClipper from 'vuejs-clipper'
import { clipperBasic, clipperPreview, clipperUpload } from 'vuejs-clipper'
Vue.use(VuejsClipper)

export default {

  name: 'PhotographerAdd',
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
			alertType:'success',
			alertMes: '',
			drawerHeaderStt: null,
  		width: 0,
  		src: [
	      "https://timtnleeproject.github.io/vuejs-clipper/ex2.jpg",
	      "https://timtnleeproject.github.io/vuejs-clipper/dawn.jpg"
	    ],
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
	mounted() {
		this.$root.$on('drawer-status', res => {
  		this.drawerHeaderStt = res
  	})

		this.$root.$on('showPhotographerAdd', res => {
			this.photographer = {}
			this.$refs.form.reset()
			this.drawerRight = res.showNavigation
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
		onFilePicked(e)
		{
			e.preventDefault();
			const file = e.target.files
			this.photographer.identification = file[0]
		},
		savePhotographer() {
			if (this.$refs.form.validate()) {
				var fd = new FormData();

				if(this.photographer.identification){
	        		fd.append("identification", this.photographer.identification);
	      		}

	      		if(this.photographer.avatar){
	        		fd.append("avatar", this.photographer.avatar);
	      		}

				if(this.photographer.branch_id){
					fd.append("branch_id", this.photographer.branch_id);
				}

		        if(this.photographer.name){
		        	fd.append("name", this.photographer.name);
		        }

		        if(this.photographer.phone_number){
		       		fd.append("phone_number", this.photographer.phone_number);
		        }

		        if(this.photographer.address){
		        	fd.append("address", this.photographer.address);
		        }
					
				if(this.photographer.email){
		        	fd.append("email", this.photographer.email);
		        }

		      	if(this.photographer.status){
		        	fd.append("status", this.photographer.status);
		      	}

	      		fd.append('userId', this.company.id)
				
	  			// let params = {information: this.photographer, userId: this.company.id}
	  			post(config.API_URL+'photographer', fd)
		  			.then(response =>{
		  				if(response && response.data.success) {
		  					this.$root.$emit('reloadTablePhotographerAdd')
						    this.alertMes = response.data.message
						    this.alertType = 'success'

						    this.$notify({
				          title: 'Success',
				          message: this.alertMes,
				          type: this.alertType,
				          duration: 2000,
				        })
		  				}
		  			})
		  			.catch(error => {
		  				this.$notify({
				          title: 'Error',
				          message: 'System Error Occurred',
				          type: 'error',
				          duration: 2000,
			        	})
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
	    }
	},
	computed: {
  	widthComputed(){
  		return this.width
  	}
  },
};
</script>

<style lang="scss" scoped>
.fix-style-flex{
	float: right;
}
.style-flex {
	padding: 5px 12px !important;
	font-weight: 500 !important;
}
.basic{
	width: 70% !important;

 }
</style>
