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

			<v-list-tile class="grow">
				<v-list-tile-content>
          			<v-list-tile-title>Credit Card & Debit Card</v-list-tile-title>
        		</v-list-tile-content>

		        <v-layout
		          align-center
		          justify-end
		        >
		          	<v-icon large class="mr-1" color="#0157a2">fab fa-cc-visa</v-icon>
		          	<v-icon large color="#0a3a82">fab fa-cc-mastercard</v-icon>
		        </v-layout>
			</v-list-tile>
		</v-list>

		<v-divider></v-divider>

		<v-list
			subheader
			two-line
			class="custom-list"
    	>
    		<v-subheader>Use Your Saved Accounts</v-subheader>
			<v-radio-group v-model="userChosse" hide-details>
		    	<v-list-tile @click="choose('visa')">
			        <v-list-tile-action>
			        	<v-radio value="visa" color="indigo"></v-radio>
			        </v-list-tile-action>

			        <v-list-tile-content>
			          <v-list-tile-title><v-icon large color="#0157a2">fab fa-cc-visa</v-icon></v-list-tile-title>
			        </v-list-tile-content>
		      	</v-list-tile>

		      	<v-list-tile @click="choose('new_credit')">
			        <v-list-tile-action>
			        	<v-radio value="new_credit" color="indigo"></v-radio>
			        </v-list-tile-action>

		        	<v-list-tile-content @click="choose">
		          		<v-list-tile-title>Use new credit card</v-list-tile-title>
		        	</v-list-tile-content>
		      	</v-list-tile>
			</v-radio-group>
  		</v-list>
  		<v-divider></v-divider>

		<template v-if="show">
		    <v-form
				ref="form"
				v-model="form"
				class="pr-3 pl-3"
			>
		  		<v-text-field
		  			type="number"
			        label="Amount"
			        v-model="formBalance.amount_card"
			        :rules="[rules.required, rules.decimal]"
			        prepend-icon="fas fa-dollar-sign"
			        class="icon-fs-20"
		      	></v-text-field>

		  		<v-text-field
			      	type="text"
			        label="Your Card Name"
			        v-model="formBalance.name_card"
			        :rules="[rules.required, rules.fullname]"
			        class="text-capitalize"
		      	></v-text-field>

		  		<v-text-field
			        label="Card Number"
			        :rules="[rules.required]"
			        v-model="formBalance.card_number"
			        mask="#### #### #### ####"
			        required
		      	></v-text-field>

		  		<v-text-field
			        label="MM / YY"
			        v-model="formBalance.expiry_date"
			        :rules="[rules.required]"
			        mask="## / ##"
			        required
		      	></v-text-field>

		  		<v-text-field
			        label="CVV"
			        v-model="formBalance.security_code"
			        :rules="[rules.required]"
			        mask="###"
		      	></v-text-field>
		   	</v-form>
		   	<v-divider></v-divider>
		   	<v-card-actions>
		      	<v-spacer></v-spacer>
		      	<v-btn
			  		flat
		        	@click="$refs.form.reset()"
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
	      		>
					Pay
				</v-btn>
		    </v-card-actions>
		</template>
 	</v-card>
</template>

<script>
import { getWithData, put, get, post } from '../../../../api'
import config from '../../../../config'

export default {

  name: 'TopUp',

  data () {
    return {
    	user:JSON.parse(localStorage.getItem('user')),
    	total_ewallet: 0,
    	userChosse: 'visa',
    	formBalance:{},
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
    	show: false,
    	isLoading: false,
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
	  choose(value){
	  	this.userChosse = value
	  	if (value === 'new_credit') {
	  		this.show = true
	  	}
	  	if (value === 'visa') {
	  		this.show = false
	  	}
	  }
  },
  created(){
  	this.callWallet()
  }
};
</script>

<style lang="scss" scoped>
	.custome-icon{
		opacity: 0.6;
	}
</style>
