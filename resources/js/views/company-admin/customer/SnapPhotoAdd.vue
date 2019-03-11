<template>
		<v-dialog
		fixed
		v-model="drawer"
		:right="!rtlLayout"
		fullscreen hide-overlay transition="slide-x-reverse-transition"
	>
		<v-card class="h-100 position-relative">
			<v-toolbar>
		    	<v-toolbar-title class="text-capitalize">Add Snap Photo</v-toolbar-title>
		    	<v-spacer></v-spacer>
		    	<v-toolbar-side-icon @click="closeDrawer">
		      		<v-icon>
		          		fas fa-times
		        	</v-icon>
		      	</v-toolbar-side-icon>
	    	</v-toolbar>
	    	<v-divider class="mt-0 mb-0"></v-divider>


	    <v-container grid-list-md >	
		    <v-layout row wrap> 
		    	
			    <v-flex xs6 >
			        <v-list class="heigth-list-title">
						<template>
							<v-list-tile>
							<v-list-tile-content>
								<v-list-tile-title class="content-flex custom-content-flex">
							  	<span class="font-weight-bold item-title">Branch:</span>
							  		 <v-select
							          :items="branches"
							          
					                  item-value="id"
	            					  item-text="name"
	            					  v-model="valueBranch"
	            					  @change="changeBranch(valueBranch)"
	            					  :rules="[rules.required]"
							        ></v-select>
								</v-list-tile-title>
							</v-list-tile-content>
							</v-list-tile>
						</template>
					</v-list>
			    </v-flex>

			    <v-flex xs6 >
			        <v-list class="heigth-list-title">
			        	<template>
			          <v-list-tile>
							<v-list-tile-content>
								<v-list-tile-title class="content-flex custom-content-flex">
							  	<span class="font-weight-bold item-title">Photographer:</span>
							  	 <v-select
							          :items="photographers"
							          item-value="id"
	            					  item-text="name"
							          :rules="[rules.required]"
							        ></v-select>
								</v-list-tile-title>
							</v-list-tile-content>
							</v-list-tile>
						</template>
						</v-list>
			    </v-flex>

			     <v-flex xs6 >
			        <v-list class="heigth-list-title">
						<template>
							<v-list-tile>
							<v-list-tile-content>
								<v-list-tile-title class="content-flex custom-content-flex">
							  	<span class="font-weight-bold item-title">Room:</span>
							  		  <v-text-field
							            label="Room"
							            :rules="[rules.required, rules.number]"
							          ></v-text-field>
								</v-list-tile-title>
							</v-list-tile-content>
							</v-list-tile>
						</template>
					</v-list>
			    </v-flex>

			    <v-flex xs6 >
			        <v-list class="heigth-list-title">
			        	<template>
			          <v-list-tile>
							<v-list-tile-content>
								<v-list-tile-title class="content-flex custom-content-flex">
							  	<span class="font-weight-bold item-title">
							  		<v-btn color="primary">Created</v-btn>
							  	</span>
							  	 	
								</v-list-tile-title>
							</v-list-tile-content>
							</v-list-tile>
						</template>
						</v-list>
			    </v-flex>

		    </v-layout>
    </v-container>    	

		</v-card>
	</v-dialog>
</template>

<script>
import { mapGetters } from "vuex"
import { get, post, put, getWithData } from '../../../api/index.js'
import config from '../../../config/index.js'

export default {

  name: 'SnapPhotoAdd',

  data () {
    return {
    	drawer: false,
    	items: ['Foo', 'Bar', 'Fizz', 'Buzz'],
    	branches: [],
    	photographers: [],
    	company: JSON.parse(localStorage.getItem('user')),
    	valueBranch: '',
    	rules: {
	        required: value => !!value || 'This field is required.',
	        number: value => {
	          const pt = /^[0-9]\d*$/
	          return pt.test(value) || 'Please input number.'
	      	}
    	}
    }
  },
  computed:{
  	...mapGetters(["rtlLayout",])
  },
  mounted() {
  	this.$root.$on('formSnapPhotoAdd', res => {
		this.drawer = res.activeform  		
	})
  },
  created() {
  	this.fetchDataBranch()
  },
  methods:{
  	closeDrawer()
  	{
  		this.drawer = false
  	},
  	fetchDataBranch()
  	{
		var url = config.API_URL+'company/branch-company?companyId='+this.company.company_id

		get(url)
		.then(res => {
			if(res.data && res.data.success){
				// var data = res.data.data
				// var vm = this
				// _.forEach(data, function(value,key){
				// 	vm.items.push(value)					
				// })
				this.branches = res.data.data
			}
		})
		.catch(err => {
			console.log(err)
		})
	},
	changeBranch(item){		
		// if(item == 0) {
		// 	this.phographers =  [{
	 //        	id:'0',
	 //        	name:'-- Select Photographer --'	
	 //        }]
		// } 
		
		var url = config.API_URL+'photographer/photographer-branch?branchId='+item
		get(url)
		.then(res => {
			if(res && res.data.success){
				this.photographers = res.data.data
				// var vm = this
				// _.forEach(data, function(value,key){
				// 	vm.photographers.push(value)
						
				// })
				
				console.log(this.photographers)
			}
		})	
		.catch(err =>{

		})
	}
  }
}
</script>

<style lang="css" scoped>
</style>