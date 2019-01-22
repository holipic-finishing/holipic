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
			
		</v-tab-item>
		<v-tab-item>
			<div>123123111111111123</div>
		</v-tab-item>
		<v-tab-item>
			<div>12312333333333333123</div>
		</v-tab-item>
	</v-tabs>
	 <v-card-actions class="w-100 border border-left-0 border-right-0 border-bottom-0 pr-4 bottom-position flex-end">
      	<v-btn @click="closeDrawer">Close</v-btn>
    </v-card-actions>
</v-card>
</template>

<script>
import { getWithData, put, get } from '../../api/index.js'
import config from '../../config/index.js'
export default {

  name: 'EWallet',

  data () {
    return {
    	menu: false,
    	settings: {
			maxScrollbarLength: 300
		},
    }
  },
  methods:{
  	closeDrawer(){
  		this.$root.$emit('closeDrawerItem', false)
  	}
  }
}
</script>

<style lang="css" scoped>
.mr-3 {
	margin-left: 16px !important;
}
</style>