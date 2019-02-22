<template>
	<v-container fluid px-0 py-0 class="fix-croll-container">
		<v-layout row wrap>
			<app-card
				colClasses="xl12 lg12 md12 sm12 xs12"
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
		      class="body-2 custom-table-package"
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
	            	<!-- <div class="custom-header" :class="header.value == 'actions' ? 'justify-content-end' : ''"> -->
		              <v-tooltip bottom>
		                <span slot="activator" class="text-capitalize font-weight-bold">
		                  {{ header.text }}
		                </span>
		                <span>
		                  {{ header.text }}
		                </span>
		              </v-tooltip>
		              <v-icon v-if="header.value != 'actions'">arrow_upward</v-icon>


	            	<!-- </div> -->
	            </th>
	          </tr>
	        </template>

		    	<template slot="items" slot-scope="props">
		    		<td class="text-xs-left">{{ props.index + 1 }}</td>
		        <td class="text-xs-left">{{ props.item.package_name }}</td>
		        <td class="text-xs-left">{{ props.item.price }}</td>
		        <td class="text-xs-left">{{ props.item.offer }}</td>
		        <td class="text-right">
		        	<v-edit-dialog
	            :return-value.sync="props.item.dollar"
	            large
	            lazy
	            @save="save('dollar', props.item.dollar, props.item.id)"
	            @cancel="cancel"
	            @open="open()"
	            @close="close('dollar', props.item.id)"
	            :ref="'v-dialog-p'+'dollar'+props.item.id"
	          >
	            <div>{{ props.item.dollar  }}</div>
	            <div slot="input" class="mt-3 title">Update Dollar</div>
	            <v-text-field
	              slot="input"
	              v-model="props.item.dollar"
	              label="Edit"
	              single-line
	              autofocus
	              type="number"
	              ref="checkPackage"
	              :rules="[rules.required, rules.number]"
	            ></v-text-field>
	          </v-edit-dialog>
		        </td>
		         <td class="text-right">
		        	<v-edit-dialog
		            :return-value.sync="props.item.euro"
		            large
		            lazy
		            @save="save('euro', props.item.euro, props.item.id)"
		            @cancel="cancel"
		            @open="open()"
		            @close="close('euro', props.item.id)"
		            :ref="'v-dialog-p'+'euro'+props.item.id"
		          >
	            <div>{{ props.item.euro }}</div>
	            <div slot="input" class="mt-3 title">Update Euro</div>
	            <v-text-field
	              slot="input"
	              v-model="props.item.euro"
	             type="number"
	              label="Edit"
	              single-line
	              autofocus
	              ref="checkPackage"
	              :rules="[rules.required, rules.decimal]"
	            ></v-text-field>
	          </v-edit-dialog>
		        </td>
		         <td class="text-right">
		        	<v-edit-dialog
	            :return-value.sync="props.item.indo"
	            large
	            lazy
	            
	            @save="save('indo', props.item.indo, props.item.id)"
	            @cancel="cancel"
	            @open="open()"
	            @close="close('indo', props.item.id)"
	            :ref="'v-dialog-p'+'indo'+props.item.id"
	          >
	            <div>{{ props.item.indo }}</div>
	            <div slot="input" class="mt-3 title">Update Indo</div>
	            <v-text-field
	              slot="input"
	              v-model="props.item.indo"
	            	type="number"
	              label="Edit"
	              single-line
	              autofocus
	              min="0"
	              ref="checkPackage"
	              :rules="[rules.required, rules.decimal]"
	            ></v-text-field>
	          </v-edit-dialog>
		        </td>
		        <td class="text-right">
		        	<v-edit-dialog
	            :return-value.sync="props.item.turkey"
	            large
	            lazy
	            
	            @save="save('turkey', props.item.turkey, props.item.id)"
	            @cancel="cancel"
	            @open="open()"
	            @close="close('turkey', props.item.id)"
	            
	            :rules="[rules.required, rules.number]"
	            :ref="'v-dialog-p'+'turkey'+props.item.id"
	          >
	            <div>{{ props.item.turkey }}</div>
	            <div slot="input" class="mt-3 title">Update Turkey</div>
	            <v-text-field
	              slot="input"
	              v-model="props.item.turkey"
	             	type="number"
	              label="Edit"
	              single-line
	              autofocus
	              min="0"
	              ref="checkPackage"
	              :rules="[rules.required, rules.decimal]"
	            ></v-text-field>
	          </v-edit-dialog>
		        </td>
		        <td class="text-right">
		        	<v-edit-dialog
	            :return-value.sync="props.item.vn"
	            large
	            lazy
	            @save="save('vn', props.item.vn, props.item.id)"
	            @cancel="cancel"
	            @open="open()"
	            @close="close"
	            :ref="'v-dialog-p'+'vn'+props.item.id"
	          >
	            <div>{{ props.item.vn }}</div>
	            <div slot="input" class="mt-3 title">Update VND</div>
	            <v-text-field
	              slot="input"
	              v-model="props.item.vn"
	             	type="number"
	              label="Edit"
	              single-line
	              autofocus
	              ref="checkPackage"
	              :rules="[rules.required, rules.decimal]"
	            ></v-text-field>
	          </v-edit-dialog>
		        </td>
		        <td class="text-center action-width">
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
		</v-layout>
		<v-layout row wrap>
			<app-card
				colClasses="xl12 lg12 md12 sm12 xs12"
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
		      class="body-2 custom-table"
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
		    			<td class="text-xs-left">{{ props.index + 1 }}</td>
			        <td class="text-xs-left">{{ props.item.size }}</td>
			        <td class="text-xs-right custom-td-package">
			        	<v-flex xs8 offset-xs2 class="center-prepend-icon">
			        	<v-edit-dialog
			        		:ref="'v-dialog'+'dollar'+props.item.id"
			            :return-value.sync="props.item.dollar"
			             :large="true"
			            lazy
			            
			            @save="savePhotoPackage('dollar', props.item.dollar, props.item.id)"
			            @cancel="cancel"
			            @open="open()"
			            @close="close"
	          			>
			            <div>{{ props.item.dollar }}</div>
			            <div slot="input" class="mt-3 title">Update Dollar</div>
			            <v-text-field
			              slot="input"
			              v-model="props.item.dollar"
			             	type="number"
			              label="Edit"
			              single-line
			              min="0"
			              autofocus
			              ref="checkPhotoPackage"
			              :rules="[rules.required, rules.number]"
			            ></v-text-field>
	         			</v-edit-dialog>
	         		</v-flex>
			        </td>
			        <td  class="text-xs-right custom-td-package">
			        	<v-flex xs8 offset-xs2 class="center-prepend-icon">
			        	<v-edit-dialog
			        		:ref="'v-dialog'+'euro'+props.item.id"
			            :return-value.sync="props.item.euro"
			            :large="true"
			            lazy
			            
			            @save="savePhotoPackage('euro', props.item.euro, props.item.id)"
			            @cancel="cancel"
			            @open="open()"
			            @close="close"
	          			>
			            <div>{{ props.item.euro }}</div>
			            <div slot="input" class="mt-3 title">Update Euro</div>
			            <v-text-field
			              slot="input"
			              v-model="props.item.euro"
			             	type="number"
			              label="Edit"
			              single-line
			              min="0"
			              autofocus
			               ref="checkPhotoPackage"
			              :rules="[rules.required, rules.decimal]"
			            ></v-text-field>
	         			</v-edit-dialog>
	         		</v-flex>
			        </td>
			        <td  class="text-xs-right custom-td-package">
			        	<v-flex xs8 offset-xs2 class="center-prepend-icon">
			        	<v-edit-dialog
			        		:ref="'v-dialog'+'indo'+props.item.id"
			            :return-value.sync="props.item.indo"
			            :large="true"
			            lazy
			            
			             @save="savePhotoPackage('indo', props.item.indo, props.item.id)"
			            @cancel="cancel"
			            @open="open()"
			            @close="close"
	          			>
			            <div>{{ props.item.indo }}</div>
			            <div slot="input" class="mt-3 title">Update Indo</div>
			            <v-text-field
			              slot="input"
			              v-model="props.item.indo"
			             	type="number"
			              label="Edit"
			              single-line
			              min="0"
			              autofocus
			               ref="checkPhotoPackage"
			              :rules="[rules.required, rules.decimal]"
			            ></v-text-field>
	         			</v-edit-dialog>
	         		</v-flex>
			        </td>
			        <td  class="text-xs-right custom-td-package">
			        	<v-flex xs8 offset-xs2 class="center-prepend-icon">
			        	<v-edit-dialog
			        		:ref="'v-dialog'+'turkey'+props.item.id"
			            :return-value.sync="props.item.turkey"
			            :large="true"
			            lazy
			            @save="savePhotoPackage('turkey', props.item.turkey, props.item.id)"
			            @cancel="cancel"
			            @open="open()"
			            @close="close"
	          			>
			            <div>{{ props.item.turkey }}</div>
			            <div slot="input" class="mt-3 title">Update Turkey</div>
			            <v-text-field
			              slot="input"
			              v-model="props.item.turkey"
			             	type="number"
			              label="Edit"
			              single-line
			              min="0"
			              autofocus
			              :rules="[rules.required, rules.decimal]"
			              ref="checkPhotoPackage"
			            ></v-text-field>
	         			</v-edit-dialog>
	         		</v-flex>
			        </td>
			        <td class="text-xs-right custom-td-package">
			        	<v-flex xs8 offset-xs2 class="center-prepend-icon">
			        	<v-edit-dialog
			        		:ref="'v-dialog'+'vn'+props.item.id"
			            :return-value.sync="props.item.vn"
			            :large="true"
			            lazy
			            @save="savePhotoPackage('vn', props.item.vn, props.item.id)"
			            @cancel="cancel"
			            @open="open()"
			            @close="close('vn', props.item.id)"
	          			>
			            <div>{{ props.item.vn }}</div>
			            <div slot="input" class="mt-3 title">Update VND</div>
			            <v-text-field
			              slot="input"
			              v-model="props.item.vn"
			             	type="number"
			              label="Edit"
			              single-line
			              min="0"
			              autofocus
			              :rules="[rules.required, rules.decimal]"
			              ref="checkPhotoPackage"
			            ></v-text-field>
	         			</v-edit-dialog>
	         		</v-flex>
			        </td>
			        <td  class="text-xs-right custom-td-package">
			        	<v-flex xs8 offset-xs2 class="center-prepend-icon">
				          <v-edit-dialog
				          	:ref="'v-dialog'+'free_photo'+props.item.id"
				            :return-value.sync="props.item.free_photo"
				            :large="true"
				            lazy
				            @save="savePhotoPackage('free_photo', props.item.free_photo, props.item.id)"
				            @cancel="cancel"
				            @open="open()"
				            @close="close('free_photo', props.item.id)"
	          			>
			            <div>{{ props.item.free_photo }}</div>
			            <div slot="input" class="mt-3 title">Update Free Photo</div>
			            <v-text-field
			              slot="input"
			              v-model="props.item.free_photo"
			             	type="number"
			              label="Edit"
			              single-line
			              min="0"
			              :rules="[rules.required, rules.number]"
			              ref="checkPhotoPackage"
			            ></v-text-field>
	         			</v-edit-dialog>
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
        { text: 'Dollar', value: 'offer', sortable: false, width: '35%' },
        { text: 'Euro', value: 'offer', sortable: false, width: '35%' },
        { text: 'Indo', value: 'offer', sortable: false, width: '35%' },
        { text: 'Turkey', value: 'offer', sortable: false, width: '35%' },
        { text: 'VND', value: 'offer', sortable: false, width: '35%' },
        { text: 'Actions', value:'actions', sortable: false, align: 'right' }
    	],
    	desserts: [],
    	headers2: [
    		{ text: 'Sl No.', value: 'id', width: '10%' },
        { text: 'Size', align: 'left', value: 'package_name', width: '25%' },
        { text: 'Dollar', value: 'offer', sortable: false, width: '65%' },
        { text: 'Euro', value: 'offer', sortable: false, width: '65%' },
        { text: 'Indo', value: 'offer', sortable: false, width: '65%' },
        { text: 'Turkey', value: 'offer', sortable: false, width: '65%' },
        { text: 'VND', value: 'offer', sortable: false, width: '65%' },
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
            const abc = /^\d+\.\d{0,10}$/
            return abc.test(value) || 'Please input number .'
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
	    persistent: true
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
          this.$notify({
	          title: 'Success',
	          message: 'Edit Item Successfully.',
	          type: 'success',
	          duration: 2000,
	        })
          this.key = 0
          this.fetchDataPhotoPackage()
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
				this.$notify({
          title: 'Success',
          message: 'Delete Item Successfully.',
          type: 'success',
          duration: 2000,
        })
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
    updatePackage(id, field) {
    	post(config.API_URL + 'edit/companyPackage/' + id, field)
			.then((res) => {
				if(res.data && res.data.success){
          this.$notify({
	          title: 'Success',
	          message: 'Edit Item Successfully.',
	          type: 'success',
	          duration: 2000,
	        })		

          this.fetchData()
				}
			})
			.catch((e) =>{
        setTimeout(() => {this.alertStt = false}, 1500)
			})
	  },
    save (type, value, id) {
    	if (!this.$refs.checkPackage.validate()) {
      	this.$refs['v-dialog-p' + type + id].isActive = true;
      } else {
        var field = {
	        field_name: type,
	        value: value,
	        id: id
      	}
      	this.updatePackage(id, field)
      }
    },
  	cancel() {
  		this.fetchData();

  		this.fetchDataPhotoPackage();		
  	},
    open() {
      
    },
    close (type, id) {
    	this.fetchData();

  		this.fetchDataPhotoPackage();

    	this.$refs['v-dialog' + type + id].isActive = false

    	this.$refs['v-dialog-p' + type + id].isActive = false;

    		
    },
    savePhotoPackage(type, value, id) {
      if (!this.$refs.checkPhotoPackage.validate()) {
      	this.$refs['v-dialog' + type + id].isActive = true;
      } else {
      	var field = {
	        field_name: type,
	        value: value,
	        id: id
      	}
      	this.fetchDataEdit(id, field)
      }
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
};
</script>

<style lang="scss" scoped>

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