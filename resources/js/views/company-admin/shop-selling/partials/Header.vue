<template>
	<v-toolbar dark color="primary">
    	<v-btn icon>
    		<i class="material-icons ">
				reply_all
			</i>
    	</v-btn>
    <v-spacer></v-spacer>

    <v-toolbar-items class="hidden-sm-and-down">
      	<v-btn flat>
	      	<i class="material-icons font-material-header">
				card_giftcard
			</i>
	      PACKGES
  		</v-btn>
      <v-btn flat>
      	<i class="material-icons font-material-header">
				add_a_photo
			</i>
      	ADD NEW PHOTO
      </v-btn>
    </v-toolbar-items>

  </v-toolbar>
</template>

<script>
export default {

  name: 'Header',

  data () {
    return {

    }
  }
}
</script>

<style lang="css" scoped>
</style>