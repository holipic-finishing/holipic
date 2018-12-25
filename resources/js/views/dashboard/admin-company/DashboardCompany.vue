<template>
	<div>
		<v-container fluid pt-0 grid-list-xl>
			<section-tooltip :title="$t('message.overview')" :tooltip="$t('message.dashboardOverview')"></section-tooltip>
			<!-- Dash Cards -->
			<v-layout row wrap border-rad-sm overflow-hidden>
				<stats-card-v2
					colClasses="xl3 lg3 md3 sm6 xs12"
					:heading="$t('message.totalcompany')"
					:amount="count_pack_company"
					:icon="$t('zmdi zmdi-account-calendar')"
					customClasses="style-card-user"
				>

				</stats-card-v2>
				<stats-card-v2
					colClasses="xl3 lg3 md3 sm6 xs12"
					:heading="$t('message.totalpackagebasic')"
					:amount="count_pack_basic"
					:icon="$t('zmdi zmdi-card')"
					customClasses="style-card-basic"
					
				>

				</stats-card-v2>
				<stats-card-v2
					colClasses="xl3 lg3 md3 sm12 xs12"
					:heading="$t('message.totalpackagepro')"
					:amount="count_pack_pro"
					:icon="$t('zmdi zmdi-card-membership')"
					customClasses="style-card-pro"


				>
				</stats-card-v2>
				<stats-card-v2
					colClasses="xl3 lg3 md3 sm12 xs12"
					:heading="$t('message.totalimagesuploads')"
					:amount="2145"
					:icon="$t('zmdi zmdi-camera')"
					customClasses="style-card-image"
				>
				</stats-card-v2>
			</v-layout>

			<active-log></active-log>
			
		</v-container>		
	</div>
	
</template>

<script>
import ActiveLog from '../ActiveLog'
export default {

  name: 'DashboardCompany',
  components: {
  	ActiveLog
  },

  data () {
    return {
    	count_pack_company:20,
    	count_pack_basic:20,
    	count_pack_pro:20


    }
  }
}
</script>

<style lang="css" scoped>
</style>