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
	      :width="400">
	      	<v-list dense>
		        <v-list-tile @click.stop="drawerRight = !drawerRight">
			          	<v-list-tile-action>
			            	<v-icon>exit_to_app</v-icon>
			          	</v-list-tile-action>
			          	<v-list-tile-content>
			            	<v-list-tile-title>Exit Your Drawer</v-list-tile-title>
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
			        	<div class="container">
				          	<div class="row">
				          		
					          	<div class="col-sm-4 text-value-company-left">Email:</div>
					          	<div class="col-sm-8 " id="text-value-company-right">{{company.email}}</div>

					          	<div class="col-sm-4 text-value-company-left">Address:</div>
					          	<div class="col-sm-8 " id="text-value-company-right">{{company.address}}</div>

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
				          </div>
			      		</div>
			      		<div class="text-center signature">Signature</div>
			        </v-list>    
  			
	      	</div>
	      	
	    </v-navigation-drawer>
	    
	   	</app-card>
	</v-layout>

</template>

<script>
import config from '../../config/index.js'

	export default {
		name: 'Company Information',
		data() {
			return {
				drawerRight: false,
	      		drawerRightEdit : false,
	      		company: [],
	      		companyId: ''
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
						this.company = response.data.data	
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
		font-size: 25px  !important; 
		font-weight: bold;
	}

	.line-company{
		height: 2px;
		width: 100%;
		background-color: #4286f4;
	}

	.image-company{
		padding: 0px 115px;
		margin: 30px 0px

	}

	.text-size {
		font-weight: bold;
		color:#4286f4;
	}
</style>