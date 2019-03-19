<template>
	<div>
		<header-page> </header-page>
		<v-container fluid class="custom-container-sp">
      <!-- thanh hung -->
			<router-view></router-view>
		</v-container>
	</div>
</template>

<script>
import HeaderPage from './partials/Header'

export default {

  name: 'index',
  components: {
  	HeaderPage
  },

  data () {
    return {

    }
  }
}
</script>

<style lang="scss" scoped>

</style>