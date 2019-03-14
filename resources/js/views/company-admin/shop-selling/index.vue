<template>
	<div >
		<!-- <header-shop> </header-shop> -->
		<v-container fluid class="custom-container-sp">
			<router-view></router-view>
		</v-container>
	</div>
</template>

<script>
// import HeaderShop from './partials/Header'

export default {

  name: 'index',
  components: {
  	// HeaderShop
  },

  data () {
    return {

    }
  }
}
</script>

<style lang="scss" scoped>

</style>