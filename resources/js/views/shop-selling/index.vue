<template>
	<div class="mouse-right">
		<header-shop> </header-shop>
		<v-container fluid class="custom-container-sp">
			<router-view></router-view>
		</v-container>
	</div>
</template>

<script>
import HeaderShop from './partials/Header'

export default {

  name: 'index',
  components: {
  	HeaderShop
  },

  data () {
    return {

    }
  },
  mounted() {
    // $(".mouse-right").on("contextmenu",function(e){
    //   return false;
    // });

    // $(document).keydown(function(e){
    //   if(e.which === 123){
    //      return false;
    //   }
    // });
  }
}
</script>

<style lang="scss" scoped>

</style>