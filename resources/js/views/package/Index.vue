<template>
<div>
	<page-title-bar></page-title-bar>
	<v-container fluid grid-list-xl pt-0>
		<v-toolbar flat color="white">
			<v-toolbar-title><v-icon>zmdi zmdi-dropbox</v-icon></v-toolbar-title>
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
	    		<td>{{ props.item.package_name }}</td>
		        <td class="text-xs-left">{{ props.item.short_description }}</td>
		        <td class="text-xs-center">{{ props.item.fee }}</td>
		        <td class="text-xs-center">{{ props.item.secure_storage }}</td>
		        <td class="text-xs-center">{{ props.item.file_upload }}</td>
		        <td class="text-xs-center">{{ props.item.minimum_user }}</td>
		        <td class="text-xs-center">{{ props.item.max_user }}</td>
		        <td class="justify-center layout px-0">
		          <v-icon
		            small
		            class="mr-2"
		            @click="editItem(props.item)"
		          >
		            edit
		          </v-icon>
		          <v-icon
		            small
		            @click="deleteItem(props.item.id)"
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
import  { get, post, put, del } from '../../api/index.js'
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
		        { text: 'Fee (%)', value: 'fee' },
		        { text: 'Storage (GB)', value: 'secure_storage' },
		        { text: 'File Upload (GB)', value: 'file_upload' },
		        { text: 'Minimum User', value: 'minimum_user' },
		        { text: 'Max User', value: 'max_user' },
		        { text: 'Actions', value: 'name', sortable: false }
	      	],
	      	desserts: [],
	      	pagination: {
		      page: 1,
		      rowsPerPage: 25,
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
	  				check : true,
	  				showDialog: true,
	  		}
  			this.$root.$emit('change-status', obj)
  			// this.$root.$emit('data-add-packages', this.item)
		},

		editItem(item){
			let obj = {
	  				check : false,
	  				showDialog: true,
	  			}
			// console.log(123)
  			this.$root.$emit('change-status', obj)
  			this.$root.$emit('data-packages', item)
		},

		deleteItem(id){
			if(confirm('Are you sure you want to delete this item?')){
				let url = config.API_URL+'packages/'+id
				del(url)
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
</style>