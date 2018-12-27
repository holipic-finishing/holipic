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
			<div class="row" style="margin-top:20px">
				<activity-log></activity-log>
				<notification-dashboard></notification-dashboard>
				
			</div>

		</v-container>		
	</div>	

</template>

<script>
import ActivityLog from '../ActivityLog'
import Notification from '../../notification/notification'
import NotificationDashboard from '../../notification/notification-dashboard'

export default {

  name: 'DashboardCompany',
  components: {
  	ActivityLog,
  	NotificationDashboard
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