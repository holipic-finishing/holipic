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
		<active-coupon-code></active-coupon-code>
		<!-- <v-data-table
	      :headers="headers"
	      :items="desserts"
	      class="elevation-1"
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
		</v-data-table> -->
	</v-container>

	</div>
</template>

<script>
import ActiveCouponCode from './ActiveCouponCode.vue'	
export default {

	name: 'Index',

	data () {
	    return {

	    }
	},
	methods : {
		showAddItem() {
			let obj = {
  				check : true,
  				showDialog: true,
	  		}
  			this.$root.$emit('change-status', obj)
		}
	},
	components:{
		ActiveCouponCode
	}
}
</script>

<style lang="css" scoped>

</style>