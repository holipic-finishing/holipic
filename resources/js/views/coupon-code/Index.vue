<template>
	<div>
		<page-title-bar></page-title-bar>
		<v-container fluid grid-list-xl pt-0>
		<v-toolbar flat color="white">
			<v-toolbar-title><v-icon>zmdi zmdi-dropbox</v-icon></v-toolbar-title>
		    <v-divider
		        class="mx-2"
		        inset
		        vertical
		    ></v-divider>
		    <v-btn @click="showAddItem()" color="primary" dark class="mb-2">Add</v-btn>
		</v-toolbar>
		<active-coupon-code></active-coupon-code>
		<v-data-table
	      :headers="headers"
	      :items="desserts"
	      class="elevation-1"
	    >
	    	<template slot="items" slot-scope="props">
	    		<td>{{ props.item.name }}</td>
		        <td class="text-xs-left">{{ props.item.code }}</td>
		        <td class="text-xs-left">{{ props.item.discount }}</td>
		        <td class="text-xs-left">{{ formatDate(props.item.from_date) }}</td>
		        <td class="text-xs-left">{{ formatDate(props.item.to_date) }}</td>
		        <td class="text-xs-left" v-if="props.item.active == '0' ">No Active</td>
		        <td class="text-xs-left" v-if="props.item.active == '1' ">Active</td>
		        <td class="">
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
	    	<template slot="no-data">
	    		<div class="btn-reset text-center"><v-btn color="primary">Reset</v-btn></div>
      		</template>
		</v-data-table>
	</v-container>

	</div>
</template>

<script>
import  { get, del } from '../../api/index.js'
import config from '../../config/index.js'
import Vue from 'vue'
import ActiveCouponCode from './ActiveCouponCode.vue'	
import moment from 'moment'

export default {

	name: 'Index',

	data () {
	    return {
	    	desserts:[],
	    	headers: [
		        {
		          text: 'Name',
		          align: 'left',
		          value: 'name'
		        },
		        { text: 'Code', value: 'code',sortable: false },
		        { text: 'Discount (%)', value: 'discount', },
		        { text: 'From Date', value: 'from_date' },
		        { text: 'To Date', value: 'to_date' },
		        { text: 'Active', value: 'active' },
		        { text: 'Actions', value: 'name', sortable: false }
	      	],
	    }
	},
	created(){
		this.fetchData()
	},
	methods : {
		showAddItem() {
			let obj = {
  				check : true,
  				showDialog: true,
	  		}
  			this.$root.$emit('change-status', obj)
		},
		fetchData() {
			let url = config.API_URL+'coupon_codes';
			get(url)
			.then((res) => {
				if(res.data && res.data.success){
					this.desserts = res.data.data
					console.log(this.desserts)
				}
				
			})
			.catch((err) =>{
				console.log(err)
			}) 
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
		ActiveCouponCode
	},
	mounted(){
      this.$root.$on('reload-table', res => {
          this.fetchData();	
      })
    },
}
</script>

<style lang="css" scoped>

</style>