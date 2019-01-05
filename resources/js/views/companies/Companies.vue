<template>
	<v-container fluid>
		<app-card>
			<company-information></company-information>
			<company-edit></company-edit>
			<page-title-bar></page-title-bar>

			<v-toolbar flat color="white" class="plr-0">
				<v-spacer></v-spacer>
				<v-text-field
	        v-model="search"
	        append-icon="search"
	        label="Enter Search Value"
	        single-line
	        hide-details
	        class="mr-3"
		    ></v-text-field>
		    <v-tooltip bottom>
			    <a :href="urlExport" target="_blank" slot="activator" class="btn btn-primary pl-2 pr-2 ml-3">
						<v-icon small>fas fa-file-excel</v-icon>
					</a>
			    <span>Export companies</span>
		    </v-tooltip>
			</v-toolbar>

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
					<td class="text-xs-left">{{ props.item.name }}</td>
					<td class="text-xs-left">{{ props.item.fullname }}</td>
					<td class="text-xs-left">{{ props.item.email }}</td>
					<td class="text-xs-left">{{ props.item.phone }}</td>
        	<td class="text-xs-left action-width">
		        <v-icon
			        small
			        class="mr-2 hover-icon"
			        @click.stop="drawerRight = !drawerRight"
			        @click="showTransaction(props.item)"
			    	>
				    	monetization_on
						</v-icon>

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
							@click="deleteTransaction(props.item.id)"
						>
							delete
						</v-icon>
					</td>
				</template>
			</v-data-table>
			
		</app-card>
	</v-container>	
</template>

<script>
	import  { get, post, put, del, getWithData } from '../../api/index.js'
	import config from '../../config/index.js'
	import Vue from 'vue'
	import Lodash from 'lodash'
	import moment from 'moment'
	import ShowTransaction from './ShowTransaction.vue'
	import CompanyInformation from './NavigationCompanyInformation'
	import CompanyEdit from './NavigationCompanyEdit'

	export default {

		name: 'Companies',
		components: {
			ShowTransaction,
			'company-information' : CompanyInformation,
			'company-edit' : CompanyEdit
		},

		data () {
			return {
				headers: [	        
					{ text: 'ID', value: 'id'},	       
					{ text: 'Company Name', value: 'name' },	
					{ text: 'Owner/ Manager', value: 'fullname' },
					{ text: 'Email', value: 'email'},	
					{ text: 'Phone', value: 'phone' },		      
		        	{ text: 'Action', sortable: false },         
		        ],
		        desserts:[],
		        search: '',
		        listPackage : [],
		        urlExport:config.API_URL+'exportexcel/companies',
		        drawerRight: false,
		        pagination: {
				  	rowsPerPage: 25,
				  	sortBy: 'id', 
				  	descending: true
		        },
		        rowsPerPageItems: [25, 50, 100, { "text": "$vuetify.dataIterator.rowsPerPageAll", "value": -1 }]
		    }
		},

		created(){
			this.fetchData();	
			this.getListPackage();
		},
		
		mounted() {
			this.$root.$on('editCompanySuccess', res => this.fetchData())
		},

		methods:{
			fetchData() {
				get(config.API_URL+'companies')
				.then((res) => {
					if(res.data && res.data.success){
						this.desserts = res.data.data
					}
				})
				.catch((e) =>{
					console.log(e)
				}) 
			},

			doReset(){
				this.search.keywords = ''
				this.search.filterPackage =''
				this.fetchData()
			},

			getListPackage(){
				var data = []
				data.push('All')

				get(config.API_URL+'list/packages')
				.then((res) => {
					_.forEach(res.data, function(value) {
						data.push(value.package_name)
					});
				})
				.catch((e) =>{
					console.log(e)
				}) 

				this.listPackage = data

			},

			showItem(item){
				this.$root.$router.push({
					path: '/default/widgets/mana-company-chart', 
					query: { companyId: item.id}
				})
			},

			showTransaction(items){
				let obj = {
					typeTime : 'Day',
					showDrawerRight : true,
					companyId : items.id,
					userId: items.owner_id
				}

				this.$root.$emit('showTransactionStatus', obj)
			},


			showInfo(item) {
				this.$root.$emit('sendEventCompanyInformation', {
					showNavigation: true,
					data: item
				});
			},

			showFormEdit(item) {
				this.$root.$emit('sendEventCompanyEdit', {
					showNavigation: true,
					data: item
				});
			},

			deleteTransaction(id) {
				alert(id)
			}
		},
	};
</script>

<style lang="scss" scoped>

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

.elevation-fix{
	margin-top:20px;
}

.h3-title-company{
	width: 290px;
}

#inspire {
	overflow: hidden!important;
}

.hover-icon{
    &:hover{
      color: blue !important;
    }
}

.action-width{
    min-width: 155px;
    width: 155px;
}
</style>