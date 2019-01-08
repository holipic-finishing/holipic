<template>
<div class="margin-table">
	<v-container fluid grid-list-xl pt-0>
		<v-toolbar flat color="white">
		    <h3 class="h3-title-package">Packages List</h3>
	        <v-divider
	            class="mx-2"
	            inset
	            vertical
	        ></v-divider>
		    <v-btn @click="showAddItem()" color="primary" dark class="mb-2">Add</v-btn>
		</v-toolbar>
		<package-item></package-item>
		<v-data-table
	        :headers="headers"
	        :items="desserts"
	        class="elevation-1"
	        :pagination.sync="pagination"
		    :loading="loadingCom"
	    >
	    	<template slot="items" slot-scope="props">
	    		<td class="text-xs-left">{{ props.item.id }}</td>
		        <td class="text-xs-left">{{ props.item.package_name }}</td>
		        <td class="text-xs-left">{{ props.item.price }}</td>
		        <td class="text-xs-left">{{ props.item.offer }}</td>
		        <td class="text-xs-left">
		            <v-icon
			            small
			            class="mr-2"
			            @click="showItem(props.item)"
		            >
		            	visibility
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
			            @click="showDialog(props.item.id, props.item.setting_id)"
		            >
		            	delete
		          	</v-icon>
		        </td>
	    	</template>
	    	<template slot="no-data">
	    		<div class="btn-reset text-center"><v-btn color="primary">Reset</v-btn></div>
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
	</v-container>

<div class="margin-table">
	<v-container fluid grid-list-xl pt-0>
		<v-toolbar flat color="white">
		    <h3>One(1) Photo Package</h3>
		</v-toolbar>
		<v-data-table
	      :headers="headers2"
	      :items="desserts2"
	      class="elevation-1"
	      :pagination.sync="pagination"
	      :disable-initial-sort="true"
		  :loading="loadingCom"
	    >
	    	<template slot="items" slot-scope="props">
	    		<td class="text-xs-left">{{ props.item.id }}</td>
		        <td class="text-xs-left">{{ props.item.size }}</td>
		        <td class="text-xs-left">
		        	<v-flex xs12 sm12 md12 slot="append">
		        		<v-flex xs3 class="symbol-td">
		        			<span >{{ props.item.symbol }}</span>
		        		</v-flex>
			            <v-flex xs7 class="symbol-td-text-field"><v-text-field 
			                v-model="props.item.price"
			                :rules="[rules.required]"
			                :disabled="key == props.item.id ? false : true"
			                outline
			                @blur="editItem5('price', props.item.price, props.item.id)"
						    @keyup.enter="editItem5('price', props.item.price, props.item.id)"
			            ></v-text-field></v-flex>
			            <v-flex xs2 class="symbol-td-icon">
		        			<span >
								<v-btn flat icon @click="unDisableItem(props.item.id)"><v-icon small>fas fa-marker</v-icon></v-btn>
							</span>
		        		</v-flex>
		            </v-flex>
		        </td>
		        <td class="text-xs-left">
		        	<v-flex xs12 sm12 md12 slot="append">
			            <v-flex xs7 class="symbol-td-text-field"><v-text-field 
			                v-model="props.item.free_photo"
			                :rules="[rules.required, rules.number]"
			                :disabled="key2 == props.item.id ? false : true"
			                outline
			                @blur="editItem5('free_photo', props.item.free_photo, props.item.id)"
						    @keyup.enter="editItem5('free_photo', props.item.free_photo, props.item.id)"
			            ></v-text-field></v-flex>
			            <v-flex xs2 class="symbol-td-icon">
		        			<span >
								<v-btn flat icon @click="unDisableItem2(props.item.id)"><v-icon small>fas fa-marker</v-icon></v-btn>
							</span>
		        		</v-flex>
		            </v-flex>
		        </td>
	    	</template>
	    	<template slot="no-data">
	    		<div class="btn-reset text-center"><v-btn color="primary">Reset</v-btn></div>
      		</template>
		</v-data-table>
	</v-container>
</div>
</div>	
</template>

<script>
import  { get, post, put, del, getWithData } from '../../../api/index.js'
import config from '../../../config/index.js'
import Vue from 'vue'
import PackageItem from './PackageItem.vue'
export default {

  	name: 'Index',

  	components:{
  		PackageItem
  	},

	data () {
	    return {
	    	headers: [
	    		{ text: 'Sl No.', value: 'id' },
		        { text: 'Package Name', align: 'left', value: 'package_name' },
		        { text: 'Package Price', value: 'price' },
		        { text: 'Offer Price', value: 'offer' },
		        { text: 'Actions', sortable: false }
	      	],
	      	desserts: [],
	      	headers2: [
	    		{ text: 'Sl No.', value: 'id' },
		        { text: 'Size', align: 'left', value: 'package_name' },
		        { text: 'Unit Price', value: 'price', sortable: false },
		        { text: 'Free Photo', value: 'offer', sortable: false },
	      	],
	      	desserts2: [],
	      	rules: {
		        required: value => !!value || 'Required.',
	          	number: value => {
		            const abc = /^[0-9]\d*$/
		            return abc.test(value) || 'Please input number.'
	          	},
	          	decimal: value => {
		            const abc = /^[0-9]\d*(\.\d+)?$/
		            return abc.test(value) || 'Please input number.'
	          	},
	        },
	      	dialog: false,
	      	pagination: {
		      page: 1,
		      rowsPerPage: 10,
		      totalItems: 0,
		    },
		    itemIdToDelete: {
		    	id: null,
		    	setting_id:null
		    },
		    loading: true,
		    key: 0,
		    key2: 0

	    }
	},
	computed: {
	    loadingCom(){
	    	return this.loading
	    },
	},
	methods:{
		fetchData() {
			let url = config.API_URL+'company_packages';
			get(url)
			.then((res) => {
				console.log(res.data.data)
				if(res.data && res.data.success){
					this.desserts = res.data.data
					this.loading = false
				}
			})
			.catch((err) =>{
				console.log(err)
			}) 
		},

		fetchDataPhotoPackage() {
			let url = config.API_URL+'get-photo-package';
			get(url)
			.then((res) => {
				if(res.data && res.data.success){
					this.desserts2 = res.data.data
					this.data = res.data.data
					this.loading = false
				}
			})
			.catch((err) =>{
				console.log(err)
			}) 
		},

		unDisableItem(key){
      		this.key = key
      	},

      	unDisableItem2(key2){
      		this.key2 = key2
      	},

		editItem5(field_name, value, id){
			var id = id
	        var field = {
		        field_name: field_name,
		        value: value,
		        id: id
	        }

	      this.fetchDataEdit(id, field)
	    },

	    fetchDataEdit(id, field){
	    	post(config.API_URL + 'edit/photoPackage/' + id, field)
			.then((res) => {
				if(res.data && res.data.success){
					Vue.notify({
		                group: 'loggedIn',
		                type: 'success',
		                text: 'Edit Item Success!'
		            });	
		            this.key = 0
					}
				})
			.catch((e) =>{
		        		setTimeout(() => {this.alertStt = false}, 1500)
					})

	    },

		showAddItem(){
			let obj = {
	  				check : 'add',
	  				showDialog: true,
	  		}
  			this.$root.$emit('change-status', obj)
		},

		showItem(item){
			let obj = {
  				check : 'show',
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

		showDialog(id, setting_id){
	      this.dialog = true
	      this.itemIdToDelete.id = id
	    },

		deleteItem(id,setting_id){

				let params = {
					id_packages : this.itemIdToDelete.id
				}

				del(config.API_URL + 'company_packages/' + params.id_packages)
				.then((res) => {
					this.loading = true;
					this.fetchData();
					this.dialog = false;	
					// setTimeout(function(){
			            Vue.notify({
			                group: 'loggedIn',
			                type: 'success',
			                text: 'Delete Item Success!'
			            });
			       // },500);
				})
				.catch((err) =>{
					console.log(err)
				})
		}
	},
	mounted(){
        this.$root.$on('reload-table', res => {
  	    this.loading = true
        this.fetchData();	
      })
    },
	created(){
		this.fetchData();	
		this.fetchDataPhotoPackage();	
	}
}
</script>

<style lang="css" scoped>

.h3-title-package{
	width: 200px;
}

.list__tile {
  height: 5rem !important;
}

.v-input input {
    max-height: 10px !important;
}

.symbol-td {
	float: left;
    padding: 18px 5px 0px 0px;
}

.symbol-td-text-field {
	float: left;
}

.symbol-td-icon {
	float: left;
}

</style>