<template>
	<div class="branch-table">
		<!-- <page-title-bar></page-title-bar> -->
		<v-container fluid grid-list-xl pt-0>
			<div id="app">
				<v-app id="inspire">
					<v-card class="p-4">
						<v-toolbar flat color="white">
					        <v-toolbar-title>
					          	Branches List
					          	
					          	<v-btn dark color="indigo" class="add-btn" @click="showFromAdd()">
							      <v-icon dark >add</v-icon>
							    </v-btn>
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
							<template slot="items" slot-scope="props">
								<td>{{ props.item.id }}</td>
								<td class="text-xs-left">{{ props.item.branch_name }}</td>
								<td class="text-xs-left">{{ props.item.username }}</td>
								<td class="text-xs-left">{{ props.item.password }}</td>
								<td class="text-xs-left">{{ props.item.branch_address }}</td>
								<td class="text-xs-left">{{ props.item.branch_phone_number }}</td>

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
						<branch-edit></branch-edit>
						<branch-add></branch-add>

					</v-card>
				</v-app>
				<!-- <show-transaction></show-transaction> -->
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
import BranchEdit from './Branch-Edit.vue'
import BranchAdd from './Branch-Add.vue'

import Vue from 'vue'


export default {

  name: 'BranchCompany',
  components: {
  	BranchEdit, BranchAdd
  },

	data () {
	    return {
	    	headers: [	        
						{ text: 'ID', value: 'id'},	       
						{ text: 'Branch Name', value: 'branch_name' },
						{ text: 'Username', value: 'username'},	
						{ text: 'Password', value: 'password' },	
						{ text: 'Address', value: 'branch_address' },		      
						{ text: 'Phone', value: 'branch_phone_number' },		     
			        	{ text: 'Action', sortable: false },         
			],
			items: [],
			search:'',
			pagination: {
				  	rowsPerPage: 25
				  	
		    },
		    rowsPerPageItems: [25, 50, 100, { "text": "$vuetify.dataIterator.rowsPerPageAll", "value": -1 }],
		    user: JSON.parse(localStorage.getItem('user')),
		    dialog: false,
		    itemIdToDelete: ''
	    }
	},
	created() {
		this.fetchData()

	},
	mounted() {
		this.$root.$on('reloadTableBranch', res => this.fetchData())
	},
	methods: {
		fetchData()
		{
			get(config.API_URL+'company/branches?userId='+this.user.id)
			.then(response => {
				this.items = response.data.data
			})
		},
		showFormEdit(item)
		{
			this.$root.$emit('sendEventBranchEdit', {
						showNavigation: true,
						data: item
			});
		},
		showFromAdd()
		{
			this.$root.$emit('sendEventBranchAdd', {
				showNavigation: true
			});
		},
		deleteItem()
		{
			del(config.API_URL+'branches/'+this.itemIdToDelete)
			.then((res) => {
	        if(res.data && res.data.success){
	          Vue.notify({
	                        type: 'success',
	                        title: 'Delete Item Successfully',
	                        position: 'top right'
	                      })
	          this.fetchData()
	          this.dialog = false
	        }
	        
	      })
	      .catch((e) =>{
	        console.log(e)
	      })
		},
		showDialog(item)
		{
			this.dialog = true
			this.itemIdToDelete = item
		}
	}
}
</script>

<style lang="scss" scoped>
	.add-btn{
		right: 0px;
    	position: absolute;
    	top: 8px;
	}
	.branch-table{
		margin-top:30px;
	}
	.hover-icon{
    &:hover{
      color: blue !important;
    }
}
</style>