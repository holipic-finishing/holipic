<template>
	<v-container fluid px-0 py-0>
		<v-layout row wrap>
			<app-card
				colClasses="xl12 lg12 md12 sm12 xs12"
				:fullScreen="true"
				:reloadable="true"
				:closeable="false"
				>
				<v-toolbar flat color="white">
			        <v-toolbar-title>
			          Photographers List
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
				    <v-btn small fab dark color="indigo" @click="showFromAdd()" class="ml-2 btn-gradient-primary">
							<v-icon dark>add</v-icon>
					</v-btn>
		    	</v-card-title>

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
					              <v-icon v-if="header.text != 'Action'">arrow_upward</v-icon>
				            	</div>
			           		</th>
			          	</tr>
		        	</template>

							<template slot="items" slot-scope="props">
								<td>{{ props.item.id }}</td>
								<td class="text-xs-left" >{{ props.item.branch.name }}</td>
								<td class="text-xs-left">{{ props.item.name }}</td>
								<td class="text-xs-left">{{ props.item.phone_number }}</td>
								<td class="text-xs-left">{{ props.item.address }}</td>
								<td class="text-xs-left">{{ props.item.created_at }}</td>

								<td class="text-xs-left">
								<!-- {{ props.item.status == true ? 'Active' : 'Inactive' }} -->
								<v-btn color="btn-gradient-primary" small v-if="props.item.status === true">Active</v-btn>
							 	<v-btn color="btn-gradient-pink" small v-else>Inactive</v-btn>
								</td>
					        	<td class="text-xs-left action-width-photographer">

					        		<v-icon
									    small
									    class="mr-2 hover-icon"
									    @click="showInfo(props.item)"
								    >
								    	visibility
									</v-icon>

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
						
			</app-card>
				<photographer-detail ></photographer-detail>
				<photographer-add></photographer-add>
				<photographer-edit></photographer-edit>

		</v-layout>
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
import PhotographerDetail from './PhotographerDetail'
import PhotographerAdd from './PhotographerAdd'
import PhotographerEdit from './PhotographerEdit'

export default {

	  name: 'Photographer',
	  components: {
	  	PhotographerDetail,PhotographerAdd,PhotographerEdit
	  },

  	data () {
	    return {
	    	headers: [	        
						{ text: 'ID', value: 'id'},	       
						{ text: 'Branch Name', value: 'branch.name' },
						{ text: 'Name', value: 'name'},	
						{ text: 'Phone', value: 'phone_number' },	
						{ text: 'Address', value: 'address' },		      
						{ text: 'Added Date', value: 'created_at' },
						{ text: 'Status', value: 'status' , sortable: false},		     
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
		    activeInfo: true,
		    itemIdToDelete: '',
		    loading: false

	    }
 	},
  	created() {
  		this.fetchData()
  	},
  	mounted() {
  		this.$root.$on('reloadTablePhotographer', res => {
  			this.fetchData()
  		})
  	},
  	methods: {
  		fetchData()
		{
			get(config.API_URL+'photographers?companyId='+this.company.company_id)
			.then(response => {
				if(response && response.data.success) {
					this.items = response.data.data
				}
			})
		},
		deleteItem()
		{
			del(config.API_URL+'photographer/'+this.itemIdToDelete+'?userId='+this.company.id)
			.then((res) => {
	        if(res.data && res.data.success){
	          this.fetchData()
	          this.dialog = false
	        }
	        
	      })
	      .catch((e) =>{
	        console.log(e)
	      })
		},
		showInfo(item)
		{
			this.$root.$emit('showInfoPhototographer', {showNavigation: true,data: item})
		},
		showDialog(item)
		{
			this.dialog = true
			this.itemIdToDelete = item
		},
		showFromAdd()
		{
			this.$root.$emit('showPhotographerAdd', {showNavigation:true})
		},
		showFormEdit(item)
		{
			this.$root.$emit('showFormEditPhotgrapher', {showNavigation: true, data: item})
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
.photographer-table{
	margin-top:30px;
}
.add-btn{
	right:0px;
	position: absolute;
	top: 8px;
}
.hover-icon{
    &:hover{
      color: blue !important;
    }
}
.action-width-photographer{
	min-width: 113px;
}
</style>