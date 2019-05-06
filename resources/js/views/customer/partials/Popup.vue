<template>
	<div class="popup" v-show="checkPopup">
		<v-layout row>
		    <v-flex xs12 sm6 offset-sm3>
		    	<v-card height="auto">
		    		<v-card-title class="v-card-title--icon">
		    			<v-toolbar-side-icon @click="checkPopup = false">
							<v-icon>
								fas fa-times
							</v-icon>
						</v-toolbar-side-icon>
		    		</v-card-title>
		    		<v-card-title>
		    			<v-img src="https://lh3.googleusercontent.com/cEk27DnlDACU9301ifc_g0RUbwbTQnbU5E0zcWHK031GXYR-fcn9tRWPJm0JDCKvquU" max-width="100%">
		       			</v-img>
		    		</v-card-title>
		    		<v-card-title class="v-card-title--text">Get Now Rest Of 10 Photos!.
		    			<br> Only for Rp 1000000
		    		</v-card-title>
		    		<v-card-actions class="v-card-action--custom">
		    			<v-btn color="success">TAKE IT</v-btn>
		    			<v-btn color="error">NO, THANKS</v-btn>
		    		</v-card-actions>
		      </v-card>
		    </v-flex>
  		</v-layout>
	</div>
</template>
<script>
export default {
	name: 'Popup',
	data () {
    return {
    	items: [
	        { title: 'Click Me' },
	        { title: 'Click Me' },
	        { title: 'Click Me' },
	        { title: 'Click Me 2' }
      	],
      	checkPopup: true
    }
  }
}
</script>

<style lang="scss" scoped>

</style>