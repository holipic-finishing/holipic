<template>
		<div class="photographer-table">
		<!-- <page-title-bar></page-title-bar> -->
		<v-container fluid grid-list-xl pt-0>
			<div id="app">
				<v-app id="inspire">
					<v-card class="p-4">
						<v-toolbar flat color="white">
					        <v-toolbar-title>
					          	Photographers List
					          	
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
							<template slot="items" slot-scope="props" >
								<td>{{ props.item.id }}</td>
								<td class="text-xs-left" >{{ props.item.branch.name }}</td>
								<td class="text-xs-left">{{ props.item.name }}</td>
								<td class="text-xs-left">{{ props.item.phone_number }}</td>
								<td class="text-xs-left">{{ props.item.address }}</td>
								<td class="text-xs-left">{{ props.item.created_at }}</td>

								<td class="text-xs-left">
								<!-- {{ props.item.status == true ? 'Active' : 'Inactive' }} -->
								<v-btn color="success" small v-if="props.item.status === true">Active</v-btn>
							 	<v-btn color="error" small v-else>Inactive</v-btn>
								</td>
					        	<td class="text-xs-left action-width">

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
						</v-data-table>
						
					</v-card>
				</v-app>
				<photographer-detail ></photographer-detail>
				<photographer-add></photographer-add>
				<photographer-edit></photographer-edit>

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
import PhotographerDetail from './Photographer-Detail.vue'
import PhotographerAdd from './Photographer-Add.vue'
import PhotographerEdit from './Photographer-Edit.vue'

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
		    itemIdToDelete: ''

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
					console.log(this.items)
				}
			})
		},
		deleteItem()
		{
			del(config.API_URL+'photographer/'+this.itemIdToDelete)
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
		}
  	}
}
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
</style>