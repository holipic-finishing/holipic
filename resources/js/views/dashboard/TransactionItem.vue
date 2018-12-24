<template>
	<v-card>
	  <v-toolbar color="indigo" dark>
      <v-toolbar-side-icon @click="closeDrawer">
      	<v-icon>exit_to_app</v-icon>
      </v-toolbar-side-icon>
      <v-toolbar-title class="text-capitalize">{{ eventType }} Company</v-toolbar-title>
    </v-toolbar>
	  
	  <!-- Show Item -->
    <v-list v-if="itemToLoad && eventType === 'show'">
    	<v-list-tile>
      	<v-list-tile-content>
          <v-list-tile-title class="content-flex">
          	<span class="font-weight-bold">Company ID</span>
          	<span>{{ itemToLoad.id }}</span>
          </v-list-tile-title>
      	</v-list-tile-content>
      </v-list-tile>
			
			<v-list-tile>
				<v-list-tile-content>
          <v-list-tile-title class="content-flex">
          	<span class="font-weight-bold">Company Name</span>
          	<span>{{ itemToLoad.company_name }}</span>
          </v-list-tile-title>
				</v-list-tile-content>
			</v-list-tile>
			
			<v-list-tile>
				<v-list-tile-content>
          <v-list-tile-title class="content-flex">
          	<span class="font-weight-bold">Invoice</span>
          	<span>{{ itemToLoad.invoice }}</span>
          </v-list-tile-title>
				</v-list-tile-content>
			</v-list-tile>

			<v-list-tile>
				<v-list-tile-content>
          <v-list-tile-title class="content-flex">
          	<span class="font-weight-bold">Date</span>
          	<span>{{ itemToLoad.dated }}</span>
          </v-list-tile-title>
				</v-list-tile-content>
			</v-list-tile>

			<v-list-tile>
				<v-list-tile-content>
          <v-list-tile-title class="content-flex">
          	<span class="font-weight-bold">Transaction</span>
          	<span>{{ itemToLoad.title }}</span>
          </v-list-tile-title>
				</v-list-tile-content>
			</v-list-tile>
	
			<v-list-tile>
				<v-list-tile-content>
          <v-list-tile-title class="content-flex">
          	<span class="font-weight-bold">Amount</span>
          	<span>{{ itemToLoad.amount_with_symbol }}</span>
          </v-list-tile-title>
				</v-list-tile-content>
			</v-list-tile>
				
			<v-list-tile>
				<v-list-tile-content>
          <v-list-tile-title class="content-flex">
          	<span class="font-weight-bold">Credit Card Fee</span>
          	<span>{{ itemToLoad.credit_card_fee_with_symbol }}</span>
          </v-list-tile-title>
				</v-list-tile-content>
			</v-list-tile>

			<v-list-tile>
				<v-list-tile-content>
          <v-list-tile-title class="content-flex">
          	<span class="font-weight-bold">Status</span>
          	<span>
          		<v-btn color="success" small v-if="itemToLoad.status === 'RECIVED'">{{ itemToLoad.status }}</v-btn>
							<v-btn color="error" small v-else>{{ itemToLoad.status }}</v-btn>
          	</span>
          </v-list-tile-title>
				</v-list-tile-content>
			</v-list-tile>

			<v-list-tile v-if="itemToLoad.user && itemToLoad.user.package">
				<v-list-tile-content>
          <v-list-tile-title class="content-flex">
          	<span class="font-weight-bold">Package Name</span>
          	<span>{{ itemToLoad.user.package.package_name }}</span>
          </v-list-tile-title>
				</v-list-tile-content>
			</v-list-tile>

			<v-list-tile v-if="itemToLoad.user">
				<v-list-tile-content>
          <v-list-tile-title class="content-flex">
          	<span class="font-weight-bold">Email</span>
          	<span>{{ itemToLoad.user.email }}</span>
          </v-list-tile-title>
				</v-list-tile-content>
			</v-list-tile>

			<v-list-tile>
				<v-list-tile-content>
          <v-list-tile-title class="content-flex">
          	<span class="font-weight-bold">Fullname</span>
          	<span class="text-capitalize">{{ itemToLoad.fullname }}</span>
          </v-list-tile-title>
				</v-list-tile-content>
			</v-list-tile>

			<v-list-tile v-if="itemToLoad.currency">
				<v-list-tile-content>
          <v-list-tile-title class="content-flex">
          	<span class="font-weight-bold">Country</span>
          	<span>{{ itemToLoad.currency.country }}</span>
          </v-list-tile-title>
        </v-list-tile-content>
      </v-list-tile>

    </v-list>
    <!-- End Item Show -->

		<!-- Edit Item -->
		<v-list v-if="itemToLoad && eventType === 'edit'">

    	<v-list-tile>
      	<v-list-tile-content>
          <v-list-tile-title class="content-flex">
          	<span class="font-weight-bold">Company ID</span>
          	<span>{{ itemToLoad.id }}</span>
          </v-list-tile-title>
      	</v-list-tile-content>
      </v-list-tile>

      <v-list-tile>
				<v-list-tile-content>
          <v-list-tile-title class="content-flex">
          	<span class="font-weight-bold">Company Name</span>
          	<span>{{ itemToLoad.company_name }}</span>
          </v-list-tile-title>
				</v-list-tile-content>
			</v-list-tile>

			<v-list-tile v-if="itemToLoad.currency">
				<v-list-tile-content>
          <v-list-tile-title class="content-flex">
          	<span class="font-weight-bold">Currency</span>
          	<span>{{ itemToLoad.currency.symbol }}</span>
          </v-list-tile-title>
        </v-list-tile-content>
      </v-list-tile>

      <v-list-tile class="custom-title">
				<v-list-tile-content class="custom-title">
          <v-list-tile-title class="content-flex custom-height">
          	<span class="font-weight-bold">Amount</span>
          	<v-text-field 
          		class="ml-5 custom-input" 
          		label="Enter Amount" 
          		v-model="itemToLoad.amount" 
          		:rules="[rules.number]"
          		box
          	>
          	</v-text-field>
          </v-list-tile-title>
				</v-list-tile-content>
			</v-list-tile>

			<v-list-tile class="custom-title">
				<v-list-tile-content class="custom-title">
          <v-list-tile-title class="content-flex custom-height">
          	<span class="font-weight-bold">Status</span>
          	<v-select
          			class="ml-5 custom-input"
          			box
		            :items="listStatus"
		            label="Chosse Status"
		            v-model="item.status"
		        >
		        </v-select>
          </v-list-tile-title>
				</v-list-tile-content>
			</v-list-tile>

      <v-spacer></v-spacer>

			<v-list-tile class="float-right">
       	<v-btn color="success" :disabled="!itemToLoad.amount" @click="editItem">Save</v-btn>
      </v-list-tile>

    </v-list>
		<!-- End Item Edit -->

	</v-card>
</template>

<script>
import { post } from '../../api'
import config from '../../config'
import Vue from 'vue'

export default {

  name: 'TransactionItem',

  props: ['eventType', 'item'],
  data () {
    return {
    	listStatus: [ 'RECIVED', 'BEEN SEEN'],
    	rules: {
      	number: value => {
          const abc = /^([0-9]*|\d*\.\d{1}?\d*)$/
          return abc.test(value) || 'Please input number.'
      	},
    	},
    }
  },
  methods:{
  	closeDrawer(){
  		this.$root.$emit('closeDrawerItem', false)
  	},
  	editItem(){
  		let params = {
  			amount: this.itemToLoad.amount,
  			status: this.itemToLoad.status
  		}
  		post(config.API_URL + 'edit/transaction/' + this.itemToLoad.id, params)
			.then((res) => {
				if(res.data && res.data.success){
					setTimeout(() => {
						Vue.notify({
	                        type: 'success',
	                        title: 'Edit Item Successfully',
	                        position: 'top right'
		                    });
						
					}, 1000)

					this.$root.$emit('editItemSucess')
					this.$root.$emit('closeDrawerItem', false)
				}
			})
			.catch((e) =>{
				Vue.notify({
                      type: 'error',
                      title: 'System Error Occurred',
                      position: 'top right'
                    });
			})
  	}
  },
  computed:{
  	itemToLoad(){
  		return this.item
  	}
  }
};
</script>

<style lang="scss" scoped>
	.content-flex{
		display: flex;
    justify-content: space-between;
    align-items: center;
	}

	.custom-title{
		align-items: end;
		height: 60px !important;
	}
	.custom-height{
		height: 100% !important;
	}
</style>