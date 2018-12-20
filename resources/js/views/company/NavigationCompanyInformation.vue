<template>
		<v-layout row wrap>
		<app-card
			colClasses="xl12 lg12 md12 sm12 xs12"
			customClasses="mb-0 sales-widget"
			:fullScreen="true"
			:reloadable="true"
			:closeable="false"
			
		>
		<v-navigation-drawer
	      fixed
	      v-model="drawerRight"
	      right
	      clipped
	      app
	      :width="400"
	      temporary
	      class="chat-sidebar-wrap"
	      style="overflow: auto;">
	      	<v-list dense>
		        <v-list-tile @click.stop="drawerRight = !drawerRight">
			          	<v-list-tile-action>
			            	<v-icon>exit_to_app</v-icon>
			          	</v-list-tile-action>
			          	<v-list-tile-content>
			            	<!-- <v-list-tile-title>Exit Your Drawer</v-list-tile-title> -->
			          	</v-list-tile-content>
		        </v-list-tile>
	      	</v-list>
	      	<div class="container fix-navigation">
	      		<div class="row image-company">
	      			<div class="col-sm-12">
				    <img src="images/HOLIPIC-LOGO.png" alt="" width="170px">
	      			</div>
				</div>
			    <div class="title-company"> {{company.name}}</div>
			        <v-list two-line>
			        	<div class="container container-company">
				          	<div class="row">

				          		<div class="col-sm-4 text-value-company-left">Company ID:</div>
					          	<div class="col-sm-8 " id="text-value-company-right">{{company.id}}</div>
				          		
					          	<div class="col-sm-4 text-value-company-left">Email:</div>
					          	<div class="col-sm-8 " id="text-value-company-right">{{company.email}}</div>

					          	<div class="col-sm-4 text-value-company-left">Address:</div>
					          	<div class="col-sm-8 " id="text-value-company-right">{{company.address}}</div>

					          	<div class="col-sm-4 text-value-company-left">Description:</div>
					          	<div class="col-sm-8 " id="text-value-company-right">{{company.description}}</div>

					          	<div class="col-sm-4 text-value-company-left">Date join:</div>
					          	<div class="col-sm-8 " id="text-value-company-right">{{company.created_at}}</div>

					          	<div class="line-company"></div>

					          	<div class="col-sm-4 text-value-company-left">Package:</div>
					          	<div class="col-sm-8 " id="text-value-company-right">{{company.package_name}}</div>

					          	<div class="col-sm-4 text-value-company-left">Storage:</div>
					          	<div class="col-sm-8 text-size" id="text-value-company-right" >{{company.file_upload}}GB</div>

					          	<div class="col-sm-4 text-value-company-left">Uploaded:</div>
					          	<div class="col-sm-8 text-size" id="text-value-company-right">{{company.total_upload}}GB</div>

					          	<div class="col-sm-4 text-value-company-left">Capacity:</div>
					          	<div class="col-sm-8 text-size" id="text-value-company-right">{{company.capacity}} GB</div>

					          	<div class="line-company"></div>

					          	<div class="col-sm-4 text-value-company-left">Total Income Fee:</div>
					          	<div class="col-sm-8 text-size" id="text-value-company-right" >{{company.total_income_fee}}</div>

					          	<div class="col-sm-4 text-value-company-left">Total Income:</div>
					          	<div class="col-sm-8 text-size" id="text-value-company-right">{{company.total_income}}</div>

					          	<div class="line-company"></div>

					          	<div class="col-sm-4 text-value-company-left">Signature:</div>

					          	<div class="line-company"></div>

				          </div>
			      		</div>

			      		<div class="container container-company2" v-if="lengthCode > 0 ">
				          	<div class="row">
				          		<div class="col-sm-12 signature ">Coupon Code</div>
				          		<div class="col-sm-4 text-value-company-left coupon-left">Name Code:</div>
					          	<div class="col-sm-8 " id="text-value-company-right">{{couponCode.name}}</div>
				          		
					          	<div class="col-sm-4 text-value-company-left coupon-left">Discount:</div>
					          	<div class="col-sm-8 " id="text-value-company-right">{{couponCode.discount}}</div>

					          	<div class="col-sm-4 text-value-company-left coupon-left">From Date:</div>
					          	<div class="col-sm-8 " id="text-value-company-right">{{couponCode.from_date}}</div>

					          	<div class="col-sm-4 text-value-company-left coupon-left">To Date:</div>
					          	<div class="col-sm-8 " id="text-value-company-right">{{couponCode.to_date}}</div>

				          	</div>

				          </div>
				          <button class="btn btn-primary btn-company" type="submit" @click.stop="drawerRight = !drawerRight"> Close </button>
			      		<!-- <div class="text-center signature">Signature</div> -->
			        </v-list>    
  			
	      	</div>
	      	
	    </v-navigation-drawer>
	    
	   	</app-card>
	</v-layout>

</template>

<script>
import config from '../../config/index.js'

	export default {
		name: 'CompanyInformation',
		data() {
			return {
				drawerRight: false,
	      		drawerRightEdit : false,
	      		company: [],
	      		companyId: '',
	      		couponCode: [],
	      		lengthCode: ''
			}
		},
		mounted() {
			this.$root.$on('sendEventCompanyInformation', response => {
				this.drawerRight = response.showNavigation
				this.company = response.data
				this.companyId = response.data.id

				this.informationCompany(this.companyId)
			});
		},
		methods: {
			informationCompany(companyId) {
				axios.get(config.API_URL+'companies/information?companyId='+this.companyId)
				.then(response => {
					if(response && response.data.success) {
						this.company = response.data.data[0]

						this.couponCode = response.data.data[1][0]

						var array = response.data.data[1]

						this.lengthCode = array.length	
						
						
					}
				})
			}
		}
	}
</script>

<style>
	.fix-navigation{
		padding: 10px 0px;
		
	}

	.fix-list{
		padding: 0px 5px;
	}

	.text-value-company {
		right:0px !important;
		color:red !important;
	}

	.title-company{
		height: 50px;
	    background-color: #4286f4;
	    text-align: center;
	    font-weight: 15px bold;
	    font-size: 20px;
	    font-weight: bold;
	    padding: 10px 0px;
	    color: white;
	}

	.text-value-company-left {
		margin: 10px 0px;
		font-size: 15px;
	}

	#text-value-company-right {
		margin: 10px 0px;
		font-size: 15px;
		
	}

	.signature{
		font-size: 20px  !important; 
		font-weight: bold;
		color: #4286f4;
		text-align:center;

	}

	.line-company{
		height: 2px;
		width: 100%;
		background-color: #4286f4;
	}

	.image-company{
		padding: 0px 115px;
    	margin-bottom: 10px;	
	}

	.text-size {
		font-weight: bold;
		color:#4286f4;
	}

	.container-company{
		overflow: auto;
		/*top:0px;
		position: absolute;
		margin-top: 130px;*/
	}

	.container-company2 {
		/*bottom:30px;
		position: absolute;*/
		padding-top: 0px;
		overflow: auto;
		/*bottom:0px;
		position: absolute;
		margin-bottom: 50px;*/
	}

	.coupon-left{
		font-weight: bold;
	}

	.btn-company{
		
    	right: 30px;
    	position: absolute;
    	color:black;
    	background-color: #e8e9ea !important;
    	border-color: #b7b9bc !important;
	}

	.btn-company:hover{
    	color:black !important;    	
	}
	
</style>