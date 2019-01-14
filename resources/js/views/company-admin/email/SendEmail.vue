<template>
<v-card class="h-100 position-relative">
	<v-toolbar>
    <v-toolbar-title class="text-capitalize">Send Email</v-toolbar-title>
    <v-spacer></v-spacer>
    <v-toolbar-side-icon @click="closeDrawer">
      	<v-icon>
          fas fa-times
        </v-icon>
      </v-toolbar-side-icon>
    </v-toolbar>
    <v-divider class="mt-0 mb-0"></v-divider>

    <v-list class="heigth-list-title">
		<v-list-tile class="height-80">
			<v-list-tile-content>
		        <v-list-tile-title class="content-flex">
		          	<span class="font-weight-bold item-title">To :</span>
        		</v-list-tile-title>
        		<v-list-tile-sub-title>
        			<div class="font-weight-bold item-title">
        				<v-checkbox
			              v-model="selectEmail"
			              label="Select all"
			              color="red"
			              hide-details
			              class="btn-style"
			            ></v-checkbox>
        			</div>
        		</v-list-tile-sub-title>
			</v-list-tile-content>
		</v-list-tile>

		<v-list-tile class="height-80" v-show="!selectEmail">
			<v-list-tile-content>
		        <v-list-tile-title class="content-flex">
		          	<span class="font-weight-bold item-title">To :</span>
        		</v-list-tile-title>
        		<v-list-tile-sub-title>
        			<div class="font-weight-bold item-title">
        				<v-checkbox
			              v-model="selectEmail"
			              label="Select all"
			              color="red"
			              hide-details
			              class="btn-style"
			            ></v-checkbox>
        			</div>
        		</v-list-tile-sub-title>
			</v-list-tile-content>
		</v-list-tile>
	</v-list>
    <v-divider class="mt-0 mb-0"></v-divider>
</v-card>
</template>

<script>
export default {

  	name: 'SendEmail',
  	props: ['item'],
	data () {
	    return {
	    	selectEmail:true
	    }
	},
	methods:{
		closeDrawer(){
  			this.$root.$emit('closeDrawerItem', false)
  		},
	}
}
</script>

<style lang="css" scoped>
.btn-style{
	margin-top : 0px  !important;
}
</style>