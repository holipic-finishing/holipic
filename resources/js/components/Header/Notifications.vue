<template>
<v-menu
		:close-on-content-click="false"
		offset-y
		left
		origin="right top" z-index="99" content-class="cart-dropdown" transition="slide-y-transition" nudge-top="-20"
	>
		<v-badge right overlap slot="activator">
			<span slot="badge">{{countNotifications}}</span>
			<i class="zmdi grey--text zmdi-notifications-active animated infinite wobble zmdi-hc-fw font-lg"></i>
		</v-badge>
		<v-card>
			<div class="dropdown-top d-custom-flex justify-space-between primary">
				<span class="white--text fw-bold">Notifications</span>
				<span class="v-badge warning">{{countNotifications}} NEW </span>
			</div>
			<div class="dropdown-content">
				<vue-perfect-scrollbar style="height:280px" :settings="settings">
					<v-list two-line>
						<template v-for="(notification, index) in notifications">
							<v-list-tile :key="index">
								<div class="product-img mr-3">
								 <v-tooltip bottom>
								 	<v-btn
								        slot="activator"
								        flat icon color="#00c2e0"
								        @click="updateIsReadById(notification)"
								      >
								        <v-icon>fiber_manual_record</v-icon>
								      </v-btn>
					               <span>{{ $t('message.hidingRead') }}</span>
					            </v-tooltip>
								</div>
								<v-list-tile-content>
									<span class="fs-14">{{ $t(notification.message) }}</span>
									<span class="fs-12 grey--text text-sx-right">
										{{notification.created_at}}
									</span>
								</v-list-tile-content>
								
							</v-list-tile>
						</template>
					</v-list>
				</vue-perfect-scrollbar>
			</div>
			<v-card-actions>
                <v-btn small color="primary" @click="showAllnotification()">{{ $t('message.viewnotifition') }}</v-btn>
            </v-card-actions>
		</v-card>
</v-menu>
</template>

<script>

import { getWithData, put } from '../../api/index.js'
import config from '../../config/index.js'
import { getCurrentAppLayout } from "../../helpers/helpers.js";
import Notifications from '../../views/notifications/Notifications'
	export default {
		data() {
			return {
				notifications: [],
				settings: {
			        maxScrollbarLength: 160
			    },
			    count:10,
			    user:{},
			    newnotification : global_notification
			};
		},
		components:{
			Notifications
		},
		methods:{
			fetchData(){
				this.user = JSON.parse(localStorage.getItem('user'))
				let url = config.API_URL + 'notifications'
				let params = {
					user_id : this.user.id
				}
				getWithData(url,params)
				.then(res => {
					if(res.data && res.data.success){
						let data = res.data.data
						this.notifications = data
					}
				})	
				.catch(err => {
					console.log(err)
				})
			},
			getCurrentAppLayoutHandler() {
				return getCurrentAppLayout(this.$router);
			},
			updateIsReadById(item) {
				let url = config.API_URL + 'notifications/'+item.id
				put(url,item)
				.then(res => {
					if(res.data && res.data.success){
						this.removeNotification(item)
						this.$root.$emit('refresh-datav2', true)

						
					}
				})	
				.catch(err => {
					console.log(err)
				})
			},
	
			showAllnotification(){
				var useAut = this.user
				var user_id = useAut.id
				if (useAut.role_id == 2) {

					this.$router.push({
						name: 'CompnayNotification',
						params: { id : user_id }
					});

				} else {

					this.$router.push({
						name: 'AdminNotification',
						params: { id: user_id }
					});

				}
			},
			removeNotification(item) {
				if(this.newnotification.length){
					var index1 = this.newnotification.findIndex(function(value){
						return value.id == item.id
					});
					this.newnotification.splice(index1, 1);
				}
				
				var index2 = this.notifications.findIndex(function(value){
					return value.id == item.id
				});
                this.notifications.splice(index2, 1);
			}
	

		},
		created(){
			this.fetchData()
			var noti = this
			socket.on('view-listings',function(data){
			        noti.notifications.unshift(data)
			    });
		},
		computed:{
			countNotifications(){
				if(this.newnotification && this.newnotification.length){
					this.notifications.unshift(this.newnotification[0])
				}
				return this.notifications.length
			},
		},
		mounted() {
			this.$root.$on('refresh-data', (data) => {
 				this.removeNotification(data)
 	 		})
		}
	};
</script>

<style lang="css" scoped>
.v-card__actions {
	justify-content: center !important
}
</style>