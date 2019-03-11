<template>
	<v-container fluid px-0 py-0 class="fix-croll-container">
		<v-layout row wrap>
		<!-- <div id="app"> -->
			<app-card
				colClasses="xl12 lg12 md12 sm12 xs12"
				customClasses="p-0 elevation-5 rp-search"
				:fullScreen="true"
				:reloadable="true"
				:closeable="false"
				:fullBlock="false"
			>

				<v-toolbar flat color="white" tabs>
			        <v-toolbar-title>
			          	Customers Manage
			        </v-toolbar-title>
					<v-spacer></v-spacer>
			        <div class="w-25 d-flex align-items-end">
			  	      	<v-text-field
				  	        v-model="search"
				  	        append-icon="search"
				  	        label="Enter Search Value"
				  	        single-line
				  	        hide-details
			  	      	></v-text-field>
						<a :href="urlExport" target="_blank" slot="activator" class="btn btn-primary ml-2 btn-gradient-primary custom-btn">
							<v-icon small color="white">fas fa-file-excel</v-icon>
						</a>
			        </div>
					<v-tabs
				        slot="extension"
				        v-model="tab"
				        slider-color="indigo"
						grow
						active-class="subheading font-weight-medium"
				   	>
				        <v-tab
				          	v-for="tab in tabs"
				          	:key="tab.valueTab"
				        >
				          	{{ tab.nameTab }}
				        </v-tab>
					</v-tabs>
		    	</v-toolbar>
				<v-divider class="m-0"></v-divider>
				<v-tabs-items v-model="tab" @change="changeTabItems" touchless>
					<v-tab-item
				        v-for="t in tabs"
				        :key="t.valueTab"
      				>
      					<template v-if="t.valueTab==='sales'">
							<v-data-table
								:headers="headers"
								:items="items"
								class="body-2 custom-table-customer"
								:pagination.sync="pagination"
								:rows-per-page-items="rowsPerPageItems"
								default-sort="id:desc"
								:search="search"
							>
								<template slot="headers" slot-scope="props">
					         		<tr>
							            <th
											v-for="header in props.headers"
											:key="header.text"
											:class="['column sortable th-margin', pagination.descending ? 'desc' : 'asc', header.value === pagination.sortBy ? 'active' : '', header.text === 'Action' ? 'text-right' : '']"
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

								<template slot="items" slot-scope="props" >
									<td>{{ props.item.id }}</td>
									<td>{{ props.item.name }}</td>
									<td>{{ props.item.room.room_hash }}</td>
									<td>{{ props.item.user.email }}</td>
									<td>{{ props.item.customer_password }}</td>
									<td>
										<v-tooltip bottom>
											<img :src="props.item.avatar" width="50px" slot="activator">
											<span>
										      	<v-card
											      	flat
											      	tile
											      	width="200"
											      	height="200"
										      	>
									       			<v-img
									                  	:src="props.item.avatar"
									                  	:lazy-src="props.item.avatar"
									                  	aspect-ratio="1"
									                  	class="grey lighten-2"
								                	>
								                  		<v-layout
								                    		slot="placeholder"
										                    fill-height
										                    align-center
										                    justify-center
										                    ma-0
								                  		>
								                    		<v-progress-circular indeterminate color="grey lighten-5"></v-progress-circular>
								                  		</v-layout>
								                	</v-img>
									      		</v-card>
											</span>
								    	</v-tooltip>
									</td>
									<td>
										<v-btn round small class="btn-customer">Manage</v-btn>
									</td>
									<td>
										<v-btn round small class="btn-customer">Manage</v-btn>
									</td>
									<td>
										<v-btn round small class="btn-customer">100</v-btn>
									</td>
									<td>
										<v-text-field
									  		name="name"
									  		label="Offer"
									  		class="height-input-customer width-input"
										></v-text-field>
									</td>
				        			<td class="action-width">
				        				<v-icon
											small
											class="mr-6 hover-icon margin-icon-customer"
										>
											card_giftcard
										</v-icon>

										<v-icon
											small
											class="mr-6 hover-icon margin-icon-customer"
											@click="showFormEdit(props.item)"
										>
											edit
										</v-icon>

										<v-icon
											small
											class="mr-6 hover-icon margin-icon-customer"
											@click="showDialog(props.item.id)"
										>
											delete
										</v-icon>
									</td>
								</template>

								<template slot="no-data">
						      		<v-alert :value="true" color="error" icon="warning">
						        		Sorry, nothing to display here :(
						      		</v-alert>
				    			</template>

					    		<v-alert slot="no-results" :value="true" color="error" icon="warning">
				          			Your search for "{{ search }}" found no results.
				        		</v-alert>
							</v-data-table>
							<customer-edit></customer-edit>
      					</template>
						<template v-if="t.valueTab==='bookings'">
							<booking></booking>
						</template>
						<template v-if="t.valueTab==='snap-photos'">
							<div>
								This is Add Snap Photos
							</div>
						</template>
      				</v-tab-item>
				</v-tabs-items>

			</app-card>
		</v-layout>
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
import CustomerEdit from './CustomerEdit'
import Booking from './Booking'


export default {

	name: 'Customers',
	components: {
		CustomerEdit, Booking
	},
	data () {
  	return {
		tab: null,
		tabs: [
			{ nameTab: 'Sales', valueTab: 'sales'},
			{ nameTab: 'Bookings', valueTab: 'bookings'},
			{ nameTab: 'Add Snap Photos', valueTab: 'snap-photos'},
		],
    	dialog: false,
    	search:'',
    	items:[],
    	headers:[
			{ text: 'ID', value: 'id', width: '1%'},
			{ text: 'Name', value: 'name',  align: 'left' },
			{ text: 'Room', value: 'room.room_hash', align: 'left'},
			{ text: 'Email', value: 'user.email' , align: 'left'},
			{ text: 'Password', value: 'customer_password', align: 'left' },
			{ text: 'Avatar' , align: 'left'},
			{ text: 'Order', align: 'left'},
			{ text: 'Invoice', align: 'left'},
			{ text: 'Rest Photo', align: 'left'},
			{ text: 'Set Offer(Rp)', width: '10%', align: 'left'},
      { text: 'Action', sortable: false ,width: '7%', value: 'actions'},
		],
		pagination: {
		  	rowsPerPage: 25
    	},
		rowsPerPageItems: [25, 50, 100, { "text": "$vuetify.dataIterator.rowsPerPageAll", "value": -1 }],
		company: JSON.parse(localStorage.getItem('user')),
		urlExport: config.API_URL+'company/branches/customers/export?companyId='+JSON.parse(localStorage.getItem('user')).company_id,
		itemIdToDelete:'',
		loading:false
  	}
	},
	created() {
		this.fetchData()
	},
	mounted() {
		this.$root.$on('reloadTableCustomer', res => this.fetchData())
	},
	methods:{
		fetchData() {
	  		get(config.API_URL+'company/branches/customers?companyId='+this.company.company_id)
	  		.then(response => {
	  			if(response && response.data.success) {
	  				this.items = response.data.data
	  			}
	  		})
	  		.catch(error => {
	  			console.log(error)
	  		})
	  	},
	  	deleteItem() {
	  		var userId = this.company.id
	  		del(config.API_URL+'company/branches/customer/delete/'+this.itemIdToDelete+'?userId='+userId)
	  		.then(response => {
	  			if(response && response.data.success) {
	  				this.dialog = false
	  				this.fetchData()
	  				this.$notify({
		          title: 'Success',
		          message: 'Delete Item Successfully.',
		          type: 'success',
		          duration: 2000,
		        })
	  			}
	  		})
	  	},
	  	showDialog(item) {
	  		this.dialog = true
	  		this.itemIdToDelete = item
	  	},
	  	showFormEdit(item) {
	  		this.$root.$emit('showFormEditCustomer', {showNavigation: true, data: item})
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
		changeTabItems(){

		}
	}
};
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
    .action-width{
    	width: 130px;
    	min-width: 130px;
    }
    .margin-icon-customer{
    	margin-left:4px !important;
    }


</style>
