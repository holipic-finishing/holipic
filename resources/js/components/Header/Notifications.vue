<template>
	<v-menu
		v-model="menu"
		:close-on-content-click="false"
		offset-y
		left
		origin="right top" 
		z-index="99" 
		content-class="cart-dropdown" 
		transition="slide-y-transition" 
		nudge-top="-20"
	>
		<v-badge
			right 
			overlap 
			slot="activator"
		>
			<span slot="badge" v-if="countNotifications != 0">{{countNotifications}}</span>
			<i class="zmdi grey--text zmdi-notifications-active animated infinite wobble zmdi-hc-fw font-lg"></i>
		</v-badge>
		<v-card>
			<div class="dropdown-top d-custom-flex justify-space-between primary">
				<span class="white--text fw-bold">Notifications</span>
				<span class="v-badge warning">{{countNotifications}} NEW </span>
			</div>
			<div v-if="notifications && notifications.length" class="dropdown-content">
				<vue-perfect-scrollbar class="scroll-area" :settings="settings" style="height:280px;">
					<v-list two-line>
						<template v-for="(notification, index) in notifications">
							<v-list-tile :key="index" :class="!notification.is_read ? 'style-content not-read' : 'style-content'" @click="updateIsReadById(notification)">
								<div class="product-img mr-3">
								<v-tooltip bottom v-if="notification.is_read == true">
									<v-btn 
									slot="activator"
									flat 
									icon 
									color="#000000"

									>
										<v-icon>fiber_manual_record</v-icon>
									</v-btn>
								<!-- <span>{{ $t('message.hidingRead') }}</span> -->
								</v-tooltip>
								<v-tooltip bottom v-if="notification.is_read == false">
									<v-btn 
									slot="activator"
									flat 
									icon 
									color="#00c2e0"
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
			<div v-else>
				<v-list two-line v-if="notifications && !notifications.length">
						<v-list-tile>
							<v-list-tile-content>
								<v-list-tile-title class="style-data">
									No New Notifications Found
								</v-list-tile-title>
							</v-list-tile-content>
						</v-list-tile>
				</v-list>
			</div>
			<v-card-actions v-if="paginator.to !== paginator.total">
		        <v-btn 
		        	small 
		        	color="primary" 
		        	@click="showAllnotification()"
		        >
		      		More..
		      	</v-btn>
      		</v-card-actions>
		</v-card>
</v-menu>
</template>

<script>

import { getWithData, put, get } from '../../api/index.js'
import config from '../../config/index.js'
import { getCurrentAppLayout } from "../../helpers/helpers.js";
import Notifications from '../../views/company-admin/notifications/Notifications'

	export default {
		data() {
			return {
				notifications: [],
				arrNotifi:[],
				settings: {
			        maxScrollbarLength: 160
			    },
			    paginator: {
	                perPage: 6,
	                currentPage: 1,
	                lastPage: 1,
	                total: 0,
	                from: 0,
	                to: 0,
        		},
			    user:{},
			    newnotification : global_notification,
			    menu: false
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
					perPage: this.paginator.perPage,
                	page: this.paginator.currentPage,
					user_id : this.user.id
				}
				getWithData(url,params)
				.then(res => {
					if(res.data && res.data.success){
						let data = res.data.data.data
						this.paginator.total = res.data.data.total
						this.paginator.to = res.data.data.to
						this.paginator.currentPage = res.data.data.current_page
						this.notifications = data
					}
				})	
				.catch(err => {
					console.log(err)
				})
			},
			getAllNotification(){
				var useAut = this.user
				let url = config.API_URL + 'get-notifications/' + useAut.id
				get(url)
				.then(res => {
					if(res.data && res.data.success){
						this.arrNotifi = res.data.data
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
						// this.fetchData()
						this.removeNotification(item)
						// this.$root.$emit('refresh-datav2', true)

						
					}
				})	
				.catch(err => {
					console.log(err)
				})
			},
	
			showAllnotification(){
				var useAut = this.user
				this.paginator.currentPage = this.paginator.currentPage + 1

				let url = config.API_URL + 'notifications'
				let params = {
					perPage: this.paginator.perPage,
                	page: this.paginator.currentPage,
					user_id : useAut.id
				}
				getWithData(url,params)
				.then(res => {
					if(res.data && res.data.success){
						let data = res.data.data.data
						this.paginator.to = res.data.data.to
						var vm = this
						var dataItem = vm.notifications
						_.forEach(data, function(value, key){
							dataItem.push(value)
						})
					
						vm.notifications = _.uniqBy(dataItem,'id')
					}
				})	
				.catch(err => {
					console.log(err)
				})
			},
			removeNotification(item) {
				this.getAllNotification()
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
			},
			
	

		},
		created(){
			this.fetchData()
			this.getAllNotification()
			var userAuth = JSON.parse(localStorage.getItem('user'))
			var noti = this
			socket.on('view-listings',function(data){
					if (data.user_id == userAuth.id) {
			        	noti.arrNotifi.unshift(data)
			        	noti.notifications.unshift(data)
						noti.paginator.total = noti.paginator.total + 1
						noti.paginator.to = noti.paginator.to + 1
					}
			    });
		},
		computed:{
			countNotifications(){
				if(this.newnotification && this.newnotification.length){
					this.arrNotifi.unshift(this.newnotification[0])
				}
				
				// let vm = this
				// let count = 0;
				// _.forEach(vm.notifications, function(value, key){
				// 	if(value.is_read === false){
				// 		count =count + 1
				// 	}
				// })
				return this.arrNotifi.length
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
.style-data {
	text-align: center !important
}
.not-read {
	background-color: #edf2fa !important;
}
.scrollbar-style {
	height: 300px;
}
</style>