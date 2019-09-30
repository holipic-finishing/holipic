<template>
	<v-container fluid grid-list-xl>
		<v-layout row wrap>
			<app-card
				colClasses="xl12 lg12 md12 sm12 xs12"
				customClasses="p-0 elevation-5 rp-search"
				:fullScreen="true"
				:reloadable="true"
				:closeable="false"
			>
				<v-toolbar flat color="white">
	        <v-toolbar-title>
	          Content Management System
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
	    	</v-card-title>

	    	<v-data-table
					:headers="headers"
					:items="desserts"
					class="body-2 global-custom-table"
					:pagination.sync="pagination"
					:rows-per-page-items="rowsPerPageItems"
					:search="search"
				>
					<template slot="headers" slot-scope="props">
         		<tr>
	            <th
								v-for="header in props.headers"
								:key="header.text"
								:class="['column sortable', pagination.descending ? 'desc' : 'asc', header.value === pagination.sortBy ? 'active' : '', header.text === 'Action' ? 'text-right' : '']"
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

					<template slot="items" slot-scope="props">
						<td>{{ props.item.id }}</td>
						<td class="text-xs-left">{{ props.item.page_title }}</td>
						<td class="text-xs-left" v-html="props.item.sort_content.substring(0,250)+'....'">...</td>
			      <td class="text-right action-width">
							<v-icon
								small
								class="mr-2 hover-icon"
								@click="showFormEdit('edit',props.item)"
							>
								edit
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
				<v-dialog
					fixed
					v-model="drawer"
					:right="!rtlLayout"
					fullscreen hide-overlay transition="slide-x-reverse-transition"
				>
					<cms-item :eventType="eventType" :item="item"></cms-item>
				</v-dialog>
			</app-card>
		</v-layout>
	</v-container>
</template>

<script>
import config from '../../../config'
import { get, post, put, del } from '../../../api'
import { mapGetters } from "vuex"
import CmsItem from './CmsItem'

export default {

	name: 'CMS',
	components: {
		CmsItem
	},
	data () {
    	return {
    		search:'',
    		drawer:false,
    		pagination: {
				  	rowsPerPage: 25,
				  	sortBy: 'id',
				  	descending: false
		    },
		    item: null,
      		eventType: '',
		    headers: [
					{ text: 'ID', value: 'id',  align: 'left', width: '3%'},
					{ text: 'Page Title', value: 'page_title', width: '20%' },
					{ text: 'Page Content', value: 'page_content' },
		      { text: 'Action', sortable: false, width: '3%', value: 'actions' },
		    ],
				desserts :[],
				rowsPerPageItems: [25, 50, 100, { "text": "$vuetify.dataIterator.rowsPerPageAll", "value": -1 }]
    	}
  	},
  	created(){
  		this.fetchData()
  	},
  	methods:{
  		fetchData(){
  			let url = 'pages'
  			get(url)
  			.then(res => {
  				if(res && res.success){
					this.desserts = res.data
				}
  			})
  			.catch(err =>{
  				console.log(err)
  			})
  		},
  		showFormEdit(event,item){
  			this.drawer = true
			this.eventType = event
			this.item = item
  		},
  		doReset(){
				this.search.keywords = ''
				this.search.filterPackage =''
				this.fetchData()
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
  	},
  	computed: {
    ...mapGetters([
      "rtlLayout",
    	]),
    	itemsToView(){
    		return this.desserts
    	}
    },
    mounted(){
    	this.$root.$on('closeDrawerItem', res => {
      		this.drawer = res
      		this.fetchData()
    	})
    	this.$root.$on('editItemSucess', res => {
    		this.fetchData()
    	})
    }

};
</script>

<style lang="css" scoped>
.input-style{
	width: 160px ;
}

.company-table{
	margin-top:30px;
}

.search-tool{
	margin-left:30px;
	margin-top:18px;
	margin-bottom:10px;

}
</style>
