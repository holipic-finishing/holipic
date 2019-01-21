<template>
<div class="session-wrapper">
	<div class="session-left">
		<!-- <session-slider-widget></session-slider-widget> -->
	</div>
	<div class="session-right text-xs-center style-left">
		<div class="session-table-cell">
			<div class="session-content">
				<img 
					:src="appLogo"
					class="img-responsive mb-3" 
					width="150" 
					height="78" 
				/>
				<router-view></router-view>
			</div>
		</div>
	</div>
</div>			
</template>

<script>
import AppConfig from "../../constants/AppConfig";
export default {

  name: 'AppAuth',

  data () {
    return {
    	appLogo: AppConfig.appLogo2
    }
  }
};
</script>

<style lang="css" scoped>
.style-left {
	margin-left: 0px;
}
</style>