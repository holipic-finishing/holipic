<template>
	<v-dialog v-model="dialog" max-width="600px" @keydown.esc="close()">
        <v-card>
          <v-card-title class="text-center">
          	 <!-- <v-spacer></v-spacer> -->
            <span class="headline">{{ check ? 'Add Coupon Code Admin' : 'Update Coupon Code Admin'}}</span>
          </v-card-title>
          <v-card-text>
           <div>
	       <v-form ref="form" @submit.prevent="save" v-show="check">
			 	<v-container grid-list-md>
	                <table class="table-wapper">
					  <thead class="thead-light">
					    <tr>
					      <th scope="col"></th>
					      <th scope="col"></th>
					    </tr>
					  </thead>
					  <tbody>
					    <tr>
					      <td>1. Name (*)</td>
					      <td> 
					          <v-text-field
					            solo
					            :rules="[rules.required]"	
					            v-model="item.name"
					            placeholder="Name"
					            append-outer-icon="edit"
					          ></v-text-field>
						       
						  </td>
					    </tr>
					    <tr>
					      <td>2.Coupon Code (*)</td>
					      <td><v-text-field
					            solo
					            :rules="[rules.required]"
					            v-model="item.code"	
					            placeholder="Code"
					            append-outer-icon="edit"
					          ></v-text-field></td>
					    </tr>
					    <tr>
					      <td>3.Discount (*)</td>
					      <td><v-text-field
					            solo
					            :rules="[rules.required, rules.decimal]"
					            v-model="item.discount"
					            placeholder="0.00 %"
					            append-outer-icon="edit"	
					          ></v-text-field></td>
					
					    </tr>
					    <tr>
					    <td>4.From Date (*)</td>
					      <td>
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
					            v-model="item.from_date"
					            label="From Day"
					            :rules="[rules.required]"
					            append-outer-icon="event"
					            readonly
					          ></v-text-field>
					          <v-date-picker v-model="item.from_date" @input="menu = false"></v-date-picker>
					        </v-menu>
					      </td>
					    </tr>
					    <td>5.To Date (*)</td>
					      <td>
					      	<v-menu
					           ref="menu1"
					          :close-on-content-click="false"
					          v-model="menu1"
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
					            v-model="item.to_date"
					            label="To Day"
					            :rules="[rules.required]"
					            append-outer-icon="event"
					            readonly
					          ></v-text-field>
					          <v-date-picker v-model="item.to_date" @input="menu1 = false"></v-date-picker>
					        </v-menu>
					      </td>
					    </tr>
					    <tr>
					      <td>6.Active</td>
					      <td> 
			                 	<v-switch
					              v-model="item.active"
					              color="red"
					              hide-details
					            ></v-switch>
    						</td>
					    </tr>
					     <tr>
					      	<td></td>
					      	<td> <br>
			                	<v-btn color="info" type="submit">SAVE</v-btn>  
    						</td>
					    </tr>
					  </tbody>
					</table>
            	</v-container>
			</v-form>
			</div>
			<div>
	       <v-form ref="form1" @submit.prevent="saveCodeUpdate" v-show="!check">
			 	<v-container grid-list-md>
	                <table class="table-wapper">
					  <thead class="thead-light">
					    <tr>
					      <th scope="col"></th>
					      <th scope="col"></th>
					    </tr>
					  </thead>
					  <tbody>
					    <tr>
					      <td>1. Name (*)</td>
					      <td> 
					          <v-text-field
					            solo
					            :rules="[rules.required]"	
					            v-model="data.name"
					            placeholder="Name"
					            append-outer-icon="edit"
					          ></v-text-field>
						       
						  </td>
					    </tr>
					    <tr>
					      <td>2.Coupon Code (*)</td>
					      <td><v-text-field
					            solo
					            :rules="[rules.required]"
					            v-model="data.code"	
					            placeholder="Code"
					            append-outer-icon="edit"
					          ></v-text-field></td>
					    </tr>
					    <tr>
					      <td>3.Discount (*)</td>
					      <td><v-text-field
					            solo
					            :rules="[rules.required, rules.decimal]"
					            v-model="data.discount"
					            placeholder="0.00 %"
					            append-outer-icon="edit"	
					          ></v-text-field></td>
					
					    </tr>
					    <tr>
					    <td>4.From Date (*)</td>
					      <td>
					      	<v-menu
					         ref="menu2"
					          :close-on-content-click="false"
					          v-model="menu2"
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
					            v-model="data.from_date"
					            label="From Day"
					            :rules="[rules.required]"
					            append-outer-icon="event"
					            readonly
					          ></v-text-field>
					          <v-date-picker v-model="data.from_date" @input="menu2 = false"></v-date-picker>
					        </v-menu>
					      </td>
					    </tr>
					    <td>5.To Date (*)</td>
					      <td>
					      	<v-menu
					           ref="menu3"
					          :close-on-content-click="false"
					          v-model="menu3"
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
					            v-model="data.to_date"
					            label="To Day"
					            :rules="[rules.required]"
					            append-outer-icon="event"
					            readonly
					          ></v-text-field>
					          <v-date-picker v-model="data.to_date" @input="menu3 = false"></v-date-picker>
					        </v-menu>
					      </td>
					    </tr>
					    <tr>
					      <td>6.Active</td>
					      <td> 
			                 	<v-switch
					              v-model="data.active"
					              color="red"
					              hide-details
					            ></v-switch>
    						</td>
					    </tr>
					     <tr>
					      	<td></td>
					      	<td> <br>
			                	<v-btn color="info" type="submit">SAVE</v-btn>  
    						</td>
					    </tr>
					  </tbody>
					</table>
            	</v-container>
			</v-form>
			</div>
          </v-card-text>
          <v-card-actions>
              <v-spacer></v-spacer>
          </v-card-actions>

        </v-card>
</v-dialog>  
</div>
</template>

<script>
import { post, put } from '../../api/index.js'
import config from '../../config/index.js'
import moment from 'moment'
export default {

	name: 'ActiveCouponCode',

	data () {
	    return {
	    	dialog: false,
		    check: false,
		    item : {},
		    rules: {
		        required: value => !!value || 'Required.',
	          	decimal: value => {
		            const abc = /^[1-9]\d*(\.\d+)?$/
		            return abc.test(value) || 'Please input number.'
	          	},
	          	number: value => {
		            const abc = /^[0-9]\d*$/
		            return abc.test(value) || 'Please input number.'
	          	}
	        },
	        date: '',
      		menu: false,
      		menu1:false,
      		menu2:false,
      		menu3:false,
      		data:{}
	    }
	},
	methods:{
		close() {
			this.dialog = false;
		},
		save(){
			if (this.$refs.form.validate()) {
				var date_now = moment(new Date().toISOString().substr(0, 10))
				var	start_day = moment(this.item.from_date)
				var	end_day =  moment(this.item.to_date)
				var day = end_day.diff(start_day,'days')
				if(start_day < date_now && end_day < date_now){
					setTimeout(function(){
					            Vue.notify({
					                group: 'loggedIn',
					                type: 'error',
					                text: 'Date some error!'
					            });
					},500);
				} else if(day < 0)  {
					setTimeout(function(){
					            Vue.notify({
					                group: 'loggedIn',
					                type: 'error',
					                text: 'From day and To day some error!'
					            });
					},500);
				} else {
					let url = config.API_URL+'coupon_codes'

					post(url,this.item)
	      		 	.then((res) => {
	      		 		 if(res.data && res.data.success){
		                    setTimeout(function(){
					            Vue.notify({
					                group: 'loggedIn',
					                type: 'success',
					                text: 'Add Success!'
					            });
						    },500);
		                    this.dialog = false
		                    this.$root.$emit('reload-table', true)
	                	}
	      		 	})
	      		 	.catch((err) =>{
	      		 		console.log(err)
	      		 	})
				}
			}
		},
		saveCodeUpdate(){

			if (this.$refs.form1.validate()) {
				var date_now = moment(new Date().toISOString().substr(0, 10))
				var	start_day = moment(this.data.from_date)
				var	end_day =  moment(this.data.to_date)
				var day = end_day.diff(start_day,'days')
				if(start_day < date_now && end_day < date_now){
					setTimeout(function(){
					            Vue.notify({
					                group: 'loggedIn',
					                type: 'error',
					                text: 'Date some error!'
					            });
					},500);
				} else if(day < 0)  {
					setTimeout(function(){
					            Vue.notify({
					                group: 'loggedIn',
					                type: 'error',
					                text: 'From day and To day some error!'
					            });
					},500);
				} else {
					let url = config.API_URL+'coupon_codes/'+this.data.id
					put(url,this.data)
	      		 	.then((res) => {
	      		 		 if(res.data && res.data.success){
		                    setTimeout(function(){
					            Vue.notify({
					                group: 'loggedIn',
					                type: 'success',
					                text: 'Add Success!'
					            });
						    },500);
		                    this.dialog = false
		                    this.$root.$emit('reload-table', true)
	                	}
	      		 	})
	      		 	.catch((err) =>{
	      		 		console.log(err)
	      		 	})
				}
			}

		},

		formatDate(date) {
          if(date){
              return moment(date, 'YYYY-MM-DD hh:mm:ss').format('YYYY-MM-DD');
          }
      	}
	},
	mounted() {
		this.$root.$on('change-status', res => {
          	this.dialog = res.showDialog
    		this.check = res.check
    		this.item = {
    		}
      	})

      	this.$root.$on('data-packages', res => {
    		this.data = {
    			from_date : this.formatDate(res.from_date),
    			to_date : this.formatDate(res.to_date),
    			name : res.name,
    			code : res.code,
    			discount : res.discount,
    			active : res.active,
    			id:res.id
    		}
    		// console.log(this.data)
    	})
	}
}
</script>

<style lang="css" scoped>
.text-center {
    display: block !important;
}
.layout-tab {
	padding: 10px 0px;
}
.table-wapper {
   border-collapse: collapse;
}
.table-wapper tr td:nth-child(1){
   width: 54%;
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