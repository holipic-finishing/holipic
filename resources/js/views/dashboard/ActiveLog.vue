<template>
	
		<div class="row" style="margin-top:20px">
			
			<div class="col-sm-8" >
				
				    <v-toolbar color="#949596" dark>
				      <v-toolbar-side-icon></v-toolbar-side-icon>
				      <v-toolbar-title>Active Logs</v-toolbar-title>
				      <v-spacer></v-spacer>
				      <!-- <v-btn icon>
				        <v-icon>search</v-icon>
				      </v-btn> -->
				    </v-toolbar>
				    <v-card>
				      <v-container fluid grid-list-lg>

				        <v-layout row wrap>
				          
					        <v-flex xs12 >
					          	<div v-for="valueTime,indexTime in times">
					          		 <v-card color="white" class="black--text" >
							            <v-layout row>
							                <v-flex xs5>
							                  <v-card-title primary-title>
							                    <div>
							                      <div class="headline">{{ valueTime.date | moment(" MMM Do YYYY") }}</div>
							                      <div>{{valueTime.date | moment('dddd')}}</div> 
							                    </div>
							                  </v-card-title>
							                </v-flex>
							                <v-flex xs7>
							                	
							                		<div v-for="valueLog, indexLog in activeLogs" class="bottom-activelog" v-if="valueLog.date == valueTime.date">
							                			<v-icon small color="black darken-2" v-if="valueLog.description == 'updated'">edit</v-icon>
							                			<v-icon small color="black darken-2" v-if="valueLog.description == 'deleted'">delete</v-icon>
							                			<v-icon small color="black darken-2" v-if="valueLog.description == 'created'">add_circle</v-icon>
							                			<v-btn round :color="valueLog.description == 'updated' ? 'warning' : valueLog.description == 'created' ? 'primary' : 'error'" dark small @click="detailLog(valueLog.id)">Form</v-btn> <b>{{valueLog.name}}</b>
							                			{{valueLog.description}} <span>form</span> <b>{{valueLog.subject_type}}</b> at {{valueLog.updated_at}}
							                		</div>
							                </v-flex>
							            </v-layout>
						              
						              <!-- <v-card-actions class="pa-3">
						                Rate this album
						                <v-spacer></v-spacer>
						                <v-icon>star_border</v-icon>
						                <v-icon>star_border</v-icon>
						                <v-icon>star_border</v-icon>
						                <v-icon>star_border</v-icon>
						                <v-icon>star_border</v-icon>
						              </v-card-actions> -->
						            </v-card>
						            <v-divider></v-divider> <br>

						        </div>
						        <div class="more">
					          		<v-btn fab dark color="blue" small @click="moreActiveLog()">
								      <v-icon dark small>add</v-icon>
								    </v-btn>
					        		
					        	</div> 
						    	 
					        </v-flex>			        	
					       
				        </v-layout>
				      </v-container>
				    </v-card>	
			</div>

			<div class="col-sm-6 ">
				
			</div>
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
			activeLogs: [],
			times: [],
			sheet:'',
			paginator: {
                perPageDay: 2,
                page: 1,

        	},

        	firstpage: {
        		firstPageDay:1,
        		firstPageWeek:1,
        		firstPageMonth:1,
        		firstPageYear:1,
        	},
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
			var user = JSON.parse(localStorage.getItem('user'))
			
			let url = config.API_URL+'active-log/show'

			let params = {
                perPage: this.paginator.perPageDay,
                userId: user.id,
                page: this.paginator.page
            }	

			getWithData(url, params)
			.then(response =>{
				if(response && response.data.success) {
					//console.log(response)
					this.activeLogs = response.data.data[0]
					this.times = response.data.data[1].data
					console.log(this.times)
				}
			})
		},

		detailLog(id) {
			// this.$router.push({path: '/default/active-log/detail'});
		},

		moreActiveLog(){
			this.firstpage.firstPageDay = this.firstpage.firstPageDay + 1 
			var page = this.firstpage.firstPageDay

			var user = JSON.parse(localStorage.getItem('user'))

			let url = config.API_URL+'active-log/show'

			let params = {
                perPage: this.paginator.perPageDay,
                userId: user.id,
                page: page
            }

            getWithData(url, params)
			.then(response =>{
				if(response && response.data.success) {
					this.activeLogs = response.data.data[0]
					
					if(response.data.data[1].data.length > 0) {
						this.times.push(response.data.data[1].data[0])
						
					}
				}
			})	
		}

	}

}
</script>
<style >

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
	}

	/*.more{
		right:0px;
		position: absolute;
		margin-right:20px;
	}*/
</style>
