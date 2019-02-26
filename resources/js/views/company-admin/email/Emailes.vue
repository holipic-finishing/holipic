<template>
	<v-container fluid px-0 py-0 class="fix-croll-container">
    <v-layout row wrap>

			<app-card
				colClasses="xl12 lg12 md12 sm12 xs12"
				customClasses="p-0 elevation-5 rp-search"
				:fullScreen="true"
				:reloadable="true"
				:closeable="false"
				:fullBlock="false"
			>

				<!-- Navigation drawer -->
				<v-navigation-drawer
		      fixed
		      v-model="drawer1"
		    	right
		      clipped
		      app
		      :width='widthComputed'
			    temporary
		  	>
		      <send-email :item="item"></send-email>
		    </v-navigation-drawer>
		    <!-- End Navigation Drawer -->

				<v-toolbar flat color="white">
	        <v-toolbar-title>
	          E-mail Templates
	        </v-toolbar-title>
		    </v-toolbar>
      	<v-divider class="m-0"></v-divider>

				<!--Search Component -->
				<v-card-title>
	      	<v-spacer></v-spacer>
	        <div class="w-25 input-search">
	  	      <v-text-field
	  	        v-model="search"
	  	        append-icon="search"
	  	        label="Enter Search Value"
	  	        single-line
	  	        hide-details
	  	      ></v-text-field>
	        </div>

					<v-btn small fab dark color="indigo" @click="showEmail()" class="ml-2 btn-gradient-primary custom-btn btn-add">
							<v-icon dark>add</v-icon>
					</v-btn>
			    <a target="_blank" slot="activator" class="btn btn-primary ml-2 btn-gradient-primary custom-btn btn-export" @click="exportCSV">
						<v-icon small color="white" style="font-size:16px">fas fa-file-excel</v-icon>
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
								color="indigo"
								@click="showEmailToSend(props.item)"
								dark
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
        <v-card-title class="headline font-weight-bold grey lighten-3">
          <v-icon large color="warning" class="mr-2">
            warning
          </v-icon>
          Do you want delete this item ?
        </v-card-title>
        <v-divider class="mt-0"></v-divider>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="secondary" outline small @click="dialog = false">Disagree</v-btn>
          <v-btn color="warning" outline small @click="deleteItem">Agree</v-btn>
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
import { getWithContentWrap } from '../../../helpers/helpers'


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
	    alertType: 'success',
	    alertMes: '',
	    authUser : JSON.parse(localStorage.getItem('user')),
	    item:null,
	    dialog: false,
	    itemIdToDelete: '',
	    loading: false,
	    drawerHeaderStt: null,
    	width: 0,
		}
	},
	created(){
		this.fetchData()
	},
	methods:{
		getCurrentWithContentWrap(){
  		return getWithContentWrap(this.drawerHeaderStt)
  		},
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
        this.alertType = 'success'
        this.alertMes = 'Delete Item Successfully'
        this.$notify({
          title: 'Success',
          message: this.alertMes,
          type: this.alertType,
          duration: 2000,
        })
        this.dialog = false
			})
			.catch((err) =>{
				this.$notify({
          title: 'Error',
          message: 'System Error Occurred',
          type: 'error',
          duration: 2000,
        })
			})
		},
		exportCSV(){
			let params = {
        company_id : this.authUser.company_id
      }
			let url = config.API_URL + 'export-customers'

			getWithData(url,params)
			.then(res => {
				if(res.data && res.data.status){
					window.location.href = res.data.link
				}
			})
			.catch(err => {
				this.$notify({
		        	title: 'Success',
		          	message: 'Cannot Export File.',
		          	type: 'error',
		          	duration: 2000,
       			 })
			})
		},
		showEmailToSend(item){
			this.drawer1 = true
			this.item = item
			this.width = this.getCurrentWithContentWrap()
		},
		showDialog(item){
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
	 	widthComputed(){
  		return this.width
  		}
  	},
	 mounted(){
	  	this.$root.$on('drawer-status', res => {
	  		this.drawerHeaderStt = res
	  	})

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
