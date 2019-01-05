<template>
	<div class="col-sm-4">
		<app-card
			:heading="$t('message.notifications')"
			:fullBlock="true"
			:closeable="true"
			:reloadable="true"
			:fullScreen="true"
			colClasses="xl12 lg12 md12 sm12 xs12"
			width="200"
		>
			<v-list two-line>
				<vue-perfect-scrollbar style="height:392px" :settings="settings">
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
				</vue-perfect-scrollbar>
					<div class="paging">
					
					<div class="paging-bottom" v-if="notifications && notifications.length">
						<div class="paging-bottom">
							<div class="pagination-info">{{ paginationInfo }}</div>
								<div class="pagination-style">
									<a class="btn-nav link disabled" @click="goToPage(1)">
										<i class="ti-angle-double-left"></i>
									</a>
								<a class="btn-nav link disabled secondary-color" @click="goToPreviousPage()">
									<i class="ti-angle-left"></i>
								</a>
								<template v-if="isNotLongPage">
									<template v-for="n in paginator.lastPage">
										<a class="page" @click="goToPage(n)" :class="isCurrentPage(n) ? 'secondary-color' : ''">{{ n }}</a>
									</template>
								</template>

								<template v-else>
									<template v-for="n in longPaginatorSize">
										<a class="page" @click="goToPage(longPaginatorStart + n - 1)" :class="isCurrentPage(longPaginatorStart + n - 1) ? 'secondary-color ': ''">{{ longPaginatorStart + n - 1 }}</a>
									</template>
								</template>

									<a class="btn-nav link disabled secondary-color" @click="goToNextPage()">
										<i class="ti-angle-right"></i>
									</a>

									<a class="btn-nav link disabled" @click="goToPage(paginator.lastPage)">
										<i class="ti-angle-double-right"></i>
									</a>
								</div>
							</div>
						</div>
					</div>
					
					<div v-if="notifications && !notifications.length">
						<p style="text-align:center">No data available</p>
					</div>
					
			</v-list>
		
		</app-card>

	</div>
</template>

<script>
import { get, put, getWithData } from '../../../api/index.js'
import config from '../../../config/index.js'
import HeadNotification from '../../../components/Header/Notifications.vue'

export default {

  name: 'notification',

  data () {
    return {
    		user_id : JSON.parse(localStorage.getItem('user')),
    		notifications:{},
    		rowsPerPage: [10, 20, 30, 40, 50],
	    	paginator: {
	                perPage: 15,
	                currentPage: 1,
	                lastPage: 1,
	                total: 0,
	                from: 0,
	                to: 0,
        	},
            message:'',
        	longPaginatorEachSize: 2,
            existPageBefore: false,
            existPageAfter: false,
            settings: {
		        maxScrollbarLength: 160
		    }
    	}
  	},
  	components:{
  		HeadNotification
  	},
  	created(){
  		this.fetchData()

  	},
  	methods:{
  		fetchData(){
  			let url = config.API_URL + 'params-notification'
  			
  			 let params = {
                perPage: this.paginator.perPage,
                page: this.paginator.currentPage,
                user_id:this.user_id.id
            }
            // console.log(params)
  			getWithData(url,params)
  			.then(res =>{
  				if(res.data && res.data.success){
  					let data = res.data.data

  					this.notifications = data.data

                    this.paginator.lastPage = data.last_page
                    this.paginator.from = data.from
                    this.paginator.to = data.to
                    this.paginator.total = data.total
  				}
  			})
  			.catch(err => {
  				console.log(err)
  			})
  		},
  		updateIsReadById(item){
  			let url = config.API_URL + 'notifications/'+item.id
				put(url,item)
				.then(res => {
					if(res.data && res.data.success){
						this.fetchData()
						this.$root.$emit('refresh-data', item)
					}
				})	
				.catch(err => {
					console.log(err)
				})
  		},

  		// changePerPage(){

  		// 	let lastPage = _.ceil(this.paginator.total/this.paginator.perPage)

        //     if(this.paginator.currentPage > lastPage){
        //             this.paginator.currentPage = 1
        //     }
        //       this.fetchData()
  		// },

  		goToPage (page) {
            if(page > 0 && page <= this.paginator.lastPage && page != this.paginator.currentPage){
                this.paginator.currentPage = page
                this.fetchData()
            }
        },

         goToPreviousPage () {
            if (this.paginator.currentPage > 1) {
                this.paginator.currentPage--
                this.fetchData()
            }
        },

        isCurrentPage (page) {
            return page === this.paginator.currentPage
        },

        goToNextPage () {
            if (this.paginator.currentPage < this.paginator.lastPage) {
                this.paginator.currentPage++
                this.fetchData()
            }
        },
  	},
  	computed: {
  		paginationInfo () {
            return this.paginator.from + ' - ' + this.paginator.to + ' of ' + this.paginator.total
        },

        isNotLongPage () {
            return this.paginator.lastPage <= (this.longPaginatorEachSize * 2) + 4
        },

        longPaginatorSize () {
            return this.longPaginatorEachSize * 2 + 1;
        },

        longPaginatorStart () {

            if (this.paginator.currentPage <= this.longPaginatorEachSize + 1) {
                this.existPageBefore = false
                this.existPageAfter = true
                return 1
            }

            if (this.paginator.currentPage >= (this.paginator.lastPage - this.longPaginatorEachSize)) {
                this.existPageBefore = true
                this.existPageAfter = false
                return this.paginator.lastPage - (this.longPaginatorEachSize*2)
            }

            this.existPageBefore = true
            this.existPageAfter = true
            return this.paginator.currentPage - this.longPaginatorEachSize
        }
  	},
  	mounted() {
		this.$root.$on('refresh-datav2', (data) => {
 				this.fetchData()
 	 		})
		}
}
</script>

<style lang="css" scoped>
.not-read {
	background-color: #edf2fa !important;
}
.pagination-style {
	 display: inline-block;
	 font-size:10px;
}

.pagination-style  a{
	 color: black;
    float: left;
    padding: 6px 10px;
    text-decoration: none;
}

.pagination-style a:hover:not(.active) {background-color: #ddd;}

.pagination-style a {
   border-radius: 6px;
}

.paging-bottom {
	text-align: center;
}

.page.secondary-color {
	background-color: #5d92f4;
}

.ntf-pagination {
	width :50%;
	float: left;
}

.notification-dropdown-form-control {
	width:20%;
}
.paging{
	margin-top:15px;
}
.pagination-info {
	font-size:13px;
}
.style-content{
	border-bottom:1px solid #ccc
}

.app-card .app-card-title h3 {
	font-size:20px !important;
}
</style>