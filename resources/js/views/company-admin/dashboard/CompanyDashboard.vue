<template>
	<v-container fluid pt-0 grid-list-xl>
		<v-layout row wrap mt-3>
			<!-- <v-flex d-flex xs12 sm12 md8>
		        <v-card>
					<activity-log></activity-log>
		        </v-card>
	      	</v-flex> -->
		      <v-flex d-flex xs12 sm12 md4>
		        <v-card>
					<notification-dashboard></notification-dashboard>
		        </v-card>
		      </v-flex>
		</v-layout>
		<!-- <section-tooltip :title="$t('message.overview')" :tooltip="$t('message.dashboardOverview')"></section-tooltip> -->
		<!-- Dash Cards -->
		<!-- <v-layout row wrap border-rad-sm overflow-hidden>
			<stats-card-v2
				colClasses="xl3 lg3 md3 sm6 xs12"
				:heading="$t('message.totalcompany')"
				:amount="count_pack_company"
				:icon="$t('zmdi zmdi-account-calendar')"
				customClasses="style-card-user"
			></stats-card-v2>
			<stats-card-v2
				colClasses="xl3 lg3 md3 sm6 xs12"
				:heading="$t('message.totalpackagebasic')"
				:amount="count_pack_basic"
				:icon="$t('zmdi zmdi-card')"
				customClasses="style-card-basic"
				
			></stats-card-v2>
			<stats-card-v2
				colClasses="xl3 lg3 md3 sm12 xs12"
				:heading="$t('message.totalpackagepro')"
				:amount="count_pack_pro"
				:icon="$t('zmdi zmdi-card-membership')"
				customClasses="style-card-pro"
			></stats-card-v2>
			<stats-card-v2
				colClasses="xl3 lg3 md3 sm12 xs12"
				:heading="$t('message.totalimagesuploads')"
				:amount="2145"
				:icon="$t('zmdi zmdi-camera')"
				customClasses="style-card-image"
			></stats-card-v2>
		</v-layout> -->
	</v-container>		
</template>

<script>
import ActivityLog from './ActivityLog'
import Notification from '../notifications/Notifications'
import NotificationDashboard from '../notifications/NotificationDashboard'

export default {

  name: 'CompanyDashboard',
  components: {
  	ActivityLog,
  	NotificationDashboard
  },

  data () {
    return {
    	count_pack_company:20,
    	count_pack_basic:20,
    	count_pack_pro:20,
    	lorem: `Lorem ipsum dolor sit amet, mel at clita quando. Te sit oratio vituperatoribus, nam ad ipsum posidonium mediocritatem, explicari dissentiunt cu mea. Repudiare disputationi vim in, mollis iriure nec cu, alienum argumentum ius ad. Pri eu justo aeque torquatos.`
    }
  }
};
</script>

<style lang="scss" scoped>
</style>