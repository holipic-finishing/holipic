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
			  		
			      	<v-btn flat>
			      		<img src="images/LOGOUT.png" width="40px" height="40px"/>
			      	</v-btn>
	    		</v-toolbar-items>
	    	</div>
	    	
		</v-toolbar>
		<v-container fluid class="v-container-shop">
			<v-layout row wrap class="custom-row">
				<v-flex xs12 lg3 md6 sm6>
					<div class="v-flex-category">
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

		</v-container>
		
		<div class="footer">
			
  			<span class="span-footer">Term & Conditions</span>
  			<span class="span-footer">Privacy Policy</span>
  			<span class="span-footer">Refund Policy</span>
		</div>
	</div>
</template>

<script>
export default {

  name: 'Dashboard',

  data () {
    return {
    	dropdown_font: ['USD', 'EURO'],
    	languages: ['ENG', 'INDO'],
    	textChange:''
    }
  },
  watch: {
  	textChange(newtext,old)
  	{
  		if(newtext) {
  			console.log("co cai moi" + newtext)
  		}

  		if(old) {
  			alert(old)
  		}
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