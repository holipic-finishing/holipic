<template>
	<v-navigation-drawer
      fixed
      v-model="drawerRight"
      right
      clipped
      app
	  :width="450"
	  temporary
      >
  		<v-list dense>
	        <v-toolbar>
	      		<v-toolbar-title class="text-capitalize">Transaction History</v-toolbar-title>
	      		<v-spacer></v-spacer>
	     		<v-text-field
					v-model="currentFilterValue"
					append-icon="search"
					
					single-line
					hide-details
					@keyup="searchFilter()"
					></v-text-field>
	    	</v-toolbar>
	 	</v-list>
	 	<!-- <v-list two-line>
          <v-list-tile >
            <v-list-tile-content>
              	Transaction History
            </v-list-tile-content>

            <v-list-tile-content>
              <input type="text" v-model="currentFilterValue" class="form-control input-style" placeholder="Search" @keyup="searchFilter()">
            </v-list-tile-content>

            <v-list-tile-action>
            	<v-btn color="primary" fab small dark>
            		<v-icon>search</v-icon>
            	</v-btn>         
            </v-list-tile-action>
          </v-list-tile>
        </v-list>  -->
 
		 	  <v-list-tile >
            <v-list-tile-content>
         
					<div class="custom-flex">
					<nav class="nav nav-bar-chart">
					  <a class="nav-link nav-time" :class="typeTimeReturn === 'Day' ? 'active' : '' " @click="activeTypeTime('Day')">D</a>
					  <a class="nav-link nav-time" :class="typeTimeReturn === 'Week' ? 'active' : '' " @click="activeTypeTime('Week')">W</a>
					  <a class="nav-link nav-time" :class="typeTimeReturn === 'Month' ? 'active' : '' " @click="activeTypeTime('Month')">M</a>
					  <a class="nav-link nav-time" :class="typeTimeReturn === 'Year' ? 'active' : '' " @click="activeTypeTime('Year')">Y</a>
					</nav>
					<div class="justify-space-between w-30">
						<div class="text-total text-xs-right">
							<h4 class="primary--text mb-0">{{total}}$</h4>
							
						</div>
						</div>			
					</div>
          	</v-list-tile-content>
		 	</v-list-tile>
		 	<v-list two-line>
            <v-list-tile
				v-for="(item, key) in optionLoadView"
				:key="item.id"
				class="style-list"
            >
              <v-list-tile-content>
                <v-list-tile-title v-text="item.title"></v-list-tile-title>
                <v-list-tile-sub-title v-text="item.dated" class="text-style"></v-list-tile-sub-title>
              </v-list-tile-content>
  
              <v-list-tile-action>
                <p class="success--text mb-0" v-if="item.type == true">+{{item.amount}}</p>
                <p class="mb-0" v-if="item.type == false">-{{item.amount}}</p>
              </v-list-tile-action>
            </v-list-tile>

            <v-list-tile>
            	<v-list-tile-content class="btn-style">
            		<app-section-loader :status="reload"></app-section-loader>
					<button type="button" @click="addTenItem(typeTime)" class="btn btn-primary">More (50+) </button>
				</v-list-tile-content>
			</v-list-tile>
        </v-list>

        <v-spacer></v-spacer>
      	<v-card-actions class="w-100 border border-left-0 border-right-0 border-bottom-0 pr-4 bottom-position flex-end">
	      <v-btn @click.stop="drawerRight = !drawerRight">Close</v-btn>
	    </v-card-actions> 
        
 </v-navigation-drawer>
	   			 <!-- end -->
</template>

<script>
import  { get, post, put, del, getWithData } from '../../api/index.js'
import config from '../../config/index.js'
import Vue from 'vue'
import Lodash from 'lodash'
import moment from 'moment'
import AppSectionLoader from "../../components/AppSectionLoader/AppSectionLoader.vue";

export default {

  	name: 'TransactionHistory',
  	components: {
  		AppSectionLoader
  	},

  	data() {
    	return {
    		drawerRight: false,
	      	typeTime:'',
	      	total:0,
	      	company_id:'',
	      	transactionHistories: [
	      	],
	      	option: [],
	      	paginator: {
                perPageDay: 2,
                page: 1,

        	},
        	reload: false,
        	currentFilterValue:'',
        	firstpage: {
        		firstPageDay:1,
        		firstPageWeek:1,
        		firstPageMonth:1,
        		firstPageYear:1,
        	},

        	searchResult: [],

    	}
  	},
  	created(){
		this.typeTime = "Day"
	},

  	mounted () {
  		this.$root.$on('showTransactionStatus', (data) => {
  		
  			this.drawerRight = data.showDrawerRight
  			this.typeTime = "Day"
  			this.reset()
  			this.company_id = data.companyId
  			this.getData(data.companyId, this.paginator.page)
  		})
  	},

  	methods: {


		getData(id, page){

			let url = config.API_URL+'transaction/history'

			let params = {
                perPage: this.paginator.perPageDay,
                companyId: id,
                page: page
            }	
            
			getWithData(url,params)
			.then((res)=>{
				if (res.data && res.data.success) {

					this.transactionHistories = res.data.data
					
					let total_revenue = 0
					let total_expenditure = 0
					let vm = this
					 _.forEach(res.data.data,function(value,key){
					
					 	if(key == "Day") {
					 		vm.option = value.data
					 		_.forEach(value.data,function(v_1,k_1){
						 		if(v_1.type == true) {
				                	total_revenue = total_revenue + parseFloat(v_1.amount)
				                } else {
				                	total_expenditure =total_expenditure + parseFloat(v_1.amount)
				                }
					 		})
					 		vm.total = total_revenue - total_expenditure
					 	}

		               
		             });
				}
			})
			.catch((e) =>{
				console.log(e)
			})

		},

		switchTime(timevalue){
			
			let page = 0;

			switch (timevalue) {
			    case 'Day':
			       		this.firstpage.firstPageDay = this.firstpage.firstPageDay + 1 
			       		page = this.firstpage.firstPageDay
			        break;
			    case 'Week':
			        	this.firstpage.firstPageWeek = this.firstpage.firstPageWeek + 1 
			       		page = this.firstpage.firstPageWeek
			        break;
			    case 'Month':
			       		this.firstpage.firstPageMonth = this.firstpage.firstPageMonth + 1 
			       		page = this.firstpage.firstPageMonth
			        break;
			    case 'Year':
			        	this.firstpage.firstPageYear = this.firstpage.firstPageYear + 1 
			       		page = this.firstpage.firstPageYear
			        break;
			    default:
			        console.log("Something went horribly wrong...")
			}

			return page
		},

  		activeTypeTime(timevalue) {

			this.currentFilterValue = ''
			this.searchResult = []
			this.typeTime = timevalue

			let option

			let total_revenue = 0
			let total_expenditure = 0
			let vm = this

			_.forEach(vm.transactionHistories, function(value, key){
				if(timevalue == key){
					option = value.data
					_.forEach(value.data, function(v_1, k_1){
						if(v_1.type == true) {
		                	total_revenue = total_revenue + parseFloat(v_1.amount)
		                } else {
		                	total_expenditure =total_expenditure + parseFloat(v_1.amount)
		                }
					})
					vm.total = total_revenue - total_expenditure
				}

			})

			this.option = option

		},

		getDataWithTimeValue(value,page){

			let url = config.API_URL+'transaction/history/item'

			let params = {
                perPage: this.paginator.perPageDay,
                companyId: this.company_id,
                page: page,
                time: value
            }	
          
			getWithData(url, params)
			.then((res)=>{
				if (res.data && res.data.success) {

					let resItem = res.data.data.data
					let vm = this

					_.forEach(resItem, function(value,key){

						vm.option.push(value)
					})
							
					var total_revenue = 0
					var total_expenditure = 0
					 _.forEach(vm.option,function(value,key){
		                if(value.type == true) {
		                	total_revenue = total_revenue + parseFloat(value.amount)
		                } else {
		                	total_expenditure =total_expenditure + parseFloat(value.amount)
		                }
		             });
		             vm.total = total_revenue - total_expenditure
					
 
				}
			})
			.catch((e) =>{
				console.log(e)
			})

		},

		addTenItem(timevalue){

			this.currentFilterValue = ''
			this.searchResult = []

			let page = this.switchTime(timevalue)
		
			this.reload = true;
		      let self = this;
		      setTimeout(() => {
		        self.reload = false;
		        self.getDataWithTimeValue(timevalue,page)
		      }, 1500);
			
		},

		stopdrawerRight(){
			this.drawerRight = false
			this.reset()

		},

		searchFilter(){
			var self = this;
	        // Add condition for currentFilterProperty == 'Name'
	    	if(this.currentFilterValue != undefined && this.currentFilterValue != ''){
 
	    		var result = this.option.filter(function(d){
	        		
	        		if(d.title.indexOf(self.currentFilterValue) > -1){
	        			return d
	        		}
	      		})

	      		this.searchResult = result

	      		return this.searchResult

	      	}else{
	      		this.searchResult = []	
	      		return this.option
	      	}  
	    },

	    reset(){
	    	this.firstpage.firstPageDay = 1
			this.firstpage.firstPageWeek = 1
			this.firstpage.firstPageMonth =1
			this.firstpage.firstPageYear = 1
			this.option = []
	    }  	

  	},

  	computed:{
	  	typeTimeReturn(){
	  		return this.typeTime
	  	},

	  	optionLoadView(){

	  		if(this.searchResult && this.searchResult.length){
	  			return this.searchResult
	  		}else{
	      		return this.option
	  		}
	  	}
	},
}
</script>

<style lang="scss" scoped>
.input-style{
	width: 160px ;
}

.nav-bar-chart{
	font-size: 14px;
    font-weight: bold;
    width: 100%;
}

.nav-link {
		color: #6b6d70 !important;
}

.active{
		color: #2196f3 !important;
}
.custom-flex {
	display: flex !important;
    width: 100%;
}
.text-total {
	padding: 7px 15px;
}.style-list {
	border-bottom: 1px solid gray;
    margin: 0px 20px;
}
.text-style {
	font-size: 12px !important;
}
.btn-style {
	align-items: center !important;
}
.text-capitalize{
	font-size:17px !important;
}
.nav-time{
	font-size:18px !important;
}
</style>
