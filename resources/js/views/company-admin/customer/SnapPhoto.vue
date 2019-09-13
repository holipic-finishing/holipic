<template>
	<div>
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

			<template slot="items" slot-scope="props">
				<td>{{ props.item.date }}</td>
				<td>{{ props.item.room }}</td>
				<td>{{ props.item.branch }}</td>
				<td>{{ props.item.photographer }}</td>
				<td>
					<v-icon
						class="mr-2 upload-photo"
						@click=""
					>
						cloud_upload
					</v-icon>

				</td>
				<td>{{ props.item.total }}</td>
	      		<td class="action-width">
					<v-icon
						small
						class="mr-2 hover-icon"	
					>
						add_circle
					</v-icon>
					<v-icon
						small
						class="mr-2 hover-icon"
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
	</div>

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
		        { text: 'Action', align: 'center', sortable: false },         
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