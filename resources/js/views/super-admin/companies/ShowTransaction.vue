<template>
	<v-navigation-drawer
      fixed
      v-model="drawerRight"
      right
      app
	  this.width = this.getCurrentWithContentWrap()
      :width='widthComputed'
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
					@keyup.enter="searchFilter(typeTime)"
					></v-text-field>
	    	</v-toolbar>
	 	</v-list>
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
								<h4 class="primary--text mb-0">{{ (!searchResult.length && on_search ==1) ? 0 : total}}$</h4>
							</div>
						</div>
					</div>
          	</v-list-tile-content>
		</v-list-tile>
		<v-list two-line class="heigth-list-title-style">
            <v-list-tile
				v-for="(item, key) in optionLoadView"
				:key="item.id"
				class="style-list"
            >
              <v-list-tile-content >
                <v-list-tile-title v-text="item.title"></v-list-tile-title>
                <v-list-tile-sub-title v-text="item.dated" class="text-style"></v-list-tile-sub-title>
              </v-list-tile-content>

  			  <v-list-tile-action class="content-list">
              	 <p>&nbsp;</p>
              </v-list-tile-action>

              <v-list-tile-action>
                <p class="success--text mb-0" v-if="item.status == 'RECIVED'">+{{item.new_amount}}</p>
                <p class="mb-0" v-else>-{{item.new_amount}}</p>
              </v-list-tile-action>
            </v-list-tile>

            <v-list-tile v-if="optionLoadView && optionLoadView.length">
            	<v-list-tile-content class="btn-style">
            		<app-section-loader :status="reload"></app-section-loader>
            		<div v-if=" check == 0 ">
						<button type="button" @click="addTenItem(typeTime)" class="btn btn-primary">More... </button>
					</div>
				</v-list-tile-content>
			</v-list-tile>
        </v-list>

 </v-navigation-drawer>
	   			 <!-- end -->
</template>

<script>
import  { get, post, put, del, getWithData } from '../../../api/index.js'
import config from '../../../config/index.js'
import Vue from 'vue'
import Lodash from 'lodash'
import moment from 'moment'
import AppSectionLoader from "../../../components/AppSectionLoader/AppSectionLoader.vue";
import { getWithContentWrap } from '../../../helpers/helpers'

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
                perPageDay: 7,
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

        	first_page_search: {
        		searchPageDay:0,
        		searchPageWeek:0,
        		searchPageMonth:0,
        		searchPageYear:0,
        	},

        	total : {
        		day:0,
        		week:0,
        		month:0,
        		year:0
        	},
        	searchResult: [],
        	user_id:'',
        	search:'',
        	on_search:0,
        	check : 0,
        	width: 0,
      		drawerHeaderStt: null

    	}
  	},

  	created(){
		this.typeTime = "Year"
	},

  	mounted () {
  		this.$root.$on('showTransactionStatus', (data) => {
  			this.drawerRight = data.showDrawerRight
  			this.typeTime = "Day"
  			this.reset()
  			this.resetPageSreach()
  			this.company_id = data.companyId
  			this.user_id = data.userId
  			this.makeParams()
  			this.getData(data.userId, this.paginator.page, this.search)
  			this.width = this.getCurrentWithContentWrap()
  		})

  		this.$root.$on('drawer-status', res => {
  				this.drawerHeaderStt = res
  		})
  	},

  	methods: {
  		getCurrentWithContentWrap(){
  				return getWithContentWrap(this.drawerHeaderStt)
  		},
		getData(id, page, search){

			let url = config.API_URL + 'company/history-transactions'

			let params = {
                perPage: this.paginator.perPageDay,
                userId: id,
                page: page,
                search:search
            }

			getWithData(url,params)
			.then((res)=>{
				if (res.data && res.data.success) {

					this.transactionHistories = res.data.data

					let vm = this


					 _.forEach(res.data.data,function(value,key){

					 	if(key == "Day") {

							vm.check = 0
							vm.invisibleButtonLoadMore(value)

					 		vm.option = value.data
					 		vm.totalAmount(vm.option)
					 	}
		             });
				}
			})
			.catch((e) =>{
				console.log(e)
			})

		},

		switchTime(timevalue){

			switch (timevalue) {
			    case 'Day':
			    		if(this.currentFilterValue == ''){
			      	 		this.firstpage.firstPageDay = this.firstpage.firstPageDay + 1
			       			return this.firstpage.firstPageDay
			    		} else {
			    			this.first_page_search.searchPageDay = this.first_page_search.searchPageDay + 1
			    			return this.first_page_search.searchPageDay
			    		}
			        break;
			    case 'Week':
			    		if(this.currentFilterValue==''){
				        	this.firstpage.firstPageWeek = this.firstpage.firstPageWeek + 1
				       		return this.firstpage.firstPageWeek
			    		} else {
			    			this.first_page_search.searchPageWeek = this.first_page_search.searchPageWeek + 1
			    			return this.first_page_search.searchPageWeek
			    		}
			        break;
			    case 'Month':
			    		if(this.currentFilterValue==''){
				       		this.firstpage.firstPageMonth = this.firstpage.firstPageMonth + 1
				       		return this.firstpage.firstPageMonth
			    		} else {
							this.first_page_search.searchPageMonth = this.first_page_search.searchPageMonth + 1
			    			return this.first_page_search.searchPageMonth
			    		}
			        break;
			    case 'Year':
			    		if(this.currentFilterValue==''){
				        	this.firstpage.firstPageYear = this.firstpage.firstPageYear + 1
				       		return this.firstpage.firstPageYear
			    		} else {
			    			this.first_page_search.searchPageYear = this.first_page_search.searchPageYear + 1
			    			return this.first_page_search.searchPageYear
			    		}
			        break;
			    default:
			        console.log("Something went horribly wrong...")
			}
		},

  		activeTypeTime(timevalue) {

  			this.resetPageSreach()
			this.typeTime = timevalue

			let option

			let vm = this

			_.forEach(vm.transactionHistories, function(value, key){
				if(timevalue == key){
					vm.check = 0
					vm.invisibleButtonLoadMore(value)
					option = value.data
					vm.totalAmount(value.data)
				}

			})

			this.option = option
		},

		getDataWithTimeValue(value,page,search){

			let url = config.API_URL + 'company/history-transactions/filter'

			let params = {
                perPage: this.paginator.perPageDay,
                userId: this.user_id,
                search:search,
                page: page,
                time: value
            }

			getWithData(url, params)
			.then((res)=>{
				if (res.data && res.data.success) {

					let resItem = res.data.data.data
					let vm = this

					this.check = 0
					vm.invisibleButtonLoadMore(res.data.data)

					if(res.data.data.total == 0){
						this.check = 1
						this.searchResult = []
					}

					if(this.currentFilterValue !==''){
						this.on_search = 1
						if(resItem.length) {
							_.forEach(resItem, function(value,key){

								vm.searchResult.push(value)
							})

							vm.totalAmount(vm.searchResult)

				        } else {
				        	this.on_search = 1
				        }

					} else {

						_.forEach(resItem, function(value,key){

							vm.option.push(value)
						})

						vm.totalAmount(vm.option)
					}
				}
			})
			.catch((e) =>{
				console.log(e)
			})

		},

		addTenItem(timevalue){
			this.makeParams()
			if(this.currentFilterValue !==''){
				this.searchFilter(timevalue)
			}
			else {
				let page = this.switchTime(timevalue)
				this.reload = true;
			      let self = this;
			      setTimeout(() => {
			        self.reload = false;
			        self.getDataWithTimeValue(timevalue,page,this.search)
			      }, 1500);
			}
		},

		stopdrawerRight(){
			this.drawerRight = false
			this.reset()
			this.resetPageSreach()
		},

		makeParams(){

			let searchValues = []
			var setsearch = ''
			if(_.trim(this.currentFilterValue)){
                searchValues.push('title:' + this.currentFilterValue)
            }

			this.search = searchValues.join(";")
		},

		searchFilter(timevalue){

           	this.makeParams()
            if(this.currentFilterValue ==''){
            	this.resetPageSreach()
            }
            else {
            	this.on_search = 1;
	            let page = this.switchTime(timevalue)
	            this.getDataWithTimeValue(timevalue,page,this.search)
            }

	    },

	    reset(){
	    	this.firstpage.firstPageDay = 1
			this.firstpage.firstPageWeek = 1
			this.firstpage.firstPageMonth =1
			this.firstpage.firstPageYear = 1
			this.option = []
			this.total = 0.00

	    },

	    resetPageSreach(){
	    	this.first_page_search.searchPageDay = 0
	    	this.first_page_search.searchPageWeek = 0
	    	this.first_page_search.searchPageMonth = 0
	    	this.first_page_search.searchPageYear = 0
	    	this.searchResult = []
	    	this.currentFilterValue = ''
	    	this.on_search = 0;
	    },

	    totalAmount(data){
	    	var total_revenue = 0
			var total_expenditure = 0
	    	_.forEach(data, function(v_1, k_1){
				if(v_1.status == 'RECIVED') {
					var new_amount = parseFloat(v_1.amount * v_1.transactionexchange.exchange_rate_to_dollar).toFixed(3)

                	total_revenue = total_revenue + parseFloat(new_amount)

                	data[k_1]['new_amount'] = new_amount
                } else {
                	var new_amount = parseFloat(v_1.amount * v_1.transactionexchange.exchange_rate_to_dollar).toFixed(3)
                	total_expenditure =total_expenditure + parseFloat(new_amount)

                	data[k_1]['new_amount'] = new_amount
                }
			})
			this.total = (total_revenue - total_expenditure).toFixed(3)
	    },

	    invisibleButtonLoadMore(value){
	    	if(value.to == value.total){
	    		this.check = 1
	    	}
	    }

  	},

  	computed:{
	  	typeTimeReturn(){
	  		return this.typeTime
	  	},

	  	optionLoadView(){
	  		if(this.on_search == 1){
	  			return this.searchResult
	  		} else {
	  			return this.option
	  		}
	  	},
	  	widthComputed(){
  			return this.width
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
    width: 60%;
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
	padding: 12px 15px;
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
.w-30 {
	width: 40%  !important;
}
.content-list {
	 min-width: 30px !important;
}
.heigth-list-title-style {
	overflow: auto;
	flex:1 1 auto;
}
</style>
