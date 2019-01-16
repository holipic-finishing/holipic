<template>
	<v-menu
		:close-on-content-click="false"

		offset-y
		left
		origin="right top" z-index="99" content-class="cart-dropdown" transition="slide-y-transition" nudge-top="-20"
	>
		<v-badge right overlap slot="activator" title="Activity Logs" @click.native="hiddenMenuActivity()">
			<span slot="badge" v-if="total>0">{{total}}</span>
		
			<i class="zmdi grey--text animated zmdi zmdi-ticket-star infinite wobble zmdi-hc-fw font-lg">
				
			</i>
		</v-badge>


		<v-card>
			<div class="dropdown-top d-custom-flex justify-space-between primary">
				<span class="white--text fw-bold">Activity Logs</span>
				<span class="v-badge warning">{{total}} New</span>
			</div>
			<div class="text-xs-center pa-4" v-if="data == ''">
				<!-- <span class="d-block font-3x mb-15 error--text">
					<i class="zmdi zmdi-shopping-cart"></i>
				</span> -->
				<v-list-tile>
					<v-list-tile-content>
						<v-list-tile-title class="style-data">
							No New Activity
						</v-list-tile-title>
					</v-list-tile-content>
				</v-list-tile>
			</div>
			<div v-else class="dropdown-content">
				<vue-perfect-scrollbar  :settings="settings" class="custom-height">
					<v-list two-line>
						
						<template v-for="(value, index) in data">
							
							<v-list-tile :key="index" class="hover_activity">
								<!-- <div class="product-img mr-3">
									<img height="55" width="55" :src="value.productImg">
								</div> -->

								<v-list-tile-content>
									<span class="fs-14">{{companyName}}</span>
									<span class="fs-12 grey--text">
										<v-icon  color="orange darken-2" v-if="value.description == 'updated'" class="mr-2 hover-icon">edit</v-icon>
			                			<v-icon  color="red lighten-2" v-if="value.description == 'deleted'" class="mr-2 hover-icon">delete</v-icon>
			                			<v-icon  color="primary darken-2" v-if="value.description == 'created'" class="mr-2 hover-icon">add_circle</v-icon>
										<b>{{value.description_log}}</b> - {{value.updated_at}}
									</span>
								</v-list-tile-content>
								
								<v-list-tile-action @click="readActivityLog(value, index)">
									<v-btn icon title="watch">
										<i class="material-icons">
											visibility
										</i>
									</v-btn>
								</v-list-tile-action>

							</v-list-tile>
							
						</template>
					
					</v-list>
				</vue-perfect-scrollbar>
				<delete-confirmation-dialog
					ref="deleteConfirmationDialog"
					heading="Are You Sure You Want To Delete?"
					message="Are you sure you want to delete this product permanently?"
				>
				</delete-confirmation-dialog>
			</div>
			<v-card-actions >
		        <v-btn 
		        	v-if="checkloadMore"
		        	small 
		        	color="primary" 
		        	@click="loadMore(currentPage +1)"
		        >
		      		{{ $t('message.viewnotifition') }}
		      	</v-btn>
      		</v-card-actions>
		</v-card>
	</v-menu>
</template>

<script>
import { mapGetters } from "vuex";
import { getCurrentAppLayout } from "../../helpers/helpers.js";
import config from "../../config/index.js"
import moment from "moment"
import  { get, post, put, del, getWithData } from '../../api/index.js'


export default {
  	props: ["horizontal"],
  	data() {
    	return {
    		selectDeletedProduct: null,
    		settings: {
        		maxScrollbarLength: 160
      		},
      		data: [],
      		user: JSON.parse(localStorage.getItem('user')),
		    url: config.API_URL+'activity-log/show',
		    total: 0,
		    paginator: {
                perPageDay: 7,
                page: 1,

        	},
        	checkloadMore: false,
        	currentPage: 1,
        	companyName: '',
        	hiddenActivity: false
    	};
  	},
  	created() {
  		var _this = this
  		socket.on('view-activity',function(data){
			// _this.data.unshift(data)
			// _this.total = _this.total + 1
			_this.data = []
			_this.getActivityLogs(1)
			
		}.bind(this));
		
  	},
  	mounted() {
  		this.getActivityLogs(this.paginator.page)
  		this.companyName = this.user.company_name
  	},
  	computed: {
   		
  	},
  	methods: {
		getActivityLogs(page) 
		{
			let params = {
                perPage: this.paginator.perPageDay,
                userId: this.user.id,
                page: page
            }	
			getWithData(config.API_URL+'activity-log/show', params)
			.then(response => {
				if (response.data && response.data.success) {
					let _this = this

					var array = []

					 _.forEach(response.data.data[0][0],function(value, key){
					 		_this.data.push(value)
		             });

		            this.total = response.data.data[0][1].total

		            this.currentPage = response.data.data[0][1].current_page

					if(response.data.data[0][1].last_page > 1) 
					{
						this.checkloadMore = true
					}
				}
				
			})
		},
		loadMore(n)
		{
			let params = {
                perPage: this.paginator.perPageDay,
                userId: this.user.id,
                page: n
            }

            getWithData(config.API_URL+'activity-log/show', params)
			.then(response => {
				if (response.data && response.data.success) { 
					let _this = this
					var array = []

					 _.forEach(response.data.data[0][0],function(value, key){
					 		_this.data.push(value)
		             });

		            this.total = response.data.data[0][1].total

		            this.currentPage = response.data.data[0][1].current_page

					if(response.data.data[0][1].current_page == response.data.data[0][1].last_page ) 
					{
						this.checkloadMore = false
					}
				}
				
			})
		},
		readActivityLog(item, key) {
			console.log(item)
			get(config.API_URL+'activity-log/update?id='+item.id)
			.then(response => {
				if(response && response.data.success) {
					 this.data.splice(key, 1);
					 this.total = this.total - 1
					 this.data = []
					 this.getActivityLogs(1)

					 if(this.data.length <= 7) {
					 	this.checkloadMore = false
					 }

				}
			})
		}
		
  	}
};
</script>
<style scoped lang="scss">
	.v-card__actions {
		justify-content: center !important;
	}

	.style-data {
		text-align: center !important;
		
	}
	.custom-height{
		height: 350px !important;
	}
	
</style>
