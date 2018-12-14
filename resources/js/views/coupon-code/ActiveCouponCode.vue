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
					      <td>3.Discount</td>
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
	      <!--  <v-form ref="form1" @submit.prevent="savePackagesUpdate" v-show="!check">
			 	<v-container grid-list-md>
	                <v-layout wrap>
	                  	<v-flex xs12 sm6>
				          <v-text-field
				            label="Package Name" 
				            v-model="data.package_name"
			                :rules="[rules.required]"
				          ></v-text-field>
				        </v-flex>

				        <v-flex xs12 sm6>
				          <v-text-field
				            label="Fee" 
				            v-model="data.fee"
		                    :rules="[rules.required, rules.number]"
				          ></v-text-field>
				        </v-flex>

				         <v-flex xs12 sm6>
				          <v-text-field
				            label="Secure Storage" 
				            v-model="data.secure_storage"
		                    :rules="[rules.required]"
				          ></v-text-field>
				        </v-flex>

				         <v-flex xs12 sm6>
				          <v-text-field
				            label="File Upload" 
				            v-model="data.file_upload"
		                    :rules="[rules.required, rules.number]"
				          ></v-text-field>
				        </v-flex>
				        
				        <v-flex xs12 sm6>
				          <v-text-field
				            label="Minimum User" 
				            v-model="data.minimum_user"
		                    :rules="[rules.required, rules.number]"
				          ></v-text-field>
				        </v-flex>

				         <v-flex xs12 sm6>
				          <v-text-field
				            label="Max User" 
				            v-model="data.max_user"
		                    :rules="[rules.required]"
				          ></v-text-field>
				        </v-flex>

				        <v-flex xs12 sm12>
				         	<v-textarea label="Short Description" 
		                     	v-model="data.short_description"
		                       :rules="[rules.required]"
		                       	class="style-rextarea">
		                    </v-textarea>
				        </v-flex>

				         <v-flex xs12 sm12>
				         	<v-textarea label="Full Description" 
		                     	v-model="data.full_description"
		                       :rules="[rules.required]"
		                       	class="style-rextarea">
		                    </v-textarea>
				        </v-flex>
	                  
	              
	                  	<v-flex xs12 sm12 class="row style">
	                  	 <v-btn color="primary" type="submit">SAVE</v-btn> 
	                	</v-flex>
	                </v-layout>
            	</v-container>
			</v-form> -->
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
      		menu1:false
	    }
	},
	methods:{
		close() {
			this.dialog = false;
		},
		save(){
			if (this.$refs.form.validate()) {
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
	mounted() {
		this.$root.$on('change-status', res => {
          	this.dialog = res.showDialog
    		this.check = res.check
    		this.item = {
    		}
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