<template>
	<div id="transaction-history" v-show="isShowTransactionHistory">
		<div class="th-wrapper">
			<div class="th-overlay" @click.stop="isShowTransactionHistory = !isShowTransactionHistory"></div>
			<div class="th-container">
				
					<div class="row">
						<div class="col-sm-12"><p class="text-center title-transaction">Transaction History</p></div>
						<div v-for="(item, index) in transactionHistories"  class="row container">
							<div class="col-sm-6 label-field">Amount:</div>
							<div class="col-sm-6 text-right label-amount">{{item.amount}}</div>

							<div class="col-sm-6 label-field">Fee:</div>
							<div class="col-sm-6 text-right ">{{item.fee}}</div>

							<div class="col-sm-6 label-field">System fee :</div>
							<div class="col-sm-6 text-right label-amount">{{item.system_fee}}</div>
							<div class="text-center col-sm-12">--------------------------------------------------------------</div>
						</div>
							
					</div>
					
					
						<!-- <v-card>
							<v-toolbar color="cyan" dark>
								<v-toolbar-title>Transaction History</v-toolbar-title>
								<v-spacer></v-spacer>
							</v-toolbar>

							<v-list two-line>
								<template v-for="(item, index) in transactionHistories">
									<v-list-tile
										:key=""
										avatar
										@click=""
										>
										<v-list-tile-content>
											<v-list-tile-title > Amount: {{item.amount}}</v-list-tile-title>
											<v-list-tile-sub-title >Fee: {{item.fee}}</v-list-tile-sub-title>
											<v-list-tile-sub-title >System fee: {{item.system_fee}}</v-list-tile-sub-title>
										</v-list-tile-content>
									</v-list-tile>
								</template>
							</v-list>
						</v-card> -->
				
			</div>
		</div>
	</div>
</template>

<script>
import  { get, post, put, del } from '../../api/index.js'
import config from '../../config/index.js'
export default {

  	name: 'TransactionHistory',

  	data() {
    	return {
    		isShowTransactionHistory: false,
    		transactionHistories: {}

    	}
  	},

  	mounted () {
  		this.$root.$on('toggleTransactionHistoryEvent', (data) => {
  			console.log(data)
  			this.isShowTransactionHistory = true
  			this.getTransactionHistory(data.companyId)
  		})
  	},

  	methods: {
  		getTransactionHistory(companyId) {
  			get(config.API_URL+'transaction/history?companyId='+companyId)
			.then((res)=>{
				// console.log(res)
				if (res.data && res.data.success) {
					this.transactionHistories= res.data.data
				}
			})
			.catch((e) =>{
				console.log(e)
			})
  		}
  	}
};
</script>

<style lang="scss" scoped>
#transaction-history{
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    height: 100%;
    z-index: 2;

	.th-wrapper{
		position: relative;
		width: 100%;
    	height: 100%;

    	.th-overlay{
    		position: absolute;
		    right: 0;
		    top: 0;
		    bottom: 0;
		    left: 0;
		    z-index: 3;
		    background: rgba(0, 0, 0, 0.13);
    	}

		.th-container{
			position: absolute;
		    right: 0;
		    top: 0;
		    bottom: 0;
		    width: 400px;
		    background: #fff;
		    z-index: 4;
		    border-left: 1px solid;
		    padding: 20px;

		}
		.title-transaction {
			color: green;
			font-size:22px;
			font-weight: bold;
		}

		.label-field{
			font-weight: bold;
		}

		.label-amount{
			font-weight: bold;
			color: green;
		}
	}
}
</style>
