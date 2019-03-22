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
			          Snap Photo
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
					class="body-2 custom-table-customer"
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
						<td class="text-xs-left">{{ props.item.date }}</td>
						<td class="text-xs-left">{{ props.item.room }}</td>
						<td class="text-xs-left">{{ props.item.branch }}</td>
						<td class="text-xs-left">{{ props.item.photographer }}</td>
						<td class="text-xs-left">
							<v-icon
								class="mr-2 upload-photo"
								@click=""
							>
								cloud_upload
							</v-icon>

						</td>
						<td class="text-xs-left">{{ props.item.total }}</td>
			      		<td class="text-xs-left action-width">
							<v-icon
								small
								class="mr-2 hover-icon"
							>
								delete
							</v-icon>

							<v-icon
								small
								class="mr-2 hover-icon"	
							>
								add_circle
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
		<snap-photo-add></snap-photo-add>

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
          			<v-btn color="warning" outline small >Agree</v-btn>
        		</v-card-actions>
      		</v-card>
    	</v-dialog>
	</v-container>
</template>

<script>
import SnapPhotoAdd from './SnapPhotoAdd'
export default {

  	name: 'SnapPhoto',
  	components: {
  		SnapPhotoAdd
  	},

  	data () {
    	return {
    		items2: ['a','b','c'],
    		headers: [	        
				{ text: 'Date', value: 'name' },
				{ text: 'Room', value: 'room' },
				{ text: 'Branch', value: 'branch'},	
				{ text: 'Photographer', value: 'photographer' },	
				{ text: 'Photos', value: 'photo' },		      
				{ text: 'Total Photos', value: 'total' },		     
		        { text: 'Action', sortable: false },         
			],
			items: [
				{ date: '2019-03-09 10:30:03',room: '9292', branch: '101', photographer: '101', photo: '', total: '18'},
				{ date: '2019-03-10 10:30:01',room: '2121', branch: '101', photographer: '102', photo: '', total: '20'}
			],
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
  	methods: {
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
    	showFromAdd(){
    		this.$root.$emit('formSnapPhotoAdd', {activeform: true})
    	}
  	}
};
</script>

<style lang="scss" scoped>
	.upload-photo{
		font-size: 40px !important;
		color: #5D92F4 !important;
	}
</style>