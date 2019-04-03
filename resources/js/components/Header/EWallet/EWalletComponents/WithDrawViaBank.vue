<template>
	<v-card class="custom-card-ewth">
		<v-list two-line>
			<v-list-tile ripple>
				<v-list-tile-content>
			      	<v-list-tile-title>
			        	<v-icon class="custome-icon body-2">far fa-eye</v-icon>
			      	</v-list-tile-title>
			        <v-list-tile-sub-title>
			      		Balance in the wallet
			        </v-list-tile-sub-title>
	      		</v-list-tile-content>

	      		<v-list-tile-action>
		      		<v-list-tile-action-text class="blue-grey--text darken-4 subheading font-weight-bold">$ {{total_ewallet}}</v-list-tile-action-text>
	    		</v-list-tile-action>
			</v-list-tile>
		</v-list>
  		<v-divider></v-divider>
  	<template v-if="total_ewallet > 0 && checkStatus == 1">
	    <v-form ref="form" v-model="form" class="pr-3 pl-3">
			<v-text-field
				v-model="formWithdraw.bank_method"
				readonly
      		></v-text-field>

	  		<v-text-field
	  			type="number"
		        label="Withdraw Amount"
		        v-model="formWithdraw.amount"
		        :rules="[rules.required, rules.decimal]"
		        prepend-icon="fas fa-dollar-sign"
		        class="icon-fs-20"
	      	></v-text-field>

			<v-text-field
				type="number"
				label="Withdraw Fee"
				v-model="formWithdraw.withdrawFee"
				:rules="[rules.required, rules.decimal]"
				prepend-icon="fas fa-dollar-sign"
				class="icon-fs-20"
			></v-text-field>

	  		<v-text-field
		      	type="text"
		        label="Your Bank Name"
		        v-model="formWithdraw.bank_name"
		        :rules="[rules.required, rules.fullname]"
		        class="text-capitalize"
	      	></v-text-field>

	      	<v-text-field
		      	type="text"
		        label="Your Bank Account Name"
		        v-model="formWithdraw.account_holder_name"
		        :rules="[rules.required, rules.fullname]"
		        class="text-capitalize"
	      	></v-text-field>

	  		<v-text-field
		        label="Card Number"
		        :rules="[rules.required]"
		        v-model="formWithdraw.account_number"
		        mask="#### #### #### ####"
		        required
	      	></v-text-field>

	  		<v-text-field
		        label="IBAN"
		        v-model="formWithdraw.iban"
		        :rules="[rules.required]"
		        mask="AA ## AAAA ###### ########"
		        required
	      	></v-text-field>

	  		<v-text-field
		        label="SWIFT Code"
		        v-model="formWithdraw.swift"
		        :rules="[rules.required]"
		        mask="AAAAAAAA"
	      	></v-text-field>
	   	</v-form>
	   	<v-divider></v-divider>
	   	<v-card-actions>
	      <v-spacer></v-spacer>
	      <v-btn
	        flat
	        @click="reset"
	        color="blue-grey"
	        class="white--text"
	      >
	        Clear
	      </v-btn>
	      <v-btn
	        :disabled="!form"
	        :loading="isLoading"
	        class="white--text"
	        color="success"
	        depressed
	        @click="submit"
	      >Save</v-btn>
	    </v-card-actions>
  	</template>
  	<template v-else-if="total_ewallet > 0 && checkStatus == 0">
  		<v-list>
			<v-list-tile id="heigth-list-title">
				<v-list-tile-content>
					<v-alert type="warning" :value="true">
	        			Requesting processing cannot send additional requests.
					</v-alert>
				</v-list-tile-content>
        	</v-list-tile>
        	<v-divider></v-divider>

  		  	<v-list-tile>
          		<v-list-tile-content>
		            <v-list-tile-title>
		            	Account holder name
		            </v-list-tile-title>
          		</v-list-tile-content>
	          	<v-list-tile-action>
		            <v-list-tile-action-text class="body-2">
		            	{{ transaction.account_holder_name }}
		          	</v-list-tile-action-text>
	          	</v-list-tile-action>
	        </v-list-tile>
	        <v-divider></v-divider>

	        <v-list-tile>
				<v-list-tile-content>
					<v-list-tile-title>
						Bank account number
					</v-list-tile-title>
				</v-list-tile-content>
				<v-list-tile-action>
					<v-list-tile-action-text class="body-2">
				  		{{ transaction.bank_account_number }}
					</v-list-tile-action-text>
				</v-list-tile-action>
	        </v-list-tile>
	        <v-divider></v-divider>

			<v-list-tile>
				<v-list-tile-content>
					<v-list-tile-title>
						Bank name
						<v-spacer></v-spacer>
					</v-list-tile-title>
				</v-list-tile-content>
				<v-list-tile-action>
					<v-list-tile-action-text class="body-2">
						{{ transaction.bank_name }}
					</v-list-tile-action-text>
				</v-list-tile-action>
			</v-list-tile>
			<v-divider></v-divider>

	        <v-list-tile>
				<v-list-tile-content>
					<v-list-tile-title>
						Amount
					</v-list-tile-title>
				</v-list-tile-content>
				<v-list-tile-action>
					<v-list-tile-action-text class="warning--text body-2">
						$ {{ transaction.amount }}
					</v-list-tile-action-text>
				</v-list-tile-action>
	        </v-list-tile>
	        <v-divider></v-divider>

	        <v-list-tile>
				<v-list-tile-content>
					<v-list-tile-title>
						Swift code
					</v-list-tile-title>
				</v-list-tile-content>
	          	<v-list-tile-action>
		          	<v-list-tile-action-text class="body-2">
		            	{{ transaction.swift_code }}
		          	</v-list-tile-action-text>
	          	</v-list-tile-action>
	        </v-list-tile>
	        <v-divider></v-divider>

	        <v-list-tile>
	          	<v-list-tile-content>
		            <v-list-tile-title>
		            	Iban
		            </v-list-tile-title>
	          	</v-list-tile-content>
		        <v-list-tile-action>
		          	<v-list-tile-action-text class="body-2">
		            	{{ transaction.iban }}
		          	</v-list-tile-action-text>
				</v-list-tile-action>
	        </v-list-tile>
	        <v-divider></v-divider>

	        <v-list-tile>
	          	<v-list-tile-content>
	            	<v-list-tile-title>
		            	Status
						<v-spacer></v-spacer>
	            	</v-list-tile-title>
	          	</v-list-tile-content>
	          	<v-list-tile-action>
	          		<v-list-tile-action-text class="body-2">
	            		{{ transaction.status }}
	          		</v-list-tile-action-text>
	          	</v-list-tile-action>
	        </v-list-tile>
	        <v-divider></v-divider>

        <v-list-tile>
          <v-list-tile-content>
            <v-list-tile-title>
            	Date
            </v-list-tile-title>
          </v-list-tile-content>
          <v-list-tile-action>
          	<v-list-tile-action-text class="body-2">
          		{{ transaction.created_at }}
          	</v-list-tile-action-text>
          </v-list-tile-action>
        </v-list-tile>
        <v-divider></v-divider>

  		</v-list>
  	</template>
  	<template v-else>
  		<v-list>
				<v-list-tile id="heigth-list-title">
					<v-list-tile-content>
						<v-alert type="warning" :value="true">
	            You do not have enough balance to execute the transaction.
						</v-alert>
					</v-list-tile-content>
        </v-list-tile>
        <v-divider></v-divider>
      </v-list>
  	</template>

 	</v-card>
</template>

<script>
import { getWithData, put, get, post } from '../../../../api'
import config from '../../../../config'

export default {

  name: 'WithDrawViaBank',

  data () {
    return {
    	user:JSON.parse(localStorage.getItem('user')),
    	total_ewallet: 0,
    	userChosse: 'visa',
    	formWithdraw:{
    		bank_method: 'Bank Transfer'
    	},
    	rules: {
        required: value => !!value || 'Required.',
      	number: value => {
          const p = /^[0-9]\d*$/
          return p.test(value) || 'Please input number format.'
      	},
      	decimal: value => {
          const p = /^[0-9]\d*(\.\d+)?$/
          return p.test(value) || 'Please input decimal format.'
      	},
      	fullname: value => {
      		const p = /^[a-z \'\-]*$/i
      		return p.test(value) || "Please input card name format"
      	}
    	},
    	form: false,
    	isLoading: false,
    	checkStatus: 1,
    	transaction:{},
    }
  },
  methods:{
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
			  			this.total_ewallet = 0
			  		}
				}
			})
			.catch(err => {
				console.log(err)
			})
	  },
	  reset(){
	  	this.$refs.form.reset()
	  },
	  submit(){
    	if (this.$refs.form.validate()) {
    		let url = config.API_URL + 'ewallet_withdraws'

    	 	let params = {
  	 			item : this.formWithdraw,
  	 			company_id : this.user.company_id,
  	 		}

    	 	post(url,params)
    	 	.then(res => {
    	 		if(res.data && res.data.success){
    	 			this.$notify({
		          title: 'Success',
		          message: "Create Withdraw Successfully",
		          type: 'success',
		          duration: 1500,
		        })
            this.withDraw()
    	 		}
	 			})
		 		.catch(err =>{
		 			console.log(err)
		 		})
    	}
    },
    withDraw(){
  		let url = config.API_URL + 'ewallet_withdraw' + '/' + this.user.company_id
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
  },
  created(){
  	this.callWallet()
  	this.withDraw()
  }
};
</script>

<style lang="scss" scoped>
</style>
