<template>
	<v-card class="h-100 position-relative">
	  <v-toolbar>
      <v-toolbar-title class="text-capitalize">{{ eventType }} Transactions</v-toolbar-title>
      <v-spacer></v-spacer>
      <v-toolbar-side-icon @click="closeDrawer">
      	<v-icon>
          fas fa-times
        </v-icon>
      </v-toolbar-side-icon>
    </v-toolbar>
    <v-divider class="mt-0 mb-0"></v-divider>
	  
	  <!-- Show Item -->
    <v-list v-if="itemToLoad && eventType === 'show'" class="heigth-list-title">
			
			<v-list-tile>
				<v-list-tile-content>
          <v-list-tile-title class="content-flex">
          	<span class="font-weight-bold item-title">Company Name</span>
          	<span>{{ itemToLoad.company_name }}</span>
          </v-list-tile-title>
				</v-list-tile-content>
			</v-list-tile>
      <v-divider class="mt-0 mb-0"></v-divider>

			
			<v-list-tile>
				<v-list-tile-content>
          <v-list-tile-title class="content-flex">
          	<span class="font-weight-bold item-title">Invoice</span>
          	<span>{{ itemToLoad.invoice }}</span>
          </v-list-tile-title>
				</v-list-tile-content>
			</v-list-tile>
      <v-divider class="mt-0 mb-0"></v-divider>


			<v-list-tile>
				<v-list-tile-content>
          <v-list-tile-title class="content-flex">
          	<span class="font-weight-bold item-title">Date</span>
          	<span>{{ itemToLoad.dated }}</span>
          </v-list-tile-title>
				</v-list-tile-content>
			</v-list-tile>
      <v-divider class="mt-0 mb-0"></v-divider>


			<v-list-tile>
				<v-list-tile-content>
          <v-list-tile-title class="content-flex">
          	<span class="font-weight-bold item-title">Transaction</span>
          	<span>{{ itemToLoad.title }}</span>
          </v-list-tile-title>
				</v-list-tile-content>
			</v-list-tile>
      <v-divider class="mt-0 mb-0"></v-divider>

	
			<v-list-tile>
				<v-list-tile-content>
          <v-list-tile-title class="content-flex">
          	<span class="font-weight-bold item-title">Amount</span>
          	<span>{{ itemToLoad.amount_with_symbol }}</span>
          </v-list-tile-title>
				</v-list-tile-content>
			</v-list-tile>
      <v-divider class="mt-0 mb-0"></v-divider>

				
			<v-list-tile>
				<v-list-tile-content>
          <v-list-tile-title class="content-flex">
          	<span class="font-weight-bold item-title">Credit Card Fee</span>
          	<span>{{ itemToLoad.credit_card_fee_with_symbol }}</span>
          </v-list-tile-title>
				</v-list-tile-content>
			</v-list-tile>
      <v-divider class="mt-0 mb-0"></v-divider>


			<v-list-tile>
				<v-list-tile-content>
          <v-list-tile-title class="content-flex h-100">
          	<span class="font-weight-bold item-title">Status</span>
          	<span>
          		<v-btn class="no-mg-horizontal" color="success" dark v-if="itemToLoad.status === 'RECIVED'">{{ itemToLoad.status }}</v-btn>
							<v-btn class="no-mg-horizontal" color="error" dark v-else>{{ itemToLoad.status }}</v-btn>
          	</span>
          </v-list-tile-title>
				</v-list-tile-content>
			</v-list-tile>
      <v-divider class="mt-0 mb-0"></v-divider>


			<v-list-tile v-if="itemToLoad.user && itemToLoad.user.package">
				<v-list-tile-content>
          <v-list-tile-title class="content-flex">
          	<span class="font-weight-bold item-title">Package Name</span>
          	<span>{{ itemToLoad.user.package.package_name }}</span>
          </v-list-tile-title>
				</v-list-tile-content>
			</v-list-tile>
      <v-divider class="mt-0 mb-0"></v-divider>


			<v-list-tile v-if="itemToLoad.user">
				<v-list-tile-content>
          <v-list-tile-title class="content-flex">
          	<span class="font-weight-bold item-title">Email</span>
          	<span>{{ itemToLoad.user.email }}</span>
          </v-list-tile-title>
				</v-list-tile-content>
			</v-list-tile>
      <v-divider class="mt-0 mb-0"></v-divider>


			<v-list-tile>
				<v-list-tile-content>
          <v-list-tile-title class="content-flex">
          	<span class="font-weight-bold item-title">Fullname</span>
          	<span class="text-capitalize">{{ itemToLoad.fullname }}</span>
          </v-list-tile-title>
				</v-list-tile-content>
			</v-list-tile>
      <v-divider class="mt-0 mb-0"></v-divider>


			<v-list-tile v-if="itemToLoad.currency">
				<v-list-tile-content>
          <v-list-tile-title class="content-flex">
          	<span class="font-weight-bold item-title">Country</span>
          	<span>{{ itemToLoad.currency.country }}</span>
          </v-list-tile-title>
        </v-list-tile-content>
      </v-list-tile>
      <v-divider class="mt-0 mb-0"></v-divider>

    </v-list>
    <!-- End Item Show -->

		<!-- Edit Item -->
		<v-list v-if="itemToLoad && eventType === 'edit'" class="heigth-list-title">
      <v-alert  v-model="alertStt" :type="alertType" dismissible>{{ alertMes }}</v-alert>

    	<v-list-tile class="height-80">
        <v-list-tile-content class="h-100">
          <v-list-tile-title class="content-flex-end h-100">
            <span class="font-weight-bold item-title position-item">Company Name</span>
            <span class="contain-text-field">
              <v-text-field
                class="font-weight-bold height-input"
                placeholder="Enter Company Name"
                v-model="itemToLoad.company_name"
                outline
                :rules="[rules.required]"
                @blur="editItem('company_name', itemToLoad.company_name)"
                @keyup.enter="editItem('company_name', itemToLoad.company_name)"
              ></v-text-field>
            </span>
            <!-- <span class="position-item">
              <v-btn flat icon @click="unDisableItem(1)"><v-icon small>fas fa-marker</v-icon></v-btn>
            </span> -->
          </v-list-tile-title>
        </v-list-tile-content>
      </v-list-tile>
      <v-divider class="mt-0 mb-0"></v-divider>

      <v-list-tile class="height-80">
        <v-list-tile-content class="h-100">
          <v-list-tile-title class="content-flex-end h-100">
            <span class="font-weight-bold item-title position-item">Invoice</span>
            <span class="contain-text-field">
              <v-text-field
                class="font-weight-bold height-input"
                placeholder="Enter Invoice"
                v-model="itemToLoad.invoice"
                outline
                :rules="[rules.required]"
                @blur="editItem('invoice', itemToLoad.invoice)"
                @keyup.enter="editItem('invoice', itemToLoad.invoice)"
              ></v-text-field>
            </span>
          </v-list-tile-title>
        </v-list-tile-content>
      </v-list-tile>
      <v-divider class="mt-0 mb-0"></v-divider>

      <v-list-tile class="height-80">
        <v-list-tile-content class="h-100">
          <v-list-tile-title class="content-flex-end h-100">
            <span class="font-weight-bold item-title position-item">Date</span>
            <span class="contain-text-field">
              <v-menu
                :close-on-content-click="false"
                v-model="menu"
                :nudge-right="40"
                lazy
                transition="scale-transition"
                offset-y
                full-width
              >
                <v-text-field
                  slot="activator"
                  v-model="computedDateFormatted"
                  readonly
                  class="font-weight-bold height-input"
                  placeholder="Enter date"
                  outline
                ></v-text-field>
                <v-date-picker v-model="date" no-title  @input="editItem('dated', date)" :max="new Date().toISOString().substr(0, 10)"></v-date-picker>
              </v-menu>
            </span>
          </v-list-tile-title>
        </v-list-tile-content>
      </v-list-tile>
      <v-divider class="mt-0 mb-0"></v-divider>

      <v-list-tile class="height-80">
        <v-list-tile-content class="h-100">
          <v-list-tile-title class="content-flex-end h-100">
            <span class="font-weight-bold item-title position-item">Transaction</span>
            <span class="contain-text-field">
              <v-select
                class="font-weight-bold height-input"
                outline
                :items="listStatus"
                v-model="itemToLoad.status"
                @change="editItem('status', itemToLoad.status)"
              ></v-select>
            </span>
          </v-list-tile-title>
        </v-list-tile-content>
      </v-list-tile>
      <v-divider class="mt-0 mb-0"></v-divider>

      <v-list-tile class="height-80">
        <v-list-tile-content class="h-100">
          <v-list-tile-title class="content-flex-end h-100">
            <span class="font-weight-bold item-title position-item-amount mr-2">
              <div>Amount</div>
              <div>{{ itemToLoad.currency.name }}</div>
            </span>
            <span class="contain-text-field">
              <v-text-field
                class="font-weight-bold height-input"
                v-model="itemToLoad.amount"
                :rules="[rules.required]"
                outline
                @blur="editItem('amount', itemToLoad.amount)"
                @keyup.enter="editItem('amount', itemToLoad.amount)"
              ></v-text-field>
            </span>
          </v-list-tile-title>
        </v-list-tile-content>
      </v-list-tile>
      <v-divider class="mt-0 mb-0"></v-divider>
      <v-spacer></v-spacer>

    </v-list>
		<!-- End Item Edit -->

    <!-- Close drawer button -->
    <v-card-actions class="w-100 border border-left-0 border-right-0 border-bottom-0 pr-4 bottom-position flex-end">
      <v-btn @click="closeDrawer">Close</v-btn>
    </v-card-actions>
    <!-- End close drawer button -->

	</v-card>
</template>

<script>
import { post } from '../../../api'
import config from '../../../config'
import Vue from 'vue'

export default {

  name: 'TransactionItem',

  props: ['eventType', 'item'],
  data () {
    return {
    	listStatus: [ 'RECIVED', 'DONE'],
    	rules: {
        required: value => !!value || 'This field is required.',
      	number: value => {
          const pattern = /^([0-9]*|\d*\.\d{1}?\d*)$/
          return pattern.test(value) || 'Please input number.'
      	},
        decimal: value => {
          const pattern = /^[\d]+[\.][\d]{3}$/
          return pattern.test(value) || 'Please input discount format. E.g:12.000'
        },
    	},
      key: 0,
      alertStt: false,
      alertType: 'success',
      alertMes: '',
      date: '',
      menu: false
    }
  },
  methods:{
  	closeDrawer(){
  		this.$root.$emit('closeDrawerItem', false)
  	},
    unDisableItem(key){
      this.key = key
    },
    editItem(field_name, value){

      var field = {
        field_name: field_name,
        value: value
      }

      if(field_name === 'dated'){
        let date = new Date(value)
        let dateFormated = this.$moment(date).format('YYYY-MM-DD')
        field.value = dateFormated
        this.menu = false
      }

      this.fetchData(field)

    },
    fetchData(field){
  		post(config.API_URL + 'edit/transaction/' + this.itemToLoad.id, field)
			.then((res) => {
				if(res.data && res.data.success){
          this.alertStt = true
          this.alertType = 'success'
          this.alertMes = 'Update Successfully'					
          setTimeout(() => {this.alertStt = false}, 1500)
          this.key = 0
					this.$root.$emit('editItemSucess')
					// this.$root.$emit('closeDrawerItem', false)
				}
			})
			.catch((e) =>{
				this.alertStt = true
        this.alertType = 'error'
        this.alertMes = 'System Error Occurred'         
        setTimeout(() => {this.alertStt = false}, 1500)
			})

    }
  },
  computed:{
  	itemToLoad(){
  		return this.item
  	},
    computedDateFormatted(){
      if(this.date){
        this.item.dated = this.date
      }

      var dateFormated = this.$moment(this.item.dated).format("DD/MM/YYYY")
      return dateFormated
    }
  },
  mounted(){
    this.$root.$on('disabled-transaction-item', res => {
      this.key = 0
      this.date = ''
    })
  }
};
</script>

<style lang="scss" scoped>

</style>