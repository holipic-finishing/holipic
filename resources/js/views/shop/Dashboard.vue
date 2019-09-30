<template>
	<div class="div-shop">
		<v-toolbar dark class="custom-toolbar-shop">
	    	<v-btn flat class="v-btn-header-branch">
	    		<h4 class="color-text-header">BRANCH NAME</h4>
	    	</v-btn>
	    	<v-spacer></v-spacer>
	    	<div class="toolbar-shop-right">
	    		<v-toolbar-items class="hidden-sm-and-down v-toolbar-item-shop">
			      	<v-overflow-btn
			          :items="dropdown_font"
			          label="USD"
			        ></v-overflow-btn>

			        <v-overflow-btn
			          :items="languages"
			          label="ENG"
			        ></v-overflow-btn>

			      	<v-btn flat @click="logout">
			      		<img src="images/LOGOUT.png" width="40px" height="40px"/>
			      	</v-btn>
	    		</v-toolbar-items>
	    	</div>
		</v-toolbar>

		<v-container fluid class="v-container-shop">
			<v-layout row wrap class="custom-row">
				<v-flex xs12 lg3 md6 sm6>
					<div class="v-flex-category" @click="showRoomLogin">
						<img src="shop_selling/ICONEYE.png" width="90%" class="v-flex-category--image"/>
						<span class="v-flex-category--title">See Photos</span>
					</div>
				</v-flex>
				<v-flex xs12 lg3 md6 sm6>
					<div class="v-flex-category">
						<img src="shop_selling/appointment.png" width="170px" class="v-flex-category--image" style="margin-top:10px;"/>
						<span class="v-flex-category--title">Make Appointment</span>
					</div>
				</v-flex>
				<v-flex xs12 lg3 md6 sm6>
					<div class="v-flex-category">
						<img src="shop_selling/add-photo.png" width="90%" class="v-flex-category--image"/>
						<span class="v-flex-category--title">Add Photos</span>
					</div>
				</v-flex>
				<v-flex xs12 lg3 md6 sm6>
					<div class="v-flex-category">
						<img src="shop_selling/snapphoto2.png" width="80%" class="v-flex-category--image"/>
						<span class="v-flex-category--title">Snap(daily) Photos</span>
					</div>
				</v-flex>
			</v-layout>
				<v-dialog
     			 	v-model="dialog"
      				width="400"
      				temporary
      				content-class="v-dialog-custom"
    				>
    				<v-card class="v-card-room">
				        <v-container fluid class="container-room">
						    <v-layout row wrap class="v-layout-room">
						    	<v-flex xs12 lg12 md12 sm12 class="flex-text-room">
							      	<div class="text-field-room">
							      		 <v-text-field
									      v-model="roomNumber"
									      label="Type here room number"
									      required
									    ></v-text-field>
							      	</div>
						      	</v-flex>
						      	<v-flex xs12 lg12 md12 sm12 class="flex-number-room">
							      	<div class="number-circle" @click="typeNumberRoom(1)">1</div>
							      	<div class="number-circle" @click="typeNumberRoom(2)">2</div>
									<div class="number-circle" @click="typeNumberRoom(3)">3</div>
						      	</v-flex>
						      	<v-flex xs12 lg12 md12 sm12 class="flex-number-room">
							      	<div class="number-circle" @click="typeNumberRoom(4)">4</div>
							      	<div class="number-circle" @click="typeNumberRoom(5)">5</div>
									<div class="number-circle" @click="typeNumberRoom(6)">6</div>
						      	</v-flex>
						      	<v-flex xs12 lg12 md12 sm12 class="flex-number-room">
							      	<div class="number-circle" @click="typeNumberRoom(7)">7</div>
							      	<div class="number-circle" @click="typeNumberRoom(8)">8</div>
									<div class="number-circle" @click="typeNumberRoom(9)">9</div>
						      	</v-flex>
						      	<v-flex xs12 lg12 md12 sm12 class="flex-number-room">
							      	<div class="number-circle" @click="typeNumberRoom('remove')">x</div>
							      	<div class="number-circle" @click="typeNumberRoom(0)">0</div>
									<div class="number-circle" @click="typeNumberRoom('removeOne')"><i class="fas fa-arrow-left"></i></div>
						      	</v-flex>
						      	<v-flex xs12 lg12 md12 sm12 class="flex-action-room">
						      		<v-btn color="primary" @click="loginRoom">
						      			ENTER &nbsp;<i class="fas fa-arrow-right"></i>
						      		</v-btn>
						      	</v-flex>
						    </v-layout>
						</v-container>
				      </v-card>
    			</v-dialog>
		</v-container>

		<div class="footer">
  			<span class="span-footer">Term & Conditions</span>
  			<span class="span-footer">Privacy Policy</span>
  			<span class="span-footer">Refund Policy</span>
		</div>
	</div>
</template>

<script>
import  { get, post, put, del, getWithData } from '../../api/index.js'
import config from '../../config/index.js'

export default {

  name: 'Dashboard',

  data () {
    return {
    	dropdown_font: ['USD', 'EURO'],
    	languages: ['ENG', 'INDO'],
    	textChange:'',
    	dialog:false,
    	roomNumber: ''
    }
  },
  methods: {
  	logout()
  	{
  		localStorage.removeItem('shopSelling')
  		localStorage.removeItem('roomLogin')
  		localStorage.removeItem('photoSelected')
  		localStorage.removeItem('thumbnailDir')
  		this.$router.push('/shop/login')
  	},
  	showRoomLogin()
  	{
  		this.dialog = true
  	},
  	typeNumberRoom(value)
  	{
  		if(value == 'remove') {
  			this.roomNumber = ''
  		} else if(value == 'removeOne') {
  			this.roomNumber = this.roomNumber.substring(0, this.roomNumber.length - 1);
  		}else{
  			this.roomNumber = this.roomNumber+value
  		}
  	},
  	loginRoom()
  	{
  		get('room/login?room='+this.roomNumber)
  		.then(res => {
  			if(res && res.success) {
  				var data = res.data
  				localStorage.setItem('roomLogin', JSON.stringify(data))
  				this.$router.push({path: '/shop/photos', params :{data: data}})
  			}
  		})
  		.catch(err => {
  			this.$notify({
	          title: 'Error',
	          message: err.response.data.message,
	          type: 'error',
	          duration: 2000,
	        })
  		})
  	}
  }
}
</script>

<style lang="css" scoped>
.color-text-header{
	color: #70778F !important;
}
.footer-shop-selling{
	height: 50px;
	background-color:#5d92f4 !important;
	color:white;
}
.footer {
   position: fixed;
   left: 0;
   bottom: 0;
   width: 100%;
   height: 50px;
   background-color:#e5e5e5 !important;
   color: #70778F !important;
   text-align: center;
   padding-top:10px !important;

}
.span-footer{
	margin:0px 15px !important;
	padding: 15px 0px;
	font-size:17px;
}

</style>
