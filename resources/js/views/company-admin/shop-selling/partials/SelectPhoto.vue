<template>
	<v-layout row wrap>
		<app-card
			colClasses="xl12 lg12 md12 xs12 d-xs-half-block w-full"
			customClasses="custom-app-card"
			:withTabs="true"	
			>
			<div class="cart">
				<i class="material-icons">
					shopping_cart
				</i>
				<div class="detail-cart">
					<span class="line-cart">$</span>
					<span class="line-cart-1">1250</span>
					<span class="line-cart-2">Order</span>		
				</div>
			</div>
			<div class=" ml-5 mr-5">
				<v-flex xs6 class="v-flex-sp-l">
					<v-card-text>
						<span class="ml-3">
						Selected 
						 <v-btn fab dark small color="primary" @click="removeAllItem()">
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
					          label="USD"
					        ></v-select>
				    	</div>

				    	<div class="ml-4 width-select">
					        <v-select
					          :items="languages"
					          label="Eng"
					        ></v-select>
				    	</div>
					</v-card-text>
				</v-flex>
				<v-layout row wrap class="photo-selected ">
					<v-flex
						v-for="(photo,index) in photos2"
						xs12 sm3
						d-flex
						:key="photo.id"
					>
						<v-card flat tile class="d-flex custom-d-flex">
							<div class="grid-item pos-relative custom-grid-item">
								<v-img
									:src="photo.src"
									aspect-ratio="1"
									class="grey lighten-2 "
									
									height="300"	
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

						<div class="parent-select-detail" @click="showDetail(photo.id)">
							<span class="select-detail">{{typeDetailReturn}}</span>
							<span class="number-detail">
								<i class="fas fa-caret-down"></i>		
							</span>
							<div class="line-detail"></div>
						</div>

						<v-dialog
		     			 	v-model="dialog"
		      				width="400"
		      				temporary
		      				v-if="photoId == photo.id"
		    				>
		    				<v-card>
						        <v-container fluid>
								    <v-layout row >
								      	<v-flex xs3 >
									        <v-card tile flat class="cursor-v-card" :class="typeDetailReturn === 't1' ? 'hover-v-card' : '' " @click="activeClass('t1')">
									        	<v-card-text>
									          		10x15
									          	</v-card-text>
									        </v-card>
								      	</v-flex>
									    <v-flex xs9 class="flex-v-number">   
									        <v-list-tile >
									          		<v-btn normal @click="decrease()">
												      <v-icon dark>remove</v-icon>
												    </v-btn>
										          	<v-text-field
											            single-line
	            										solo
											            v-model="number"
											        ></v-text-field>
											          <v-btn  normal @click="increase()">
												      <v-icon dark>add</v-icon>
												    </v-btn>
									        </v-list-tile> 
									    </v-flex>
								    </v-layout>
									
								    <v-layout row>
								      	<v-flex xs3 >
									        <v-card  tile flat class="cursor-v-card" :class="typeDetailReturn === 't2' ? 'hover-v-card' : '' " @click="activeClass('t2')">
									          <v-card-text>
									          	15x21
									          </v-card-text>
									        </v-card>
								      	</v-flex>
									      <v-flex xs9 class="flex-v-number">
									        
									          	<v-list-tile >
									          		<v-btn normal @click="decrease()">
												      <v-icon dark>remove</v-icon>
												    </v-btn>
										          	<v-text-field
											            single-line
	            										solo
											            v-model="number"
											          ></v-text-field>
											          <v-btn  normal @click="increase()">
												      <v-icon dark>add</v-icon>
												    </v-btn>
									          	</v-list-tile> 
									      </v-flex>
								    </v-layout>

								    <v-layout row>
								      	<v-flex xs3 >
									        <v-card  tile flat class="cursor-v-card" :class="typeDetailReturn === 't3' ? 'hover-v-card' : '' " @click="activeClass('t3')">
									          <v-card-text>
									          	20x30
									          </v-card-text>
									        </v-card>
								      	</v-flex>
									     <v-flex xs9 class="flex-v-number">
									        
									          	<v-list-tile >
									          		<v-btn normal @click="decrease()">
												      <v-icon dark>remove</v-icon>
												    </v-btn>
										          	<v-text-field
											            single-line
	            										solo
											            v-model="number"
											          ></v-text-field>
											          <v-btn  normal @click="increase()">
												      <v-icon dark>add</v-icon>
												    </v-btn>
									          	</v-list-tile> 
									      </v-flex>
								    </v-layout>

								    <v-layout row>
								      	<v-flex xs3 >
									        <v-card  tile flat class="cursor-v-card" :class="typeDetailReturn === 't4' ? 'hover-v-card' : '' " @click="activeClass('t4')">
									          <v-card-text>
									          	Digital
									          </v-card-text>
									        </v-card>
								      	</v-flex>
									      <v-flex xs9 class="flex-v-number">
									        
									          	<v-list-tile >
									          		<v-btn normal @click="decrease()">
												      <v-icon dark>remove</v-icon>
												    </v-btn>
										          	<v-text-field
											            single-line
	            										solo
											            v-model="number"
											          ></v-text-field>
											          <v-btn  normal @click="increase()">
												      <v-icon dark>add</v-icon>
												    </v-btn>
									          	</v-list-tile> 
									      </v-flex>
								    </v-layout>

								    <v-layout row>
								      	<v-flex xs3 >
									        <v-card  tile flat class="cursor-v-card" :class="typeDetailReturn === 't5' ? 'hover-v-card' : '' " @click="activeClass('t5')">
									          <v-card-text>
									          	Album
									          </v-card-text>
									        </v-card>
								      	</v-flex>
									      <v-flex xs9 class="flex-v-number">
									        
									          	<v-list-tile >
									          		<v-btn normal @click="decrease()">
												      <v-icon dark>remove</v-icon>
												    </v-btn>
										          	<v-text-field
											            single-line
	            										solo
											            v-model="number"
											          ></v-text-field>
											          <v-btn  normal @click="increase()">
												      <v-icon dark>add</v-icon>
												    </v-btn>
									          	</v-list-tile> 
									      </v-flex>
								    </v-layout>
								</v-container>
						      </v-card>
		    			</v-dialog>
					</v-flex>
				</v-layout>
			</div>  
		</app-card>

		<app-card
			colClasses="xl12 lg12 md12 xs12 d-xs-half-block w-full"
			customClasses="custom-app-card"
			:withTabs="true"	
			>
			<div class="mb-5 ml-5 mr-5">
				<v-flex xs2 class="v-flex-sp-l">
					<v-card-text >
						<span class="ml-3">Others</span> 
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

				<v-layout row wrap class="photo-selected ">
					<v-flex
						v-for="photo in photos"
						xs12 sm3
						d-flex
						:key="photo.id"
					>
						<v-card flat tile class="d-flex custom-d-flex" >
							<div class="grid-item pos-relative custom-grid-item">
								<v-img
									:src="photo.src"
									:ref="'imageSrc'+photo.id"
									aspect-ratio="1"
									class="grey lighten-2 hover-image"
									
									height="300"
									:value="photo.src"
									@click="selectPhoto(photo, $event)"
									>
								</v-img>
							</div>
						</v-card>

						<div class="icon-frame-photo">
						 	<span class="v-flex-sp-l" @click="showZoomImageAndSlide()">
						 		<i class="material-icons">
									zoom_out_map
								</i>
						 	</span>
						 	<span class="v-flex-sp-r">
						 		<i class="material-icons" :class="'active-image'+photo.id">
									check_circle
								</i>
						 	</span>
						</div>

						
					</v-flex>

					<v-dialog
		     			 	v-model="dialog2"
		      				width="1000"
		      				class="v-dialog2"
		    				>
						<v-carousel class="custom-carousel" hide-delimiters>
						    <v-carousel-item
						      v-for="(item,i) in photos"
						      :key="i"
						      :src="item.src"
						      width="50%"
						      
						    ></v-carousel-item>
						</v-carousel>
					</v-dialog>
				</v-layout>
			</div>
		</app-card>

		<app-card colClasses="xl12 lg12 md12 xs12 d-xs-half-block w-full"
			customClasses="custom-app-card custom-app-card-footer"
			:withTabs="true">
			<div class="footer-shop-selling">
				
			</div>
		</app-card>
	</v-layout>
</template>
<script>
import fancyBox from 'vue-fancybox';
export default {

  name: 'SelectPhoto',

  data () {
    return {
    	currencies:['USD'],
    	languages:['Eng'],
    	photos: [{
						id: 1,
						src: "/static/img/blog-1.jpg",
						caption: "Caption 1",
						author: "Admin",
						likes: "250"
					},
					{
						id: 2,
						src: "/static/img/blog-2.jpg",
						caption: "Caption 2",
						author: "Erik Turner",
						likes: "150"
					},
					{
						id: 3,
						src: "/static/img/blog-3.jpg",
						caption: "Caption 3",
						author: "John Smith",
						likes: "200"
					},
					{
						id: 4,
						src: "/static/img/blog-4.jpg",
						caption: "Caption 4",
						author: "Antonio Rice",
						likes: "300"
					},
					{
						id: 5,
						src: "/static/img/blog-5.jpg",
						caption: "Caption 5",
						author: "Caleb Wilson",
						likes: "400"
					},
					{
						id: 6,
						src: "/static/img/blog-6.jpg",
						caption: "Caption 6",
						author: "Zachary Robbins",
						likes: "50"
					},
					{
						id: 7,
						src: "/static/img/blog-7.jpg",
						caption: "Caption 7",
						author: "Jon Wagner",
						likes: "100"
					},
					{
						id: 8,
						src: "/static/img/blog-8.jpg",
						caption: "Caption 8",
						author: "Dorothy Bass",
						likes: "75"
					}
				],
		photos2: [
				],
		items:[{id: 1, name: 'hung'},{id:2, name: 'hung2'}],
		dialog:false,
		dialog2:false,
		photoId:'',
		number: 0,
		typeDetail: 'Select detail',
		count:0,
		countOther:0
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
  	}
  },
  created(){
  	this.countOther = this.photos.length
  },
  methods:{
  	removeItem(index,photo)
  	{
		this.photos2.splice(index, 1);
		this.count --
		$('.active-image'+photo.id).css("color", "#464D69");
  	},
  	removeAllItem()
  	{
  		this.photos2 = []
  		this.count = 0
  		_.forEach(this.photos, (value,index) => {
  			$('.active-image'+value.id).css("color", "#464D69");
  		})
  	},
  	showDetail(id)
  	{
  		this.dialog = true
  		this.photoId = id
  	},
  	activeClass(type)
  	{
  		this.typeDetail = type
  	},
  	increase()
  	{
  		this.number ++
  	},
  	decrease()
  	{
  		if(this.number > 0)
  		{
  			this.number --
  		}
  	},
  	selectPhoto(photo, $event)
  	{
  		var _this = this

  		var photoSelected = _.find(this.photos2, (value,key) => { 
  			return value['id'] == photo.id; 
  		});

  		if(photoSelected == undefined)
  		{
  			this.photos2.push(photo)
  			$('.active-image'+photo.id).css("color", "#5d92f4");
  			this.count++
  			
  		} else {
			var index = this.photos2.indexOf(photo);
			if (index !== -1) this.photos2.splice(index, 1);

  			$('.active-image'+photo.id).css("color", "#464D69");
  			this.count--
  			
  		}
  		console.log(this.$refs['imageSrc']+photo.id)

  		// fancyBox(e.target, this.photos);
  		
  	},
  	showZoomImageAndSlide()
  	{
  		this.dialog2 = true
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
	z-index:999;
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
    /* background-color: white; */
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

</style>