<template>
  <div>
		<multiple-image-upload-plugin
	    @upload-success="uploadImageSuccess"
	    @before-remove="beforeRemove"
	    @edit-image="editImage"
	    @data-change="dataChange"
	    :data-images="images"
	  ></multiple-image-upload-plugin>
	</div>
</template>

<script>
import MultipleImageUploadPlugin from '../../../../plugins/multiple-upload/MultipleImageUploadPlugin'

export default {

  name: 'MultipleUpload',
  components: {
    MultipleImageUploadPlugin,
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