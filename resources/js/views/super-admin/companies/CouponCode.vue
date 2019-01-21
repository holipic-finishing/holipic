<template>
	<v-navigation-drawer
    v-model="drawer"
    right
    fixed
    temporary
    this.width = this.getCurrentWithContentWrap()
    :width='widthComputed'
  >
		
	</v-navigation-drawer>
</template>

<script>
import { getWithContentWrap } from '../../../helpers/helpers'

export default {

  name: 'CouponCode',

  data() {
    return {
    	drawer: false,
    	width: 0,
    	drawerHeaderStt: null,
    };
  },
  methods:{
  	getCurrentWithContentWrap(){
  		return getWithContentWrap(this.drawerHeaderStt)
  	}
  },
  mounted(){
  	this.$root.$on('drawer-status', res => {
  		this.drawerHeaderStt = res
  	})

  	this.$root.$on('show-coupon-code-component', res => {
  		this.drawer = true
			this.width = this.getCurrentWithContentWrap()
  	})
  },
  computed: {
  	widthComputed(){
  		return this.width
  	}
  }
};
</script>

<style lang="scss" scoped>

</style>
