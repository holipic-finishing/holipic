<template>
	<v-container fluid px-0 py-0>
    <app-card 
      colClasses="xs12 sm12 md12 lg12"
      :fullScreen="true" 
      :reloadable="true" 
      :closeable="true"
      customClasses="blog-widget"
    >
      <dropzone-upload></dropzone-upload>
    </app-card>
  </v-container>
</template>

<script>
import MultipleUpload from './components/MultipleUpload'
import DropzoneUpload from './components/DropzoneUpload'

export default {

  name: 'UploadPhotos',
  components: { 
    DropzoneUpload
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