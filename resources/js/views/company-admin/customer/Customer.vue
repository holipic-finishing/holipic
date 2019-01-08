<template>
	<div class="photographer-table">
		<v-container fluid grid-list-xl pt-0>
			<div id="app">
				<v-app id="inspire">
					<v-card class="p-4">
						<v-toolbar flat color="white">
					        <v-toolbar-title>
					          	 Manage Customers
					          	 <!-- <v-btn dark color="indigo" class="add-btn" >
							      Export
							    </v-btn> -->

							    <a :href="urlExport" target="_blank" slot="activator" class="btn btn-primary pl-2 pr-2 ml-3 add-btn">
									<v-icon small>fas fa-file-excel</v-icon>
								</a>
							    
					        </v-toolbar-title>
					    </v-toolbar>
					    <v-divider></v-divider>
						<v-card-title>
				      		<v-spacer></v-spacer>
				      		<v-text-field
				        		v-model="search"
						        append-icon="search"
						        label="Enter search value"
						        single-line
						        hide-details
						    ></v-text-field>
				    	</v-card-title>


						<v-data-table 
							:headers="headers" 
							:items="items" 
							class="elevation-5"  
							:pagination.sync="pagination" 
							:rows-per-page-items="rowsPerPageItems" 
							default-sort="id:desc"
							:search="search"
						>
							<template slot="items" slot-scope="props" >
								<td>{{ props.item.id }}</td>
								<td class="text-xs-left" >{{ props.item.name }}</td>
								<td class="text-xs-left">{{ props.item.room }}</td>
								<td class="text-xs-left">{{ props.item.email }}</td>
								<td class="text-xs-left">{{ props.item.password }}</td>
								<td class="text-xs-left"><img :src="props.item.avatar" width="100%"></td>

								<td class="text-xs-left">
									<v-btn color="success" small >Manage</v-btn>
								</td>
								<td class="text-xs-left">
									<v-btn color="success" small >Manage</v-btn>
								</td>
								<td class="text-xs-left">
									<v-btn color="success" small >100</v-btn>
								</td>
								<td class="text-xs-left">
									<v-text-field
									  name="name"
									  outline
									  class="height-input center-input"
									></v-text-field>
								</td>
					        	<td class="text-xs-left action-width">
									<v-icon
										small
										class="mr-2 hover-icon"
										@click="showFormEdit(props.item)"
									>
										edit
									</v-icon>

									<v-icon
										small
										class="mr-2 hover-icon"
										@click="showDialog(props.item.id)"
									>
										delete
									</v-icon>

								</td>
							</template>
						</v-data-table>
						<customer-edit></customer-edit>
						
					</v-card>
				</v-app>

			</div>
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
	</div>	
</template>

<script>
import  { get, post, put, del, getWithData } from '../../../api/index.js'
import config from '../../../config/index.js'
import CustomerEdit from './Customer-Edit'

export default {

  name: 'Customer',
  components: {
  	CustomerEdit
  },

  data () {
    return {
    	dialog: false,
    	search:'',
    	items:[],
    	headers:[
    			{ text: 'ID', value: 'id'},	       
				{ text: 'Name', value: 'name' },
				{ text: 'Room', value: 'room'},	
				{ text: 'Email', value: 'email' },	
				{ text: 'Password', value: 'password' },		      
				{ text: 'Avatar', value: 'avatar' },
				{ text: 'Order'},
				{ text: 'Invoice'},
				{ text: 'Rest Photo'},
				{ text: 'Set Offer(Rp)', width: '15%'},
	        	{ text: 'Action', sortable: false, width:'7%' },  
		],
		pagination: {
				  	rowsPerPage: 25  	
		    		},
		rowsPerPageItems: [25, 50, 100, { "text": "$vuetify.dataIterator.rowsPerPageAll", "value": -1 }],
		user: JSON.parse(localStorage.getItem('user')),
		urlExport: config.API_URL+'company/branches/customers/export?userId='+JSON.parse(localStorage.getItem('user')).id

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
  		get(config.API_URL+'company/branches/customers?userId='+this.user.id)
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

  	},
  	showDialog()
  	{
  		this.dialog = true
  	},
  	showFormEdit(item)
  	{
  		this.$root.$emit('showFormEditCustomer', {showNavigation: true, data: item})
  	}
  }
}
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
    .center-input{
    	margin-top: 30px;
    }
</style>