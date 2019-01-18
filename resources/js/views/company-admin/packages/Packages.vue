<template>
	<v-container fluid pt-0 grid-list-xl mt-3>
		<v-layout row wrap>
			<app-card
				colClasses="xl12 lg12 md12 sm12 xs12"
				customClasses="p-0 elevation-5"
				:fullScreen="true"
				:reloadable="true"
				:closeable="false"
			>
				<v-toolbar flat color="white">
	        <v-toolbar-title>
	          Packages List
	        </v-toolbar-title>
	      </v-toolbar>
	      <v-divider class="m-0"></v-divider>

	      <v-card-title>
		      <v-spacer></v-spacer>
			    <v-btn small fab dark @click="showAddItem()" class="ml-2 btn-gradient-primary">
						<v-icon dark>add</v-icon>
					</v-btn>
		    </v-card-title>

		    <package-item></package-item>
				<v-data-table
		      :headers="headers"
		      :items="desserts"
		      class="elevation-5 body-2 global-custom-table"
		      :pagination.sync="pagination"
			    :loading="loadingCom"
			  >
			  	<v-progress-linear slot="progress" color="blue" indeterminate></v-progress-linear>
					<!--Header -->
					<template slot="headers" slot-scope="props">
	          <tr>
	            <th
	              v-for="header in props.headers"
	              :key="header.text"
	              :class="['column sortable', pagination.descending ? 'desc' : 'asc', header.value === pagination.sortBy ? 'active' : '']"
	              @click="changeSort(header.value)"
	            >
	            	<div class="custom-header" :class="header.value == 'actions' ? 'justify-content-end' : ''">
		              <v-tooltip bottom>
		                <span slot="activator" class="text-capitalize font-weight-bold">
		                  {{ header.text }}
		                </span>
		                <span>
		                  {{ header.text }}
		                </span>
		              </v-tooltip>
		              <v-icon v-if="header.value != 'actions'">arrow_upward</v-icon>
	            	</div>
	            </th>
	          </tr>
	        </template>

		    	<template slot="items" slot-scope="props">
		    		<td class="text-xs-left">{{ props.item.id }}</td>
		        <td class="text-xs-left">{{ props.item.package_name }}</td>
		        <td class="text-xs-left">{{ props.item.price }}</td>
		        <td class="text-xs-left">{{ props.item.offer }}</td>
		        <td class="text-right">
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
		            @click="showDialog(props.item.id)"
		          >
		          	delete
		        	</v-icon>
		        </td>
		    	</template>
		    	<template slot="no-data">
		    		<div class="btn-reset text-center"><v-btn color="primary">Reset</v-btn></div>
		    	</template>
				</v-data-table>
			</app-card>
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
		</v-layout>
		<v-layout row wrap>
			<app-card
				colClasses="xl12 lg12 md12 sm12 xs12"
				customClasses="p-0 elevation-5"
				:fullScreen="true"
				:reloadable="true"
				:closeable="false"
			>
				<v-toolbar flat color="white">
	        <v-toolbar-title>
	          One(1) Photo Package
	        </v-toolbar-title>
	      </v-toolbar>
	      <v-divider class="m-0"></v-divider>

	      <v-data-table
		      :headers="headers2"
		      :items="desserts2"
		      class="elevation-5 body-2 global-custom-table"
		      :pagination.sync="pagination"
		      :disable-initial-sort="true"
				  :loading="loadingCom"
			  >
			  	<v-progress-linear slot="progress" color="blue" indeterminate></v-progress-linear>
					<!--Header -->
					<template slot="headers" slot-scope="props">
	          <tr>
	            <th
	              v-for="header in props.headers"
	              :key="header.text"
	              :class="['column sortable', pagination.descending ? 'desc' : 'asc', header.value === pagination.sortBy ? 'active' : '']"
	              @click="changeSort(header.value)"
	            >
	            	<div class="custom-header" :class="header.value == 'price' || header.value == 'offer' ? 'justify-content-center' : ''">
		              <v-tooltip bottom>
		                <span slot="activator" class="text-capitalize font-weight-bold">
		                  {{ header.text }}
		                </span>
		                <span>
		                  {{ header.text }}
		                </span>
		              </v-tooltip>
		              <v-icon v-if="header.value == 'package_name' || header.value == 'id'">arrow_upward</v-icon>
	            	</div>
	            </th>
	          </tr>
	        </template>

		    	<template slot="items" slot-scope="props">
		    		<td class="text-xs-left">{{ props.item.id }}</td>
			      <td class="text-xs-left">{{ props.item.size }}</td>
		        <td>
		        	<v-flex xs8 offset-xs2 class="center-prepend-icon">
			          <v-text-field
			          	hide-details
			          	single-line
			          	:prepend-icon="props.item.symbol"
			            v-model="props.item.price"
			            :rules="[rules.required]"
			            outline
			            clear-icon="mdi-close-circle"
			            clearable
			            type="number"
			            @blur="editPhotoPackage('price', props.item.price, props.item.id)"
								  @keyup.enter="editPhotoPackage('price', props.item.price, props.item.id)"
			          ></v-text-field>
			        </v-flex>
		        </td>
		        <td>
		        	<v-flex xs8 offset-xs2 class="center-prepend-icon">
			          <v-text-field
			          	hide-details
			          	single-line
			            v-model="props.item.free_photo"
			            :rules="[rules.required, rules.number]"
			            outline
			            clear-icon="mdi-close-circle"
			            clearable
			            type="number"
			            @blur="editPhotoPackage('free_photo', props.item.free_photo, props.item.id)"
					    		@keyup.enter="editPhotoPackage('free_photo', props.item.free_photo, props.item.id)"
			          ></v-text-field>
			        </v-flex>
		        </td>
		    	</template>

		    	<!--No data -->
				  <template slot="no-data">
			      <v-alert :value="true" color="error" icon="warning">
			        Sorry, nothing to display here :(
			      </v-alert>
	    		</template>
				</v-data-table>

			</app-card>
		</v-layout>
	</v-container>
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
        { text: 'Actions', value:'actions', sortable: false, align: 'right' }
    	],
    	desserts: [],
    	headers2: [
    		{ text: 'Sl No.', value: 'id', width: '10%' },
        { text: 'Size', align: 'left', value: 'package_name', width: '25%' },
        { text: 'Unit Price', value: 'price', sortable: false, width: '35%', align: 'center' },
        { text: 'Free Photo', value: 'offer', sortable: false, width: '35%' },
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
	    keyPhotoPackage: 0,
	    user: JSON.parse(localStorage.getItem('user')),
    }
	},
	computed: {
    loadingCom(){
    	return this.loading
    },
	},
	methods:{
		fetchData() {
			let url = config.API_URL+'get-company-package';
			post(url, this.user)
			.then((res) => {
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
			post(url, this.user)
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

      	unDisablePhotoPackage(keyPhotoPackage){
      		this.keyPhotoPackage = keyPhotoPackage
      	},

		editPhotoPackage(field_name, value, id){
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
          })
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
	  				company_id: this.user.company_id
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

			del(config.API_URL + 'company_packages/' + this.itemIdToDelete.id)
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
		},
		toggleAll () {
      if (this.selected.length) this.selected = []
      else{
	    	this.selected = this.desserts.slice()
      }
    },
    changeSort (column) {
      var columnsNoSearch = ['actions', 'price', 'offer']
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
    },
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
};
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
    padding: 12px 5px 0px 0px;
}

.symbol-td-text-field {
	float: left;
}

.symbol-td-icon {
	float: left;
}

</style>