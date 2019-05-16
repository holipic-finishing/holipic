<template>
	<div class="popup" v-show="checkPayment">
		<v-layout row>
		    <v-flex xs12 sm6 offset-sm3>
		    	<v-card height="auto" class="v-card-payment">
		    		<v-card-title class="v-card-payment--header">
		    			<div class="line">
		    			<v-toolbar-side-icon @click="checkPayment = false">
							<v-icon>
								fas fa-times
							</v-icon>
						</v-toolbar-side-icon>
						</div>
						
						<v-img src="/shop_selling/logo-holipic-new.png" max-width="50"></v-img>

						<v-list-tile-content class="v-card__title--custom">
			                <v-list-tile-title>
			                	Total Payment
			                </v-list-tile-title>
			                <v-list-tile-sub-title> 
								$100.000
			                </v-list-tile-sub-title>
              			</v-list-tile-content>
		    		</v-card-title>

		    		<v-card-title class="title-note">Have a promocode?</v-card-title>
		    		<v-card class="v-card-info-payment">
		    			<div class="title-card">
		    				<span class="title-card--left">Credit Card & Debit Card</span>
		    				<div class="title-card--right">
		    					<v-img src="https://www.wctfcu.com/images/default-source/Page-Images/inside-headers-credit-cards-card-help-visa--customer-service.jpg?sfvrsn=a87f258_6"
			            		max-width="15%" class="v-image-left"></v-img>
					            <v-img src="https://content.heropay.com/wp-content/uploads/2016/11/MasterCard_Logo.png" max-width="15%"></v-img>
		    				</div>
		    			</div>
		    			<v-card-title class="content-text-payment">
		    				<v-flex xs12 sm12>
					          <v-text-field
					            label="Name on card"
					            single-line
					            solo
					            :rules="rules.name"
					          ></v-text-field>
					        </v-flex>
					        <v-flex xs12 sm12>
					          <v-text-field
					            label="Solo"
					            single-line
					            solo
					            :rules="rules.name"
					          ></v-text-field>
					        </v-flex>
					        <v-flex xs12 sm12>
					          <v-text-field
					            label="MM/YY"
					            single-line
					            solo
					            :rules="rules.name"
					          ></v-text-field>
					        </v-flex>
					        <v-flex xs12 sm12>
					          <v-text-field
					            label="CVV"
					            single-line
					            solo
					            :rules="rules.name"
					          ></v-text-field>
					        </v-flex>
		    			</v-card-title>

		    			<v-card-title class="v-card-title-footer-logo">
			    			<v-img src="https://asset.horizoncreditunion.com.au/images/verified-by-visa.png" max-width="20%" class="margin-image"></v-img>
			    			<v-img src="https://www.metairiebank.com/wp-content/uploads/2017/01/mastercard-securecode.png" max-width="20%" class="margin-image"></v-img>
			    			<v-img src="https://www.goinflow.com/wp-content/uploads/2008/08/norton_feat.png" max-width="20%" class="margin-image"></v-img>	
		    			</v-card-title>
		    		</v-card>
		    		<v-card-title class="v-card-footer-payment">
		    			<span>PROCESS PAYMENT</span>
		    			<span><i class="fas fa-angle-right"></i></span>
		    		</v-card-title>	
		      </v-card>
		    </v-flex>
  		</v-layout>
	</div>
</template>

<script>
export default {

  name: 'Payment',

  data () {
    return {
    	checkPayment:true,
    	rules: {
        	name: [val => (val || '').length > 0 || 'This field is required']
        },
    }
  },
  mounted(){
  	this.$root.$on('showPopupPayment', res => this.checkPayment = true)
  }
}
</script>

<style lang="css" scoped>
.line{
	width: 50px;
	height: auto;
	border-right: 2px solid rgba(0,0,0,0.12);
	margin-right:10px;
}
</style>