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
			<div class="table-component">
				<vue-perfect-scrollbar class="scroll-area" :settings="settings">
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
			</div>
			
		</v-tab-item>
		<v-tab-item>
			<div>123123111111111123</div>
		</v-tab-item>
		<v-tab-item>
			<v-alert  v-model="alertStt" :type="alertType" dismissible>{{ alertMes }}</v-alert>
			<div class="tab-3" v-if="total_ewallet > 0 && checkStatus == 1">
				<v-card>
		            <v-toolbar color="primary" dark flat dense cad>
		              <v-toolbar-title class="subheading">Withdraw Via Bank Form</v-toolbar-title>
		              <v-spacer></v-spacer>
		              <v-toolbar-title>$ {{total_ewallet}}</v-toolbar-title>
		            </v-toolbar>
		            <v-divider></v-divider>
		            <v-card-text class="">
		              <v-form v-model="valid" >				 
					      <v-text-field
					        label="Withdraw Amount"
					        name="amount"
					        placeholder="Enter Amount"
					        v-model="formModel.amount"
					        v-validate="'required|decimal:5'"
					        data-vv-name="amount"     
					        :error-messages="errors.collect('amount')"  
					        prefix="$"
					        @blur="checkAmount()"
					        required
					      ></v-text-field>
					       <v-text-field
					        label="Bank Account Number"
					        placeholder="####-####-####-####"
					        v-validate="'required'"
					        data-vv-name="account_number"     
					        :error-messages="errors.collect('account_number')"                
					        v-model="formModel.account_number"
					        mask="credit-card"
					        required
					      ></v-text-field> 
						  <v-text-field
					        label="Bank Name"
					        name="bank_name"
					        placeholder="Enter Your Bank Name"
					        v-model="formModel.bank_name"
					        v-validate="'required'"
					        data-vv-name="bank_name"     
					        :error-messages="errors.collect('bank_name')"  
					        required
					      ></v-text-field> 
					      <v-text-field
					        label="Account Holder Name"
					        name="account_holder_name"
					        placeholder="Enter Your Bank Account Name"
					        v-model="formModel.account_holder_name"
					        v-validate="'required'"
					        data-vv-name="account_holder_name"     
					        :error-messages="errors.collect('account_holder_name')"  
					        required
					      ></v-text-field>  
					      <v-text-field
					        label="IBAN"
					        name="iban"
					        placeholder="Enter Your IBAN"
					        v-model="formModel.iban"
					        v-validate="'required'"
					        data-vv-name="iban"     
					        :error-messages="errors.collect('iban')"
					        required
					      ></v-text-field>  
					      <v-text-field
					        label="SWIFT"
					        name="swift"
					        placeholder="Enter SWIFT Code"
					        v-model="formModel.swift"
					        v-validate="'required'"
					        data-vv-name="swift"     
					        :error-messages="errors.collect('swift')"  
					        required
					      ></v-text-field>
					      <div class="form-btn">
					      	  <v-spacer></v-spacer>
						      <v-btn @click="submit" dark color="indigo">Submit</v-btn>
						     <!--  <v-btn outline @click="clear">Clear</v-btn> -->
						  </div>    
					   </v-form>   
		            </v-card-text>       
          		</v-card>
			</div>
			<div class="tab-4" v-else-if="checkStatus == 0">
				<v-alert
			      :value="true"
			      type="warning"
			    >
			      Requesting processing cannot send additional requests	.
			    </v-alert>
			</div>
			<div class="tab-4" v-else>
				<v-alert
			      :value="true"
			      type="warning"
			    >
			      You do not have enough balance to execute the transaction.
			    </v-alert>
			</div>
		</v-tab-item>
	</v-tabs>
	 <v-card-actions class="w-100 border border-left-0 border-right-0 border-bottom-0 pr-4 bottom-position flex-end">
      	<v-btn @click="closeDrawer">Close</v-btn>
    </v-card-actions>
</v-card>
</template>

<script>
import { getWithData, put, get, post } from '../../api/index.js'
import config from '../../config/index.js'
export default {

  name: 'EWallet',

  data () {
    return {
  		headers: [	        
			{ text: 'Title', value: 'title' },
			{ text: 'Date', value: 'dated'},	
			{ text: 'Into Money', value: 'new_amount' },	
		],
		pagination: {
			rowsPerPage: 10	  	
		},
		rowsPerPageItems: [25, 50, 100, { "text": "$vuetify.dataIterator.rowsPerPageAll", "value": -1 }],
		user:JSON.parse(localStorage.getItem('user')),
		items:[],
		settings: {
	        maxScrollbarLength: 160
	    },
	    formModel:{},
	    valid: true,
	    total_ewallet:0,
	    alertStt: false,
    	alertType: 'success',
    	alertMes: '',
    	checkStatus : 0
    }
  },
  methods:{
  	closeDrawer(){
  		this.$root.$emit('closeDrawerItem', false)
  		this.formModel = {};
        this.$validator.reset();
  	},
  	withDraw(){
  		let url = config.API_URL + 'ewallet_withdraw/'+this.user.company_id
  		get(url)
  		.then(res => {
  			if(res.data.data){
  				this.checkStatus = 1
  			} else {
  				this.checkStatus = 0
  			}
  		})
  		.catch(err => {
  			console.log(err)
  		})
  	},
  	fetchData(){
  		let url = config.API_URL + 'e-wallet/transaction-history'
			let params = {
				company_id : this.user.company_id,
				user_id : this.user.id
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
  	callWallet(){
  		let url = config.API_URL + 'e-wallet/total-ewallet'
			let params = {
				company_id : this.user.company_id,
				user_id : this.user.id
			}
			getWithData(url,params)
			.then(res => {
				if(res.data){
					let data = res.data
					this.total_ewallet = data.toFixed(3)

					if(this.total_ewallet <= 0) {
			  			this.$root.$emit('ewallet', 0)
			  		} else {
			  			this.$root.$emit('ewallet',this.total_ewallet)
			  		}
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
    submit(){
    	 this.$validator.validateAll().then((result) => {
    	 	if(result){
    	 		let url = config.API_URL + 'ewallet_withdraws'

    	 		let params = {
    	 			item : this.formModel,
    	 			company_id : this.user.company_id,
    	 		}

    	 		post(url,params)
    	 		.then(res => {
    	 			if(res.data && res.data.success){
    	 				this.alertStt = true
			          	this.alertType = 'success'
			          	this.alertMes = 'Create Successfully'					
			          	setTimeout(() => {
			            	this.alertStt = false
			            	this.withDraw()
						}, 1500)

    	 			}
    	 		})
    	 		.catch(err =>{

    	 		})
    	 	}
    	 });
    },
    checkAmount(){
    	var amount = (this.total_ewallet - this.formModel.amount)
    	if(amount < 0)  {
    		this.alertStt = true
          	this.alertType = 'error'
          	this.alertMes = 'The balance is not enough to make the transaction'					
          	setTimeout(() => {
            	this.alertStt = false
			}, 2000)
			this.formModel.amount = ""
    	}
    }
  },
  created(){
  	this.fetchData()
  	this.callWallet()
  	this.withDraw()
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
.table-component {
	margin: 15px;
}
.tab-3 {
    width: 65%;
    margin: 15px auto;
}
.form-btn {
	text-align: right;
}
.tab-4 {
	width: 50%;
	 margin: 15px auto;
}
</style>