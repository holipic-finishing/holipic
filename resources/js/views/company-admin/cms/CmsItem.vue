<template>
  <v-card class="h-100 position-relative">
  	<v-toolbar>
      <v-toolbar-title class="text-capitalize">{{ eventType }} Content Management</v-toolbar-title>
      <v-spacer></v-spacer>
      <v-toolbar-side-icon @click="closeDrawer">
      	<v-icon>
          fas fa-times
        </v-icon>
      </v-toolbar-side-icon>
    </v-toolbar>
    <v-divider class="mt-0 mb-0"></v-divider>

      <!-- Edit Item -->
  	<v-list v-if="itemToLoad && eventType === 'edit'" class="heigth-list-title">

      <!-- <v-alert  v-model="alertStt" :type="alertType" dismissible>{{ alertMes }}</v-alert> -->
      <v-list-tile class="height-80">
        <v-list-tile-content class="h-100">
          <v-list-tile-title class="content-flex-end h-100">
            <span class="font-weight-bold item-title-style position-item">Page Title</span>
            <span class="contain-text-field">
              <v-text-field
                class="font-weight-bold height-input"
                placeholder="Enter Page Title"
                v-model="itemToLoad.page_title"
                outline
                :rules="[rules.required]"
                @blur="editItem('page_title', itemToLoad.page_title)"
                @keyup.enter="editItem('page_title', itemToLoad.page_title)"
              ></v-text-field>
            </span>
            <!-- <span class="position-item">
              <v-btn flat icon @click="unDisableItem(1)"><v-icon small>fas fa-marker</v-icon></v-btn>
            </span> -->
          </v-list-tile-title>
        </v-list-tile-content>
      </v-list-tile>
      <v-divider class="mt-0 mb-0"></v-divider>
      <v-spacer></v-spacer>

      <v-list-tile class="height-100">
        <v-list-tile-content class="h-100">
          <v-list-tile-title class="content-flex-end h-100">
				    <ckeditor 
  				    id="editor1"
  			      v-model="itemToLoad.page_content" 
  			      :config="config"
  			      v-validate="'required'"
  			      name="page_content"	  
  			      @blur="editItem('page_content', itemToLoad.page_content)"
              class="style-ckeditor"
			      >
			     </ckeditor>
          </v-list-tile-title>
          <span v-show="errors.has('page_content')" class="help is-danger" style="color:red">{{ errors.first('page_content') }}</span>
        </v-list-tile-content>
      </v-list-tile>

    </v-list>
  	<!-- End Item Edit -->

   	<!-- Close drawer button -->
    <v-card-actions class="w-100 border border-left-0 border-right-0 border-bottom-0 pr-4 bottom-position flex-end">
      	<v-btn @click="closeDrawer">Close</v-btn>
    </v-card-actions>
    <!-- End close drawer button -->		
  </v-card>    
</template>

<script>
import Ckeditor from 'vue-ckeditor2'	
import config from '../../../config'
import { post } from '../../../api'

export default {

	name: 'CmsItem',
 	props: ['eventType', 'item'],
 	components: { Ckeditor },
	data () {
		return {
	    alertType: 'success',
	    alertMes: '',
	    key : 0,
		  rules: {
      		required: value => !!value || 'This field is required.'
  		},
	    config: {
	        toolbar: [
	          ['Undo','Redo'],
	          ['Bold','Italic','Strike'],
            [ 'Link', 'Unlink', 'Anchor' ],
            [ 'Image', 'Table', 'HorizontalRule', 'SpecialChar', 'PageBreak' ],
            ['NumberedList','BulletedList'],
            ['Cut','Copy','Paste'],
            [ 'Styles', 'Format', 'Font', 'FontSize' ],
	          [ 'Maximize','Source'],
	        ],
	        height: 270,
	        width: '100%',
	    },
	    validate:false
		}
  },
  methods:{
		closeDrawer(){
			this.$root.$emit('closeDrawerItem', false)
			this.key = 0	
		},
		unDisableItem(key){
   		this.key = key
  	},
    editItem(field_name, value){
    	this.Validate(field_name,value)
    	if(this.validate) {
    		var regex = /(&nbsp;|<([^>]+)>)/ig
	    	var strippedContent = value.replace(regex, '');
	    	if(field_name == 'page_title'){

  				var field = {
  					field_name: field_name,
  					value: value
  				}

	    	}else {

	    		var field = {
  					field_name: field_name,
  					value: value,
  					sort_value : strippedContent
				  }
	    	}
				this.fetchData(field)
	    }
		},
		fetchData(field){
  		post(config.API_URL + 'edit/page/' + this.itemToLoad.id, field)
			.then((res) => {
				if(res.data && res.data.success){
	        this.alertType = 'success'
	        this.alertMes = 'Update Successfully'					
	        this.$notify({
            title: 'Success',
            message: this.alertMes,
            type: this.alertType,
            duration: 2000,
          })
			    this.key = 0
					this.$root.$emit('editItemSucess')
				}
			})
			.catch((e) =>{
        this.alertType = 'error'
        this.alertMes = 'System Error Occurred'
        this.$notify({
          title: 'Error',
          message: this.alertMes,
          type: this.alertType,
          duration: 2000,
        })          
			})
 		},
 		Validate(field_name,value){
 			if(!value){
			this.alertStt = true
	        this.alertType = 'error'
	        this.alertMes = 'No ' + field_name + ' Yet'  
	        this.validate = false      
	        setTimeout(() => {this.alertStt = false}, 1500)
 			}else {
 				this.validate = true  
 			}
 		}
  },
	computed:{
		itemToLoad(){
			return this.item
		},
	}
};
</script>

<style lang="scss" scoped>

.item-title-style {
    margin-right:15px;
}
.contain-text-field {
    width: 50%  !important;
}
.content-flex-end {
    justify-content: center !important;
    align-items: center !important;
}
.style-ckeditor{
  width: 100%
}
</style>