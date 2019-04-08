<template>
	<v-container fluid px-0 py-0 class="fix-croll-container">
		<v-layout row wrap>
			<app-card
				colClasses="xl12 lg12 md12 sm12 xs12"
				customClasses="rp-0 elevation-5 rp-search"
				:fullScreen="true"
				:reloadable="true"
				:closeable="false"
				:fullBlock="false"
			>

				<v-toolbar flat color="white">
			        <v-toolbar-title>
			          Branches List
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
				    <v-btn small fab dark @click="showFromAdd()" class="ml-2 btn-gradient-primary rp-btn-add-export">
						<v-icon dark>add</v-icon>
					</v-btn>
			    </v-card-title>

		    	<!-- Table Component -->
			  	<v-data-table 
					:headers="headers" 
					:items="items" 
					class="body-2 global-custom-table"
					:pagination.sync="pagination" 
					:rows-per-page-items="rowsPerPageItems" 
					default-sort="id:desc"
					:search="search"
				>
					<v-progress-linear slot="progress" color="blue" indeterminate></v-progress-linear>
					<!--Header -->
					<template slot="headers" slot-scope="props">
			         	<tr>
				            <th
				              	v-for="header in props.headers"
				              	:key="header.text"
				              	:class="['column sortable', pagination.descending ? 'desc' : 'asc', header.value === pagination.sortBy ? 'active' : '']"
				              	@click="changeSort(header.value)"
				            >
				            	<div class="custom-header">
					              	<v-tooltip bottom>
						                <span slot="activator" class="text-capitalize font-weight-bold">
						                  	{{ header.text }}
						                </span>
						                <span>
						                  	{{ header.text }}
						                </span>
					              	</v-tooltip>
					              	<v-icon v-if="header.value != 'actions'">arrow_upward</v-icon>
				            	</div>
			           		</th>
			          	</tr>
		        	</template>

					<template slot="items" slot-scope="props">
						<td>{{ props.item.id }}</td>
						<td class="text-xs-left">{{ props.item.name }}</td>
						<td class="text-xs-left">{{ props.item.user.username }}</td>
						<td class="text-xs-left">{{ props.item.branch_password }}</td>
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
		    	<!-- End Table Component -->
			</app-card>
		</v-layout>
		<branch-edit></branch-edit>
		<branch-add></branch-add>
		<v-dialog v-model="dialog" persistent max-width="450">
		    <v-card>
		        <v-card-title class="headline font-weight-bold grey lighten-3">
		          	<v-icon large color="warning" class="mr-2">
		            	warning
		          	</v-icon>
		          	Do you want delete this item ?
		        </v-card-title>
		        <v-divider class="mt-0"></v-divider>
		        <v-card-actions>
		          	<v-spacer></v-spacer>
		          	<v-btn color="secondary" outline small @click="dialog = false">Disagree</v-btn>
		          	<v-btn color="warning" outline small @click="deleteItem">Agree</v-btn>
		        </v-card-actions>
		    </v-card>
    	</v-dialog>
	</v-container>
</template>

<script>
import  { get, post, put, del, getWithData } from '../../../api/index.js'
import config from '../../../config/index.js'
import BranchEdit from './BranchEdit.vue'
import BranchAdd from './BranchAdd.vue'

import Vue from 'vue'


export default {

  	name: 'Branches',
  	components: {
  		BranchEdit, BranchAdd
  	},

	data () {
	    return {
	    	headers: [	        
				{ text: 'ID', value: 'id', width: '60%'},	       
				{ text: 'Branch Name', value: 'name' },
				{ text: 'Username', value: 'user.username'},	
				{ text: 'Password', value: 'branch_password' },	
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
		    company: JSON.parse(localStorage.getItem('user')),
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
			get(config.API_URL+'company/branches?companyId='+this.company.company_id)
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
	        	this.$notify({
		          title: 'Success',
		          message: 'Delete Item Successfully.',
		          type: 'success'
		        });
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
		},
		toggleAll () {
	      	if (this.selected.length) this.selected = []
	      	else{
		    	this.selected = this.desserts.slice()
	      	}
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
	    },
	}
};
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