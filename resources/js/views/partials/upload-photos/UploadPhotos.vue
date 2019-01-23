<template>
	<v-container fluid pt-0 grid-list-xl class="h-100">
		<v-layout row wrap mt-3 class="h-100">
			<v-flex d-flex xs12>
        <v-card class="card-wrap" v-if="isOnline">
        	<v-container
	          fluid
	          grid-list-md
	          class="custom-container h-100"
	        >
	        	<v-layout row wrap>
              <v-flex xs12 >
                <multiple-upload></multiple-upload>
              </v-flex>
	        	</v-layout>
	        </v-container>
        </v-card>
        <v-card v-if="isOffline">
          This part will be visible only if user is offline
        </v-card>
    	</v-flex>
		</v-layout>
	</v-container>
</template>

<script>
import MultipleUpload from './components/MultipleUpload'

export default {

  name: 'UploadPhotos',
  components: { 
    MultipleUpload
  },
  data () {
    return {
    	
    }
  },
  methods: {

	},
	computed:{
		
	}
};
</script>

<style lang="scss" scoped>

</style>