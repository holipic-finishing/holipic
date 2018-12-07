<template>
	<v-container fluid pt-0 grid-list-xl>
			<section-tooltip :title="$t('message.overview')" :tooltip="$t('message.dashboardOverview')"></section-tooltip>
			<!-- Dash Cards -->
			<v-layout row wrap border-rad-sm overflow-hidden>
				<stats-card-v2
					colClasses="xl3 lg3 md3 sm6 xs12"
					:heading="$t('message.totalcompany')"
					:amount="2145"
					:icon="$t('zmdi zmdi-account-calendar')"
					customClasses="style-card-user"
				>
				<!-- <div class="pa-4">
				</div> -->
				</stats-card-v2>
				<stats-card-v2
					colClasses="xl3 lg3 md3 sm6 xs12"
					:heading="$t('message.totalpackagebasic')"
					:amount="136"
					:icon="$t('zmdi zmdi-card')"
					customClasses="style-card-basic"
					
				>
				<!-- <div class="pa-4">
				</div> -->
				</stats-card-v2>
				<stats-card-v2
					colClasses="xl3 lg3 md3 sm12 xs12"
					:heading="$t('message.totalpackagepro')"
					:amount="2145"
					:icon="$t('zmdi zmdi-card-membership')"
					customClasses="style-card-pro"


				>
				<!-- <div class="pa-4">
					
				</div> -->
				</stats-card-v2>
				<stats-card-v2
					colClasses="xl3 lg3 md3 sm12 xs12"
					:heading="$t('message.totalimagesuploads')"
					:amount="2145"
					:icon="$t('zmdi zmdi-camera')"
					customClasses="style-card-image"
				>
				<!-- <div class="pa-4">
					<line-chart-shadow
						:dataSet="onlineRevenue"
						:lineTension="0.4"
						:dataLabels="labels"
						:width="370"
						:height="80"
						:borderWidth=3
						:enableGradient='false'
						:enableShadow='false'
						:borderColor="ChartConfig.color.warning">
					</line-chart-shadow>
				</div> -->
				</stats-card-v2>
			</v-layout>
			<!-- Sales -->
			<v-layout row wrap>
				<app-card
					:heading="$t('message.sales')"
					colClasses="xl8 lg7 md7 sm6 xs12"
					customClasses="mb-0 sales-widget"
					:fullScreen="true"
					:reloadable="true"
					:closeable="true"
				>
					<sales class="mb-4" :height="320"></sales>	
					<v-layout class="cart-wrap hidden-xs-only pl-4">
						<v-flex d-custom-flex>
							<span class="mr-2"><i class="zmdi zmdi-shopping-cart-plus primary--text"></i></span>
							<p class="mb-0">
								<span class="d-block fs-14 fw-bold">2382</span>
								<span class="d-block fs-12 grey--text">Sales</span>
							</p>
						</v-flex>
						<v-flex d-custom-flex>
							<span class="mr-2"><i class="zmdi zmdi-eye success--text"></i></span>
							<p class="mb-0">
								<span class="d-block fs-14 fw-bold">53,255</span>
								<span class="d-block fs-12 grey--text">Views</span>
							</p>
						</v-flex>
						<v-flex d-custom-flex>
							<span class="mr-2"><i class="zmdi zmdi-equalizer error--text"></i></span>
							<p class="mb-0">
								<span class="d-block fs-14 fw-bold">$1,25,000</span>
								<span class="d-block fs-12 grey--text">Earned</span>
							</p>
						</v-flex>
					</v-layout>				
				</app-card>
				<!-- Devices Share -->
				<app-card
					colClasses="xl4 lg5 md5 sm6 xs12"
					:heading="$t('message.devicesShare')"
					:fullScreen="true"
					:reloadable="true"
					:closeable="true"
					customClasses="device-share-widget"
				>
					<device-share></device-share>
				</app-card>
			</v-layout>
			<!-- Social Feeds -->
			<v-layout row wrap>
				<app-card
					colClasses="xl3 lg3 md3 sm6 xs12"
					customClasses="social-share-wrap"
				>	
					<social-feeds 
						socialIcon="zmdi zmdi-facebook"
						friends="89K"
						feeds="459"
						type="facebook"
					>
					</social-feeds>
				</app-card>					
				<app-card
					colClasses="xl3 lg3 md3 sm6 xs12"
					customClasses="social-share-wrap"
				>	
					<social-feeds 
						socialIcon="zmdi zmdi-twitter"
						friends="65K"
						feeds="350"
						type="twitter"
					>
					</social-feeds>
				</app-card>
				<app-card
					colClasses="xl3 lg3 md3 sm6 xs12"
					customClasses="social-share-wrap"
				>	
					<social-feeds 
						socialIcon="zmdi zmdi-linkedin"
						friends="35K"
						feeds="689"
						type="linkedin"
					>
					</social-feeds>
				</app-card>
				<app-card
					colClasses="xl3 lg3 md3 sm6 xs12"
					customClasses="social-share-wrap"
				>	
					<social-feeds 
						socialIcon="zmdi zmdi-google"
						friends="90K"
						feeds="1000"
						type="google"
					>
					</social-feeds>
				</app-card>
			</v-layout>
			<v-layout row wrap>	
				<app-card 
					colClasses="xs12 sm12 md4 lg4"
					:heading="$t('message.newPost')"
					:fullScreen="true" 
					:reloadable="true" 
					:closeable="true"
					customClasses="blog-widget"
				>
					<new-post></new-post>
				</app-card>
			</v-layout>
		</v-container>
</template>

<script>
// charts component
import LineChartShadow from "../../components/Charts/LineChartShadow";
import Sales from "../../components/Charts/SalesChartV2";
import LineChartWithArea from "../../components/Charts/LineChartWithArea";

// widgets
import SocialFeeds from "../../components/Widgets/SocialFeeds";
import NewPost from "../../components/Widgets/AddNewBlog";
import DeviceShare from "../../components/Widgets/DeviceShare";

import { ChartConfig } from "../../constants/chart-config";

export default {
  components: {
    LineChartShadow,
    Sales,
    LineChartWithArea,
    SocialFeeds,
    NewPost,
    DeviceShare
  },
  data() {
    return {
      blog: {
        id: 3,
        thumbnail: "/static/img/blog-3.jpg",
        title: "lorem ipsum is simply dummy text",
        body:
          "Consectetur adipisicing elit. Ullam expedita, necessitatibus sit exercitationem aut quo quos inventore similique nulla minima distinctio illo iste dignissimos vero nostrum, magni pariatur delectus natus.",
        date: "1-jun-2018"
      },
      ChartConfig,
      labels: ["A", "B", "C", "D", "E", "F", "J", "K", "L", "M", "N", "P"],
      totalEarnings: [30, 50, 25, 55, 44, 60, 30, 20, 40, 20, 40, 44],
      onlineRevenue: [30, 50, 25, 55, 44, 60, 30, 20, 40, 20, 40, 44],
      newCustomers: [30, 50, 25, 55, 44, 60, 30, 20, 40, 20, 40, 44]
    };
  }
};
</script>
