<template>
	<v-container fluid>
		<app-card>

			<v-navigation-drawer 
        fixed
        v-model="drawer" 
        :right="!rtlLayout" 
        temporary 
        app 
        class="chat-sidebar-wrap"
        width="450"
      >
        <coupon-code-item :eventType="eventType" :item="item"></coupon-code-item>
      </v-navigation-drawer>

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
			    <v-btn 
			    	@click="couponCodeEvent('add-new', null)"
			    	color="primary" 
			    	dark
			    	slot="activator"
			    	fab
			    	small
			    >
			    	<v-icon dark>fas fa-plus</v-icon>
			    </v-btn>
			    <span>Add New Coupon Code</span>
		    </v-tooltip>
			</v-toolbar>

			<v-data-table
      	:headers="headers"
      	:items="desserts"
	  		:pagination.sync="pagination"
	  		:loading="loading"
	  		item-key="id"
	  		:search="search"
        :rows-per-page-items="rowsPerPageItems"
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
	                <span slot="activator" class="text-capitalize subheading font-weight-bold">
	                  {{ header.text }}
	                </span>
	                <span>
	                  {{ header.text }}
	                </span>
	              </v-tooltip>
	              <v-icon v-if="header.value != 'actions' && header.value != 'code'">arrow_upward</v-icon>
            	</div>
            </th>
        	</tr>
		    </template>
		    <!--Prop data -->
		    <template slot="items" slot-scope="props">
	    		<td>{{ props.item.name }}</td>
	        <td class="text-left">{{ props.item.code }}</td>
	        <td class="text-right">{{ props.item.discount }}</td>
	        <td class="text-center">{{ formatDate(props.item.from_date) }}</td>
	        <td class="text-center">{{ formatDate(props.item.to_date) }}</td>
	        <td class="text-left" v-if="props.item.active == '0' ">Inactive</td>
	        <td class="text-left" v-if="props.item.active == '1' ">Active</td>
	        <td class="action-width text-right">
          	<v-icon
            	small
            	class="mr-2"
            	@click="editItem(props.item)"
          	>
            	edit
          	</v-icon>
          	<v-icon
            	small
            	@click="deleteItem(props.item.id)"
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
		</app-card>
	</v-container>
</template>

<script>
import  { get, del } from '../../api/index.js'
import config from '../../config/index.js'
import Vue from 'vue'
import CouponCodeItem from './CouponCodeItem'	
import moment from 'moment'
import { mapGetters } from "vuex"

export default {

	name: 'CouponCodes',

	data () {
	    return {
	    	search: '',
	    	desserts:[],
	    	headers: [
		        { text:'Name', value:'name', width: '20%', align:'left' },
		        { text:'Code', value:'code', width: '10%', sortable: false },
		        { text:'Discount (%)', value:'discount', width:'10%' },
		        { text:'From Date', value:'from_date', width: '15%', align:'center' },
		        { text:'To Date', value:'to_date', width: '15%', align:'center' },
		        { text:'Active', value: 'active' },
		        { text:'Actions', value:'actions', sortable: false }
	      	],
	      	pagination: {
		    },
		    loading: true,
		    search: '',
		    rowsPerPageItems: [ 20, 50, 100, { "text": "$vuetify.dataIterator.rowsPerPageAll", "value": -1 } ],
		    drawer: false,
		    item: null,
      	eventType: '',
		}
	},
	created(){
		this.loading = true
		this.fetchData()
	},
	methods : {
		changeSort (column) {
			var columnsNoSearch = ['code', 'actions']
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
		fetchData() {
			let url = config.API_URL + 'coupon_codes'
			get(url)
			.then((res) => {
				if(res.data && res.data.success){
					this.desserts = res.data.data
					this.loading = false
				}
			})
			.catch((err) =>{
				console.log(err)
			}) 
		},
		couponCodeEvent(event, item){
			this.drawer = true
      this.$root.$emit('disabled-transaction-item')
      this.eventType = event
      this.item = item
		},
		addNewCouponCode() {
			let obj = {
  				check : true,
  				showDialog: true,
	  		}
  			this.$root.$emit('change-status', obj)
		},
		editItem(item){
			let obj = {
	  				check : false,
	  				showDialog: true,
	  			}
  			this.$root.$emit('change-status', obj)
  			this.$root.$emit('data-packages', item)
		},
		formatDate(date) {
      if(date){
          return moment(date, 'YYYY-MM-DD hh:mm:ss').format('MM/DD/YYYY');
      }
  	},
    deleteItem(id){
			if(confirm('Are you sure you want to delete this item?')){
				let url = config.API_URL+'coupon_codes/'+id
				del(url)
				.then((res) => {
					this.fetchData();	
					setTimeout(function(){
			            Vue.notify({
			                group: 'loggedIn',
			                type: 'success',
			                text: 'Delete Item Success!'
			            });
			       },500);
				})
				.catch((err) =>{
					console.log(err)
				})
			}
		}
	},
	components:{
		'coupon-code-item' : CouponCodeItem
	},
	mounted(){
		this.$root.$on('closeDrawerItem', res => {
      this.drawer = res
    })

    this.$root.$on('reload-table', res => {
        this.fetchData();	
    })
  },
  computed:{
  	...mapGetters([
    	"rtlLayout",
    ]),
  }
};
</script>

<style lang="scss" scoped>
</style>