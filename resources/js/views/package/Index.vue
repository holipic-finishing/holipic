<template>
<div class="margin-table">
	<!-- <page-title-bar></page-title-bar> -->
	<v-container fluid grid-list-xl pt-0>
		<v-toolbar flat color="white">
			<!-- <v-toolbar-title><v-icon>zmdi zmdi-dropbox</v-icon></v-toolbar-title>
		    <v-divider
		        class="mx-2"
		        inset
		        vertical
		    ></v-divider> -->
		    <h3 class="h3-title-package">Packages List</h3>
	        <v-divider
	          class="mx-2"
	          inset
	          vertical
	        ></v-divider>
		    <v-btn @click="showAddItem()" color="primary" dark class="mb-2">Add</v-btn>
		</v-toolbar>
		<active-package></active-package>
		<v-data-table
	      :headers="headers"
	      :items="desserts"
	      class="elevation-1"
	      :disable-initial-sort="true"
	      :pagination.sync="pagination"

	    >
	    	<template slot="items" slot-scope="props">
	    		<td class="text-xs-left">{{ props.item.package_name }}</td>
		        <td class="text-xs-left">{{ props.item.short_description }}</td>
		        <td class="text-xs-left">{{ props.item.secure_storage }}</td>
		        <td class="text-xs-center">{{ props.item.file_upload }}</td>
		        <td class="text-xs-left">
		        	<div v-if="props.item.email_service == true">
		        		YES
		        	</div>
		        	<div v-else>
		        		NO
		        	</div>
		        </td>
		        <td class="text-xs-left">
		        	<div v-if="props.item.sms == true">
		        		YES
		        	</div>
		        	<div v-else>
		        		NO
		        	</div>
		        </td>
		        <td class="text-xs-center">{{ props.item.fee }}</td>
		        <td class="text-xs-center">{{ props.item.max_user }}</td>
		        <td class="text-xs-left">
		          <v-icon
		            small
		            class="mr-2"
		            @click="settingItem(props.item)"
		          >
		            settings
		          </v-icon>
		          <v-icon
		            small
		            class="mr-2"
		            @click="editItem(props.item)"
		          >
		            edit
		          </v-icon>
		          <v-icon
		            small
		            class="mr-2"
		            @click="deleteItem(props.item.id,props.item.setting_id)"
		          >
		            delete
		          </v-icon>
		        </td>
	    	</template>
	    	<template slot="no-data">
	    		<div class="btn-reset text-center"><v-btn color="primary">Reset</v-btn></div>
        		
      		</template>
		</v-data-table>
	</v-container>
</div>	
</template>

<script>
import  { get, post, put, del, getWithData } from '../../api/index.js'
import config from '../../config/index.js'
import Vue from 'vue'
import ActivePackage from './Activepackage.vue'
export default {

  	name: 'Index',

  	components:{
  		ActivePackage
  	},

	data () {
	    return {
	    	headers: [
		        {
		          text: 'Package Name',
		          align: 'left',
		          value: 'package_name'
		        },
		        { text: 'Short Description', value: 'short_description',sortable: false },
		        { text: 'Storage (GB)', value: 'secure_storage' },
		        { text: 'File Upload (GB)', value: 'file_upload' },
		        { text: 'Email Service', value: 'minimum_user' },
		        { text: 'SMS', value: 'minimum_user' },
		        { text: 'Fee (%)', value: 'fee' },
		        { text: 'Max Branch', value: 'max_user' },
		        { text: 'Actions', sortable: false }
	      	],
	      	desserts: [],
	      	pagination: {
		      page: 1,
		      rowsPerPage: 5,
		      totalItems: 0,
		      // rowsPerPageItems: [5,10, 15, 20, 25, 30]
		    },
	      	// item : {}


	    }
	},
	methods:{
		fetchData() {
			let url = config.API_URL+'packages';
			get(url)
			.then((res) => {
				// console.log(res.data.data)
				if(res.data && res.data.success){
					this.desserts = res.data.data
					// console.log(res.data.data)
				}
				
			})
			.catch((err) =>{
				console.log(err)
			}) 
		},

		showAddItem(){
			let obj = {
	  				check : 'add',
	  				showDialog: true,
	  		}
  			this.$root.$emit('change-status', obj)
  			// this.$root.$emit('data-add-packages', this.item)
		},

		settingItem(item){
			let obj = {
	  				check : 'setting',
	  				showDialog: true,
	  		}
  			this.$root.$emit('change-status', obj)
  			this.$root.$emit('data-packages', item)
		},

		editItem(item){
			let obj = {
	  				check : 'edit',
	  				showDialog: true,
	  			}

  			this.$root.$emit('change-status', obj)
  			this.$root.$emit('data-packages', item)
		},

		deleteItem(id,setting_id){
			if(confirm('Are you sure you want to delete this item?')){
				let url = config.API_URL+'delete-package'

				let params = {
					id_packages : id,
					id_setting : setting_id
				}

				getWithData(url,params)
				.then((res) => {
					this.fetchData();	
					setTimeout(function(){
			            Vue.notify({
			                group: 'loggedIn',
			                type: 'success',
			                text: 'Delete Item Success!'
			            });
			       },500);
				})
				.catch((err) =>{
					console.log(err)
				})
			}
			
		}

	},
	mounted(){
      this.$root.$on('reload-table', res => {
          this.fetchData();	
      })
    },
	created(){
		// setTimeout(function(){
  //           Vue.notify({
  //               group: 'loggedIn',
  //               type: 'success',
  //               text: 'User Logged In Success!'
  //           });
  //      },1500);
  			this.fetchData();	
	}
}
</script>

<style lang="css" scoped>
.h3-title-package{
	width: 200px;
}
</style>