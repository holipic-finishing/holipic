<template>
  <v-container fluid px-0 py-0>
  	<v-layout row wrap>
  		<app-card
  			colClasses="xl12 lg12 md12 sm12 xs12"
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
          <!-- <transaction-item :eventType="eventType" :item="item"></transaction-item> -->
        </v-navigation-drawer>

        <v-toolbar flat color="white">
          <v-toolbar-title>
            Orders
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
  	    <!--End Search Component -->
  			<!--Data Table Component -->
  			<v-data-table
  				v-model="selected"
  			  :headers="headers"
  			  :items="itemsToView"
  			  class="body-2 global-custom-table"
  			  :pagination.sync="pagination"
  			  :loading="loadingCom"
  			  select-all
  			  item-key="id"
  			  :search="search"
          :rows-per-page-items="rowsPerPageItems"
  			>
  				<!-- <v-progress-linear slot="progress" color="blue" indeterminate></v-progress-linear> -->
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

  				<!--Prop data -->
  				<template slot="items" slot-scope="props">
  					
  		    		<td>{{ props.item.id }}</td>
              <td>{{ props.item.branch.name }}</td>
              <td>{{ props.item.photographer.name }}</td>
              <td v-if="props.item.customer && props.item.customer.room">{{ props.item.customer.room.room_hash }}</td>
              <td v-else>No Room</td>
              <td>{{ props.item.total_amount_to_dollar }}</td>
              <td>{{ props.item.purchase_date | moment("DD/MM/YYYY") }}</td>
              <td>{{ props.item.download_date | moment("DD/MM/YYYY") }}</td>
              <td>{{ props.item.created_at | moment("DD/MM/YYYY") }}</td>
              <td v-if="props.item.customer && props.item.customer.user">{{ props.item.customer.user.email }}</td>
              <td v-else>No Email</td>
              <td>{{ props.item.payment_method }}</td>
  		    		<td>
                  <v-btn class="btn-gradient-success ml-0 mr-0" color="success" small v-if="props.item.status === 'DONE'">{{ props.item.status }}</v-btn>
                  <v-btn class="btn-gradient-pink ml-0 mr-0" color="primary" small v-if="props.item.status === 'PENDING'">{{ props.item.status }}</v-btn>
                  <v-btn class="btn-gradient-warning ml-0 mr-0" color="error" small v-if="props.item.status === 'CANCEL'">{{ props.item.status }}</v-btn>
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
  			<!--End Data Table Component -->
  		</app-card>
     
  	</v-layout>
  </v-container>
</template>

<script>
//import files
import config from '../../../config'
import { get, post, put, del } from '../../../api'
import { mapGetters } from "vuex"
// import TransactionItem from './TransactionItem'
import Vue from 'vue'

export default {
  name: 'Orders',

  components:{
    // TransactionItem
  },
  data () {
    return {
      dialog: false,
    	desserts: [],
    	headers: [
        {
          text: 'ID',
          align: 'left',
          value: 'id',
          width: '3%'
        },
        { 
          text: 'Branch',
          align: 'left',
          value: 'branch.name',
          width: '10%'
        },
        { 
          text: 'Photographer',
          align: 'left',
          value: 'photographer.name',
          width: '10%'
        },
        { 
          text: 'Room Number',
          align: 'left',
          value: 'customer.room.room_hash',
          width: '10%'
        },
        { 
          text: 'Total Amount',
          align: 'left',
          value: 'total_amount_to_dollar',
          width: '10%'
        },
        { 
          text: 'Purchase Date',
          align: 'left',
          value: 'purchase_date',
          width: '10%'
        },
        { 
          text: 'Download Date',
          align: 'left',
          value: 'download_date',
          width: '10%'
        },
        { 
          text: 'Order Date',
          align: 'left',
          value: 'created_at',
          width: '10%'
        },
        { 
          text: 'Customer Email',
          align: 'left',
          value: 'customer.user.email',
        },
        { 
          text: 'Payment Method',
          align: 'center',
          value: 'payment_method',
          width: '5%'
        },
        { 
          text: 'Status',
          align: 'center',
          value: 'status',
        },
        
      ],
      pagination: {
      },
      loading: true,
      search: '',
      selected: [],
      drawer: false,
      item: null,
      eventType: '',
      params: {
      	defaultDay: 'default'
      },
      itemIdToDelete: null,
      rowsPerPageItems: [ 20, 50, 100, { "text": "$vuetify.dataIterator.rowsPerPageAll", "value": -1 } ],
      company_id:JSON.parse(localStorage.getItem('user')).company_id,
    }
  },
  computed: {
    ...mapGetters([
      "rtlLayout",
    ]),
    loadingCom(){
    	return this.loading
    },
    itemsToView(){
    	return this.desserts
    }
  },
  mounted () {
  	this.$root.$on('loadTransactionsWithTime', res => {
  		let params = res.params
  		this.params = params
  		this.loading = true
  		this.fetchData(params)
  	})

    this.$root.$on('closeDrawerItem', res => {
      this.drawer = res
    })

    this.$root.$on('editItemSucess', res => {
    	this.loading = true
    	this.fetchData(this.params)
    })

  },
  methods: {
    fetchData(params){
      params.company_id = this.company_id
    	post(config.API_URL + 'order/history-order', params)
				.then((res) => {
					if(res.data && res.data.success){
						this.desserts = res.data.data
						this.loading = false
            this.$root.$emit('total-companies', this.desserts.length)
					}
				})
				.catch((e) =>{
					console.log(e)
				})
    },
    toggleAll () {
      if (this.selected.length) this.selected = []
      else{
	    	this.selected = this.desserts.slice()
      }
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
      del(config.API_URL + 'orders/' + this.itemIdToDelete)
      .then((res) => {
        console.log(res.data)
        if(res.data && res.data.success){
          Vue.notify({
                        type: 'success',
                        title: 'Delete Item Successfully',
                        position: 'top right'
                      })
          this.loading = true
          this.fetchData(this.params)
          this.dialog = false
        }
        
      })
      .catch((e) =>{
        console.log(e)
      })
    }
  },

  created(){
  	this.loading = true
  	this.fetchData(this.params)
  }

};
</script>

<style lang="scss" scoped>

  .action-width{
    min-width: 130px;
    width: 130px;
  }

  .hover-icon{
    &:hover{
      color: blue;
    }
  }
</style>