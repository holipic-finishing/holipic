<template>
	<div class="company-table">
		<v-container fluid grid-list-xl pt-0>
			<div id="app">
				<v-app id="inspire">
					<v-card class="p-4">
						<v-toolbar flat color="white">
					        <v-toolbar-title>
					          	Manage Sales
					        </v-toolbar-title>
					    </v-toolbar>
					    <v-divider></v-divider>
					    <!-- Filter Component -->
					   <v-layout row wrap border-rad-sm overflow-hidden>
					   	<!-- select box branch -->
						<v-flex xl2 lg2 md2 sm6 xs12>
				       <v-select
				          v-model="selected"
				          :items="items"
				           autocomplete
			              browserAutocomplete="off"
			              label="Select Branch"
			              item-text="name"
			              item-value="value"
			              v-on:change="changeBranh"
				        ></v-select>
				      	</v-flex>
					   	<!-- select box photographer -->
						<v-flex xl3 lg3 md3 sm6 xs12>
				        <v-select
				          v-model="selected1"
				          :items="phographer"
				           autocomplete
			              browserAutocomplete="off"
			              item-text="name"
			              item-value="value"
			              label="Select Photographer"
				        ></v-select>
				      	</v-flex>
					   	<!-- Start day -->
					   	<v-flex xl2 lg2 md2 sm6 xs12>
						<v-menu 
							:close-on-content-click="false"
			                v-model="menu1"
			                :nudge-right="40"
			                lazy
			                transition="scale-transition"
			                offset-y
						>
							<v-text-field 
								slot="activator"
								prepend-icon="event"
								v-model="computedStartDay"
								readonly
		  						placeholder="Enter Start Date"
							></v-text-field>
							<v-date-picker 
								v-model="from_day"
								no-title
								scrollable 
								:max="new Date().toISOString().substr(0, 10)"
							></v-date-picker>
						</v-menu>
						</v-flex>
						<!-- End day -->
						<v-flex xl2 lg2 md2 sm6 xs12>
						<v-menu 
							:close-on-content-click="false"
			                v-model="menu2"
			                :nudge-right="40"
			                lazy
			                transition="scale-transition"
			                offset-y
						>
							<v-text-field 
								slot="activator"
								prepend-icon="event"
								v-model="computedEndDay"
								readonly
		  						placeholder="Enter End Date"
							></v-text-field>
							<v-date-picker 
								v-model="to_day" 
								no-title 
								scrollable 
								:max="new Date().toISOString().substr(0, 10)"
							></v-date-picker>
						</v-menu>
						</v-flex>
						<v-flex xl1 lg1 md1 sm6 xs12>
							<v-btn class="btn-style" depressed color="primary">Go</v-btn>
				      	</v-flex>
				      	<v-flex xl1 lg1 md1 sm6 xs12>
						    <v-tooltip bottom class="icon-style">
							    <a :href="urlExport" target="_blank" slot="activator" class="btn btn-primary pl-2 pr-2 ml-3">
										<v-icon small color="white">fas fa-file-excel</v-icon>
									</a>
							    <span>Export companies</span>
						    </v-tooltip>
				      	</v-flex>
						</v-layout>
						<!--Search Component -->
						<v-card-title class="card-style">
				      		<v-spacer></v-spacer>
				      		<v-text-field
				        		v-model="search"
						        append-icon="search"
						        label="Enter search value"
						        single-line
						        hide-details
						    ></v-text-field>
				    	</v-card-title>
				    </v-card>
				</v-app>
			</div>
		</v-container>
	</div>
</template>

<script>
export default {

  name: 'Sales',

  data () {
    return {
    	menu1:false,
		menu2:false,	
		from_day:'',
		to_day:'',
		urlExport:'',
		search:'',
		selected: '',
        items: [
        	{name:'Programming',value:'0'},
        	{name:'Design',value:'1'},
        	{name:'Vue',value:'2'},
        	{name:'Vuetify',value:'3'}
       	],
        phographer:[{
        	value:'0',
        	name:'Select Photographer'	
        	}
        ],
		selected1:''
    }
  }
}
</script>

<style lang="css" scoped>
</style>