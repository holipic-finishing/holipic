<template>
	<div class="col-sm-8" >
	    <app-card
			:heading="$t('message.activityLog')"
			:fullBlock="true"
			:closeable="true"
			:reloadable="true"
			:fullScreen="true"	
			colClasses="xl12 lg12 md12 sm12 xs12"
			width="200"
		>
			<v-divider></v-divider>
			<vue-perfect-scrollbar style="height:404px" :settings="settings">      
	          	<div v-for="valueTime,indexTime in times">
	          		 <v-container fluid grid-list-lg>
			            <v-layout row>

			                <v-flex xs6>
			                  <v-card-title primary-title>
			                    <div>
			                      <div class="headline">{{ valueTime.date | moment(" MMM Do YYYY") }}</div>
			                      <div>{{valueTime.date | moment('dddd')}}</div> 
			                    </div>
			                  </v-card-title>
			                </v-flex>

			                <v-flex xs6>
			                		<div v-for="valueLog, indexLog in activityLog" class="bottom-activelog" v-if="valueLog.date == valueTime.date">
			                			<v-icon  color="orange darken-2" v-if="valueLog.description == 'updated'" class="mr-2 hover-icon">edit</v-icon>
			                			<v-icon  color="red lighten-2" v-if="valueLog.description == 'deleted'" class="mr-2 hover-icon">delete</v-icon>
			                			<v-icon  color="primary darken-2" v-if="valueLog.description == 'created'" class="mr-2 hover-icon">add_circle</v-icon>
			                			<!-- <v-btn round :color="valueLog.description == 'updated' ? 'warning' : valueLog.description == 'created' ? 'primary' : 'error'" dark small @click="detailLog(valueLog.id)">Form</v-btn> --> <b>{{valueLog.name}}</b>
			                			{{valueLog.description}} <span>form</span> <b>{{valueLog.subject_type}}</b> at {{valueLog.updated_at}}

			                		</div>
			                </v-flex>

			            </v-layout>
		            </v-container>

		            <v-divider></v-divider>
		        </div>
		    </vue-perfect-scrollbar>

		        <v-container fluid grid-list-lg>
		        <div class="more">
				    <div class="row pagination-fl">
				    	<div class="paging">

				    		<div class="paging-bottom">
				    			<div class="pagination-style">
				    				<a class="btn-nav link disabled" @click="moreActiveLog(1)">
				    					<i class="ti-angle-double-left"></i>
				    				</a>

				    				<a class="btn-nav link disabled secondary-color" @click="moreActiveLog(pagination.current_page - 1)">
				    					<i class="ti-angle-left"></i>
				    				</a>

				    				<template>
				    					<template v-for="n in pagination.last_page">
				    						<a class="page" @click="moreActiveLog(n)" :class="{'secondary-color': pagination.current_page == n}">{{ n }}</a>
				    					</template>
				    				</template>

									<a class="btn-nav link disabled secondary-color" @click="moreActiveLog(pagination.current_page + 1)">
										<i class="ti-angle-right"></i>
									</a>

									<a class="btn-nav link disabled" @click="moreActiveLog(pagination.last_page)">
										<i class="ti-angle-double-right"></i>
									</a>
								</div>
							</div>
						</div>

				    	<div>
				    		Total: <b>{{pagination.total_page}}</b> Days
				    	</div>

				    </div>  
	        		
	        	</div> 
	        	</v-container>
		    	
		</app-card>	
	</div>
			
</template>

<script>
//config 
import config from '../../config/index.js'
import moment from "moment"
import  { get, post, put, del, getWithData } from '../../api/index.js'



export default {
	data() {
		return {
			activityLog: [],
			times: [],
			sheet:'',
			perPage: 2,
        	firstpage: {
        		firstPageDay:1,
        		firstPageWeek:1,
        		firstPageMonth:1,
        		firstPageYear:1,
        	},
        	pagination:{},
        	settings: {
		        maxScrollbarLength: 160
		    },
		    user: JSON.parse(localStorage.getItem('user')),
		    url: config.API_URL+'activity-log/show'
		}
	},

	created() {
		this.getActiveLog()
	},

	mounted() {
		this.$root.$on('editItemSucess', res => this.getActiveLog())
	},

	methods: {

		getActiveLog() {
		
			let params = {
                perPage: this.perPage,
                userId: this.user.id,
                page: 1
            }	

			getWithData(this.url, params)
			.then(response =>{
				if(response && response.data.success) {
					this.activityLog = response.data.data[0]

					this.times = response.data.data[1].data
					
					this.pagination = {
						current_page: response.data.data[1].current_page,
						last_page: parseInt(response.data.data[1].last_page),
						from_page: response.data.data[1].from,
						to_page: response.data.data[1].to,
						total_page: response.data.data[1].total,
						// path_page: response.data.data[1].path,
						// first_link: response.data.data[1].first_page_url,
						// last_link: response.data.data[1].last_page_url,
						// prev_link: response.data.data[1].prev_page_url,
						// next_link: response.data.data[1].next_page_url

					}
					console.log(response.data.data[1].current_page)
				}
			})
		},

		detailLog(id) {
			// this.$router.push({path: '/default/active-log/detail'});
		},

		moreActiveLog(n){

			if(n > this.pagination.last_page)
			{
				n = this.pagination.last_page
			}

			let params = {
                perPage: this.perPage,
                userId: this.user.id,
                page: n
            }

            getWithData(this.url, params)
			.then(response =>{
				if(response && response.data.success) {
					this.activityLog = response.data.data[0]

					this.times = response.data.data[1].data
					
					this.pagination = {
						current_page: response.data.data[1].current_page,
						last_page: parseInt(response.data.data[1].last_page),
						from_page: response.data.data[1].from,
						to_page: response.data.data[1].to,
						total_page: response.data.data[1].total,
						path_page: response.data.data[1].path,
						first_link: response.data.data[1].first_page_url,
						last_link: response.data.data[1].last_page_url,
						prev_link: response.data.data[1].prev_page_url,
						next_link: response.data.data[1].next_page_url

					}

				}
			})	
		}

	}

};
</script>
<style lang="scss" scoped>

	.headline{
		font-size:20px !important;
		font-weight: bold;
	}

	.line{
		height: 3px;
		color:red;
		width: auto;
	}

	.bottom-activelog{
		margin-bottom: 10px;
		font-size: 0.875rem !important;
	}

	/*.more{
		right:0px;
		position: absolute;
		margin-right:20px;
	}*/

	.pagination-fl{
		display: flex !important;
	    justify-content: space-between !important;
	    padding: 0 15px !important;
	    align-items: baseline !important;
	}

	.pagination-style {
	 	display: inline-block;
	 	font-size:12px;
	}

	.pagination-style  a{
		color: black;
	    float: left;
	    padding: 8px 15px;
	    text-decoration: none;
	}

	.pagination-style a:hover:not(.active) {background-color: #ddd;}

	.pagination-style a {
	   border-radius: 8px;
	}

	.page.secondary-color {
		background-color: #5d92f4;
	}
	
</style>