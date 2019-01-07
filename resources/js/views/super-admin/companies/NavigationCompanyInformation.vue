<template>
		
    <v-navigation-drawer 
    fixed
    v-model="drawerRight" 
    right
    temporary 
    app 
    class="chat-sidebar-wrap"
    width="450"
  	>

	    <v-card class="h-100 position-relative">
			<v-toolbar>
	      		<v-toolbar-title class="text-capitalize">{{company.name}}</v-toolbar-title>
	      		<v-spacer></v-spacer>
	     		<v-toolbar-side-icon @click.stop="drawerRight = !drawerRight">
		      		<v-icon>
		          		fas fa-times
		        	</v-icon>
	      		</v-toolbar-side-icon>
	    	</v-toolbar>
		    <v-divider class="no-mg-bottom"></v-divider>
			  
			  <!-- Show information -->
		    <v-list class="heigth-list-title">
				
				<v-list-tile>
					<v-list-tile-content>
			          	<v-list-tile-title class="content-flex">
				          	<span class="font-weight-bold item-title">Package name:</span>
				          	<span>{{company.package_name}}</span>
	          			</v-list-tile-title>
					</v-list-tile-content>
				</v-list-tile>
	     		 <v-divider class="no-mg-bottom"></v-divider>

				
				<v-list-tile>
					<v-list-tile-content>
			          	<v-list-tile-title class="content-flex">
				          	<span class="font-weight-bold item-title">Email login:</span>
				          	<span>{{company.email}}</span>
			         	</v-list-tile-title>
					</v-list-tile-content>
				</v-list-tile>
	      		<v-divider class="no-mg-bottom"></v-divider>


				<v-list-tile>
					<v-list-tile-content>
			         	<v-list-tile-title class="content-flex">
				          	<span class="font-weight-bold item-title">Address:</span>
				          	<span>{{company.address}}</span>
			          	</v-list-tile-title>
					</v-list-tile-content>
				</v-list-tile>
	      		<v-divider class="no-mg-bottom"></v-divider>

	      		<v-list-tile>
					<v-list-tile-content>
			         	<v-list-tile-title class="content-flex">
				          	<span class="font-weight-bold item-title">Added date:</span>
				          	<span>{{company.created_at}}</span>
			          	</v-list-tile-title>
					</v-list-tile-content>
				</v-list-tile>
	      		<v-divider class="no-mg-bottom"></v-divider>

	      		<v-list-tile>
					<v-list-tile-content>
			         	<v-list-tile-title class="content-flex">
				          	<span class="font-weight-bold item-title">Total customer:</span>
				          	<span>...</span>
			          	</v-list-tile-title>
					</v-list-tile-content>
				</v-list-tile>
	      		<v-divider class="no-mg-bottom"></v-divider>

	      		<v-list-tile>
					<v-list-tile-content>
			         	<v-list-tile-title class="content-flex">
				          	<span class="font-weight-bold item-title">Total storage:</span>
				          	<span>{{company.file_upload}}GB</span>
			          	</v-list-tile-title>
					</v-list-tile-content>
				</v-list-tile>
	      		<v-divider class="no-mg-bottom"></v-divider>	

	      		<v-list-tile>
					<v-list-tile-content>
			         	<v-list-tile-title class="content-flex">
				          	<span class="font-weight-bold item-title">Total income :</span>
				          	<span>{{company.total_income}}</span>
			          	</v-list-tile-title>
					</v-list-tile-content>
				</v-list-tile>
	      		<v-divider class="no-mg-bottom"></v-divider>

	      		<v-list-tile>
					<v-list-tile-content>
			         	<v-list-tile-title class="content-flex">
				          	<span class="font-weight-bold item-title">Signature :</span>
				          	<span>...</span>
			          	</v-list-tile-title>
					</v-list-tile-content>
				</v-list-tile>
	      		<v-divider class="no-mg-bottom"></v-divider>	

	    </v-list>
	    <v-list v-if="lengthCode > 0">
	    	
	    	<v-list-tile>
				<v-list-tile-content>
			         	<v-list-tile-title class="content-flex">
				          	<span class="font-weight-bold item-title">COUPON CODE</span>
			          	</v-list-tile-title>
				</v-list-tile-content>
			</v-list-tile>

			<v-list-tile>
				<v-list-tile-content>
			         	<v-list-tile-title class="content-flex">
				          	<span class="font-weight-bold item-title">Name Code:</span>
				          	<span>{{couponCode.name}}</span>
			          	</v-list-tile-title>
				</v-list-tile-content>
			</v-list-tile>
			<v-divider class="no-mg-bottom"></v-divider>

			<v-list-tile>
				<v-list-tile-content>
			         	<v-list-tile-title class="content-flex">
				          	<span class="font-weight-bold item-title">Discount:</span>
				          	<span>{{couponCode.discount}}</span>
			          	</v-list-tile-title>
				</v-list-tile-content>
			</v-list-tile>
			<v-divider class="no-mg-bottom"></v-divider>

			<v-list-tile>
				<v-list-tile-content>
			         	<v-list-tile-title class="content-flex">
				          	<span class="font-weight-bold item-title">From Date:</span>
				          	<span>{{couponCode.from_date}}</span>
			          	</v-list-tile-title>
				</v-list-tile-content>
			</v-list-tile>
			<v-divider class="no-mg-bottom"></v-divider>

			<v-list-tile>
				<v-list-tile-content>
			         	<v-list-tile-title class="content-flex">
				          	<span class="font-weight-bold item-title">To Date:</span>
				          	<span>{{couponCode.to_date}}</span>
			          	</v-list-tile-title>
				</v-list-tile-content>
			</v-list-tile>
			<v-divider class="no-mg-bottom"></v-divider>

	    </v-list>
	    <!-- End show information -->

	    <!-- Close drawer button -->

	    <v-card-actions class="w-100 border border-left-0 border-right-0 border-bottom-0 pr-4 bottom-position flex-end">
	      <v-btn @click.stop="drawerRight = !drawerRight">Close</v-btn>
	    </v-card-actions>
	    <!-- End close drawer button -->

		</v-card>

  		</v-navigation-drawer>
	    


</template>

<script>
import config from '../../../config/index.js'

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
				//this.company = response.data
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
