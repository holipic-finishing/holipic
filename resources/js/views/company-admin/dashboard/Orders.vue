<template>
  <v-container fluid grid-list-xl>
    <v-layout row wrap>
      <app-card
        colClasses="xl12 lg12 md12 sm12 xs12"
        :fullScreen="true"
        :reloadable="true"
        :closeable="false"
        :fullBlock="true"
        class="p-0"
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
          <!-- Order Item -->
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
  			  :headers="headers"
  			  :items="itemsToView"
  			  class="body-2 custom-table-order"
  			  :pagination.sync="pagination"
  			  :loading="loadingCom"
  			  item-key="id"
  			  :search="search"
          :rows-per-page-items="rowsPerPageItems"
  			>
  				<v-progress-linear slot="progress" color="blue" indeterminate></v-progress-linear>

  				<!--Prop data -->
  				<template slot="items" slot-scope="props">
  					
  		    		<td>{{ props.item.id }}</td>
              <td>{{ props.item.branch.name }}</td>
              <td>{{ props.item.photographer.name }}</td>
              <td v-if="props.item.customer && props.item.customer.room">{{ props.item.customer.room.room_hash }}</td>
              <td v-else>No Room</td>
              <td v-if="props.item.customer && props.item.customer.user">{{ props.item.customer.user.email }}</td>
              <td v-else>No Email</td>
              <td >{{ props.item.total_amount_to_dollar }}</td>
              <td>{{ props.item.payment_method }}</td>
              <td>
               <!--  <v-btn class="btn-gradient-success ml-0 mr-0" color="success" small v-if="props.item.status === 'DONE'">{{ props.item.status }}</v-btn>
                <v-btn class="btn-gradient-pink ml-0 mr-0" color="primary" small v-if="props.item.status === 'PENDING'">{{ props.item.status }}</v-btn>
                <v-btn class="btn-gradient-warning ml-0 mr-0" color="error" small v-if="props.item.status === 'CANCEL'">{{ props.item.status }}</v-btn>
                <v-btn class="btn-gradient-primary ml-0 mr-0" color="primary" small v-if="props.item.status === 'PAID'">{{ props.item.status }}</v-btn> -->

                <span class="text-success" v-if="props.item.status === 'DONE'">{{ props.item.status }}</span>

                <span class="text-warning" v-if="props.item.status === 'PENDING'">{{ props.item.status }}</span>

                <span class="text-danger" v-if="props.item.status === 'CANCEL'">{{ props.item.status }}</span>

                <span class="text-primary" v-if="props.item.status === 'PAID'">{{ props.item.status }}</span>

                <span class="text-info" v-if="props.item.status === 'BOOKING'">{{ props.item.status }}</span>

            </td>
              <td class="text-right action-width">
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
                >
                  edit
                </v-icon>
                <v-icon
                  small
                  class="mr-2 hover-icon"
                >
                  delete
                </v-icon>
              </td>              
              <!-- <td>{{ props.item.purchase_date | moment("DD/MM/YYYY") }}</td>
              <td>{{ props.item.download_date | moment("DD/MM/YYYY") }}</td>
              <td>{{ props.item.created_at | moment("DD/MM/YYYY") }}</td>
  		    		<td>
                  <v-btn class="btn-gradient-success ml-0 mr-0" color="success" small v-if="props.item.status === 'DONE'">{{ props.item.status }}</v-btn>
                  <v-btn class="btn-gradient-pink ml-0 mr-0" color="primary" small v-if="props.item.status === 'PENDING'">{{ props.item.status }}</v-btn>
                  <v-btn class="btn-gradient-warning ml-0 mr-0" color="error" small v-if="props.item.status === 'CANCEL'">{{ props.item.status }}</v-btn>
              </td> -->
  											
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

      <order-detail></order-detail>
		</app-card>
   
	</v-layout>

  </v-container>

</template>

<script>
//import files
import config from '../../../config'
import { get, post, put, del } from '../../../api'
import { mapGetters } from "vuex"
import Vue from 'vue'
import OrderDetail from './OrderDetail.vue'

export default {
  name: 'Orders',

  components:{
    // TransactionItem
    'order-detail':OrderDetail

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
          class: 'mb-icon',
        },
        { 
          text: 'Branch',
          align: 'left',
          value: 'branch.name',
          class: 'mb-icon',
        },
        { 
          text: 'Photographer',
          align: 'left',
          value: 'photographer.name',
          class: 'mb-icon',
        },
        { 
          text: 'Room',
          align: 'left',
          value: 'customer.room.room_hash',
          class: 'mb-icon',
        },
        { 
          text: 'Email',
          align: 'left',
          value: 'customer.user.email',
          class: 'mb-icon',
        },
        { 
          text: 'Amount',
          align: 'left',
          value: 'total_amount_to_dollar',
          class: 'mb-icon',
        },
        { 
          text: 'Payment Method',
          align: 'left',
          value: 'payment_method',
          class: 'mb-icon',
        },
        {
          text: 'Status',
          align: 'left',
          value: 'actions',
          sortable: false,
        },
        {
          text: 'Action',
          align: 'left',
          sortable:false,
        }
      ],
      pagination: {
      },
      loading: true,
      search: '',
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
  	this.$root.$on('loadOdersWithTime', res => {
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

    this.$root.$on('searchTag', res => {
      this.params = res
      this.params.check =1
      this.fetchData(this.params)
    })

  },
  methods: {
    fetchData(params){
      params.company_id = this.company_id
      let url = config.API_URL + 'order/history-order'
    	post(url, params)
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
    },
    showInfo(item) {
      this.$root.$emit('showDetailOrder', {showNavigation: true, data: item})
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