<template>
<v-card class="h-100 position-relative">
	<v-toolbar>
		<v-toolbar-title class="text-xs-center">E WALLET</v-toolbar-title>
		<v-spacer></v-spacer>
		<v-toolbar-side-icon @click="closeDrawer">
      	<v-icon>
          fas fa-times
        </v-icon>
      	</v-toolbar-side-icon>
    </v-toolbar>
	<v-divider class="mt-0 mb-0"></v-divider>
	<v-tabs grow  class="heigth-list-title">
		<v-tab>Transaction History</v-tab>
		<v-tab>Top Up Balance</v-tab>
		<v-tab>Withdraw Via Bank Transfer</v-tab>
		<v-tab-item>
			<!-- Table Component -->
			<vue-perfect-scrollbar class="scroll-area" :settings="settings" style="height:20%;">
			    <v-data-table 
					:headers="headers" 
					:items="items" 
					class="elevation-5 body-2 global-custom-table"
					:pagination.sync="pagination" 
					:rows-per-page-items="rowsPerPageItems" 
					disable-initial-sort 
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
						
						<td class="text-xs-left">{{ props.item.title }}</td>
						<td class="text-xs-left">{{ props.item.dated }}</td>
						<td class="success--text mb-0" v-if="props.item.status == 'RECIVED'">+ {{ props.item.new_amount }}</td>
						<td class="mb-0" v-else>- {{ props.item.new_amount }}</td>
			 
					</template>

					<!--No data -->
					<template slot="no-data">
				      <v-alert :value="true" color="error" icon="warning">
				        Sorry, nothing to display here :(
				      </v-alert>
		    		</template>
				</v-data-table>
			</vue-perfect-scrollbar>
		</v-tab-item>
		<v-tab-item>
			<div>123123111111111123</div>
		</v-tab-item>
		<v-tab-item>
			<div>12312333333333333123</div>
		</v-tab-item>
	</v-tabs>
	 <v-card-actions class="w-100 border border-left-0 border-right-0 border-bottom-0 pr-4 bottom-position flex-end">
      	<v-btn @click="closeDrawer">Close</v-btn>
    </v-card-actions>
</v-card>
</template>

<script>
import { getWithData, put, get } from '../../api/index.js'
import config from '../../config/index.js'
export default {

  name: 'EWallet',

  data () {
    return {
  		headers: [	        
			{ text: 'Title', value: 'title' },
			{ text: 'Date', value: 'dated'},	
			{ text: 'Status', value: 'new_amount' },	
		],
		pagination: {
			rowsPerPage: 25	  	
		},
		rowsPerPageItems: [25, 50, 100, { "text": "$vuetify.dataIterator.rowsPerPageAll", "value": -1 }],
		user:JSON.parse(localStorage.getItem('user')),
		items:[],
		settings: {
	        maxScrollbarLength: 160
	    },
    }
  },
  methods:{
  	closeDrawer(){
  		this.$root.$emit('closeDrawerItem', false)
  	},
  	fetchData(){
  		let url = config.API_URL + 'e-wallet/transaction-history'
			let params = {
				company_id : this.user.company_id
			}
			getWithData(url,params)
			.then(res => {
				if(res.data && res.data.success){
					let data = res.data.data
					this.items = data

				}
			})	
			.catch(err => {
				console.log(err)
			})
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
  },
  created(){
  	this.fetchData()
  },
  computed:{
	  	optionLoadView(){
	  		return this.items
	  	}
	},
}
</script>

<style lang="css" scoped>
.mr-3 {
	margin-left: 16px !important;
}
</style>