<template class="custom-room">
	<div class="room-margin">
		<v-card class="card-around">
		  	<v-list-tile-avatar class="v-list__tile__avatar--wh">
		  		<v-layout row wrap class="layout-position">
		  			<!-- <v-flex xs6 md6 lg6 class="flex-line-room-left">
		  				<div class="hr-room" style="z-index: 999; width: 200px; height: 3px; background-color: white;  transform: rotate(-45deg); right:0px; float:right;">
		  					
		  				</div>
		  			</v-flex> -->

		  			
		  			<!-- <v-flex xs6 md6 lg6 class="flex-line-room-right">
		  			  	<div class="hr-room" style="z-index: 999; width: 200px; height: 3px; background-color: white; position: absolute; transform: rotate(-45deg);">
		  			  		
		  			  	</div>
		  			</v-flex> -->

		  			<v-flex xs12 md12 lg12 class="mt-160">
		  				<marquee>
		  				<span style="font-size:30px !important;font-weight: bold; -webkit-text-fill-color: white;">Room</span>
		  				</marquee>
		  			</v-flex>

		  		</v-layout>

		  		<v-list-tile class="v-list-title--room">
		  			<v-text-field
		  			  solo
		  			  type="number"
		  			  v-model="room"
		  			></v-text-field>
		  			<div style="top: -16px !important; position: inherit;">
		  				<v-btn outline fab color="indigo" @click="loginRoom()">
					      <i class="fas fa-angle-double-down"></i>
					    </v-btn>
    				</div>
		  		</v-list-tile>

				<v-img src="https://santabarbaraca.com/content/uploads/2016/08/santa-barbara-beaches.jpg">
				</v-img>
  			</v-list-tile-avatar>

		</v-card>	
	</div>
</template>

<script>
import  { get, post, put, del, getWithData } from '../../../api/index.js'
import config from '../../../config/index.js'

export default {

  name: 'index',

  data () {
    return {
    	room:''
    }
  },
  methods: {
  	loginRoom()
  	{
  		get(config.API_URL+'room/show-photo?room='+this.room)
  		.then(res => {
  			if(res && res.data.success) {
  				var data = res.data.data
  				localStorage.setItem('photoRoom', JSON.stringify(data))
  				this.$router.push({name: 'ShopSelling', params :{data: data}}) 
  			}
  		})
  		.catch(err => {
  			this.$notify({
	          title: 'Error',
	          message: err.response.data.message,
	          type: 'error',
	          duration: 2000,
	        })
  		})
  	}
  }
}
</script>

<style lang="css" scoped>
</style>