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
			<div class="tab-3">
				<v-card>
		            <v-toolbar color="primary" dark flat dense cad>
		              <v-toolbar-title class="subheading">Top Up Balance</v-toolbar-title>
		              <v-spacer></v-spacer>
		              <v-toolbar-title>$ {{total_ewallet}}</v-toolbar-title>
		            </v-toolbar>
		            <v-divider></v-divider>
		            <v-card-text class="card-style">
		            	<v-container>
        					<v-layout wrap>
        						<v-flex xs12 sm3 class="text-style"> 
        							Credit Card & Debit Card
        						</v-flex>
        						<v-flex xs12 sm9 >
        							<div style="text-align: right;"> 
        								<img src="../../../../public/static/visa_PNG17.png" height="40" width="120">
        							</div>
        						</v-flex>
        					</v-layout>
        				</v-container>
      						
		            	<v-form ref="form1">
		            	<v-container>
      						<v-layout row wrap>
      						<v-flex xs12 sm3 > 
						      <v-select
							      v-validate="'required'"
							      :items="pay"
							      v-model="select"
							      :rules="[rules.required]"
							      label="Select"
							      required
							    ></v-select>
						   </v-flex>
						   <v-flex xs12 sm9 > 
						      <v-text-field
						        label="Amount"
						        name="amount_card"
						        placeholder="Enter Amount"
						        v-model="formBalance.amount_card"
						        :rules="[rules.required, rules.decimal]"
						        prefix="$" 
						        required
						      ></v-text-field>
						   </v-flex>		
      						<v-flex xs12 sm12 > 
						      <v-text-field
						        label="Name on card"
						        name="name_card"
						        placeholder="Enter Your Name"
						        v-model="formBalance.name_card"
						        :rules="[rules.required]"  
						        required
						      ></v-text-field>
						   </v-flex>
						   <v-flex xs12 sm12 >
						       <v-text-field
						        label="Card number"
						        placeholder="####-####-####-####"
						        :rules="[rules.required]"                
						        v-model="formBalance.card_number"
						        mask="credit-card"
						        required
						      ></v-text-field>
						 	</v-flex>
						    <v-flex xs12 sm6 >   
							  <v-text-field
						        label="Expiry date"
						        name="expiry_date"
						        placeholder="MM / YYYY"
						        v-model="formBalance.expiry_date"
						        :rules="[rules.required]"
						        mask="## / ####"  
						        required
						      ></v-text-field>
						    </v-flex>
						    <v-flex xs12 sm6 >   
						      <v-text-field
						        label="Security code"
						        name="security_code"
						        placeholder="CVV2"
						        v-model="formBalance.security_code"
						        :rules="[rules.required]"  
						        required
						      ></v-text-field> 
						    </v-flex> 
						   </v-layout>
						</v-container>
						    
					      <div class="form-btn">
					      	  <v-spacer></v-spacer>
						      <!-- <v-btn @click="submit" dark color="indigo">Submit</v-btn> -->
						     <!--  <v-btn outline @click="clear">Clear</v-btn> -->
						  </div>    
					   </v-form>
		            </v-card-text>
		        </v-card>
			</div>
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
		              <v-form ref="form">				 
					      <v-text-field
					        label="Withdraw Amount"
					        name="amount"
					        placeholder="Enter Amount"
					        v-model="formModel.amount"
					        :rules="[rules.required, rules.decimal]"
					        prefix="$"
					        @blur="checkAmount()"
					        required
					      ></v-text-field>
					       <v-text-field
					        label="Bank Account Number"
					        placeholder="####-####-####-####"
					        :rules="[rules.required]"               
					        v-model="formModel.account_number"
					        mask="credit-card"
					        required
					      ></v-text-field> 
						  <v-text-field
					        label="Bank Name"
					        name="bank_name"
					        placeholder="Enter Your Bank Name"
					        v-model="formModel.bank_name"
					        :rules="[rules.required]"  
					        required
					      ></v-text-field> 
					      <v-text-field
					        label="Account Holder Name"
					        name="account_holder_name"
					        placeholder="Enter Your Bank Account Name"
					        v-model="formModel.account_holder_name"
					        :rules="[rules.required]"  
					        required
					      ></v-text-field>  
					      <v-text-field
					        label="IBAN"
					        name="iban"
					        placeholder="Enter Your IBAN"
					        v-model="formModel.iban"
					        :rules="[rules.required]"
					        required
					      ></v-text-field>  
					      <v-text-field
					        label="SWIFT"
					        name="swift"
					        placeholder="Enter SWIFT Code"
					        v-model="formModel.swift"
					        :rules="[rules.required]"  
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
			    <v-container>
						<v-layout justify-center>
							<table class="table table-striped">
								<tr>
									<td>Account holder name :</td>
									<td>{{ transaction.account_holder_name }}</td>
								</tr>
								<tr>
									<td>Bank account number :</td>
									<td>{{ transaction.bank_account_number }}</td>
								</tr>
								<tr>
									<td>Bank name :</td>
									<td>{{ transaction.bank_name }}</td>
								</tr>
								<tr>
									<td>Amount :</td>
									<td>$ {{ transaction.amount }}</td>
								</tr>
								<tr>
									<td>Swift code :</td>
									<td>{{ transaction.swift_code }}</td>
								</tr>
								<tr>
									<td>Iban :</td>
									<td>{{ transaction.iban }}</td>
								</tr>
								<tr>
									<td>Status :</td>
									<td>
									<v-btn color="btn-gradient-primary" small v-if="transaction.status === 'PENDING'">PENDING</v-btn>
							 		<!-- <v-btn color="btn-gradient-pink" small v-else>Inactive</v-btn> -->
							 		</td>
								</tr>
								<tr>
									<td>Date :</td>
									<td>{{ transaction.created_at }}</td>
								</tr>
							</table>
					</v-layout>
				</v-container>
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
	    formBalance:{},
	    total_ewallet:0,
	    alertStt: false,
    	alertType: 'success',
    	alertMes: '',
    	checkStatus : 0,
    	select: null,
      	pay: ['Visa','Master Card'],
      	transaction:{},
      	rules: {
	        required: value => !!value || 'Required.',
          	number: value => {
	            const abc = /^[0-9]\d*$/
	            return abc.test(value) || 'Please input number.'
          	},
          	decimal: value => {
	            const abc = /^[0-9]\d*(\.\d+)?$/
	            return abc.test(value) || 'Please input number.'
          	},
	    },
    }
  },
  methods:{
  	closeDrawer(){
  		this.$root.$emit('closeDrawerItem', false)
  		this.$refs.form.reset()
        this.$refs.form.resetValidation()
  	},
  	withDraw(){
  		let url = config.API_URL + 'ewallet_withdraw/'+this.user.company_id
  		get(url)
  		.then(res => {
  			if(res.data.data){
  				this.checkStatus = 1
  			} else {
  				this.transaction = res.data.item
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
			  			this.total_ewallet = 0
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
    	if (this.$refs.form.validate()) {
    		let url = config.API_URL + 'ewallet_withdraws'

    	 	let params = {
    	 			item : this.formModel,
    	 			company_id : this.user.company_id,
    	 		}
    	 	console.log(params)
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
	 			console.log(err)
	 		})
    	}	
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
};
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
.card-style {
	padding: 0px !important;
}
.text-style {
	padding-top : 6px;
}
</style>