<template>
	<v-layout row wrap>
		<app-card
			colClasses="xl12 lg12 md12 sm12 xs12"
			customClasses="mb-0 sales-widget"
			:fullScreen="true"
			:reloadable="true"
			:closeable="false"
		>
      <v-navigation-drawer 
        fixed
        v-model="drawer" 
        :right="!rtlLayout" 
        temporary 
        app 
        class="chat-sidebar-wrap"
        width="450"
      >
        <transaction-item :eventType="eventType" :item="item"></transaction-item>
      </v-navigation-drawer>

      <v-toolbar flat color="white">
        <v-toolbar-title>
          <router-link :to="{ path: '/default/transaction/histories' }">Transactions</router-link>
        </v-toolbar-title>
      </v-toolbar>
      <v-divider></v-divider>

			<!--Search Component -->
			<v-card-title>
	      Search
	      <v-spacer></v-spacer>
	      <v-text-field
	        v-model="search"
	        append-icon="search"
	        label="Enter Search Value"
	        single-line
	        hide-details
	      ></v-text-field>
	    </v-card-title>
	    <!--End Search Component -->
			<!--Data Table Component -->
			<v-data-table
				v-model="selected"
			  :headers="headers"
			  :items="itemsToView"
			  class="elevation-5"
			  :pagination.sync="pagination"
			  :loading="loadingCom"
			  :total-items="totalDesserts"
			  select-all
			  item-key="id"
			  :search="search"
        :rows-per-page-items="rowsPerPageItems"
			>
				<v-progress-linear slot="progress" color="blue" indeterminate></v-progress-linear>
				<!--Header -->
				<template slot="headers" slot-scope="props">
          <tr>
            <th>
              <v-checkbox
                :input-value="props.all"
                :indeterminate="props.indeterminate"
                primary
                hide-details
                @click.native="toggleAll"
              ></v-checkbox>
            </th>
            <th
              v-for="header in props.headers"
              :key="header.text"
              :class="['column sortable', pagination.descending ? 'desc' : 'asc', header.value === pagination.sortBy ? 'active' : '']"
              @click="changeSort(header.value)"
            >
            	<div class="custom-header">
	              <v-tooltip bottom>
	                <span slot="activator" class="text-capitalize subheading font-weight-bold">
	                  {{ header.text }}
	                </span>
	                <span>
	                  {{ header.text }}
	                </span>
	              </v-tooltip>
	              <v-icon>arrow_upward</v-icon>
            	</div>
            </th>
          </tr>
        </template>

				<!--Prop data -->
				<template slot="items" slot-scope="props">
					<tr :active="props.selected" @click="props.selected = !props.selected">
						<td>
              <v-checkbox
                :input-value="props.selected"
                primary
                hide-details
              ></v-checkbox>
            </td>
		    		<td>{{ props.item.id }}</td>
		    		<td>{{ props.item.company_name }}</td>
		    		<td class="text-right">{{ props.item.invoice }}</td>
						<td class="text-right">{{ props.item.dated | moment("DD/MM/YYYY") }}</td>
		    		<td>{{ props.item.title }}</td>
		    		<td class="text-right">
		    			<div v-if="props.item.status === 'RECIVED'" style="color:green">
		    				+ {{ props.item.amount_with_symbol }} 
		    			</div>
		    			<div v-else>
		    				{{ - props.item.amount_with_symbol }} 
		    			</div>
		    		</td>
		    		<td class="text-right">
								<v-btn color="success" small v-if="props.item.status === 'RECIVED'">{{ props.item.status }}</v-btn>
							 	<v-btn color="error" small v-else>{{ props.item.status }}</v-btn>
			    	</td>
		    		<td> 
		    			<v-icon
				    		class="mr-2"
				    		@click="transactionEvent('show', props.item)"
				    	>
				    		visibility
				    	</v-icon>
				      <v-icon
				    		class="mr-2"
				    		@click="transactionEvent('edit', props.item)"
				      >
				        edit
				      </v-icon>
				      <v-icon
				    		class="mr-2"
				    		@click="showDialog(props.item.id)"
				      >
				        delete
				      </v-icon>
		    		</td>
					</tr>
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
			<!--End Data Table Component -->
		</app-card>
    <v-dialog v-model="dialog" persistent max-width="450">
      <v-card>
        <v-card-title class="headline font-weight-bold grey lighten-2">
          <v-icon x-large color="yellow accent-3">
            warning
          </v-icon>
          Do you want delete this item ?
        </v-card-title>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="green darken-1" flat @click="dialog = false">Disagree</v-btn>
          <v-btn color="green darken-1" flat @click="deleteItem">Agree</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
	</v-layout>
</template>

<script>
//import files
import config from '../../../config'
import { get, post, put, del } from '../../../api'
import { mapGetters } from "vuex"
import TransactionItem from './TransactionItem'
import Vue from 'vue'

export default {

  name: 'Transactions',

  components:{
    TransactionItem
  },
  data () {
    return {
      dialog: false,
    	desserts: [],
    	totalDesserts: 0,
    	headers: [
        {
          text: 'ID',
          align: 'left',
          value: 'id',
          width: '3%'
        },
        { 
          text: 'Company Name',
          align: 'left',
          value: 'company_name',
          width: '10%'
        },
        { 
          text: 'Invoice',
          align: 'right', 
          value: 'invoice' 
        },
        {
          text: 'Date',
          align: 'right',
          value: 'dated'
        },
        {
          text: 'Transaction',
          align: 'left',
          value: 'title'
        },
        {
          text: 'Amount',
          align: 'right',
          value: 'amount_with_symbol'
        },
        {
          text: 'Status',
          align: 'right',
          value: 'status'
        },
        {
          text: 'Action',
          align: 'center',
          sortable: false
        }
      ],
      pagination: {
      },
      loading: true,
      search: '',
      selected: [],
      itemsTmp: [],
      drawer: false,
      item: null,
      eventType: '',
      paramsSaveForEditSuccess: null,
      itemIdToDelete: null,
      rowsPerPageItems: [ 20, 50, 100, { "text": "$vuetify.dataIterator.rowsPerPageAll", "value": -1 } ]
    }
  },
  watch: {
    params: {
      handler() {
          this.getDataFromApi()
          .then(data => {
              this.desserts = data.items;
              this.totalDesserts = data.total;
          });
      },
      deep: true
    }
  },
  computed: {
    ...mapGetters([
      "rtlLayout",
    ]),
    params(nv) {
      return {
          ...this.pagination,
          query: this.search
      }
    },
    loadingCom(){
    	return this.loading
    },
    itemsToView(){
    	if (this.desserts === undefined || this.desserts.length == 0) {
    		return this.itemsTmp
    	}else{
    		return this.desserts
    	}
    }
  },
  mounted () {
  	this.$root.$on('loadTransactionsWithTime', res => {
  		let params = res.params
      this.paramsSaveForEditSuccess = res.params

	    this.getDataFromApi(params)
		    .then(data => {
		      this.items = data.items
		      this.totalItems = data.total
		    })
  	})

    this.$root.$on('closeDrawerItem', res => {
      this.drawer = res
    })

    this.$root.$on('editItemSucess', res => {
      this.getDataFromApi(this.paramsSaveForEditSuccess)
        .then(data => {
          this.items = data.items
          this.totalItems = data.total
        })
    })

  },
  methods: {
  	getDataFromApi(params) {
  		this.loading = true
      return new Promise((resolve, reject) => {
        const {
            sortBy,
            descending,
            page,
            rowsPerPage
        } = this.pagination
        
        let search = this.search.trim().toLowerCase()
        let items = this.getItems(params)

        if (search) {
          items = items.filter(item => {
            return Object.values(item)
                .join(",")
                .toLowerCase()
                .includes(search)
          })
        }

        if (this.pagination.sortBy) {
          items = items.sort((a, b) => {
              const sortA = a[sortBy]
              const sortB = b[sortBy]

              if (descending) {
                if (sortA < sortB) return 1
                if (sortA > sortB) return -1
                return 0
              } else {
                if (sortA < sortB) return -1
                if (sortA > sortB) return 1
                return 0
              }
          })
        }

        if (rowsPerPage > 0) {
          items = items.slice(
            (page - 1) * rowsPerPage,
            page * rowsPerPage
          )
        }
        const total = items.length
          
        setTimeout(() => {
            this.loading = false
            resolve({
              items,
              total
            })
        }, 1000)
      })
    },
    getItems (params) {
			this.fetchData(params)
			return this.itemsTmp
    },
    fetchData(paramsFromToChart){

    	let paramsToBackEnd = {
															defaultDay :  'default'
														}
			if (paramsFromToChart) {
				paramsToBackEnd = paramsFromToChart
			}

    	post(config.API_URL + 'histories/transactions', paramsToBackEnd)
				.then((res) => {
					if(res.data && res.data.success){
						this.itemsTmp = res.data.data
					}
				})
				.catch((e) =>{
					console.log(e)
				})
    },
    toggleAll () {
      if (this.selected.length) this.selected = []
      else{
      	if (this.desserts === undefined || this.desserts.length == 0) {
	    		this.selected = this.itemsTmp.slice()
	    	}else{
	    		this.selected = this.desserts.slice()
	    	}
      }
    },
    changeSort (column) {
      if (this.pagination.sortBy === column) {
        this.pagination.descending = !this.pagination.descending
      } else {
        this.pagination.sortBy = column
        this.pagination.descending = false
      }
    },
    transactionEvent(event, item){
    	this.drawer = true
      this.$root.$emit('disabled-transaction-item')
      this.eventType = event
      this.item = item
    },
    showDialog(id){
      this.dialog = true
      this.itemIdToDelete = id
    },
    deleteItem(){
      del(config.API_URL + 'transactions/' + this.itemIdToDelete)
      .then((res) => {
        if(res.data && res.data.success){
          Vue.notify({
                        type: 'success',
                        title: 'Delete Item Successfully',
                        position: 'top right'
                      })

          this.getDataFromApi(this.paramsSaveForEditSuccess)
          .then(data => {
            this.items = data.items
            this.totalItems = data.total
          })

          this.dialog = false
        }
        
      })
      .catch((e) =>{
        console.log(e)
      })
    }
  },

  created(){
  	this.fetchData()
  }

};
</script>

<style lang="scss" scoped>
	.custom-header{
		display:flex;
		justify-content:center;
		align-items:center;
	}
</style>