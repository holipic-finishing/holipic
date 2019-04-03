<template>
	<v-navigation-drawer
		v-if="role_id === '2'"
    fixed
    v-model="eWalletSidebar"
    right
    temporary
    app
    clipped
  	:width='widthComputed'
	>
		<v-card class="h-100 position-relative">
			<v-toolbar tabs>
		    <v-toolbar-title class="text-capitalize">E-Wallet</v-toolbar-title>
		    <v-spacer></v-spacer>
		    <v-toolbar-side-icon @click.stop="closeDrawerRight()">
	      	<v-icon>
	          fas fa-times
	        </v-icon>
		    </v-toolbar-side-icon>
				<v-tabs
	        slot="extension"
	        v-model="tab"
	        color="primary"
	        grow
	        dark
	        class="custom-tab"
	        active-class="body-2 font-weight-bold blue darken-4 text-uppercase"
	      >
	        <v-tab
	          v-for="t in tabs"
	          :key="t"
	        >
	          {{ t }}
	        </v-tab>
	      </v-tabs>
	    </v-toolbar>

      <v-tabs-items v-model="tab" class="height-ewallet">
	      <v-tab-item
	        v-for="t in tabs"
	        :key="t"
	      >
	      	<div v-if="t === 'Transactions History'">
						<e-wallet-transactions-history></e-wallet-transactions-history>
	      	</div>
	      	<div v-if="t === 'Top Up Balance'">
						<top-up></top-up>
	      	</div>
	      	<div v-if="t === 'Withdraw Via Bank'">
						<with-draw-via-bank></with-draw-via-bank>
	      	</div>
	      </v-tab-item>
	    </v-tabs-items>
		</v-card>
	</v-navigation-drawer>
</template>

<script>
import { getWithContentWrap } from '../../../helpers/helpers.js'
import EWalletTransactionsHistory from './EWalletComponents/EWalletTransactionsHistory.vue'
import TopUp from './EWalletComponents/TopUp.vue'
import WithDrawViaBank from './EWalletComponents/WithDrawViaBank.vue'

export default {

  name: 'EWallet',
  components:{
  	EWalletTransactionsHistory,
  	TopUp,
  	WithDrawViaBank
  },
  data () {
    return {
    	eWalletSidebar: false,
    	role_id : '',
    	drawerHeaderStt: null,
    	width: 0,
    	tabs: [
	      'Transactions History', 'Top Up Balance', 'Withdraw Via Bank'
	    ],
	    tab: null,
    }
  },
  mounted(){
  	this.$root.$on('open-EWallet', res => {
      this.eWalletSidebar = res.showDialog
  		this.role_id = res.role_id
  		this.width = this.getCurrentWithContentWrap()
    })
  },
  methods:{
		getCurrentWithContentWrap(){
  		return getWithContentWrap(this.drawerHeaderStt)
  	},
  	closeDrawerRight(){
			this.eWalletSidebar = false
		},
  },
  computed: {
  	widthComputed(){
  		return this.width
  	}
  },
};
</script>

<style lang="scss" scoped>
</style>
