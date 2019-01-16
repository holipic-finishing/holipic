<template>
  <div class="w-100">

    <div class="image-container position-relative text-center" v-if="!images.length">
      <div class="drag-upload-cover position-absolute" v-if="isDragover" @drop="onDrop">
        <div class="centered full-width text-center text-primary">
          <v-icon class="upload-icon" color="green darken-2">far fa-images</v-icon>
          <h4 class="drop-text-here"><b>{{dropText}}</b></h4>
        </div>
      </div>
      <div v-else class="image-center position-absolute display-flex flex-column justify-content-center align-items-center" @dragover.prevent="onDragover">
        <div>
          <v-icon class="upload-icon" color="green darken-2">fas fa-cloud-upload-alt</v-icon>
        </div>
        <div class="text-center">
          <label class="headline">{{dragText}}</label>
          <br>
          <a class="browse-text headline">{{browseText}}</a>
        </div>
        <div class="image-input position-absolute full-width full-height">
          <label for="image-upload" class="full-width full-height cursor-pointer">
          </label>
        </div>
      </div>
    </div>

    <div class="image-container position-relative text-center image-list" v-else>

      <div class="preview-image full-width position-relative cursor-pointer">
        <div class="image-overlay position-relative-upload full-width full-height"></div>
        <v-card flat tile class="d-flex">
          <v-img
            :src="imagePreview"
            :lazy-src="imagePreview"
            class="grey lighten-2"
            srcset
          >
            <v-layout
              slot="placeholder"
              fill-height
              align-center
              justify-center
              ma-0
            >
              <v-progress-circular indeterminate color="green lighten-2"></v-progress-circular>
            </v-layout>
          </v-img>
        </v-card>
      </div>

      <div class="image-bottom display-flex position-absolute full-width align-items-center justify-content-between" :class="!showPrimary && 'justify-content-end'">
        <div class="image-bottom-left display-flex align-items-center" v-if="showPrimary">
          <div class="display-flex align-items-center" v-show="imageDefault">
            <span class="image-primary display-flex align-items-center">
              <v-icon dark>check_circle</v-icon>
              <span class="ml-2">{{primaryText}}</span>
            </span>
            <popper trigger="click" :options="{placement: 'top'}">
              <div class="popper popper-custom">
                {{popupText}}
              </div>
              <i slot="reference" class="cursor-pointer display-flex align-items-center">
                <v-icon color="white">fas fa-info-circle</v-icon>
              </i>
            </popper>
          </div>
          <a class="white--text cursor-pointer" @click.prevent="markIsPrimary(currentIndexImage)" v-show="!imageDefault">
            <span>{{markIsPrimaryText}}</span>
            <v-icon dark>gavel</v-icon>
          </a>
        </div>
        <div class="d-flex justify-content-around align-items-center">
          <label class="mb-0 mr-2 cursor-pointer" for="image-edit">
            <v-icon color="white">fas fa-pencil-alt</v-icon>
          </label>

          <a class="image-delete cursor-pointer" @click.prevent="deleteImage(currentIndexImage)">
            <v-icon color="white">fas fa-trash-alt</v-icon>
          </a>
        </div>
      </div>

    </div>

    <v-card class="mt-2 border-top" v-if="imagePreview">
      <v-container grid-list-sm fluid>
        <v-layout row wrap>
          <v-flex xs12 md6>
            <v-slider label="Scale" v-model="scale" min="1" max="100" step="1"></v-slider>
          </v-flex>
          <v-flex xs12 md6>
            <v-slider label="Quality" v-model="quality" min="1" max="100" step="1"></v-slider>
          </v-flex>
        </v-layout>
      </v-container>
    </v-card>

    <v-card class="mt-2 border-top" v-if="images.length && multiple">
      <v-container grid-list-sm fluid>
        <v-layout row wrap>
          <v-flex
            v-for="(image, index) in images"
            :key="index"
            xs1
            d-flex
            class="image-list-item"
            @click="changeHighlight(index)"
            :class="image.highlight && 'image-highlight'"
          >
            <v-card flat tile class="d-flex">
              <v-img
                :src="image.path"
                :lazy-src="image.path"
                class="grey lighten-2"
                srcset
              >
                <v-layout
                  slot="placeholder"
                  fill-height
                  align-center
                  justify-center
                  ma-0
                >
                  <v-progress-circular indeterminate color="green lighten-2"></v-progress-circular>
                </v-layout>
              </v-img>
              
            </v-card>
          </v-flex>
          <v-flex
            xs1
            class="image-list-item"
            v-if="images.length < maxImage"
          >
            <div class="w-100 h-100">
              <label for="image-upload" class="d-flex align-items-center justify-content-center w-100 h-100 cursor-pointer m-0">
                <svg class="icon add-image-svg" xmlns="http://www.w3.org/2000/svg" width="512" height="512" viewBox="0 0 512 512">
                  <path d="M511.5 227.5h-227V.5h-57v227H-.5v57h228v228h57v-228h227z"></path>
                </svg>
              </label>
            </div>
          </v-flex>
        </v-layout>
      </v-container>
    </v-card>

    <div>
      <input id="image-upload" @change="uploadFieldChange" name="images" :multiple="multiple" :accept="accept" type="file">
      <input id="image-edit" @change="editFieldChange" name="image" :accept="accept" type="file">
    </div>

  </div>
</template>

<script>
import { forEach, findIndex, orderBy, cloneDeep } from 'lodash'
import Popper from 'vue-popperjs'
import 'vue-popperjs/dist/css/vue-popper.css'
import Compressor from 'compressorjs'

export default {

  name: 'UploadMultipleImagePlugin',

  props: {
    dragText: {
      type: String,
      default: 'Drag photos (many)'
    },
    browseText: {
      type: String,
      default: '(Or) Choose'
    },
    primaryText: {
      type: String,
      default: 'Default'
    },
    markIsPrimaryText: {
      type: String,
      default: 'Set Default'
    },
    popupText: {
      type: String,
      default: 'This image will be displayed as default'
    },
    dropText: {
      type: String,
      default: 'Drop your file here ...'
    },
    accept: {
      type: String,
      default: 'image/gif,image/jpeg,image/png,image/bmp,image/jpg'
    },
    dataImages: {
      type: Array,
      default: () => {
        return []
      }
    },
    multiple: {
      type: Boolean,
      default: true
    },
    showPrimary: {
      type: Boolean,
      default: true
    },
    maxImage: {
      type: Number,
      default: 5
    }
  },
  data () {
    return {
      currentIndexImage: 0,
      images: [],
      isDragover: false,
      quality: 0.6,
      convertSize: 5000000,
      original:{},
      compressed: {
      },
      reader: {},
    }
  },
  components: {
    Popper
  },
  computed: {
    imagePreview () {
      let index = findIndex(this.images, { highlight: 1 })
      if (index > -1) {
        return this.images[index].path
      } else {
        return this.images.length ? this.images[0].path : ''
      }
    },
    imageDefault () {
      if (this.images[this.currentIndexImage]) {
        return this.images[this.currentIndexImage].default
      }
    }
  },
  methods: {
    /**
     * Drop file
     */
    onDrop (e) {
      this.isDragover = false
      e.stopPropagation()
      e.preventDefault()
      let files = e.dataTransfer.files
      if (!files.length) {
        return false
      }
      forEach(files, (value, index) => {
        this.createImage(value)
        if (!this.multiple) {
          return false
        }
      })
      if (document.getElementById('image-upload')) {
        document.getElementById('image-upload').value = []
      }
    },
    /**
     * Dragover file
     */
    onDragover () {
      this.isDragover = true
    },
    /**
     * Compress file
     * @param File file
     * @return file compression
     */
    createCompressFile(file){
      var _this = this
      new Compressor(file, {
        quality: this.quality,
        mimeType: 'auto',
        convertSize: this.convertSize,
        success(result) {
          
          let reader = new FileReader()
          reader.readAsDataURL(result)

          
          reader.onload = (e) => {
            let base64 = e.target.result
            let fileInfo = {
              name: result.name,
              type: result.type,
              size: Math.round(result.size / 1000)+' kB',
              base64: e.target.result
            }

            _this.compressed = fileInfo
          }

          // const formData = new FormData()
          // formData.append('file', result)

          // Send the compressed image file to server with XMLHttpRequest.
          // axios.post('/path/to/upload', formData)
          // .then(() => {
          //   console.log('Upload success');
          // });
        },
        error(err) {
          console.log(err.message);
        },
      })

      
      
    },
    createOriginalFile(file){
      let reader = new FileReader()
      reader.readAsDataURL(file)

      reader.onload = (e) => {
        let base64 = e.target.result

        let fileInfo = {
          name: file.name,
          type: file.type,
          size: Math.round(file.size / 1000)+' kB',
          base64: reader.result,
        }

        this.original = fileInfo 
      }

      const formData = new FormData()
      formData.append('file', file)

      // Send the compressed image file to server with XMLHttpRequest.
      // axios.post('/path/to/upload', formData)
      // .then(() => {
      //   console.log('Upload success');
      // })
    },
    /**
     * Create Image 
     * @param  File file
     */
    createImage (file) {

      /*******************Original File****************************/
      this.createOriginalFile(file)
      /*******************End Original File************************/

      /*******************Compression File*************************/
      this.createCompressFile(file)
      /******************End Compression File**********************/

      if (!this.images.length) {
        this.images.push({
          name: file.name, 
          path: this.compressed.base64, 
          highlight: 1, 
          default: 1
        })
        this.currentIndexImage = 0
      } else {
        this.images.push({
          name: file.name, 
          path: this.compressed.base64, 
          highlight: 0, 
          default: 0
        })
      }

      this.$root.$emit('upload-success')
    },
    editImage (file) {
      this.reader = new FileReader()
      let formData = new FormData()
      formData.append('file', file)
      this.reader.onload = (e) => {
        let dataURI = e.target.result
        if (dataURI) {
          if (this.images.length && this.images[this.currentIndexImage]) {
            this.images[this.currentIndexImage].path = dataURI
            this.images[this.currentIndexImage].name = file.name
          }
        }
      }
      this.reader.readAsDataURL(file)
      this.$emit('edit-image', formData, this.currentIndexImage, this.images)
    },
    uploadFieldChange (e) {
      let files = e.target.files || e.dataTransfer.files
      if (!files.length) {
        return false
      }
      forEach(files, (value, index) => {
        this.createImage(value)
      })
      if (document.getElementById('image-upload')) {
        document.getElementById('image-upload').value = []
      }
    },
    editFieldChange (e) {
      let files = e.target.files || e.dataTransfer.files
      if (!files.length) {
        return false
      }
      forEach(files, (value, index) => {
        this.editImage(value)
      })
      if (document.getElementById('image-edit')) {
        document.getElementById('image-edit').value = ''
      }
    },
    changeHighlight (currentIndex) {
      this.currentIndexImage = currentIndex
      this.images.map((item, index) => {
        if (currentIndex === index) {
          item.highlight = 1
        } else {
          item.highlight = 0
        }
        return item
      })
    },
    markIsPrimary (currentIndex) {
      this.images.map((item, index) => {
        if (currentIndex === index) {
          item.highlight = 1
          item.default = 1
        } else {
          item.highlight = 0
          item.default = 0
        }
        return item
      })
      this.currentIndexImage = 0
      this.images = orderBy(this.images, 'default', 'desc')
      this.$emit('mark-is-primary', currentIndex, this.images)
    },
    deleteImage (currentIndex) {
      this.$emit('before-remove', currentIndex, () => {
        if (this.images[currentIndex].default === 1) {
          this.images[0].default = 1
        }
        this.images.splice(currentIndex, 1)
        this.currentIndexImage = 0
        if (this.images.length) {
          this.images[0].highlight = 1
        }
      }, this.images)
    },
  },
  watch: {
    dataImages: {
      handler: function (newVal) {
        this.images = newVal
      },
      deep: true
    },
  },
  mounted () {
    ['drag', 'dragstart', 'dragend', 'dragover', 'dragenter', 'dragleave', 'drop'].forEach((event) => {
      window.addEventListener(event, (e) => {
        e.preventDefault()
        e.stopPropagation()
      })
    })
    document.body.addEventListener('dragleave', (event) => {
      event.stopPropagation()
      event.preventDefault()
      this.isDragover = false
    })
  },
  created () {
    this.images = []
    this.images = cloneDeep(this.dataImages)
  }
};
</script>

<style lang="scss" scoped>

</style>
