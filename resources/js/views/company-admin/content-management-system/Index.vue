<template>
<div class="company-table">
<!-- <page-title-bar></page-title-bar> -->
<v-container fluid grid-list-xl pt-0>
	<div id="app">
		<v-app id="inspire">
			<v-card class="p-4">
				<v-navigation-drawer 
					fixed
					v-model="drawer" 
					:right="!rtlLayout" 
					temporary 
					app 
					class="chat-sidebar-wrap"
					width="800"
				>
				<cms-item :eventType="eventType" :item="item"></cms-item>
				</v-navigation-drawer>
				<v-toolbar flat color="white">
			        <v-toolbar-title>
			          	Content Management System
			        </v-toolbar-title>
			    </v-toolbar>
			    <v-divider></v-divider>
				<!--Search Component -->
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
		    	<!--End Search Component -->
				<!--Data Table Component -->
				<v-data-table
				:headers="headers" 
				:items="desserts" 
				class="elevation-5"  
				:pagination.sync="pagination" 
				:rows-per-page-items="rowsPerPageItems" 
				default-sort="id:desc"
				:search="search"
				>
					<template slot="items" slot-scope="props">
						<td>{{ props.item.id }}</td>
						<td class="text-xs-left">{{ props.item.page_title }}</td>
						<td class="text-xs-left" v-html="props.item.sort_content.substring(0,190)+'....'">...</td>
			        	<td class="text-xs-left action-width">
							<v-icon
								small
								class="mr-2 hover-icon"
								@click="showFormEdit('edit',props.item)"
							>
								edit
							</v-icon>
						</td>
					</template>
				</v-data-table>
		    </v-card>
		</v-app>
	</div>
</v-container>
</div>			    	
</template>

<script>
import config from '../../../config'
import { get, post, put, del } from '../../../api'
import { mapGetters } from "vuex"
import CmsItem from './CmsItem.vue'

export default {

	name: 'Index',
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
				  	descending: true
		    },
		    item: null,
      		eventType: '',
		    headers: [	        
					{ text: 'ID', value: 'id',  align: 'left', width: '3%'},	       
					{ text: 'Page Title', value: 'page_title',width: '20%' },	
					{ text: 'Page Content', value: 'page_content' },	      
		        	{ text: 'Action', sortable: false, width: '3%' },         
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
  			let url = config.API_URL + 'pages'
  			get(url)
  			.then(res => {
  				if(res.data && res.data.success){
					this.desserts = res.data.data
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

}
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