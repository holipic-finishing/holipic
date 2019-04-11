<template>
	<v-layout row wrap>
		<!-- Selected photo-->
		<app-card
			colClasses="xl12 lg12 md12 xs12 d-xs-half-block w-full"
			customClasses="custom-app-card"
			:withTabs="true"	
			>
			<div class="cart" @click="checkout()">
				<i class="material-icons">
					shopping_cart
				</i>
				<div class="detail-cart">
					<span class="line-cart">$</span>
					<span class="line-cart-1">{{total}}</span>
					<span class="line-cart-2">Order</span>		
				</div>
			</div>
			<div class=" ml-5 mr-5">
				<v-flex xs6 class="v-flex-sp-l">
					<v-card-text>
						<span class="ml-3">
						{{$t('message.selectedPhoto')}} 
						 <v-btn fab dark small color="primary" @click="removeAllItem()" class="color-blue-shopselling">
					      <v-icon dark>clear</v-icon>
					    </v-btn>
						({{countSelected}})
						</span>
					</v-card-text>
				</v-flex>
				<v-flex xs6 class="v-flex-sp-r">
					<v-card-text class="select-languages">
						<div class="ml-4 width-select">
							<v-select
					          :items="currencies"
					          v-model="selectCurrency"
					        ></v-select>
				    	</div>

				    	<div class="ml-4 width-select">
					        <v-select
					          :items="languages"
					          v-model="selectLanguage"
					          @change="changeLanguage()"
					        ></v-select>
				    	</div>
					</v-card-text>
				</v-flex>
				<v-layout row wrap class="photo-selected ">
					<v-flex
						v-for="(photo,index) in changePhotos2"
						xs12 sm3
						d-flex
						:key="photo.id"
					>
						<v-card flat tile class="d-flex custom-d-flex">
							<div class="grid-item pos-relative custom-grid-item">
								<v-img
									:src="thumbnailDir+photo.name"
									aspect-ratio="1"
									class="grey lighten-2 "
									
									height="300"
									contain
									>
									<div class="content-info">
										<v-icon color="white" @click="removeItem(index, photo)">cancel</v-icon>
									</div>
									<v-layout
										slot="placeholder"
										fill-height
										align-center
										justify-center
										ma-0
									>
										<v-progress-circular indeterminate color="grey lighten-5">
										</v-progress-circular>
									</v-layout>
								</v-img>
							</div>
						</v-card>

						<div class="parent-select-detail" @click="showDetail(photo)">
							<span class="select-detail" :class="'select-detail'+photo.id" >{{photo.size}}</span>
							<span class="number-detail">
								<i class="fas fa-caret-down"></i>		
							</span>
							<div class="line-detail"></div>
						</div>

						
					</v-flex>
				</v-layout>

				<v-dialog
     			 	v-model="dialog"
      				width="400"
      				temporary
      				content-class="v-dialog-custom"
    				>
    				<v-card>
				        <v-container fluid>
						    <v-layout row v-for="type in photoTypes" :key="type.id">
						      	<v-flex xs3 >
							        <v-card tile flat class="cursor-v-card" :class="type.active && photoOpened.size == type.size ? 'hover-v-card' : '' " @click="activeClass(type)">
							        	<v-card-text>
							          		{{type.size}}
							          	</v-card-text>
							        </v-card>
						      	</v-flex>
							    <v-flex xs9 class="flex-v-number">   
							        <v-list-tile >
							          		<v-btn normal @click="decrease()" v-if="photoOpened !== null && photoOpened.size == type.size ">
										      <v-icon dark>remove</v-icon>
										    </v-btn>
										    <v-btn normal v-else :disabled="true">
										      <v-icon dark>remove</v-icon>
										    </v-btn>
								          	<v-text-field
								          		v-if="photoOpened !== null && photoOpened.size == type.size "
									            single-line
        										solo
									            v-model="photoOpened.quantity"
									            @keyup="setQuantity(photoOpened, photoOpened.quantity)"
									        >
									        </v-text-field>
									        <v-text-field
								          		v-else
								          		:disabled="true"
									            single-line
        										solo
									            v-model="number"
									        ></v-text-field>
									        <v-btn normal @click="increase(photoOpened, photoOpened.quantity)" v-if="photoOpened !== null && photoOpened.size == type.size ">
										      	<v-icon dark>add</v-icon>
										    </v-btn>
										    <v-btn normal @click="increase(photoOpened, photoOpened.quantity)" v-else :disabled="true">
										      	<v-icon dark>add</v-icon>
										    </v-btn>
							        </v-list-tile> 
							    </v-flex>
						    </v-layout>
						</v-container>
				      </v-card>
    			</v-dialog>
			</div>  
		</app-card>
		<!-- Selected photo-->

		<!--Orther photo -->
		<app-card
			colClasses="xl12 lg12 md12 xs12 d-xs-half-block w-full"
			customClasses="custom-app-card"
			:withTabs="true"	
			>
			<div class="mb-5 ml-5 mr-5">
				<v-flex xs2 class="v-flex-sp-l">
					<v-card-text >
						<span class="ml-3">{{$t('message.otherPhoto')}}</span> 
						<span class="ml-3 pt-3 top-relative"><i class="material-icons">
							filter
						</i>
						</span>
						<span class="ml-1">
							({{countOtherPhoto}})
						</span>
						<span class="ml-1 pt-3 top-relative">
							<i class="material-icons">
								keyboard_arrow_down
							</i>
						</span>
					</v-card-text>
				</v-flex>

				<v-flex xs10 class="v-flex-sp-r line-flex">
					
				</v-flex>

				<v-layout row wrap class="photo-selected images">
					
					<v-flex
						v-for="(photo,index) in photos"
						xs12 sm3
						d-flex
						:key="photo.id"
					>
						<v-card flat tile class="d-flex custom-d-flex" >
							<div class="grid-item pos-relative custom-grid-item">
								<v-img
									:src="thumbnailDir + photo.name"
									aspect-ratio="1"
									class="grey lighten-2 hover-image"
									height="300"
									:key="photo.id"
									@click="selectPhoto(photo,index)"
									contain
									>
								</v-img>
								
								<!-- <img :src="thumbnailDir + photo.name"/> -->

							</div>
						</v-card>

						<div class="icon-frame-photo">
						 	<span class="v-flex-sp-l" @click="showZoomImageAndSlide(photo,index)">
						 		<i class="material-icons cursor-v-card">
									zoom_out_map
								</i>
						 	</span>
						 	<span class="v-flex-sp-r" >
						 		<i class="material-icons cursor-v-card" :class="'active-image'+photo.id">
									check_circle
								</i>
						 	</span>
						</div>	
					</v-flex>
					
				 	<!-- <lightbox id="mylightbox" 
				      ref="lightbox"
				      :images="photos"
				      :directory="thumbnailDir"
				      :timeoutDuration="5000"
				 	/> -->
					
					<!-- <div class="list" v-for="(n, index) in imageList" :data-index="index">
					  <img @click="open($event)" :src="n.url">
					</div> -->
					<!-- 	<v-dialog
		     			 	v-model="dialog2"
		      				width="1000"
		      				class="v-dialog2"
		    				> -->
						<!-- <v-carousel class="custom-carousel" hide-delimiters >
						    <v-carousel-item
						      v-for="(item,i) in photoZoom"
						      :key="i"
						      :src="item.src"
						      width="50%"
						    ></v-carousel-item>
						</v-carousel> -->
					<!-- </v-dialog> -->
				</v-layout>
			</div>
		</app-card>
		<div v-if="activeGallery">
			<vue-gallery-slideshow :images="photos" :index="index" @close="index = null" :dir="thumbnailDir"></vue-gallery-slideshow>
		</div>
		<!--Orther photo -->

		<!-- <app-card colClasses="xl12 lg12 md12 xs12 d-xs-half-block w-full"
			customClasses="custom-app-card custom-app-card-footer"
			:withTabs="true">
			<div class="footer-shop-selling">
				
			</div>
		</app-card> -->
	</v-layout>
</template>
<script>

import Lightbox from 'vue-my-photos'
import Vue from 'vue'
import config from '../../../config'
import  { get, post, put, del, getWithData } from '../../../api/index.js'
import VueGallerySlideshow from './GallerySlideshow.vue'

Vue.component('lightbox', Lightbox);


export default {

  name: 'SelectPhoto',

  data () {
    return {
    	currencies:['USD'],
    	languages:['ENG', 'EST', 'RUS', 'FIN' ],
    	selectCurrency: 'USD',
    	selectLanguage: 'ENG',
  //   	photos: [
		// 	{
		// 		id: 1,
		// 		name: "blog-1.jpg",
		// 		caption: "Caption 1",
		// 		author: "Admin",
		// 		likes: "250",
		// 		checked:false
		// 	},
		// 	{
		// 		id: 2,
		// 		name: "blog-2.jpg",
		// 		caption: "Caption 2",
		// 		author: "Erik Turner",
		// 		likes: "150",
		// 		checked:false
		// 	},
		// 	{
		// 		id: 3,
		// 		name: "blog-3.jpg",
		// 		caption: "Caption 3",
		// 		author: "John Smith",
		// 		likes: "200",
		// 		checked:false
		// 	},
		// 	{
		// 		id: 4,
		// 		name: "blog-4.jpg",
		// 		caption: "Caption 4",
		// 		author: "Antonio Rice",
		// 		likes: "300",
		// 		checked:false
		// 	},
		// 	{
		// 		id: 5,
		// 		name: "blog-5.jpg",
		// 		caption: "Caption 5",
		// 		author: "Caleb Wilson",
		// 		likes: "400",
		// 		checked:false
		// 	},
		// 	{
		// 		id: 6,
		// 		name: "blog-6.jpg",
		// 		caption: "Caption 6",
		// 		author: "Zachary Robbins",
		// 		likes: "50",
		// 		checked:false
		// 	},
		// 	{
		// 		id: 7,
		// 		name: "blog-7.jpg",
		// 		caption: "Caption 7",
		// 		author: "Jon Wagner",
		// 		likes: "100",
		// 		checked:false
		// 	},
		// 	{
		// 		id: 8,
		// 		name: "blog-8.jpg",
		// 		caption: "Caption 8",
		// 		author: "Dorothy Bass",
		// 		likes: "75",
		// 		checked:false
		// 	},
		// 	{
		// 		id: 9,
		// 		name: "blog-8.jpg",
		// 		caption: "Caption 8",
		// 		author: "Dorothy Bass",
		// 		likes: "75",
		// 		checked:false
		// 	},
		// 	{
		// 		id: 10,
		// 		name: "blog-8.jpg",
		// 		caption: "Caption 8",
		// 		author: "Dorothy Bass",
		// 		likes: "75",
		// 		checked:false
		// 	}
		// ],
		photos:[],
		photos2: [],
		items:[{id: 1, name: 'hung'},{id:2, name: 'hung2'}],
		dialog:false,
		dialog_nouse:false,
		dialog2:false,
		photoId:'',
		number: 0,
		typeDetail: 'Select detail',
		count:0,	
		countOther:0,
		photoZoom: [],
		thumbnailDir: config.BASE_URL + '/static/img/',
		activeText: true,
		photoTypes: [],
		photoOpened: null,
		total:0,
		number: 0,
	    index: null,
	    room: JSON.parse(localStorage.getItem('roomLogin')),
	    activeGallery:false
    }
  },
  components: {
    VueGallerySlideshow
  },
  mounted(){
  	this.$i18n.locale = 'en'

  	this.$root.$on('typePackage', res => {
  		this.checkCondition(res.name, this.count)
  	})

  	this.$root.$on('photo-chosses', res => {
  		this.photos2 = res

		_.forEach(res, (value,index) => {
            _.forEach(this.photos, (v,i) => {
              	if(value.image_id === v.id){
                  	$(document).ready(function() {
                      $('.active-image'+v.id).css("color", "#00C1F8");
                  	})
                  	
              } else {
                    $('.active-image'+v.id).css("color", "#464D69");
              }
          })
        })

        this.getPricePackage(this.photos2)
  	})

  	this.$root.$on('updatePhoto', res => {
  		var key = _.findIndex(this.photos, function(value) { 
						return value.id == res.data.id; 
					});
  		this.photos[key].checked = res.checked
  	})

  },
  computed:{
  	typeDetailReturn()
  	{
  		return this.typeDetail
  	},
  	countSelected()
  	{
  		return this.count
  	},
  	countOtherPhoto()
  	{
  		return this.countOther
  	},
  	changePhotos()
  	{	
  		return this.photos
  	},
  	changePhotos2()
  	{
        return this.photos2
  	}
  },
  created(){
  	this.countOther = this.photos.length
  	
  	this.getDataPackage()
  	
  	this.getPhotoFromRoom()	
  },
  methods:{
  	removeItem(index,photo)
  	{
		this.photos2.splice(index, 1);

		let totalNew = 0

		if(this.photos2.length > 0) {
			this.getPricePackage(this.photos2)
		}else {
			this.total = 0
		}

		this.count --

		this.deletePhotoUnselected(photo.image_id)

		this.photos[index].checked = false

		$('.active-image'+photo.image_id).css("color", "#464D69");
  	},
  	removeAllItem()
  	{
  		_.forEach(this.photos2, (value,index) => {
  			this.deletePhotoUnselected(value.image_id)
  		})

  		this.getPhotoFromRoom()

  		this.photos2 = []

  		this.count = 0
  		
  		_.forEach(this.photos, (value,index) => {
  			$('.active-image'+value.id).css("color", "#464D69");
  		})

  		// localStorage.setItem('photoSelected', JSON.stringify(this.photos2))

  		this.total = 0
  	},
  	showDetail(photo)
  	{
  		this.dialog = true
  		this.photoId = photo.id
  		this.photoOpened = photo

  		_.forEach(this.photoTypes, (item, index) => {
  			if (item.size == photo.size) {
  				this.photoTypes[index]['active'] = true
  			}

  			this.photoTypes[index]['quantity'] = 1
  		})
  	},
  	activeClass(type)
  	{
  		this.typeDetail = type.size

  		_.forEach(this.photoTypes, (item, index) => {
  			this.photoTypes[index]['active'] = false
  			if (item.size == type.size) {
  				this.photoTypes[index]['active'] = true
  			}
  		})

  		this.addPhotoSelectedIntoDB(this.photoOpened)

  		let numberActive = 0

  		_.forEach(this.photos2, (value, index) => {
  			if(value['id'] == this.photoId) {
  				this.photos2[index]['size'] = type.size
  				this.photoOpened = this.photos2[index]
  				this.photoOpened.quantity = 1
  			}

  			get(config.API_URL+'photo-package/search?size='+value['size'])
	  		.then(res => {
	  			if(res && res.data.success) {
  					numberActive = numberActive + (value['quantity'] *res.data.data.dollar)
	  				this.total = numberActive
	  			}
	  		})
  		})
  	},
  	increase(photoOpened, quantity)
  	{
  		this.photoOpened.quantity ++
  		this.dialog = false
  		this.dialog = true
  		this.setQuantity(this.photoOpened, this.photoOpened.quantity)
  		this.addPhotoSelectedIntoDB(this.photoOpened)
  	},
  	decrease()
  	{
  		if(this.photoOpened.quantity > 1)
  		{
  			this.photoOpened.quantity --
  			this.dialog = false
  			this.dialog = true
  			this.setQuantity(this.photoOpened, this.photoOpened.quantity)
  			this.addPhotoSelectedIntoDB(this.photoOpened)
  		}
  	},
  	selectPhoto(photo,index)
  	{
  		var photoSelected = _.find(this.photos2, (value,key) => { 
  			return value.image_id == photo.id; 
  		});

  		if(photoSelected == undefined)
  		{
  			photo.checked = true
  			photo.image_id = photo.id
  			this.photos2.push(photo)

  			var length = this.photos2.length

  			this.photos2[length-1].size = 'DIGITAL'
  			this.photos2[length-1].quantity = 1
  			$('.active-image'+photo.id).css("color", "#00C1F8");

  			this.count++
  			this.getPricePackage(this.photos2)

  			this.addPhotoSelectedIntoDB(photo)
  		} else {
  			var key = _.findIndex(this.photos2, function(value) { 
  					return value.image_id == photo.id; 
  				});

			this.photos2.splice(key, 1);

  			photo.checked = false

			this.deletePhotoUnselected(photo.id)

			var totalNew = 0 

			if(this.photos2.length > 0) {
				this.getPricePackage(this.photos2)
			} else {
				this.total = 0
			}
			
  			$('.active-image'+photo.id).css("color", "#464D69");
  			this.count--	
  		}

  		_.forEach(this.photoTypes, (item, index) => {
  			this.photoTypes[index]['quantity'] = 1	
  		})		
  	},
  	addPhotoSelectedIntoDB(photo)
  	{
  		let params = {photo}
  		post(config.API_URL+'cart/add-photo',params)
  		.then(res => {

  		})
  	},
  	deletePhotoUnselected(imageId)
  	{
  		del(config.API_URL+'cart/delete-photo?imageId='+imageId)
  		.then(res => {
  			console.log(res.data)
  		})
  	},

  	getPricePackage(photos)
  	{
  		var totalNew = 0
  		_.forEach(photos, (value, index) => {
			get(config.API_URL+'photo-package/search?size='+value['size'])
		  		.then(res => {
		  			if(res && res.data.success) {
			  			totalNew = totalNew + (value['quantity'] * res.data.data.dollar)
			  			this.total = totalNew
		  			}
		  	})	
		})
  	},
  	showZoomImageAndSlide(photo,index)
  	{
  		this.index = index

  		this.$root.$emit('array-photos', this.photos2); 	

  	},
  	setQuantity : _.debounce( 
  		function(photo, quantity) {
	  	
	  		let totalNew = 0 
	  		_.forEach(this.photos2, (value,index) => {
	  			if(value['id'] == photo.id) {
	  				this.photos2[index]['quantity'] = quantity
	  			}

	  			get(config.API_URL+'photo-package/search?size='+value['size'])
		  		.then(res => {
		  			if(res && res.data.success) {
	  					totalNew = totalNew + (value['quantity'] * res.data.data.dollar)
		  				this.total = totalNew	
		  			}
		  		})
	  		})

  			this.addPhotoSelectedIntoDB(photo)
  		}, 2000)
  	,
  	changeLanguage()
  	{
  		if(this.selectLanguage == 'EST') {
  			this.$i18n.locale = 'es'
  		}else if(this.selectLanguage == 'RUS'){
  			this.$i18n.locale = 'ru'
  		}else if(this.selectLanguage == 'FIN'){
  			this.$i18n.locale = 'fi'
  		}else {
  			this.$i18n.locale = 'en'
  		}
  	},
  	getDataPackage()
  	{
  		get(config.API_URL+'photo_packages')
  		.then(res => {
  			if(res && res.data.success){
  				this.photoTypes = res.data.data
  			}
  		})
  		.catch(err => {
  			console.log(err.response)
  		})
  	},
  	getPhotoFromRoom()
  	{
  		get(config.API_URL+'room/show-photo?room='+this.room.id)
  		.then(res => {
  			if(res && res.data.success){
  				
  				this.thumbnailDir = res.data.data[1]
  				this.photos = res.data.data[0]['images']

  				_.forEach(this.photos, (value,index) => {
  					if(value['image_selected'] !== null) {
  						this.photos2.push(value['image_selected'])	
  					}
  				})

  				this.count = this.photos2.length

  				this.countOther = this.photos.length

        		this.getPricePackage(this.photos2)

  				_.forEach(this.photos2, (value) => {
  					$(document).ready(function() {
  						$('.active-image'+value.image_id).css("color", "#00C1F8");
  					})
  				})	
  			}
  		})
  		.then(res => {
  			this.activeGallery = true
  		})
  		.catch(err => {
  			console.log(err.response)
  		})
  	},
  	checkCondition(namePackage, count)
  	{
  		var messagePackage = ''

  		if(namePackage == 'Package 1' && count < 21) {
  			messagePackage = 'Please choose 21 image'
  			
  		} else if(namePackage == 'Package 2' && count < 30) {
  			messagePackage = 'Please choose 30 image'
  			
  		} else if(namePackage == 'Package 3' && count < 40) {
  			messagePackage = 'Please choose 40 image'
  			
  		}else {
  			messagePackage	 = 'Please choose 50 image'
  			
  		}

  		this.$notify({
          title: 'Notification',
          message: messagePackage,
          type: 'error',
          duration: 2000,
		})
  	},
  	checkout()
  	{
  		localStorage.setItem('photoSelected', JSON.stringify(this.photos2))

  		localStorage.setItem('thumbnailDir', this.thumbnailDir)

  		if(this.photos2.length > 0 ) {
  			this.$router.push('/shop-selling/confirm-booking')
  		}
  	}
  }
}

</script>

<style lang="scss" scoped>
.width-select{
	width:55px !important;
}
.top-relative{
	top:5px;
	position: relative;
}
.custom-grid-item{
	height: 300px !important;
	margin-top:20px !important;

}
.custom-primary{
	background-color: hsla(0, 0%, 0%, 0.2) !important;
}

.footer-shop-selling{
	height: 50px;
	background-color:#5d92f4 !important;
	color:white;
}
.cart{
	position: fixed;
	z-index:7;
	background-color:white !important;
	right: 55px;
	border-radius:2px;
	-moz-box-shadow: 0 0 5px #888;
	-webkit-box-shadow: 0 0 5px#888;
	box-shadow: 0 0 5px #888;
	margin: 0 auto !important;
	padding:5px 10px ;
	cursor:pointer;
	padding-top: 10px;
	top: 195px;
}

.cart .detail-cart{
    float: left;
    display: none;   
}
.cart:hover .detail-cart{
	color:#00C1F8;
	display: block;
}

.line-cart{
	border-right: 2px solid #00C1F8;
    padding-right: 20px;
}

.line-cart-1{
	border-right: 2px solid #00C1F8;
	padding-right: 20px;
	margin-left:20px;
}

.select-detail{
	margin-left: 100px;
}

.number-detail{
	float: right;
	margin-right: 100px;
}

.line-detail{
	height: 1px;
    width: 50%;
    margin: 0 auto;
    background-color: black;
}

.parent-select-detail{
	cursor: pointer;
}

.thumbnailfade-leave-active,
.thumbnailfade-enter-active {
  transition: all 0.4s ease;
}

.thumbnailfade-enter-active {
  transition-delay: 0.4s;
}

.thumbnailfade-enter,
.thumbnailfade-leave-to {
  opacity: 0;
}


</style>