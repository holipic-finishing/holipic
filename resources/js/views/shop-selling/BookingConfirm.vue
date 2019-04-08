<template>
	<div>
	<app-card colClasses="xl12 lg12 md12 xs12 d-xs-half-block w-full"
			customClasses="custom-app-card custom-app-card-footer booking-app-card"
		>
		<div class="header-confirm-booking">
			<v-btn icon @click="backPageShopSelling()">
	    		<i class="material-icons color-text-header">
					reply_all
				</i>
    		</v-btn>
    		<span>Type Here Your Details</span>
		</div>

		<div class="content-booking">
			<div class="title-booking">
				<span class="title-booking--span">Order Confirm</span>
				<div class="title-booking--line"></div>
			</div>
			<div class="body-booking">
				<!-- <v-layout justify-center>
					<v-flex xs12 sm9 md9 lg9 class="box-body-booking">
					    <v-card row>
					    	<v-layout>
					    		<v-flex xs12 sm8 md8 lg8 class="flex-9">
					      			<v-layout row>
					      			  	<v-flex xs6 sm6 md6 lg6>
					      			  		<v-container class="container-content-image-booking">
					      			  			<v-layout wrap >
					      			  				<v-flex xs3 sm3 md3 lg3 ml-3 mb-3>
					      			  					<v-img src="static/avatars/user-2.jpg"></v-img>
					      			  				</v-flex>
					      			  				<v-flex xs3 sm3 md3 lg3 ml-3 mb-3>
					      			  					<v-img src="static/avatars/user-3.jpg"></v-img>
					      			  				</v-flex>
					      			  				<v-flex xs3 sm3 md3 lg3 ml-3 mb-3>
					      			  					<v-img src="static/avatars/user-4.jpg"></v-img>
					      			  				</v-flex>
					      			  				<v-flex xs3 sm3 md3 lg3 ml-3 mb-3>
					      			  					<v-img src="static/avatars/user-5.jpg"></v-img>
					      			  				</v-flex>
					      			  				<v-flex xs3 sm3 md3 lg3 ml-3 mb-3>
					      			  					<v-img src="static/avatars/user-6.jpg"></v-img>
					      			  				</v-flex>
					      			  				<v-flex xs3 sm3 md3 lg3 ml-3 mb-3>
					      			  					<v-img src="static/avatars/user-7.jpg"></v-img>
					      			  				</v-flex>
					      			  				<v-flex xs3 sm3 md3 lg3 ml-3 mb-3>
					      			  					<v-img src="static/avatars/user-8.jpg"></v-img>
					      			  				</v-flex>
					      			  				<v-flex xs3 sm3 md3 lg3 ml-3 mb-3>
					      			  					<v-img src="static/avatars/user-9.jpg"></v-img>
					      			  				</v-flex>
					      			  				<v-flex xs3 sm3 md3 lg3 ml-3 mb-3>
					      			  					<v-img src="static/avatars/user-7.jpg"></v-img>
					      			  				</v-flex>
					      			  				<v-flex xs3 sm3 md3 lg3 ml-3 mb-3>
					      			  					<v-img src="static/avatars/user-7.jpg"></v-img>
					      			  				</v-flex>
					      			  				<v-flex xs3 sm3 md3 lg3 ml-3 mb-3>
					      			  					<v-img src="static/avatars/user-8.jpg"></v-img>
					      			  				</v-flex>
					      			  				<v-flex xs3 sm3 md3 lg3 ml-3 mb-3>
					      			  					<v-img src="static/avatars/user-9.jpg"></v-img>
					      			  				</v-flex>
					      			  				<v-flex xs3 sm3 md3 lg3 ml-3 mb-3>
					      			  					<v-img src="static/avatars/user-7.jpg"></v-img>
					      			  				</v-flex>
					      			  				<v-flex xs3 sm3 md3 lg3 ml-3 mb-3>
					      			  					<v-img src="static/avatars/user-8.jpg"></v-img>
					      			  				</v-flex>
					      			  				<v-flex xs3 sm3 md3 lg3 ml-3 mb-3>
					      			  					<v-img src="static/avatars/user-9.jpg"></v-img>
					      			  				</v-flex>
					      			  				<v-flex xs3 sm3 md3 lg3 ml-3 mb-3>
					      			  					<v-img src="static/avatars/user-7.jpg"></v-img>
					      			  				</v-flex>
					      			  			</v-layout>
					      			  		</v-container>
					      			  		
					      			  	</v-flex>
					      			  	<v-flex xs6 sm6 md6 lg6>
					      			  		<div class="content-title-booking">
					      			  			ORDER DETAIL
					      			  		</div>
					      			  		
				      			  			<table>
					      			  			<tr>
					      			  				<th class="th-formate pt-3" >Formate</th>
					      			  				<th class="th-quantity pt-3" >Quantity</th>
					      			  				<th class="th-cost pt-3" >Cost</th>
					      			  			</tr>
					      			  			<tr>
					      			  				<td class="th-formate--td pt-3">DIGITAL</td>
					      			  				<td class="th-quantity--td pt-3" >1</td>
					      			  				<td class="th-cost--td pt-3">Rp 150000</td>
					      			  			</tr>
					      			  			<tr>
					      			  				<td class="th-formate--td pt-3">FRAME</td>
					      			  				<td class="th-quantity--td pt-3">0</td>
					      			  				<td class="th-cost--td pt-3">Rp 0</td>
					      			  			</tr>
					      			  			<tr>
					      			  				<td class="th-formate--td pt-3">4R</td>
					      			  				<td class="th-quantity--td pt-3">0</td>
					      			  				<td class="th-cost--td pt-3" >Rp 0</td>
					      			  			</tr>
					      			  			<tr>
					      			  				<td class="th-formate--td pt-3">6R</td>
					      			  				<td class="th-quantity--td pt-3">0</td>
					      			  				<td class="th-cost--td pt-3">Rp 0</td>
					      			  			</tr>
					      			  			<tr>
					      			  				<td class="th-formate--td pt-3">10R</td>
					      			  				<td class="th-quantity--td pt-3">0</td>
					      			  				<td class="th-cost--td pt-3">Rp 0</td>
					      			  			</tr>
					      			  			<tr>
					      			  				<td class="th-formate--td pt-3 pb-3">Photo Slate</td>
					      			  				<td class="th-quantity--td pt-3 pb-3">0</td>
					      			  				<td class="th-cost--td pt-3 pb-3">Rp 0</td>
					      			  			</tr>
				      			  			</table>

				      			  			<div class="content-footer-booking">
				      			  				<div class="content-footer-booking--left">
				      			  					TOTAL
				      			  				</div>
				      			  				<div class="content-footer-booking--right">
				      			  					150000 RP
				      			  				</div>
				      			  			</div>
					      			  	</v-flex>
					      			</v-layout>
					      		</v-flex>
					      		<v-flex xs12 sm4 md4 lg4 class="flex-3">
					      			<v-card class='content-confirm-booking' row>
					      				<v-container class="container-content-confirm-booking">
						      			  	<v-layout wrap class="layout-content-confirm-booking">
						      			  		<v-flex xs2 lg2 md2 sm2 class="content-confirm-booking--left">
						      			  			<span class="content-confirm-booking--left--icon">
						      			  				<i class="far fa-user"></i>
						      			  			</span>
						      			  		</v-flex>
						      			  		<v-flex xs9 lg9 md9 sm9 class="content-confirm-booking--right">
						      			  			<div class="content-confirm-booking--right--input">
						      			  				<v-text-field
												            v-model="first"
												            label=""
												            solo
												        ></v-text-field>
						      			  			</div>
						      			  		</v-flex>

						      			  		<v-flex xs2 lg2 md2 sm2 class="content-confirm-booking--left">
						      			  			<span class="content-confirm-booking--left--icon">
						      			  				<i class="zmdi zmdi-format-list-numbered"></i>
						      			  			</span>
						      			  		</v-flex>
						      			  		<v-flex xs9 lg9 md9 sm9 class="content-confirm-booking--right">
						      			  			<div class="content-confirm-booking--right--input">
						      			  				<v-text-field
												            v-model="first"
												            label=""
												            solo
												        ></v-text-field>
						      			  			</div>
						      			  		</v-flex>

						      			  		<v-flex xs2 lg2 md2 sm2 class="content-confirm-booking--left">
						      			  			<span class="content-confirm-booking--left--icon">
						      			  				<i class="fas fa-envelope"></i>
						      			  			</span>
						      			  		</v-flex>
						      			  		<v-flex xs9 lg9 md9 sm9 class="content-confirm-booking--right">
						      			  			<div class="content-confirm-booking--right--input">
						      			  				<v-text-field
												            v-model="first"
												            label=""
												            solo
												        ></v-text-field>
						      			  			</div>
						      			  		</v-flex>

						      			  		<v-flex xs2 lg2 md2 sm2 class="content-confirm-booking--left">
						      			  			<span class="content-confirm-booking--left--icon">
						      			  				<i class="fas fa-phone"></i>
						      			  			</span>
						      			  		</v-flex>
						      			  		<v-flex xs9 lg9 md9 sm9 class="content-confirm-booking--right">
						      			  			<div class="content-confirm-booking--right--input">
						      			  				<v-text-field
												            v-model="first"
												            label=""
												            solo
												        ></v-text-field>
						      			  			</div>
						      			  		</v-flex>

						      			  		<v-flex xs2 lg2 md2 sm2 class="content-confirm-booking--left">
						      			  			<span class="content-confirm-booking--left--icon">
						      			  				<i class="far fa-calendar-alt"></i>
						      			  			</span>
						      			  		</v-flex>
						      			  		<v-flex xs9 lg9 md9 sm9 class="content-confirm-booking--right">
						      			  			<div class="content-confirm-booking--right--input">
						      			  				<v-text-field
												            v-model="first"
												            label=""
												            solo
												        ></v-text-field>
						      			  			</div>
						      			  		</v-flex>

						      			  		<v-flex xs12 lg12 md12 sm12 class="content-confirm-booking--btn">
						      			  			<v-btn depressed large color="primary">FINISH BOOKING
						      			  				<i class="fas fa-arrow-right" style="margin-left:10px"></i>
						      			  			</v-btn>
						      			  		</v-flex>
						      			  	</v-layout>
					      				</v-container>
					      			</v-card>
					      		</v-flex>
					    	</v-layout>
					      	
					    </v-card>
					</v-flex>
				</v-layout> -->
				<v-container>
					<div class="row box-body-booking">
						<div class="col-4" style="overflow: auto;">
							<div class="container">
								<div class="row" style="height: 300px;" >
									<div class="col-4 mb-3" v-for="photo in albumPhotos">
										<v-img :src="'/static/img/'+photo.name"></v-img>
									</div>
									<!-- <div class="col-4 mb-3">
										<v-img src="static/avatars/user-8.jpg"></v-img>
									</div>
									<div class="col-4 mb-3">
										<v-img src="static/avatars/user-8.jpg"></v-img>
									</div>
									<div class="col-4 mb-3">
										<v-img src="static/avatars/user-8.jpg"></v-img>
									</div>
									<div class="col-4 mb-3">
										<v-img src="static/avatars/user-8.jpg"></v-img>
									</div>
									<div class="col-4 mb-3">
										<v-img src="static/avatars/user-8.jpg"></v-img>
									</div>
									<div class="col-4 mb-3">
										<v-img src="static/avatars/user-8.jpg"></v-img>
									</div>
									<div class="col-4 mb-3">
										<v-img src="static/avatars/user-8.jpg"></v-img>
									</div>
									<div class="col-4 mb-3">
										<v-img src="static/avatars/user-8.jpg"></v-img>
									</div>

									<div class="col-4 mb-3">
										<v-img src="static/avatars/user-8.jpg"></v-img>
									</div>
									<div class="col-4 mb-3">
										<v-img src="static/avatars/user-8.jpg"></v-img>
									</div>
									<div class="col-4 mb-3">
										<v-img src="static/avatars/user-8.jpg"></v-img>
									</div>
									<div class="col-4 mb-3">
										<v-img src="static/avatars/user-8.jpg"></v-img>
									</div>
									<div class="col-4 mb-3">
										<v-img src="static/avatars/user-8.jpg"></v-img>
									</div>
									<div class="col-4 mb-3">
										<v-img src="static/avatars/user-8.jpg"></v-img>
									</div>
									<div class="col-4 mb-3">
										<v-img src="static/avatars/user-8.jpg"></v-img>
									</div>
									<div class="col-4 mb-3">
										<v-img src="static/avatars/user-8.jpg"></v-img>
									</div>
									<div class="col-4 mb-3">
										<v-img src="static/avatars/user-8.jpg"></v-img>
									</div>
									<div class="col-4 mb-3">
										<v-img src="static/avatars/user-8.jpg"></v-img>
									</div>
									 -->
									
								</div>
							</div>
						</div>
						<div class="col-4">
							<div class="container">
							  	<div class="content-title-booking">
	      			  				ORDER DETAIL
		      			  		</div>
		      			  		
		  			  			<table style="width: 100%">
		      			  			<tr>
		      			  				<th class="th-formate pt-3" >Formate</th>
		      			  				<th class="th-quantity pt-3" >Quantity</th>
		      			  				<th class="th-cost pt-3" >Cost</th>
		      			  			</tr>
		      			  			<tr v-for="detail in detailBooking">
		      			  				<td class="th-formate--td pt-3">{{detail.size}}</td>
		      			  				<td class="th-quantity--td pt-3" v-if="detail.priceNew != 0">{{detail.quantity}}</td>
		      			  				<td class="th-quantity--td pt-3" v-else>0</td>
		      			  				<td class="th-cost--td pt-3 td-custom">{{detail.priceNew}}</td>
		      			  			</tr>
		      			  			<!-- <tr>
		      			  				<td class="th-formate--td pt-3">FRAME</td>
		      			  				<td class="th-quantity--td pt-3">0</td>
		      			  				<td class="th-cost--td pt-3">Rp 0</td>
		      			  			</tr>
		      			  			<tr>
		      			  				<td class="th-formate--td pt-3">4R</td>
		      			  				<td class="th-quantity--td pt-3">0</td>
		      			  				<td class="th-cost--td pt-3" >Rp 0</td>
		      			  			</tr>
		      			  			<tr>
		      			  				<td class="th-formate--td pt-3">6R</td>
		      			  				<td class="th-quantity--td pt-3">0</td>
		      			  				<td class="th-cost--td pt-3">Rp 0</td>
		      			  			</tr>
		      			  			<tr>
		      			  				<td class="th-formate--td pt-3">10R</td>
		      			  				<td class="th-quantity--td pt-3">0</td>
		      			  				<td class="th-cost--td pt-3">Rp 0</td>
		      			  			</tr> -->
		      			  			<!-- <tr>
		      			  				<td class="th-formate--td pt-3 pb-3"></td>
		      			  				<td class="th-quantity--td pt-3 pb-3"></td>
		      			  				<td class="th-cost--td pt-3 pb-3"></td>
		      			  			</tr> -->
		  			  			</table>

		  			  			<div class="content-footer-booking">
		  			  				<div class="content-footer-booking--left">
		  			  					TOTAL
		  			  				</div>
		  			  				<div class="content-footer-booking--right">
		  			  					150000 RP
		  			  				</div>
		  			  			</div>
	  			  			</div>
						</div>

						<div class="col-4 flex-3">
							<v-card class='content-confirm-booking' row>
			      				<v-container class="container-content-confirm-booking">
				      			  	<v-layout wrap class="layout-content-confirm-booking">
				      			  		<v-flex xs2 lg2 md2 sm2 class="content-confirm-booking--left">
				      			  			<span class="content-confirm-booking--left--icon">
				      			  				<i class="far fa-user"></i>
				      			  			</span>
				      			  		</v-flex>
				      			  		<v-flex xs9 lg9 md9 sm9 class="content-confirm-booking--right">
				      			  			<div class="content-confirm-booking--right--input">
				      			  				<v-text-field
										            v-model="first"
										            label=""
										            solo
										        ></v-text-field>
				      			  			</div>
				      			  		</v-flex>

				      			  		<v-flex xs2 lg2 md2 sm2 class="content-confirm-booking--left">
				      			  			<span class="content-confirm-booking--left--icon">
				      			  				<i class="zmdi zmdi-format-list-numbered"></i>
				      			  			</span>
				      			  		</v-flex>
				      			  		<v-flex xs9 lg9 md9 sm9 class="content-confirm-booking--right">
				      			  			<div class="content-confirm-booking--right--input">
				      			  				<v-text-field
										            v-model="customerBooking.room"
										            label=""
										            solo
										        ></v-text-field>
				      			  			</div>
				      			  		</v-flex>

				      			  		<v-flex xs2 lg2 md2 sm2 class="content-confirm-booking--left">
				      			  			<span class="content-confirm-booking--left--icon">
				      			  				<i class="fas fa-envelope"></i>
				      			  			</span>
				      			  		</v-flex>
				      			  		<v-flex xs9 lg9 md9 sm9 class="content-confirm-booking--right">
				      			  			<div class="content-confirm-booking--right--input">
				      			  				<v-text-field
										            v-model="first"
										            label=""
										            solo
										        ></v-text-field>
				      			  			</div>
				      			  		</v-flex>

				      			  		<v-flex xs2 lg2 md2 sm2 class="content-confirm-booking--left">
				      			  			<span class="content-confirm-booking--left--icon">
				      			  				<i class="fas fa-phone"></i>
				      			  			</span>
				      			  		</v-flex>
				      			  		<v-flex xs9 lg9 md9 sm9 class="content-confirm-booking--right">
				      			  			<div class="content-confirm-booking--right--input">
				      			  				<v-text-field
										            v-model="first"
										            label=""
										            solo
										        ></v-text-field>
				      			  			</div>
				      			  		</v-flex>

				      			  		<v-flex xs2 lg2 md2 sm2 class="content-confirm-booking--left">
				      			  			<span class="content-confirm-booking--left--icon">
				      			  				<i class="far fa-calendar-alt"></i>
				      			  			</span>
				      			  		</v-flex>
				      			  		<v-flex xs9 lg9 md9 sm9 class="content-confirm-booking--right">
				      			  			<div class="content-confirm-booking--right--input">
				      			  				<v-text-field
										            v-model="customerBooking.date"
										            label=""
										            solo
										        ></v-text-field>
				      			  			</div>
				      			  		</v-flex>

				      			  		<v-flex xs12 lg12 md12 sm12 class="content-confirm-booking--btn">
				      			  			<v-btn depressed large color="primary" class="btn-finish-booking">FINISH BOOKING
				      			  				<i class="fas fa-arrow-right" style="margin-left:10px"></i>
				      			  			</v-btn>
				      			  		</v-flex>
				      			  	</v-layout>
			      				</v-container>
					      	</v-card>
						</div>

					</div>
				</v-container>

			</div>
		</div>
	</app-card>
</div>
</template>

<script>
import config from '../../config/index.js'
import  { get, post, put, del, getWithData } from '../../api/index.js'

import moment from 'moment'

export default {

  name: 'BookingConfirm',

  data () {
    return {
    	first: '',
    	
    	albumPhotos: JSON.parse(localStorage.getItem('photoSelected')),
    	detailBooking: [],
    	customerBooking:{name:'', room:'', email:'', mobile:'', date:''}
    }
  },
  mounted() {

  	var groupArray = _.groupBy(this.albumPhotos, 'size');

	var quantity = 0;

	var newArray = [];

	_.forEach(groupArray, (value, index) => {
		_.forEach(value, (value2, index2) => {
			quantity += value2['quantity']
		})

		newArray.push({name: index, quantity: quantity})

		quantity = 0
	})

	this.customerBooking.room = (JSON.parse(localStorage.getItem('photoRoom'))).room_number

	this.customerBooking.date = new Date().toISOString().substr(0, 10)

	this.getDataPackage(newArray);
  },
  methods:{
  	backPageShopSelling()
  	{
  		this.$router.push('/shop-selling')
  	},
  	getDataPackage(array)
  	{
  		get(config.API_URL+'photo_packages')
  		.then(res => {
  			if(res && res.data.success){
  				_.forEach(res.data.data, (value,index) => {
			  		_.forEach(array, (value2, index2) => {
			  			if(value['size'] == value2['name']) {
			  				value['quantity'] = value2['quantity']
			  				value['priceNew'] = value2['quantity'] * value['dollar']
			  			}
			  		})

			  		if(!value['priceNew']){
			  			value['priceNew'] = 0
			  		}

			  		this.detailBooking.push(value)
  				})
  			}
  		})
  		.catch(err => {
  			console.log(err.response)
  		})
  	}
  }
}
</script>

<style lang="scss" scoped>
.custom-app-card-footer{
	height: 100vh;
	overflow: hidden;
}
.footer-shop-selling{
	height: 50px;
	background-color:#5d92f4 !important;
	color:white;
	overflow: hidden;
}
.color-text-header{
	color:white;
}
.title-booking {
	height: 100px;
	width: auto !important;
	text-align:center;
	padding:30px 0px !important;
	&--span{
		margin:0 auto !important;
		font-size:30px !important;
		font-weight:bold;
		letter-spacing: 5px;
		text-transform: uppercase;
	}
	&--line{
		height: 3px;
		width: 150px;
		background-color:#00C1F8;
		margin: 0 auto !important;
	}
}
.content-booking{
	height: 100vh;
	flex-direction: column;
	overflow: hidden;
	padding: 0px !important;
}

table > tr:last-child td {
	padding-bottom:10px;
}

</style>