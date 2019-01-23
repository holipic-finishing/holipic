<template>
	<v-navigation-drawer
    v-model="drawer"
    right
    fixed
    temporary
    this.width = this.getCurrentWithContentWrap()
    :width='widthComputed'
    @input="loadDataAfterCouponCodeEvent"
  >
		<v-card class="h-100 position-relative">
			<!-- Toolbar -->
		  <v-toolbar>
	      <v-toolbar-title class="text-capitalize">{{ typeEvent }}</v-toolbar-title>
	      <v-spacer></v-spacer>
	      <v-toolbar-side-icon @click="closeDrawer">
	      	<v-icon>
	          fas fa-times
	        </v-icon>
	      </v-toolbar-side-icon>
	    </v-toolbar>
	    <v-divider class="mt-0 mb-0"></v-divider>
	    <!-- End Toolbar -->

	    <v-layout row wrap class="flexible-list-title">
	      <v-flex xs12>
	        <v-card>
  					<v-list two-line>
  						<template v-for="(couponCode, index) in couponCodes">
    					  <v-list-tile
		              :key="couponCode.name"
		              ripple
		              @click="toggle(index, couponCode.id)"
		              v-if="couponCode.active"
		            >
		            	<v-list-tile-content>
		                <v-list-tile-title>
		                	<v-tooltip top>
		                		<span slot="activator">{{ couponCode.name }}</span>
		                		<span>{{ couponCode.name }}</span>	  
		                	</v-tooltip>
		                </v-list-tile-title>
		                <v-list-tile-sub-title>{{ couponCode.discount }} %</v-list-tile-sub-title>
		              </v-list-tile-content>

		              <v-list-tile-action>
		              	<v-tooltip bottom v-if="selected.indexOf(index) < 0">
			                <v-icon
			                  slot="activator"
			                >
			                  fas fa-check
			                </v-icon>
			                <span>Add</span>
		              	</v-tooltip>
										
										<v-tooltip bottom v-else>
			                <v-icon
			                  color="green darken-1"
			                  slot="activator"
			                >
			                  fas fa-check
			                </v-icon>
			                <span>Cancel Add</span>
										</v-tooltip>

		                <v-list-tile-action-text>
		                	{{ couponCode.from_date | moment("DD/MM/YYYY") }} - {{ couponCode.to_date | moment("DD/MM/YYYY") }}
		                </v-list-tile-action-text>
		              </v-list-tile-action>
		          	</v-list-tile>
		          	<v-divider
		              v-if="index + 1 < couponCodes.length && couponCode.active"
		              :key="index"
		            ></v-divider>
  						</template>
  					</v-list>
	        </v-card>
	      </v-flex>
	    </v-layout>

	    <!-- Close drawer button -->
	    <v-card-actions class="w-100 border border-left-0 border-right-0 border-bottom-0 pr-4 bottom-position flex-end">
	      <v-btn @click="closeDrawer">Close</v-btn>
	    </v-card-actions>
	    <!-- End close drawer button -->

		</v-card>
	</v-navigation-drawer>
</template>

<script>
import  { get, post } from '../../../api'
import { getWithContentWrap } from '../../../helpers/helpers'
import config from '../../../config'
import Vue from 'vue'


export default {

  name: 'CouponCode',
  props: [
  	'typeEvent', 'item'
  ],
  data() {
    return {
    	drawer: false,
    	width: 0,
    	drawerHeaderStt: null,
    	couponCodes: [],
    	selected: [],
    	couponId: null,
    };
  },
  methods:{
  	getCurrentWithContentWrap(){
  		return getWithContentWrap(this.drawerHeaderStt)
  	},
  	fetchData() {
			let url = config.API_URL + 'coupon_codes'
			get(url)
			.then((res) => {
				if(res.data && res.data.success){
					this.couponCodes = res.data.data
				}
			})
			.catch((err) =>{
				console.log(err)
			}) 
		},
		closeDrawer(){
			this.drawer = false
			this.$root.$emit('load-data-after-coupon-code_event')
  	},
  	toggle (index, id) {

      const i = this.selected.indexOf(index)

      if (i > -1) {
        this.selected.splice(i, 1)
        this.couponId = 0
        this.cancelCouponCode(this.couponId, this.item.id)
      } else {
      	if (this.selected.length > 0) {
      		this.$message({
	          showClose: true,
	          message: 'Warning, Maximum one voucher is added.',
	          type: 'warning'
	        });
      	}else{
        	this.selected.push(index)
        	this.couponId = id
        	this.addCouponCode(this.couponId, this.item.id)
      	}
      }
    },
    addCouponCode(couponId, companyId){
    	let url = config.API_URL + 'add-coupon-code/' + couponId + "/" + companyId
    	post(url)
			.then((res) => {
				if (res.data && res.data.success) {
					this.$message({
	          showClose: true,
	          message: 'Success, ' + res.data.message,
	          type: 'success'
	        });
				}
			})
			.catch((err) =>{
				this.$message({
          showClose: true,
          message: 'Error, ' + res.data.message,
          type: 'error'
        });
			})
    },
    cancelCouponCode(couponId, companyId){
    	let url = config.API_URL + 'cancel-coupon-code/' + couponId + "/" + companyId
    	post(url)
			.then((res) => {
				if (res.data && res.data.success) {
					this.$message({
	          showClose: true,
	          message: 'Success, ' + res.data.message,
	          type: 'success'
	        });
				}
			})
			.catch((err) =>{
				console.log(err)
			})
    },
    showExistCoupon(item){
    	if (item.coupon_codes_id) {
				var _this = this
				_.forEach(_this.couponCodes, function(value, key){
					if (item.coupon_codes_id == value.id) {
						_this.selected.push(key)
					}
				})
			}
    },
    loadDataAfterCouponCodeEvent(){
			this.$root.$emit('load-data-after-coupon-code_event')
    }
  },
  mounted(){

  	this.$root.$on('drawer-status', res => {
  		this.drawerHeaderStt = res
  	})

  	this.$root.$on('show-coupon-code-component', res => {
  		this.selected = []
  		this.drawer = true
			this.width = this.getCurrentWithContentWrap()
			this.showExistCoupon(res)
  	})
  },
  computed: {
  	widthComputed(){
  		return this.width
  	}
  },
  created(){
  	this.fetchData()
  }
};
</script>

<style lang="scss" scoped>

</style>
