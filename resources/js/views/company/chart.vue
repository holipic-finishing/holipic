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
		    				<v-form ref="form" lazy-validation>
			    				<label class="company-label">Company name:</label>
			    				<v-flex xs12 >
						          <v-text-field
						            label="Outline"
						            single-line
						            outline
						            type="text"
						            name="company.name"
						            v-model="company.name"
						            required
						            :rules="[rules.required, rules.min]"
						          ></v-text-field>
						        </v-flex>
						        <label class="company-label">Description:</label>
						        <v-flex xs12 >
						          <v-text-field
						            label="Outline"
						            single-line
						            outline
						            v-model="company.description"
						            :rules="[rules.required]"
						          ></v-text-field>
						        </v-flex>
						        <label class="company-label">Address:</label>
						        <v-flex xs12 >
						          <v-text-field
						            label="Outline"
						            single-line
						            outline
						            v-model="company.address"
						            :rules="[rules.required]"
						          ></v-text-field>
						        </v-flex>

					        </v-form>
					        <v-btn
						      color="info"
						      :disabled="!valid"
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
						<div class="row">
							<!-- <div class="col-sm-4">
								<p class="mb-0"><span class="ladgend ladgend-success"></span> <span>Open Rate</span></p>
								<p class="mb-0"><span class="ladgend ladgend-pink"></span> <span>Recurring Payments</span></p>
							</div>
 -->
							<div class="col-sm-2">
								 <v-select
						          :items="selectDate"
						          label="Choose Date or Month"
						          outline
						          v-model="valueSelectDateMonth"
						        ></v-select>
							</div>

							<div class="col-sm-4">
								
								 <v-menu
							        ref="menu"
							        :close-on-content-click="false"
							        v-model="menu"
							        :nudge-right="40"
							        :return-value.sync="date"
							        lazy
							        transition="scale-transition"
							        offset-y
							        full-width
							        min-width="290px"
							      >
							        <v-text-field
							          slot="activator"
							          v-model="date"
							          label="Date/Month"
							          prepend-icon="event"
							          outline
							          @change="loadChartWithDayMonth"
							        ></v-text-field>

							        <v-date-picker v-model="date" no-title scrollable :type="valueSelectDateMonth == 'Month' ? 'month' : 'date'">
							          <v-spacer></v-spacer>
							          <v-btn flat color="primary" @click="menu = false">Cancel</v-btn>
							          <v-btn flat color="primary" @click="loadChartWithDayMonth">OK</v-btn>
							        </v-date-picker>
							      </v-menu>
							</div>
						
						</div>
					
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
        valid: true,
        rules: {
        	required: value => !!value || 'This field is required.',
        	min: value => value.length >= 8 || 'Min 8 characters',
        },
        date: new Date().toISOString().substr(0, 10),
      	menu: false,
      	modal: false,
      	menu2: false,
      	selectDate: ['Day', 'Month'],
      	valueSelectDateMonth: ''
       
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
  			if (this.$refs.form.validate()) {
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
  			}	
  		},
  		informationCompany() {
  			axios.get((config.API_URL+'companies/'+this.$route.query.companyId))
  			.then ((response) => {
  				if(response && response.data.success) {
  					this.company = response.data.data
  				}
  			});
  		},

  		loadChartWithDayMonth() {
  			this.$refs.menu.save(this.date)
  			//alert(this.valueSelectDateMonth)
  			axios.get(config.API_URL+'company/load-chart?type='+this.valueSelectDateMonth+'&date='+this.date+'&companyId='+this.companyId)
  			.then((response) => {
  				if(response && response.data.success) {
  					this.$root.$emit('companyChart', response.data.data)
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