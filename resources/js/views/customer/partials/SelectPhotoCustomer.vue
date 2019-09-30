<template>
	<v-layout row wrap>
		<popup></popup>
		<payment v-if="checkPayment"></payment>
		<!-- Selected photo-->

		<app-card
			colClasses="xl12 lg12 md12 xs12 d-xs-half-block w-full"
			customClasses="custom-app-card"
			:withTabs="true"
			>
			<div class=" ml-5 mr-5">
				<v-flex xs2 class="v-flex-sp-l">
					<v-card-text >
						<span class="ml-3">Download</span>
						<span class="ml-3 pt-3 top-relative"><i class="material-icons">
							filter
						</i>
						</span>
						<span class="ml-1">
							<!-- ({{countSelected}}) -->
							(0)
						</span>
						<span class="ml-1 pt-3 top-relative">
							<i class="material-icons">
								keyboard_arrow_down
							</i>
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
					        ></v-select>
				    	</div>
					</v-card-text>
				</v-flex>
				<v-layout row wrap class="photo-selected ">
					<!-- <v-flex
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

						<div class="icon-frame-photo">
						 	<span class="v-flex-sp-l" @click="showZoomImageAndSlideDownload(photo)">
						 		<i class="material-icons cursor-v-card">
									zoom_out_map
								</i>
						 	</span>
						 	<span class="v-flex-sp-r" >
						 		<i class="material-icons cursor-v-card" style="color:#00C1F8">
									check_circle
								</i>
						 	</span>
						</div>

					</v-flex>

					<lightbox id="mylightbox"
				      ref="lightboxdownload"
				      :images="photos2"
				      :directory="thumbnailDir"
				      :timeoutDuration="5000"
				 	/> -->
				</v-layout>

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
						<span class="ml-3">Purchase</span>

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
						v-for="photo in photos"
						xs12 sm3
						d-flex
						:key="photo.id"
					>
						<v-card flat tile class="d-flex custom-d-flex">
							<div class="grid-item pos-relative custom-grid-item">

								<v-img
									:src="thumbnailDir + photo.name"
									aspect-ratio="1"
									class="grey lighten-2 hover-image"
									height="300"
									:key="photo.id"
									@click="photo.is_booking == false ? selectPhoto(photo) : ''"
									contain
									>
								</v-img>

							</div>
						</v-card>

						<div class="icon-frame-photo">
						 	<span class="v-flex-sp-l" @click="showZoomImageAndSlide(photo)">
						 		<i class="material-icons cursor-v-card">
									zoom_out_map
								</i>
						 	</span>

						 	<span class="v-flex-sp-r" v-if="photo.image_selected == null">
						 		<i class="material-icons cursor-v-card" :class="'active-image'+photo.id">
									check_circle
								</i>
						 	</span>
						</div>
					</v-flex>

				 	<lightbox id="mylightbox"
				      ref="lightbox"
				      :images="photos"
				      :directory="thumbnailDir"
				      :timeoutDuration="5000"
				 	/>

				</v-layout>
			</div>
		</app-card>

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

import  { get, post, put, del, getWithData } from '../../../api/index.js'
import Lightbox from 'vue-my-photos'
import Vue from 'vue'
import Popup from './Popup.vue'
import Payment from './Payment.vue'
Vue.component('lightbox', Lightbox);


export default {

  name: 'SelectPhoto',
  components: {
  	Popup,Payment
  },

  data () {
    return {
    	currencies:['USD'],
    	languages:['ENG'],
    	selectCurrency: 'USD',
    	selectLanguage: 'ENG',
    // 	photos: [{
				// 		id: 1,
				// 		name: "blog-1.jpg",
				// 		caption: "Caption 1",
				// 		author: "Admin",
				// 		likes: "250"
				// 	},
				// 	{
				// 		id: 2,
				// 		name: "blog-2.jpg",
				// 		caption: "Caption 2",
				// 		author: "Erik Turner",
				// 		likes: "150"
				// 	},
				// 	{
				// 		id: 3,
				// 		name: "blog-3.jpg",
				// 		caption: "Caption 3",
				// 		author: "John Smith",
				// 		likes: "200"
				// 	},
				// 	{
				// 		id: 4,
				// 		name: "blog-4.jpg",
				// 		caption: "Caption 4",
				// 		author: "Antonio Rice",
				// 		likes: "300"
				// 	},
				// 	{
				// 		id: 5,
				// 		name: "blog-5.jpg",
				// 		caption: "Caption 5",
				// 		author: "Caleb Wilson",
				// 		likes: "400"
				// 	},
				// 	{
				// 		id: 6,
				// 		name: "blog-6.jpg",
				// 		caption: "Caption 6",
				// 		author: "Zachary Robbins",
				// 		likes: "50"
				// 	},
				// 	{
				// 		id: 7,
				// 		name: "blog-7.jpg",
				// 		caption: "Caption 7",
				// 		author: "Jon Wagner",
				// 		likes: "100"
				// 	},
				// 	{
				// 		id: 8,
				// 		name: "blog-8.jpg",
				// 		caption: "Caption 8",
				// 		author: "Dorothy Bass",
				// 		likes: "75"
				// 	}
				// ],
		photos2: [],
		photos: [],
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
		// thumbnailDir: 'https://holipic.pth.com/static/img/',
		thumbnailDir:'',
		activeText: true,
		photoTypes: [
			{
				id: 't1',
				type: '10x15',
				active: false,
				quantity: 1
			},
			{
				id: 't2',
				type: '15x21',
				active: false,
				quantity: 1
			},
			{
				id: 't3',
				type: 'Digital',
				active: false,
				quantity: 1
			},
		],
		photoOpened: null,
		thumbnailDir:'',
		customer: JSON.parse(localStorage.getItem('user')),
		checkPayment: false
    }
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
  	changePhotos2()
  	{
        return this.photos2
  	}
  },
  mounted() {
  	this.$root.$on('activeSelectedImage', res => {
  		var key = _.findIndex(this.photos2, function(value) {
  					return value.image_id == res;
  				});

		this.photos2.splice(key, 1);

  		$('.active-image'+res).show();

  	})

  	this.$root.$on('showPopupPayment', res => this.checkPayment = true)
  },
  created(){
  	this.getPhotoFromRoom()

  	this.countOther = this.photos.length


  },
  methods:{
  	removeItem(index,photo)
  	{
		this.photos2.splice(index, 1);
		this.count --
		$('.active-image'+photo.id).css("color", "#464D69");

		del('cart/delete-photo?imageId='+photo.id)
  		.then(res => {

  		})

		//send event basket
  		this.$root.$emit('sendEventCountBasket', this.count)
  	},
  	removeAllItem()
  	{
  		this.photos2 = []
  		this.count = 0
  		_.forEach(this.photos, (value,index) => {
  			$('.active-image'+value.id).css("color", "#464D69");
  		})
  	},
  	showDetail(photo)
  	{
  		this.dialog = true
  		this.photoId = photo.id
  		this.photoOpened = photo
  		_.forEach(this.photoTypes, (item, index) => {
  			if (item.type == photo.type) {
  				this.photoTypes[index]['active'] = true
  			}

  			this.photoTypes[index]['quantity'] = 1
  		})
  	},
  	activeClass(type)
  	{
  		this.typeDetail = type.type

  		_.forEach(this.photoTypes, (item, index) => {
  			this.photoTypes[index]['active'] = false
  			if (item.type == type.type) {
  				this.photoTypes[index]['active'] = true
  			}
  		})

  		_.forEach(this.photos2, (value, index) => {
  			if(value['id'] == this.photoId) {
  				this.photos2[index]['type'] = type.type
  				this.photoOpened = this.photos2[index]
  			}
  		})
  	},
  	increase(photoOpened, quantity)
  	{
  		this.photoOpened.quantity ++
  		this.dialog = false
  		this.dialog = true
  	},
  	decrease()
  	{
  		if(this.photoOpened.quantity > 1)
  		{
  			this.photoOpened.quantity --
  			this.dialog = false
  			this.dialog = true
  		}
  	},
  	selectPhoto(photo)
  	{
  		var photoSelected = _.find(this.photos2, (value,key) => {
  			return value['id'] == photo.id;
  		});

  		console.log(photoSelected)

  		if(photoSelected == undefined)
  		{
  			this.photos2.push(photo)
  			var length = this.photos2.length
  			this.photos2[length-1].type = 'Digital'
  			this.photos2[length-1].quantity = 1
  			// $('.active-image'+photo.id).css("color", "#00C1F8");
  			$('.active-image'+photo.id).hide();
  			this.count++
  			this.addPhotoSelectedIntoDB(photo)
  			this.$root.$emit('sendEventCountBasket', this.count)
  		} else {
			var index = this.photos2.indexOf(photo);
			if (index !== -1) this.photos2.splice(index, 1);
  			$('.active-image'+photo.id).show();
  			this.addPhotoSelectedIntoDB(photo)
  			this.$root.$emit('sendEventCountBasket', this.count)
  			//$('.active-image'+photo.id).css("color", "#464D69");
  			//this.count--
  		}

  		//send event basket
  		_.forEach(this.photoTypes, (item, index) => {
  			this.photoTypes[index]['quantity'] = 1
  		})

  		console.log(this.photos2)
	},
  	showZoomImageAndSlide(photo)
  	{
  		this.$refs.lightbox.show(photo.name);

  	},
  	showZoomImageAndSlideDownload(photo)
  	{
  		this.$refs.lightboxdownload.show(photo.name)
  	},
  	setQuantity(photo, quantity)
  	{
  		_.forEach(this.photos2, (value,index) => {
  			if(value['id'] == photo.id) {
  				this.photos2[index]['quantity'] = quantity
  			}
  		})
  	},
  	getPhotoFromRoom()
  	{
  		get('room/show-photo?room='+this.customer.room_id)
  		.then(res => {
  			if(res && res.success){

  				this.thumbnailDir = res.data[1]

  				this.photos = res.data[0]['images']
  			}
  		})
  		.catch(err => {
  			console.log(err.response)
  		})
  	},
  	addPhotoSelectedIntoDB(photo)
  	{	let params = {photo}
  		post('customer/order-image', params)
  		.then(res => {

  		})
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
	z-index:100;
	background-color:white !important;
	right: 63px;
	border-radius:2px;
	-moz-box-shadow: 0 0 5px #888;
	-webkit-box-shadow: 0 0 5px#888;
	box-shadow: 0 0 5px #888;
	margin: 0 auto !important;
	padding:5px 10px ;
	cursor:pointer;
	padding-top: 10px;
}

.cart .detail-cart{
    float: left;
    display: none;
}
.cart:hover .detail-cart{
	color:#5d92f4;
	display: block;
}

.line-cart{
	border-right: 2px solid #5d92f4;
    padding-right: 20px;
}

.line-cart-1{
	border-right: 2px solid #5d92f4;
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
