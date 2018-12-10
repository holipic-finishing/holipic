<template>
	<div>
		<page-title-bar></page-title-bar>
		<div style="padding:0px 20px">
		  <v-card>
		    <v-card-title class="headline font-weight-regular blue-grey white--text">Information</v-card-title>
		    <v-card-text>
		    	<div class="container">
		    		<div class="row">
		    			<div class="col-sm-4">
							<img src="/static/avatars/user-12.jpg" class="img-responsive rounded-circle mr-4" alt="user profile" width="70%" /> 
		    			</div>
		    			
		    			<div class="col-sm-8">
		    				<v-form ref='vform' v-model="valid">
		    				<label class="company-label">Company name:</label>
		    				<v-flex xs12 >
					          <v-text-field
					            label="Outline"
					            single-line
					            outline
					            v-model="company.name"
					            :rules="[rules.required]"
					          ></v-text-field>
					        </v-flex>
					        <label class="company-label">Description:</label>
					        <v-flex xs12 >
					          <v-text-field
					            label="Outline"
					            single-line
					            outline
					            v-model="company.description"
					            :rules="[rules.required, rules.min]"
					          ></v-text-field>
					        </v-flex>
					        <label class="company-label">Address:</label>
					        <v-flex xs12 >
					          <v-text-field
					            label="Outline"
					            single-line
					            outline
					            v-model="company.address"
					            :rules="[rules.required, rules.min]"
					          ></v-text-field>
					        </v-flex>

					       <!--  <v-flex xs12 >
					          <v-text-field
					            label="Outline"
					            single-line
					            outline
					          ></v-text-field>
					        </v-flex> -->
					        </v-form>
					        <v-btn
						      color="info"
						      @click="updateCompany()"
						    >
						      Update Company
						    </v-btn>
						    
		    			</div>

		    		</div>
		    	</div>
		      	<!-- <div class="media pos-relative">
					<img src="/static/avatars/user-12.jpg" class="img-responsive rounded-circle mr-4" alt="user profile" width="20%" /> -->
					<!-- <div class="media-body">
						<span class="pink--text">Request</span>
						<h2>Andre Hicks</h2>
						<span>Sr. Develoepr @Oracle</span>
						<div class="btn-wrapper">
						<v-btn color="success">Accept</v-btn>
						<v-btn color="error">Reject</v-btn>
						</div>
					</div> -->
					<!-- <v-avatar color="warning" class="overlap">
						<v-icon dark>ti-id-badge</v-icon>
					</v-avatar> -->
			<!-- </div> -->
		    </v-card-text>
		  </v-card>
		</div>
		<div style="padding:10px 20px">
		  <v-card>
		    <v-card-title class="headline font-weight-regular blue white--text">Chart </v-card-title>
		    <v-card-text>
		    	<app-card
					:heading="$t('message.totalAmountCompany')"
					colClasses="xl12 lg12 md12 xs12 sm12"
					:fullScreen="true"
					:reloadable="true"
					:closeable="true"
					>					
					<div class="ladgend-wrapper mb-3">
						<p class="mb-0"><span class="ladgend ladgend-success"></span> <span>Open Rate</span></p>
						<p class="mb-0"><span class="ladgend ladgend-pink"></span> <span>Recurring Payments</span></p>
					</div>
					<total-earnings :width="300" :height="300" :companyId="companyId"></total-earnings>				
				</app-card>
		    </v-card-text>
		      
		  </v-card>
		</div>
	</div>	
</template>

<script>
import config from '../../config/index.js'
import Vue from 'vue'
import TotalEarnings from "../../components/Charts/TotalEarnings"
export default {
  	name: 'chart-company',
   	components: {
    TotalEarnings
  },
  data () {
    return {
    	loader: null,
        loading: false,
        company: [],
        companyId: this.$route.query.companyId,
        valid: false,
        rules: {
        	required: value => !!value || 'This field is required.',
        	min: value => value.length >= 8 || 'Min 8 characters'
        }
        // totalEarnings: [30, 50, 25, 55, 44, 60, 30, 20, 40, 20, 40, 44]
    }

  },
  watch: {
  	loader () {
        const l = this.loader
        this[l] = !this[l]
        setTimeout(() => (this[l] = false), 3000)
        this.loader = nulls
    }
  },

  mounted() {
  	//alert(this.companyDescription)
  	this.informationCompany()
  },

  methods:{
  		updateCompany() {
  			axios.put(config.API_URL+'companies/'+this.$route.query.companyId, {params: {name: this.company.name, address: this.company.address, description: this.company.description}})
  			.then (response => {
  				if(response && response.data.success) {
  					this.company = response.data.data
  					 setTimeout(function(){	
  					 	Vue.notify({
  					 	 group: 'loggedIn',
  					 	 type: 'success',
  					 	 text: 'Update success'
  					 	});
  					 },500);

  				}
  			})
  		},
  		informationCompany() {
  			axios.get((config.API_URL+'companies/'+this.$route.query.companyId))
  			.then ((response) => {
  				if(response && response.data.success) {
  					this.company = response.data.data
  				}
  			});
  		}
  }
}
</script>

<style lang="css" scoped>
	.img-responsive {
		margin-left:0px;
		margin-top:70px;
	}
	.company-label{
		color:#607d8b;
		font-size: 17px;
	}
</style>