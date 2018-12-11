<template>
<div>
	<page-title-bar></page-title-bar>
	<v-container fluid grid-list-xl pt-0>
      <v-layout row wrap>
        <app-card

        	:heading="$t('message.settingPackageSystem')"
            :fullBlock="true"
            colClasses="xl12 lg12 md12 sm12 xs12"
          >
		<div class="layout-tab">
		    <div class="tabs" >
		        <a v-for="(pp,index) in package" v-on:click="choosePackage(pp.package_name,pp.id)" v-bind:class="[ activetab === pp.package_name ? 'active' : '' ]">{{pp.package_name}}</a>
		    </div>

		    <div class="content-tab">
		        <div v-for="(pp,index) in package" v-if="activetab === pp.package_name" class="tabcontent">
		        	<div v-if="pp.setting != null">
			            <table class="table-wapper">
						  <thead class="thead-light">
						    <tr>
						      <th scope="col"></th>
						      <th scope="col"></th>
						    </tr>
						  </thead>
						  <tbody>
						    <tr>
						      <td>1.Cronjob expiry timing for deleting images files from company clouds to reduce space {{pp.package_name }} (Day)</td>
						      <td> 
						          <v-text-field
						            solo
						            :rules="[rules.required, rules.number]"	
						            v-model="pp.setting.expiration_date"
						            placeholder="Day"
						            counter="4"
						            maxlength="4"
						            append-outer-icon="edit"
						          ></v-text-field>
							       
							  </td>
						    </tr>
						    <tr>
						      <td>2.Manage system fees {{pp.package_name }} (%)</td>
						      <td><v-text-field
						            solo
						            :rules="[rules.required, rules.decimal]"
						            v-model="pp.setting.fee"	
						            placeholder="0.00"
						            append-outer-icon="edit"
						          ></v-text-field></td>
						    </tr>
						    <tr>
						      <td>3.Manage Credit Card fees {{pp.package_name }}(%)</td>
						      <td><v-text-field
						            solo
						            :rules="[rules.required, rules.decimal]"
						            v-model="pp.setting.card_fee"
						            placeholder="0.00"
						            append-outer-icon="edit"	
						          ></v-text-field></td>
						
						    </tr>
						    <tr>
						      <td>4.Manage complimentary bonus to TopUp {{pp.package_name }}</td>
						      <td><v-text-field
						            solo
						            :rules="[rules.required, rules.decimal]"
						            v-model="pp.setting.bonus"
						            placeholder="0.00"
						            append-outer-icon="edit"	
						          ></v-text-field></td>
						
						    </tr>
						    <tr>
						      <td>5.On/off sms services {{pp.package_name }}</td>
						      <td> 
				                 	<v-switch
						              v-model="pp.setting.sms"
						              color="red"
						              hide-details
						            ></v-switch>
        						</td>
						    </tr>
						     <tr>
						      	<td></td>
						      	<td> <br>
				                	<v-btn color="info" type="submit" :disabled="!pp.setting.expiration_date || !pp.setting.fee || !pp.setting.card_fee || !pp.setting.bonus ||pp.setting.expiration_date.length > 4" @click="saveSetting(pp.setting)">SAVE</v-btn>  
        						</td>
						    </tr>
						  </tbody>
						</table>
					</div>
					<!-- setting is null -->
		            <div v-else>
			            <table class="table-wapper">
						  <thead class="thead-light">
						    <tr>
						      <th scope="col"></th>
						      <th scope="col"></th>
						    </tr>
						  </thead>
						  <tbody>
						    <tr>
						      <td>1.Cronjob expiry timing for deleting images files from company clouds to reduce space {{pp.package_name }} (Day)</td>
						      <td> 
						          <v-text-field
						            solo
						            :rules="[rules.required, rules.number]"
						            maxlength="4"
						            counter
						            v-model="pro.expiration_date"
						            placeholder="Day"
						            append-outer-icon="edit"	
						          ></v-text-field>
							       
							  </td>
						    </tr>
						    <tr>
						      <td>2.Manage system fees {{pp.package_name }} (%)</td>
						      <td><v-text-field
						            solo
						            :rules="[rules.required, rules.decimal]"
						            v-model="pro.fee"
						            placeholder="0.00"
						            append-outer-icon="edit"		
						          ></v-text-field></td>
						    </tr>
						    <tr>
						      <td>3.Manage Credit Card fees {{pp.package_name }} (%)</td>
						      <td><v-text-field
						            solo
						            :rules="[rules.required, rules.decimal]"
						            v-model="pro.card_fee"
						             placeholder="0.00"
						             append-outer-icon="edit"	
						          ></v-text-field></td>
						
						    </tr>
						    <tr>
						      <td>4.Manage complimentary bonus to TopUp {{pp.package_name }}</td>
						      <td><v-text-field
						            solo
						            :rules="[rules.required, rules.decimal]"
						            v-model="pro.bonus"
						             placeholder="0.00"
						             append-outer-icon="edit"	
						          ></v-text-field></td>
						
						    </tr>
						    <tr>
						      <td>5.On/off sms services {{pp.package_name }}</td>
						      <td> 
				                 	<v-switch
						              v-model="pro.sms"
						              color="red"
						              hide-details
						            ></v-switch>
        						</td>
						    </tr>
						     <tr>
						      	<td></td>
						      	<td> <br>
				                	<v-btn color="info" type="submit" :disabled="!pro.expiration_date || !pro.fee || !pro.bonus || !pro.card_fee" @click="createSetting(packages_id)">SAVE</v-btn>
        						</td>
						    </tr>
						  </tbody>
						</table>
					</div>	
		        </div>    
		    </div>
		</div>
	</app-card>
</v-layout>
</v-container>
</div>
</template>

<script>
import { get, post, put } from '../../api/index.js'
import config from '../../config/index.js'
import Vue from 'vue'
export default {

	name: 'setting',

	data () {
	    return {
	    activetab: "Basic" ,
	    rules: {
		        required: value => !!value || 'Required.',
	          	decimal: value => {
		            const abc = /^[1-9]\d*(\.\d+)?$/
		            return abc.test(value) || 'Please input number.'
	          	},
	          	number: value => {
		            const abc = /^[0-9]\d*$/
		            return abc.test(value) || 'Please input number.'
	          	},
	          	counter: value => value.length <= 4 || 'Max 4 characters',

	        },
	    pro:{},
	    package:{},
	    packages_id:1,

	    }
	},
	methods:{
		saveSetting(item){
			// console.log(item.expiration_date.length)
			let url = config.API_URL+'settings/'+item.id
			put(url,item)
			.then((res) =>{ 
				setTimeout(function(){
			            Vue.notify({
			                group: 'loggedIn',
			                type: 'success',
			                text: 'Update Item Success!'
			            });
			       },500);
				this.fetchData()
			})
			.catch(err => {
				if(err.response.status == 500)
				{
					setTimeout(function(){
			            Vue.notify({
			                group: 'loggedIn',
			                type: 'error',
			                text: 'Something error!'
			            });
			       },500);
				}
				// console.log(err.response.status == 500)
			})
		},
		createSetting(id){
			let url = config.API_URL+'settings'
			let params = {
				expiration_date : this.pro.expiration_date,
				fee : this.pro.fee,
				card_fee : this.pro.card_fee,
				bonus : this.pro.bonus,
				sms : this.pro.sms,
				package_id : id

			}

			post(url,params)
			.then((res) => {
				 if(res.data && res.data.success){
	                    setTimeout(function(){
				            Vue.notify({
				                group: 'loggedIn',
				                type: 'success',
				                text: 'Add Setting Success!'
				            });
					    },500);
	               }
				this.fetchData()
				this.pro = {}
			})
			.catch((err) => {
				if(err.response.status == 500)
				{
					setTimeout(function(){
			            Vue.notify({
			                group: 'loggedIn',
			                type: 'error',
			                text: 'Something error!'
			            });
			       },500);
				}
			})
			

		},

		fetchData(){
			let url = config.API_URL+'get-package'
			get(url)
			.then((res) => {
				this.package = res.data.data
			})
			.catch((err) =>{

			})
		},
		choosePackage(package_name,id){
			this.activetab = package_name
			this.packages_id = id
		},

	},
	created() {
		this.fetchData()
	}
}
</script>
	
<style lang="css" scoped>
.layout-tab {
	padding: 10px 0px;
}
.table-wapper {
   border-collapse: collapse;
}
.table-wapper tr td:nth-child(1){
   width: 80%;
   /*padding: 6px 0px;*/
       text-align: left;
    vertical-align: initial;
}
.table-wapper tr td:nth-child(2){
   /*width: 10%;*/
    text-align: left;
    vertical-align: initial;
}
.v-input__control{
	min-height: 0px !important 	;
}
</style>