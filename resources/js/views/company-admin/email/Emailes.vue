<template>
	<v-container fluid px-0 py-0>
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

    <v-layout row wrap>
			<app-card
				colClasses="xl12 lg12 md12 sm12 xs12"
				:fullScreen="true"
				:reloadable="true"
				:closeable="false"
			>
				<v-toolbar flat color="white">
	        <v-toolbar-title>
	          E-mail Templates
	        </v-toolbar-title>
		    </v-toolbar>
      	<v-divider class="m-0"></v-divider>

				<!--Search Component -->
				<v-card-title>
	      	<v-spacer></v-spacer>
	        <div class="w-25">
	  	      <v-text-field
	  	        v-model="search"
	  	        append-icon="search"
	  	        label="Enter Search Value"
	  	        single-line
	  	        hide-details
	  	      ></v-text-field>
	        </div>
					<v-btn fab dark small color="#5D92F4" class="ml-2 btn-gradient-primary" @click="showEmail()">
						<v-icon dark >add</v-icon>
					</v-btn>
			    <a target="_blank" slot="activator" class="btn btn-primary ml-2 btn-gradient-primary custom-btn" @click="exportCSV">
						<v-icon small color="white" class="custom-v-icon">fas fa-file-excel</v-icon>
					</a>
		    </v-card-title>

		    <v-data-table 
					:headers="headers" 
					:items="items" 
					class="body-2 global-custom-table"
					:pagination.sync="pagination" 
					:rows-per-page-items="rowsPerPageItems" 
					default-sort="id:desc"
					:search="search"
				>
					<template slot="items" slot-scope="props">
						<td>{{ props.item.id }}</td>
						<td>{{ props.item.email_title }}</td>
						<td>{{ props.item.format_email_content }}</td>
						<td>
							<v-btn 
								small 
								color="primary" 
								@click="showEmailToSend(props.item)" 
								class="btn-gradient-success ml-0 mr-0"
							>
								Send Email
							</v-btn>
						</td>
			      <td class="text-right">
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
		  </app-card>
		</v-layout>

		<email-item></email-item>

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

	</v-container>
		
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
				{ text: 'ID', value: 'id',  align: 'left', width: '5%', class: 'mb-icon'},	       
				{ text: 'Title', value: 'email_title',width: '10%', class: 'mb-icon' },	
				{ text: 'Description', value: 'format_email_content',width: '65%', class: 'mb-icon' },	      
	    	{ text: 'Send Email',sortable: false ,width: '5%', class: 'mb-icon'},  
	    	{ text: 'Action', sortable: false, width: '10%', align: 'right', class: 'mb-icon' },         
	    ],
			items :[],
			rowsPerPageItems: [25, 50, 100, { "text": "$vuetify.dataIterator.rowsPerPageAll", "value": -1 }],
			alertStt: false,
	    alertType: 'success',
	    alertMes: '',
	    authUser : JSON.parse(localStorage.getItem('user')),
	    item:null,
	    dialog: false,
	    itemIdToDelete: '',
	    loading: false
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
					console.log('aaa')
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
		},
		changeSort (column) {
	      var columnsNoSearch = ['actions']
	      if (columnsNoSearch.indexOf(column) > -1) {
	        return
	      }
	      this.loading = true
	      if (this.pagination.sortBy === column) {
	        this.pagination.descending = !this.pagination.descending
	      } else {
	        this.pagination.sortBy = column
	        this.pagination.descending = false
	      }
	      this.loading = false
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
};
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