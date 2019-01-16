<template>
  <div>
		<upload-multiple-image-plugin
	    @upload-success="uploadImageSuccess"
	    @before-remove="beforeRemove"
	    @edit-image="editImage"
	    @data-change="dataChange"
	    :data-images="images"
	  ></upload-multiple-image-plugin>
	</div>
</template>

<script>
import UploadMultipleImagePlugin from '../plugins/UploadMultipleImagePlugin'

export default {

  name: 'MultipleUpload',
  components: {
    UploadMultipleImagePlugin,
  },
  data () {
    return {
    	images: [],
    }
  },
  methods: {
    uploadImageSuccess(formData, index, fileList) {
      console.log('data', formData, index, fileList)
      // Upload image api
      // axios.post('http://your-url-upload', formData).then(response => {
      //   console.log(response)
      // })
    },
    beforeRemove (index, done, fileList) {
      console.log('index', index, fileList)
      var r = confirm("remove image")
      if (r == true) {
        done()
      } else {
        
      }
    },
    editImage (formData, index, fileList) {
      console.log('edit data', formData, index, fileList)
    },
    dataChange (data) {
      console.log('change data', data)
    }
  }
};
</script>

<style lang="scss" scoped>
</style>