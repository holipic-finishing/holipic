<template>
<v-card class="position-relative">
	<v-toolbar>
		<v-toolbar-title class="text-xs-center">E WALLET</v-toolbar-title>
		<v-spacer></v-spacer>
		<v-toolbar-title>$ {{total_ewallet}}</v-toolbar-title>
		<v-toolbar-side-icon @click="closeDrawer">
      	<v-icon>
          fas fa-times
        </v-icon>
      	</v-toolbar-side-icon>
    </v-toolbar>
	<v-divider class="mt-0 mb-0"></v-divider>
	<v-card-title primary-title class="style-body">
      	<v-container fluid grid-list-md>
      	<v-layout row wrap>
      		<v-flex xl4 lg4 md4 sm12 xs12 >
      		 	<div class="tab-3">
      		 		<v-card class="style-card-form">
			            <v-toolbar color="primary" dark flat dense cad>
			              <v-toolbar-title class="subheading">Transactions History</v-toolbar-title>
			              <v-spacer></v-spacer>
			              <!-- <v-toolbar-title>$ {{total_ewallet}}</v-toolbar-title> -->
			            </v-toolbar>
			            <v-divider></v-divider>
			            <v-card-text class="card-style">
							<vue-perfect-scrollbar class="scroll-area" :settings="settings" style="height:620px">
								<v-list two-line class="heigth-list-title-style">
									<v-list-tile
										v-for="(item, key) in items"
										:key="item.id"
										class="style-list"
						            >
						              <v-list-tile-content>
						                <v-list-tile-title v-text="item.title" class="style-text" style="font-weight: 700;"></v-list-tile-title>
						                <v-list-tile-sub-title v-text="item.dated" class="text-styl-dated"></v-list-tile-sub-title>
						              </v-list-tile-content>
						  		
						              
						              <v-list-tile-action>
						                <p class="success--text mb-0" v-if="item.status == 'RECIVED'">+{{item.new_amount}}</p>
						                <p class="mb-0" v-else>-{{item.new_amount}}</p>
						              </v-list-tile-action>
						            </v-list-tile>

					        	</v-list>
								<!--No data -->
								<template slot="no-data">
							      <v-alert :value="true" color="error" icon="warning">
							        Sorry, nothing to display here :(
							      </v-alert>
					    		</template>
								</v-data-table>
							</vue-perfect-scrollbar>
						</v-card-text>
					</v-card>
				</div>
      		</v-flex>
      		<v-flex xl4 lg4 md4 sm12 xs12>
      		 	<div class="tab-3">
					<v-card class="style-card-form">
			            <v-toolbar color="primary" dark flat dense cad>
			              <v-toolbar-title class="subheading">Top Up Balance</v-toolbar-title>
			              <v-spacer></v-spacer>
			              <v-toolbar-title>$ {{total_ewallet}}</v-toolbar-title>
			            </v-toolbar>
			            <v-divider></v-divider>
			            <v-card-text>
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
	        				<v-container fluid>
	        					<v-radio-group v-model="radios">
							      <div slot="label"><strong>USE YOUR SAVED ACCOUNTS</strong></div>
							      <v-radio value="visa">
							        <div slot="label">
							        	<img src="../../../../public/static/Visa-icon.png" height="50" width="50">
							        </div>
							      </v-radio>
							      <v-radio value="new_credit">
							        <div slot="label"><strong>Use new credit card</strong></div>
							      </v-radio>
							    </v-radio-group>
	        				</v-container>
	      						
			            	<v-form ref="form1">
			            		<v-list class="heigth-list-title">
						           <v-list-tile class="height-70">
										<v-list-tile-content>
								            <v-list-tile-title class="content-flex-end h-100">
									          	<span class="font-weight-bold item-title position-item ">Amount</span>
									          	<span class="contain-text-field">
									          		<v-text-field
									          			class="text-field-padding"
										            	solo
										            	name="amount_card"
												        placeholder="Amount"
												        v-model="formBalance.amount_card"
												        :rules="[rules.required, rules.decimal]"
												        prefix="$" 
												        required
										            >  
										        	</v-text-field>
										        </span>
							            	</v-list-tile-title>
										</v-list-tile-content>
								   </v-list-tile>

								   <v-list-tile class="height-70">
										<v-list-tile-content>
								            <v-list-tile-title class="content-flex-end h-100">
									          	<span class="font-weight-bold item-title position-item">Name on card</span>
									          	<span class="contain-text-field">
									          		<v-text-field
									          			class="text-field-padding"
										            	solo
										            	name="name_card"
												        placeholder="Your Name"
												        v-model="formBalance.name_card"
												        :rules="[rules.required]"  
												        required
										            >  
										        	</v-text-field>
										        </span>
							            	</v-list-tile-title>
										</v-list-tile-content>
								   </v-list-tile>

								   <v-list-tile class="height-70">
										<v-list-tile-content>
								            <v-list-tile-title class="content-flex-end h-100">
									          	<span class="font-weight-bold item-title position-item">Card number</span>
									          	<span class="contain-text-field">
									          		<v-text-field
									          			class="text-field-padding"
										            	solo
												        placeholder="####-####-####-####"
												        :rules="[rules.required]"                
												        v-model="formBalance.card_number"
												        mask="credit-card"
												        required
										            >  
										        	</v-text-field>
										        </span>
							            	</v-list-tile-title>
										</v-list-tile-content>
								   </v-list-tile>

								   <v-list-tile class="height-70">
										<v-list-tile-content>
								            <v-list-tile-title class="content-flex-end h-100">
									          	<span class="font-weight-bold item-title position-item">Expiry date</span>
									          	<span class="contain-text-field">
									          		<v-text-field
									          			class="text-field-padding"
										            	solo
												        name="expiry_date"
												        placeholder="MM / YYYY"
												        v-model="formBalance.expiry_date"
												        :rules="[rules.required]"
												        mask="## / ####"  
												        required
										            >  
										        	</v-text-field>
										        </span>
							            	</v-list-tile-title>
										</v-list-tile-content>
								   </v-list-tile>

								   <v-list-tile class="height-70">
										<v-list-tile-content>
								            <v-list-tile-title class="content-flex-end h-100">
									          	<span class="font-weight-bold item-title position-item">Security code</span>
									          	<span class="contain-text-field">
									          		<v-text-field
									          			class="text-field-padding"
										            	solo
												        name="security_code"
												        placeholder="CVV2"
												        v-model="formBalance.security_code"
												        :rules="[rules.required]"  
												        required
										            >  
										        	</v-text-field>
										        </span>
							            	</v-list-tile-title>
										</v-list-tile-content>
								   </v-list-tile>
								</v-list>								    
						      <div class="form-btn">
						      	  <v-spacer></v-spacer>
							      <v-btn  dark color="indigo">Submit</v-btn>
							     <!--  <v-btn outline @click="clear">Clear</v-btn> -->
							  </div>    
						   </v-form>
			            </v-card-text>
			        </v-card>
				</div>
      		</v-flex>
      		<v-flex xl4 lg4 md4 sm12 xs12>
				<v-alert  v-model="alertStt" :type="alertType" dismissible>{{ alertMes }}</v-alert>
				<div class="tab-3" v-if="total_ewallet > 0 && checkStatus == 1">
					<v-card class="style-card-form">
			            <v-toolbar color="primary" dark flat dense cad>
			              <v-toolbar-title class="subheading">Withdraw Via Bank Form</v-toolbar-title>
			              <v-spacer></v-spacer>
			              <v-toolbar-title>$ {{total_ewallet}}</v-toolbar-title>
			            </v-toolbar>
			            <v-divider></v-divider>
			            <v-card-text>
			              <v-form ref="form">
			           
	      					<v-list class="heigth-list-title">
					           <v-list-tile class="height-70">
									<v-list-tile-content>
							            <v-list-tile-title class="content-flex-end h-100">
								          	<span class="font-weight-bold item-title position-item" >Payment Method</span>
								          	<span class="contain-text-field">
								          		<v-text-field
								          			class="text-field-padding"
									            	solo
									            	value="Bank Transfer"
													readonly
									            >  
									        	</v-text-field>
									        </span>
						            	</v-list-tile-title>
									</v-list-tile-content>
							   </v-list-tile>

							   <v-list-tile class="height-70">
									<v-list-tile-content>
							            <v-list-tile-title class="content-flex-end h-100">
								          	<span class="font-weight-bold item-title position-item">Withdraw Amount</span>
								          	<span class="contain-text-field">
								          		<v-text-field
								          		solo
								          		class="text-field-padding"
										        name="amount"
										        v-model="formModel.amount"
										        :rules="[rules.required, rules.decimal]"
										        prefix="$"
										        @blur="checkAmount()"
										        required	
									            >  
									        	</v-text-field>
									        </span>
						            	</v-list-tile-title>
									</v-list-tile-content>
							   </v-list-tile>

							   <v-list-tile class="height-70">
									<v-list-tile-content>
							            <v-list-tile-title class="content-flex-end h-100">
								          	<span class="font-weight-bold item-title position-item">Withdraw Fee</span>
								          	<span class="contain-text-field">
								          		<v-text-field
								          		solo
								          		class="text-field-padding"
								          		readonly	
									            >  
									        	</v-text-field>
									        </span>
						            	</v-list-tile-title>
									</v-list-tile-content>
							   </v-list-tile>

							   <v-list-tile class="height-70">
									<v-list-tile-content>
							            <v-list-tile-title class="content-flex-end h-100">
								          	<span class="font-weight-bold item-title position-item">Account No</span>
								          	<span class="contain-text-field">
								          		<v-text-field
								          		solo
								          		class="text-field-padding"
								          		placeholder="####-####-####-####"
									        	:rules="[rules.required]"               
									        	v-model="formModel.account_number"
									        	mask="credit-card"
									        	required	
									            >  
									        	</v-text-field>
									        </span>
						            	</v-list-tile-title>
									</v-list-tile-content>
							   </v-list-tile>

							   <v-list-tile class="height-70">
									<v-list-tile-content>
							            <v-list-tile-title class="content-flex-end h-100">
								          	<span class="font-weight-bold item-title position-item">Bank Name</span>
								          	<span class="contain-text-field">
								          		<v-text-field
								          		solo
								          		class="text-field-padding"
								          		name="bank_name"
										        placeholder="Your Bank Name"
										        v-model="formModel.bank_name"
										        :rules="[rules.required]"  
										        required	
									            >  
									        	</v-text-field>
									        </span>
						            	</v-list-tile-title>
									</v-list-tile-content>
							   </v-list-tile>

							   <v-list-tile class="height-70">
									<v-list-tile-content>
							            <v-list-tile-title class="content-flex-end h-100">
								          	<span class="font-weight-bold item-title position-item">Acc.Holder Name</span>
								          	<span class="contain-text-field">
								          		<v-text-field
								          		solo
								          		class="text-field-padding"
								          		name="account_holder_name"
										        placeholder="Your Bank Account Name"
										        v-model="formModel.account_holder_name"
										        :rules="[rules.required]"  
										        required	
									            >  
									        	</v-text-field>
									        </span>
						            	</v-list-tile-title>
									</v-list-tile-content>
							   </v-list-tile>

							   <v-list-tile class="height-70">
									<v-list-tile-content>
							            <v-list-tile-title class="content-flex-end h-100">
								          	<span class="font-weight-bold item-title position-item">IBAN</span>
								          	<span class="contain-text-field">
								          		<v-text-field
								          		solo
								          		class="text-field-padding"
								          		name="iban"
										        placeholder="Your IBAN"
										        v-model="formModel.iban"
										        :rules="[rules.required]"
										        required	
									            >  
									        	</v-text-field>
									        </span>
						            	</v-list-tile-title>
									</v-list-tile-content>
							   </v-list-tile>

							   <v-list-tile class="height-70">
									<v-list-tile-content>
							            <v-list-tile-title class="content-flex-end h-100">
								          	<span class="font-weight-bold item-title position-item">SWIFT</span>
								          	<span class="contain-text-field">
								          		<v-text-field
								          		solo
								          		class="text-field-padding"
								          		name="swift"
										        placeholder="SWIFT Code"
										        v-model="formModel.swift"
										        :rules="[rules.required]"  
										        required	
									            >  
									        	</v-text-field>
									        </span>
						            	</v-list-tile-title>
									</v-list-tile-content>
							   </v-list-tile>
				    		</v-list>
						        
						    <div class="form-btn">
						        <v-spacer></v-spacer>
							    <v-btn @click="submit" dark color="indigo">Submit</v-btn>
							      <!-- <v-btn outline @click="clear">Clear</v-btn> -->
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
      		</v-flex>		
		</v-layout>
		</v-container>	
	</v-card-title>
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
		user:JSON.parse(localStorage.getItem('user')),
		items:[],
		settings: {
	        maxScrollbarLength: 160
	    },
	    formModel:{},
	    formBalance:{},
	    total_ewallet:100,
	    alertStt: false,
    	alertType: 'success',
    	alertMes: '',
    	checkStatus : 1,
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
	    radios: 'new_credit',
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
    	if(amount < 30)  {
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
  	if(this.user.role_id == 2){
	  	this.fetchData()
	  	this.callWallet()
	  	this.withDraw()
  	}
  },
  computed:{
	  	optionLoadView(){
	  		return this.items
	  	}
	},
};
</script>

<style lang="css" scoped>

@media screen and (max-width: 1150px) {
    .position-item{
		font-size: 13px;
	}
	.v-input {
		font-size: 13px;
	}
}

@media screen and (min-width: 960px) {
    .form-btn {
    	height: 15px;
	}
	.form-btn button {
		position: absolute;
	    bottom: 10px;
    	right: 26px;
	}
}

@media screen and (max-width: 360px) {
    .position-item{
		font-size: 12.5px;
	}
	.style-text {
		font-size: 14px;
	}
	.text-styl-dated {
    	font-size: 12px;
	}
}


.mr-3 {
	margin-left: 16px !important;
}
.table-component {
	margin: 15px;
}
.tab-3 {
    margin: 10px 0px;
}
.form-btn {
	text-align: right;	
}
.tab-4 {

	 margin: 15px auto;
}
.card-style {
	padding: 0px !important;
	/*height: 600px;*/
}
.text-style {
	padding-top : 6px;
}
.text-styl-dated{
	padding-top: 0px;
    font-size: 14px;
}
.heigth-list-title-style {
	overflow: auto;
	flex:1 1 auto;
}
.style-list {
	border-bottom: 1px solid #80808042;
    margin: 5px 0px;
}
.borderless td, .borderless th {
    border: none;
}
.style-body {
	padding-top: 5px;
}
.content-flex-end {
    display: flex;
    justify-content: start;
    align-items: baseline;
    padding-top: 6px;
    position: relative;
}
.text-field-padding {
	padding-left: 30px;
	padding-right: 1px; 
}
.position-item{
	top: 0px !important;
}
.container {
	padding: 10px !important;
}	
.v-input--selection-controls {
	margin-top:0px !important;
}
.style-card-form {
	height: 100%  !important;
}
</style>