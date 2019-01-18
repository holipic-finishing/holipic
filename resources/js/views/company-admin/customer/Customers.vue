<template>
	<!-- <div class="photographer-table"> -->
		<v-container fluid pt-0 grid-list-xl mt-3>
			<v-layout row wrap>
			<!-- <div id="app"> -->
				<app-card
				colClasses="xl12 lg12 md12 sm12 xs12"
				customClasses="p-0 elevation-5"
				:fullScreen="true"
				:reloadable="true"
				:closeable="false"
				>
					<v-toolbar flat color="white">
				        <v-toolbar-title>
				          Customers Manage
				        </v-toolbar-title>
				    </v-toolbar>
		      		<v-divider class="m-0"></v-divider>
					<!--Search Component -->
					<v-card-title>
				      	<v-spacer></v-spacer>
				        <div class="w-25">
				  	      <v-text-field
				  	        v-model="search"
				  	        append-icon="search"
				  	        label="Enter Search Value"
				  	        single-line
				  	        hide-details
				  	      ></v-text-field>
				        </div>
				         <a target="_blank" slot="activator" class="btn btn-primary ml-2 btn-gradient-primary fix-btn-priamry " :href="urlExport">
							<v-icon small color="white" class="fix-v-icon">fas fa-file-excel</v-icon>
							</a>
					    
			    	</v-card-title>

					<v-data-table 
						:headers="headers" 
						:items="items" 
						class="elevation-5 custom-table-customer"  
						:pagination.sync="pagination" 
						:rows-per-page-items="rowsPerPageItems" 
						default-sort="id:desc"
						:search="search"
						>

						<template slot="headers" slot-scope="props">
			         	<tr>
				            <th
				              v-for="header in props.headers"
				              :key="header.text"
				              :class="['column sortable', pagination.descending ? 'desc' : 'asc', header.value === pagination.sortBy ? 'active' : '']"
				              @click="changeSort(header.value)"
				            >
				            	
					              <v-tooltip bottom>
					                <span slot="activator" class="text-capitalize font-weight-bold">
					                  {{ header.text }}
					                </span>
					                <span>
					                  {{ header.text }}
					                </span>
					              </v-tooltip>
					              <v-icon v-if="header.text != 'Action' && header.text != 'Order' && header.text != 'Invoice' && header.text != 'Rest Photo' && header.text != 'Avatar'">arrow_upward</v-icon>
				            	
			           		</th>
			          	</tr>
		        	</template>

						<template slot="items" slot-scope="props" >
							<td>{{ props.item.id }}</td>
							<td class="text-xs-left" >{{ props.item.name }}</td>
							<td class="text-xs-left">{{ props.item.room.room_hash }}</td>
							<td class="text-xs-left">{{ props.item.user.email }}</td>
							<td class="text-xs-left">{{ props.item.customer_password }}</td>
							<td class="text-xs-left"><img :src="props.item.avatar" width="100%"></td>

							<td class="text-xs-left">
								<v-btn color="success" small class="btn-customer btn-gradient-primary">Manage</v-btn>
							</td>
							<td class="text-xs-left">
								<v-btn color="success" small class="btn-customer btn-gradient-primary">Manage</v-btn>
							</td>
							<td class="text-xs-left">
								<v-btn color="success" small class="btn-customer btn-gradient-primary">100</v-btn>
							</td>
							<td class="text-xs-left center-input-customer">
								<v-text-field
								  name="name"
								  outline
								  class="height-input-customer width-input"
								></v-text-field>
							</td>
				        	<td class="text-xs-left action-width ">

				        		<v-icon
									small
									class="mr-6 hover-icon margin-icon-customer"
									
								>
									card_giftcard
								</v-icon>
								<v-icon
									small
									class="mr-6 hover-icon margin-icon-customer"
									@click="showFormEdit(props.item)"
								>
									edit
								</v-icon>

								<v-icon
									small
									class="mr-6 hover-icon margin-icon-customer"
									@click="showDialog(props.item.id)"
								>
									delete
								</v-icon>

							</td>
						</template>

						<!--No data -->
						<template slot="no-data">
					      <v-alert :value="true" color="error" icon="warning">
					        Sorry, nothing to display here :(
					      </v-alert>
			    		</template>
						
						<!--Search no result -->
				    	<v-alert slot="no-results" :value="true" color="error" icon="warning">
				          Your search for "{{ search }}" found no results.
				        </v-alert>
					</v-data-table>

					<customer-edit></customer-edit>
				</app-card>

			</v-layout>		

			<!-- </div> -->
			<v-dialog v-model="dialog" persistent max-width="450">
		      <v-card>
		        <v-card-title class="headline font-weight-bold">
		          <v-icon x-large color="yellow accent-3" class="mr-2">
		            warning
		          </v-icon>
		          Do you want delete this item ?
		        </v-card-title>
		        <v-divider class="mt-0"></v-divider>
		        <v-card-actions>
		          <v-spacer></v-spacer>
		          <v-btn flat @click="dialog = false">Disagree</v-btn>
		          <v-btn flat @click="deleteItem">Agree</v-btn>
		        </v-card-actions>
		      </v-card>
		    </v-dialog>
		</v-container>		
	<!-- </div>	 -->
</template>

<script>
import  { get, post, put, del, getWithData } from '../../../api/index.js'
import config from '../../../config/index.js'
import CustomerEdit from './CustomerEdit'

export default {

  name: 'Customers',
  components: {
  	CustomerEdit
  },

  data () {
    return {
    	dialog: false,
    	search:'',
    	items:[],
    	headers:[
    			{ text: 'ID', value: 'id', width: '1%'},	       
				{ text: 'Name', value: 'name' },
				{ text: 'Room', value: 'room.room_hash'},	
				{ text: 'Email', value: 'user.email' },	
				{ text: 'Password', value: 'customer_password' },		      
				{ text: 'Avatar' },
				{ text: 'Order'},
				{ text: 'Invoice'},
				{ text: 'Rest Photo'},
				{ text: 'Set Offer(Rp)', width: '10%'},
	        	{ text: 'Action', sortable: false ,width: '7%'},  
		],
		pagination: {
				  	rowsPerPage: 25  	
		    		},
		rowsPerPageItems: [25, 50, 100, { "text": "$vuetify.dataIterator.rowsPerPageAll", "value": -1 }],
		company: JSON.parse(localStorage.getItem('user')),
		urlExport: config.API_URL+'company/branches/customers/export?companyId='+JSON.parse(localStorage.getItem('user')).company_id,
		itemIdToDelete:'',
		loading:false

    }
  },
  created() {
  	this.fetchData()

  },
  mounted() {
  	this.$root.$on('reloadTableCustomer', res => this.fetchData())
  },
  methods:{
  	fetchData()
  	{
  		get(config.API_URL+'company/branches/customers?companyId='+this.company.company_id)
  		.then(response => {
  			if(response && response.data.success) {
  				this.items = response.data.data
  			}
  		})
  		.catch(error => {
  			console.log(error)
  		})
  	},
  	deleteItem() 
  	{
  		var userId = this.company.id
  		del(config.API_URL+'company/branches/customer/delete/'+this.itemIdToDelete+'?userId='+userId) 
  		.then(response => {
  			if(response && response.data.success) {
  				this.dialog = false
  				this.fetchData()
  			}
  		})
  	},
  	showDialog(item)
  	{
  		this.dialog = true
  		this.itemIdToDelete = item
  	},
  	showFormEdit(item)
  	{
  		this.$root.$emit('showFormEditCustomer', {showNavigation: true, data: item})
  	},
  	changeSort (column) {
	      var columnsNoSearch = ['actions']
	      if (columnsNoSearch.indexOf(column) > -1) {
	        return
	      }
	      this.loading = true
	      if (this.pagination.sortBy === column) {
	        this.pagination.descending = !this.pagination.descending
	      } else {
	        this.pagination.sortBy = column
	        this.pagination.descending = false
	      }
	      this.loading = false
    }
  }
};
</script>

<style lang="scss" scoped>
	.hover-icon{
	    &:hover{
	      color: blue !important;
	    }
    }
    .add-btn{
    	right: 0px;
    	position: absolute;
    	top: 8px;
    }
    .action-width{
    	min-width:80px;
    }
    .margin-icon-customer{
    	margin-left:4px !important;
    }
   	.fix-btn-priamry{
	   	display:block;
	  	height: 41px;
	  	width: 41px;
	  	border-radius: 50%;
	}
</style>