<template>
<v-container fluid pt-0 grid-list-xl>
		<!-- <section-tooltip :title="$t('message.overview')" :tooltip="$t('message.dashboardOverview')"></section-tooltip> -->
		<!-- Dash Cards -->
		<v-layout row wrap border-rad-sm overflow-hidden>
			<stats-card-v2
				colClasses="xl6 lg6 md6 sm6 xs12"
				:heading="$t('message.photographers')"
				:amount="120"
				:icon="$t('zmdi zmdi-chart')"
				customClasses="style-card-basic"
				
			></stats-card-v2>
			<stats-card-v2
				colClasses="xl6 lg6 md6 sm6 xs12"
				:heading="$t('message.customer')"
				:amount="131"
				:icon="$t('zmdi zmdi-account-add')"
				customClasses="style-card-pro"
			></stats-card-v2>
		</v-layout>
		<div class="row" style="margin-top:20px">
		<!-- 	<activity-log></activity-log>
			<notification-dashboard></notification-dashboard> -->
		</div>
	</v-container>		
</template>

<script>
export default {

  name: 'BranchDashboard',

  data () {
    return {

    }
  }
}
</script>

<style lang="css" scoped>
</style>