<template>
	<v-container fluid px-0 py-0>
    <app-card 
      colClasses="xs12 sm12 md12 lg12"
      :fullScreen="true" 
      :reloadable="true" 
      :closeable="true"
      customClasses="blog-widget"
    >
    <div id='upload_container' class='custom_progress'>
      <!-- <dropzone-upload></dropzone-upload> -->
       <ejs-uploader id='defaultfileupload' name="UploadFiles" :autoUpload= "isAuto" :asyncSettings= "path" ref="uploadObj" :dropArea= "dropElement" maxFileSize=1004857600
             :pausing= 'onPausing' :sequentialUpload= 'sequentialUpload' :allowedExtensions="extensions"
>
            </ejs-uploader>
    </div>
    </app-card>
  </v-container>
</template>

<script>

import MultipleUpload from './components/MultipleUpload'
import DropzoneUpload from './components/DropzoneUpload'
import Vue from 'vue';
import { UploaderPlugin } from '@syncfusion/ej2-vue-inputs';
import config from "../../../config/index.js"

Vue.use(UploaderPlugin);

export default {

  name: 'UploadPhotos',
  components: { 
    DropzoneUpload
  },
  data () {
    return {
    	path:  {
                saveUrl: config.API_URL + "company/upload-photo",
                removeUrl: 'https://aspnetmvc.syncfusion.com/services/api/uploadbox/Remove'

            },
        sequentialUpload: true,
        autoUpload: false,
        isAuto: false,
        dropElement: '.control-fluid',
        currentIndex: 0,
        isInteraction: false,
        extensions:'.jpg, .jpeg, .png'
    }
  },
  methods: {
        onUploadBegin(args) {
            // check whether the file is uploading from paste.
            axios.post(config.API_URL + "company/upload-photo", args)
            .then (res => {

            })
        },
        onPausing(args) {
            if (args.event !== null && !navigator.onLine) {
                this.isInteraction = true;
            } else {
                this.isInteraction = false;
            }
        },
        onResuming(args) {
            if (args.event !== null && !navigator.onLine) {
                this.isInteraction = true;
            } else {
                this.isInteraction = false;
            }
        }  
	},
	computed:{
		
	}
};
</script>

<style lang="scss" scoped>
  @import "../../../../../node_modules/@syncfusion/ej2-base/styles/material.css";
  @import "../../../../../node_modules/@syncfusion/ej2-buttons/styles/material.css";
  @import "../../../../../node_modules/@syncfusion/ej2-vue-inputs/styles/material.css";
   
</style>