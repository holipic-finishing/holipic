<template>
	<div class="branch-table">
		<!-- <page-title-bar></page-title-bar> -->
		<v-container fluid grid-list-xl pt-0>
			<v-navigation-drawer 
	        fixed
	        v-model="drawer1" 
	        :right="!rtlLayout" 
	        temporary 
	        app 
	        class="chat-sidebar-wrap"
	        width="450"
	      >
	      
	        <send-email :item="item"></send-email>
	      </v-navigation-drawer>
			<div id="app">
				<v-app id="inspire">
					<v-card class="p-4">
						<v-alert  v-model="alertStt" :type="alertType" dismissible>{{ alertMes }}</v-alert>
						<v-toolbar flat color="white">
					        <v-toolbar-title>
					          	E-mail Templates
					          	
					          	<v-btn dark color="#5D92F4" class="add-btn" @click="showEmail()">
							      <v-icon dark>add</v-icon>
							    </v-btn>
							    <a target="_blank" slot="activator" class="btn btn-primary pl-2 pr-2 ml-3 a-icon" @click="exportCSV">
								<v-icon small color="white">fas fa-file-excel</v-icon>
								</a>
					        </v-toolbar-title>
					    </v-toolbar>
					    <v-divider></v-divider>
						<v-card-title>
				      		<v-spacer></v-spacer>
				      		<v-text-field
				        		v-model="search"
						        append-icon="search"
						        label="Enter search value"
						        single-line
						        hide-details
						    ></v-text-field>
				    	</v-card-title>


						<v-data-table 
							:headers="headers" 
							:items="items" 
							class="elevation-5"  
							:pagination.sync="pagination" 
							:rows-per-page-items="rowsPerPageItems" 
							default-sort="id:desc"
							:search="search"
						>
							<template slot="items" slot-scope="props">
								<td>{{ props.item.id }}</td>
								<td>{{ props.item.email_title }}</td>
								<td>{{ props.item.format_email_content }}</td>
								<td><v-btn small color="primary" @click="showEmailToSend(props.item)">Send Email</v-btn></td>
					        	<td>

									<v-icon
										small
										class="mr-2 hover-icon"
										@click="updateEmail(props.item)"
									>
										edit
									</v-icon>

									<v-icon
										small
										class="mr-2 hover-icon"
										@click="showDialog(props.item.id)"
									>
										delete
									</v-icon>

								</td>
							</template>
						</v-data-table>
						<v-dialog v-model="dialog" persistent max-width="450">
					      <v-card>
					        <v-card-title class="headline font-weight-bold">
					          <v-icon x-large color="yellow accent-3" class="mr-2">
					            warning
					          </v-icon>
					          Do you want delete this item ?
					        </v-card-title>
					        <v-divider class="mt-0"></v-divider>
					        <v-card-actions>
					          <v-spacer></v-spacer>
					          <v-btn flat @click="dialog = false">Disagree</v-btn>
					          <v-btn flat @click="deleteItem">Agree</v-btn>
					        </v-card-actions>
					      </v-card>
					    </v-dialog>
					</v-card>
				</v-app>
			</div>
		</v-container>		
		<email-item></email-item>
	</div>	
</template>

<script>
import config from '../../../config'
import { get, post, put, del, getWithData } from '../../../api'
import EmailItem from './EmailItem.vue'
import { mapGetters } from "vuex"
import SendEmail from './SendEmail.vue'
export default {

	name: 'Email',

	components:{
		EmailItem,
		SendEmail
	},

	data () {
	return {
			search:'',
			drawer:false,
			drawer1:false,
      		pagination: {
				  	rowsPerPage: 25,
				  	sortBy: 'id', 
				  	descending: false
		    },
		    headers: [	        
					{ text: 'ID', value: 'id',  align: 'left', width: '3%'},	       
					{ text: 'Title', value: 'email_title',width: '20%' },	
					{ text: 'Description', value: 'format_email_content',width: '50%' },	      
		        	{ text: 'Send Email',sortable: false ,width: '5%'},  
		        	{ text: 'Action', sortable: false, width: '10%' },         
		    ],
			items :[],
			rowsPerPageItems: [25, 50, 100, { "text": "$vuetify.dataIterator.rowsPerPageAll", "value": -1 }],
			alertStt: false,
		    alertType: 'success',
		    alertMes: '',
		    authUser : JSON.parse(localStorage.getItem('user')),
		    item:null,
		    dialog: false,
		    itemIdToDelete: ''
		}
	},
	created(){
		this.fetchData()	
	},
	methods:{
		showEmail(){
			let obj = {
  				check : true,
  				showDrawer: true,
	  		}
  			this.$root.$emit('change-status', obj)
		},
		fetchData(){
			let url = config.API_URL + 'emails'
			get(url)
			.then(res => {
				if(res.data && res.data.success){
					let data = res.data.data
					this.items = data
				}
			})
			.catch(err => {

			})
		},
		updateEmail(item){
			let obj = {
	  				check : false,
	  				showDrawer: true,
	  			}
  			this.$root.$emit('change-status', obj)
  			this.$root.$emit('data-email', item)
		},
		deleteItem(){
			
				let url = config.API_URL+'emails/'+this.itemIdToDelete
				del(url)
				.then((res) => {
					this.fetchData();	
					this.alertStt = true
			        this.alertType = 'success'
			        this.alertMes = 'Delete Successfully'					
			        setTimeout(() => {this.alertStt = false}, 1500)
			        this.dialog = false
				})
				.catch((err) =>{
					console.log(err)
				})
			
		},
		exportCSV(){
			let params = {
                company_id : this.authUser.company_id
            }	
			let url = config.API_URL+'company/export/customer'
			getWithData(url,params)
			.then(res => {
				if(res.data && res.data.status){
					window.location.href = res.data.link
				}
			})
			.catch(err => {
				console.log(err)
			})
		},
		showEmailToSend(item){
			console.log(item)
			this.drawer1 = true
			this.item = item
		},
		showDialog(item)
		{
			this.dialog = true
			this.itemIdToDelete = item
		}
	},
	computed: {
		 ...mapGetters(["rtlLayout",]),
    },
    mounted(){
		this.$root.$on('reload-data', res => {
	     	this.fetchData()
	    })
	    this.$root.$on('closeDrawerItem', res => {
	     	this.drawer1 = res
	    })
    }
}
</script>

<style lang="css" scoped>
.add-btn{
		right: 40px;
    	position: absolute;
    	top: 8px;
}
.branch-table{
	margin-top:30px;
}
.hover-icon{
	&:hover{
 	 color: blue !important;
 	}
} 
.a-icon {
	right: 0px;
    position: absolute;
    top: 13px;
}
</style>