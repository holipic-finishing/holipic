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
				<v-container>
					<div class="row box-body-booking">
						<div class="col-4 col-image" style="overflow: auto;">
							<div class="container container-image">
								<div class="row" >
									<div class="col-4 mb-3" v-for="(photo,index) in albumPhotos" >
										<v-img :src="thumbnailDir+photo.name" :lazy-src="thumbnailDir+photo.name">

										</v-img>
									</div>

								</div>
							</div>
						</div>
						<div class="col-4 col-type">
							<div class="container container-type">
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

		  			  			</table>

		  			  			<div class="content-footer-booking">
		  			  				<div class="content-footer-booking--left">
		  			  					TOTAL
		  			  				</div>
		  			  				<div class="content-footer-booking--right">
		  			  					{{total}}
		  			  				</div>
		  			  			</div>
	  			  			</div>
						</div>

						<div class="col-4 flex-3 col-info">
							<v-card class='content-confirm-booking' row>
			      				<v-container class="container-content-confirm-booking">
			      					<v-form ref="form">
				      			  	<v-layout wrap class="layout-content-confirm-booking">

				      			  		<v-flex xs2 lg2 md2 sm2 class="content-confirm-booking--left">
				      			  			<span class="content-confirm-booking--left--icon">
				      			  				<i class="far fa-user"></i>
				      			  			</span>
				      			  		</v-flex>
				      			  		<v-flex xs9 lg9 md9 sm9 class="content-confirm-booking--right">
				      			  			<div class="content-confirm-booking--right--input">
				      			  				<v-text-field
										            v-model="customerBooking.name"
										            label=""
										            solo
										            :rules="nameRules"
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
										            disabled
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
										            v-model="customerBooking.email"
										            label=""
										            solo
										             :rules="emailRules"
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
										            v-model="customerBooking.mobile"
										            label=""
										            solo
										            :rules="phoneRules"
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
										            disabled
										        ></v-text-field>
				      			  			</div>
				      			  		</v-flex>

				      			  		<v-flex xs12 lg12 md12 sm12 class="content-confirm-booking--btn">
				      			  			<v-btn depressed large color="primary" class="btn-finish-booking" @click="checkout">FINISH BOOKING
				      			  				<i class="fas fa-arrow-right" style="margin-left:10px"></i>
				      			  			</v-btn>
				      			  		</v-flex>

				      			  	</v-layout>
				      			  	</v-form>
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
import  { get, post, put, del, getWithData } from '../../api/index.js'

import moment from 'moment'

export default {

  name: 'BookingConfirm',

  data () {
    return {
    	first: '',
    	albumPhotos: JSON.parse(localStorage.getItem('photoSelected')),
    	detailBooking: [],
    	customerBooking:{name:'', room:'', email:'', mobile:'', date:''},
    	thumbnailDir:'',
    	nameRules: [
	    	v => !!v || 'Name is required',
	        v => (v && v.length <= 10) || 'Password must be less than 10 characters'
		],
		emailRules: [
	        v => !!v || 'E-mail is required',
	        v => /.+@.+/.test(v) || 'E-mail must be valid'
	    ],
	    phoneRules:[
	    	v => !!v || 'Phone is required'
	        // v => /^[0-9]*$/.test(v) || 'phoneRules'
	    ],
	    roomLogin: JSON.parse(localStorage.getItem('roomLogin')),
	    total:0
    }
  },
  mounted() {

  	// var roomLogin = JSON.parse(localStorage.getItem('roomLogin'))

    this.thumbnailDir = localStorage.getItem('thumbnailDir')

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

	this.customerBooking.room = this.roomLogin.room_number

	this.customerBooking.date = new Date().toISOString().substr(0, 10)

	this.getDataPackage(newArray);
  },
  methods:{
  	backPageShopSelling()
  	{
  		this.$router.push('/shop')
  	},
  	getDataPackage(array)
  	{
  		get('photo_packages')
  		.then(res => {
  			if(res && res.success){
  				_.forEach(res.data, (value,index) => {
			  		_.forEach(array, (value2, index2) => {
			  			if(value['size'] == value2['name']) {
			  				value['quantity'] = value2['quantity']
			  				value['priceNew'] = value2['quantity'] * value['dollar']
			  			}
			  		})

			  		if(!value['priceNew']){
			  			value['priceNew'] = 0
			  		}

			  		this.total = this.total + value['priceNew']

			  		this.detailBooking.push(value)
  				})
  			}
  		})
  		.catch(err => {
  			console.log(err.response)
  		})
  	},
  	checkout()
  	{
  		if(this.$refs.form.validate()){
  			let images 	= JSON.parse(localStorage.getItem('photoSelected'));

  			let params 	= { params: {
  								name: this.customerBooking.name ,
		  						roomId: this.roomLogin.id,
		  						email: this.customerBooking.email,
		  				 		phone: this.customerBooking.mobile,
		  				 		date: this.customerBooking.date,
		  				 		total: this.total
  						   },
  						   images: images
  						}
  			post('shop-selling/order-confirm', params)
  			.then(res => {

  			})
  		}
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
