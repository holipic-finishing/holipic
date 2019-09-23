<template>
	<div>
	<v-toolbar dark color="primary" class="custom-toolbar">
    	 <v-toolbar-title>
    	 	<img src="/images/HOLIPIC-LOGO.png" width="30%">
    	 </v-toolbar-title>
    <v-spacer></v-spacer>

    <v-toolbar-items class="hidden-sm-and-down">

      	<v-btn flat @click="showBasket()">
      		<span class="quantity-cart">
      			<p>{{countBasket}}</p>
      		</span>
      		<span>
      			<i class="material-icons font-material-header" style="margin-top: -6px;">
					shopping_cart
				</i>
      		</span>
	      	<span class="name-cart">Basket</span>

  		</v-btn>
      <v-btn flat @click="downloadPhoto()">
      	<span class="quantity-dowload">
      		<p>{{countDownload}}</p>
      	</span>
      	<span>
      		<i class="fa fa-download font-material-header" aria-hidden="true"></i>
      	</span>
      	<span class="name-cart">Download</span>
      </v-btn>

       <v-btn icon @click="showPackage()">
        <v-icon class="icon-color">more_vert</v-icon>
      </v-btn>
    </v-toolbar-items>

  </v-toolbar>

  	<v-layout row justify-center>
	   	<v-dialog v-model="dialog" scrollable max-width="300px" content-class="custom-dialog-customer">
		    <v-card>
		    	<v-card-title class="v-card__title--profile">
		    	  <span class="f-cart-title ml-3">ANTOI</span>
		    	  <v-btn icon @click="showPackage()">
			        <v-icon>keyboard_arrow_right</v-icon>
			      </v-btn>
		    	</v-card-title>

		        <v-divider class="custom-divider"></v-divider>

		          	<v-list-tile class="v-list-title-profile-customer">
		          		<span class="ml-3 mr-3 f-span c-span"> <i class="fas fa-credit-card"></i> </span>

		          		<span class="c-span">Purchase Details</span>
		          	</v-list-tile>
		          	<v-list-tile class="v-list-title-profile-customer">
		          		<span class="ml-3 mr-3 f-span c-span"><i class="material-icons">filter_vintage</i></span>
		          		<span class="c-span">Voucher</span>
		          	</v-list-tile>

		          	<v-list-tile class="v-list-title-profile-customer">
		          		<span class="ml-3 mr-3 f-span c-span"><i class="material-icons">feedback</i></span>
		          		<span class="c-span">Feedback</span>
		          	</v-list-tile>

		          	<v-list-tile class="v-list-title-profile-customer">
		          		<span class="ml-3 mr-3 f-span c-span"><i class="material-icons">access_time</i></span>
		          		<span class="c-span">Account Expiry</span>
		          	</v-list-tile>

		        <v-divider class="custom-divider"></v-divider>
		        <v-card-actions class="v-list-title-profile-customer">
		        	<i class="fas fa-sign-out-alt ml-4 mr-3 f-span c-span"></i>
		          	<!-- <v-btn flat @click="dialog = false"> -->
		          		<span class="c-span">Logout</span>
		      		<!-- </v-btn> -->
		        </v-card-actions>
		    </v-card>
	    </v-dialog>
	</v-layout>


		<!-- Dialog download file -->
		<v-dialog v-model="dialog2" scrollable max-width="200px" content-class="custom-dialog-download"
		 hide-overlay>
			<v-card>
			  	<v-list-tile>
				  	<div>Preparing download</div>
				  	<div class="r-download">
				  		<span class="ml-2" style="color:white">
				  			<v-btn icon @click="showOrNotShowDetail()">
					  			<i class="material-icons fz-arrow-down">
									{{icon}}
								</i>
							</v-btn>
				  		</span>
				  		<span class="ml-2" style="color:white">
				  			<v-btn icon @click="closeDialogDownload()">
					  			<i class="material-icons">
									clear
								</i>
							</v-btn>
				  		</span>
				  	</div>
			  	</v-list-tile>
			  <v-list class="v-list--header-customer ml-3" v-if="showDetail">
			  	<span>
			  		<i class="material-icons">
						archive
					</i>
				</span>
			    <span class="ml-3 mt-1">Zipping 1 file</span>
			    <span class="ml-3 r-progress mt-1">
			    	<v-progress-circular
				      :value="40"
				      color="blue-grey"
				    ></v-progress-circular>
			    </span>

			  </v-list>
			</v-card>
		</v-dialog>
		<!-- Dialog download file -->

		<!--Dialog table cart-->
		<v-dialog v-model="dialog3" scrollable content-class="custom-dialog-basket" max-width="1200">
			<v-container>
	  			<table class="table">
				    <thead class="thead-light">
				      <tr>
				        <th>Selected</th>
				        <th>Product</th>
				        <th>Quanity</th>
				        <th>Total Price</th>
				        <th></th>
				      </tr>
				    </thead>
				    <tbody>
				      <tr v-for="(image,index) in imageSelected">
				        <td><img :src="dir+image.name" width="60px" height="60px"></td>
				        <td class="mt-3 pt-4">{{image.size}}</td>
				        <td class="mt-3 pt-4">{{image.quantity}}</td>
				        <td class="total-price pt-4">{{image.price}}</td>
				        <td class="icon-clear">
				        	<v-btn icon @click="deleteImageSelected(image.image_id,index)">
					        	<v-icon>clear</v-icon>
					      </v-btn>
				        </td>
				      </tr>
				      <!-- <tr>
				        <td><img src="https://blogphotoshop.com/wp-content/uploads/2019/01/illustrator-cs6.png" width="60px" height="60px"></td>
				        <td class="mt-3 pt-4">Digital</td>
				        <td class="mt-3 pt-4">1</td>
				        <td class="total-price pt-4">Rp 15000</td>
				        <td class="icon-clear">
				        	<v-btn icon>
					        	<v-icon>clear</v-icon>
					      	</v-btn>
				        </td>
				      </tr> -->
				    </tbody>
				</table>
				<v-divider></v-divider>
				<v-layout row wrap>
				  	<v-flex md9 xs9 lg9>

				  	</v-flex>
				  	<v-flex md3 xs3 lg3>
				  		<span style="font-weight: bold;margin-left: 25px;">Total: {{total}}</span>
				  	</v-flex>

				  	<v-flex md10 xs10 lg10>

				  	</v-flex>
				  	<v-flex md2 xs2 lg2>
				  		<v-btn color="warning" @click="processPayment()">purchase</v-btn>
				  	</v-flex>

				</v-layout>

			</v-container>
		</v-dialog>
</div>

</template>

<script>
import {get, post, del} from '../../../api/index.js'
import config from '../../../config/index.js'

export default {

  name: 'Header',

  data () {
    return {
    	dialog: false,
    	dialog2:false,
    	dialog3:false,
    	showDetail: true,
    	icon: 'keyboard_arrow_down',
    	countBasket: 0,
    	countDownload: 0,
    	customer: JSON.parse(localStorage.getItem('user')),
    	imageSelected: [],
    	dir:'',
    	total:''
    }
  },
  mounted() {
  	this.$root.$on('sendEventCountBasket', res => {
  		this.countBasket = res
 		this.imageSelected = []
  		this.showImageSelected()
  	})
  },
  created(){
  	this.showImageSelected()
  },
  methods:{
  	showPackage()
  	{
  		this.dialog = true
  	},
  	downloadPhoto()
  	{
  		this.dialog2 = true
  	},
  	showOrNotShowDetail()
  	{
  		this.showDetail = this.showDetail ? false : true

  		this.icon = this.icon == 'keyboard_arrow_down' ? 'keyboard_arrow_up': 'keyboard_arrow_down'
  	},
  	closeDialogDownload()
  	{
  		this.dialog2 = false
  		this.showDetail = true
  		this.icon = 'keyboard_arrow_down'
  	},
  	showBasket()
  	{
  		this.dialog3 = true
  	},
  	showImageSelected()
  	{
  		get(config.API_URL+'customer/list-image-selected?roomId='+this.customer.room_id)
  		.then(res => {
  			if(res.data && res.data.success) {
  				this.imageSelected = res.data.data[0]
  				this.dir = res.data.data[1]
  				this.countBasket = this.imageSelected.length
  				this.total = _.sumBy(this.imageSelected, function(v) { return parseInt(v.price); });
  			}
  		})
  	},
  	deleteImageSelected(imageId,index)
  	{
  		del(config.API_URL+'cart/delete-photo?imageId='+imageId)
  		.then(res => {
  			this.imageSelected.splice(index, 1)
  			this.countBasket = this.imageSelected.length
  			this.$root.$emit('activeSelectedImage', imageId)
  		})
  	},
  	processPayment()
  	{
  		this.dialog3 = false
  		this.$root.$emit('showPopupPayment')
  	}
  }
};
</script>

<style lang="css" scoped>
.quantity-cart{
    color: white !important;
    background-color: #00C1F8;
    width: 30px;
    height: 30px;
    border-radius: 50%;
    float: right;
    position: absolute;
    right: -15px;
    top: -5px !important;
    padding: 4px 0px !important;
}

.quantity-dowload{
	color: white !important;
    background-color: #00C1F8;
    width: 30px;
    height: 30px;
    border-radius: 50%;
    float: right;
    position: absolute;
    right: 0px;
    top: -5px !important;
    padding: 4px 0px !important;
}

.f-span{
	font-size: 20px !important;
}
.c-span{
	color: #424242 !important;

}
.f-cart-title{
	font-size:25px !important;
	color: #424242 !important;
	font-weight: bold;
	margin-left:30px !important;
	margin-top:7px !important;
}
.v-dialog__content{
	position: absolute;
}

.r-download{
	right: 10px;
    position: absolute;
}

.total-price{
	width: 150px;
}
.icon-clear{
	width: 40px;
}
.name-cart{
	color: #70778F !important;
}
</style>
