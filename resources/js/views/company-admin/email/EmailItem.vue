<template>
	<v-dialog
		fixed
		v-model="drawer"
		:right="!rtlLayout"
		fullscreen hide-overlay transition="slide-x-reverse-transition"
	>
		<v-card class="h-100 position-relative">
			<v-toolbar>
		    	<v-toolbar-title class="text-capitalize">{{ eventType }} E-mail Templates</v-toolbar-title>
		    	<v-spacer></v-spacer>
		    	<v-toolbar-side-icon @click="closeDrawer">
		      		<v-icon>
		          		fas fa-times
		        	</v-icon>
		      	</v-toolbar-side-icon>
	    	</v-toolbar>
	    	<v-divider class="mt-0 mb-0"></v-divider>

	    	<v-form
	    		ref="form"
	    		class="heigth-list-title"
	    		v-show="check"
	    		@submit.prevent="saveEmail"
	    	>
		    	<v-list>
					<v-list-tile class="height-75">
				        <v-list-tile-content class="h-100">
				          	<v-list-tile-title class="content-flex-end h-100">
					            <span class="item-title-style position-item">Title</span>
					            <span class="contain-text-field">
					              	<v-text-field
						                class="height-input"
						                placeholder="Enter Title"
						                v-model="itemToSave.email_title"
						                name="email_title"
					             	 	v-validate="'required'"
						                :error-messages="errors.collect('email_title')"
						                data-vv-name="email_title"
					              	></v-text-field>
					            </span>
				          	</v-list-tile-title>
				        </v-list-tile-content>
				     </v-list-tile>
				     <v-divider class="mt-0 mb-0"></v-divider>
				     <v-spacer></v-spacer>

		    		<v-list-tile class="height-100">
		        		<v-list-tile-content class="h-100">
			          		<v-list-tile-title class="content-flex-end h-100 mt-2 mb-2">
			            		<span class="font-weight-bold item-title-style position-item">
									Email Content
				            	</span>
			          		</v-list-tile-title>
				          	<v-list-tile-title class="content-flex-end h-100">
								<ckeditor
									id="editor1"
								    v-model="itemToSave.email_content"
								    :config="config"
								    v-validate="'required'"
								    name="email_content"
					           		class="style-ckeditor"
								></ckeditor>
				          	</v-list-tile-title>
		          			<span v-show="errors.has('email_content')" class="help is-danger" style="color:red">{{ errors.first('email_content') }} </span>
		        		</v-list-tile-content>
		      		</v-list-tile>
	    		</v-list>
	    		<v-card-actions class="w-100 border border-left-0 border-right-0 border-bottom-0 pr-4 bottom-position flex-end">
		 			<v-btn type="submit" color="indigo">Save</v-btn>
	    		</v-card-actions>
		    </v-form>

	    	<!-- edit -->
	    	<div v-if="!check">
	    		<v-list class="heigth-list-title">
					<v-list-tile class="height-75">
		        		<v-list-tile-content class="h-100">
		          			<v-list-tile-title class="content-flex-end h-100">
		            			<span class="item-title-style position-item">Title</span>
					            <span class="contain-text-field">
					              	<v-text-field
						                class="height-input"
						                placeholder="Enter Title"
						                v-model="item.email_title"
					                	@blur="editItem('email_title', item.email_title)"
					                	@keyup.enter="editItem('email_title', item.email_title)"
					              	></v-text-field>
					            </span>
		          			</v-list-tile-title>
		        		</v-list-tile-content>
		      		</v-list-tile>
		      		<v-divider class="mt-0 mb-0"></v-divider>
		      		<v-spacer></v-spacer>

		   			<v-list-tile class="height-100">
		        		<v-list-tile-content class="h-100">
							<v-list-tile-title class="content-flex-end h-100 mt-2 mb-2">
								<ckeditor
							      	v-model="item.email_content"
							      	:config="config"
							      	name="email_content1"
				           		  	class="style-ckeditor"
						     	  	@blur="editItem('email_content', item.email_content)"
						      	></ckeditor>
		          			</v-list-tile-title>
		          			<span v-show="errors.has('email_content1')" class="help is-danger" style="color:red">{{ errors.first('email_content1') }} </span>
		        		</v-list-tile-content>
		      		</v-list-tile>
	    		</v-list>
	    	</div>
		</v-card>
	</v-dialog>
</template>

<script>
import Ckeditor from 'vue-ckeditor2'
import config from '../../../config'
import { post } from '../../../api'
import { mapGetters } from "vuex"

export default {
	name: 'EmailItem',

	components:{
		Ckeditor,
	},
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
	    validate:false,
	    itemToSave:{
	    	email_title :'',
	    	email_content : ''
	    },
	   	drawer: false,
	    check: false,
	    item:{}
		}
	},
	methods:{
		closeDrawer(){
			this.drawer = false
			this.resetData()
			this.key = 0
			this.itemToSave.email_content = ""
		},
		resetData(){
			this.$refs.form.reset()
      		console.clear()
		},
		saveEmail(){
			this.$validator.validateAll().then((result) => {
				if(result){

					let url = config.API_URL + 'emails'
					var regex = /(&nbsp;|<([^>]+)>)/ig
    				var strippedContent = this.itemToSave.email_content.replace(regex, '');
					let param = {
						email_title : this.itemToSave.email_title,
						email_content : this.itemToSave.email_content,
						format_email_content: strippedContent.slice(0, 190) + '....'
					}

					post(url,param)
					.then(res => {
						if(res.data && res.data.success){
			        this.alertType = 'success'
			        this.alertMes = 'Create Template Successfully.'
			        this.$notify({
			          title: 'Success',
			          message: this.alertMes,
			          type: this.alertType,
			          duration: 2000,
			        })
			        this.key = 0
							this.$root.$emit('reload-data')
						}
					})
					.catch(err => {
						this.$notify({
		          title: 'Error',
		          message: 'System Error Occurred.',
		          type: 'error',
		          duration: 2000,
		        })
					})
				}
			});
		},
		editItem(field_name, value){
			this.Validate(field_name,value)
    	if(this.validate) {
    		var regex = /(&nbsp;|<([^>]+)>)/ig
	    	var strippedContent = value.replace(regex, '');
	    	if(field_name == 'email_title'){

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
				this.updateData(field)
	    }
		},

		updateData(field){
  		post(config.API_URL + 'edit/email/' + this.item.id, field)
			.then((res) => {
				if(res.data && res.data.success){
	        this.alertType = 'success'
	        this.alertMes = 'Update Item Successfully'
	        this.$notify({
	          title: 'Success',
	          message: this.alertMes,
	          type: this.alertType,
	          duration: 2000,
	        })
	        this.key = 0
					this.$root.$emit('reload-data')
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
		unDisableItem(key){
   		this.key = key
  	},

  	Validate(field_name,value){
 			if(!value){
        this.alertType = 'error'
        this.alertMes = 'No ' + field_name + ' Yet'
        this.validate = false
        this.$notify({
          title: 'Error',
          message: this.alertMes,
          type: this.alertType,
          duration: 2000,
        })
 			}else {
 				this.validate = true
 			}
 		}
	},
	mounted(){
		this.$root.$on('change-status', res => {
    	this.drawer = res.showDrawer
  		this.check = res.check
  		if(this.check){
  			this.$validator.reset()
  			}
  		})

	  	this.$root.$on('data-email', res => {
	  		this.item = {
	  			email_title : res.email_title,
	  			email_content : res.email_content,
	  			id : res.id
	  		}
	  	})
	},
	computed:{
		eventType(){
			return this.check ? 'Create' : 'Edit'
		},
		...mapGetters(["rtlLayout",])
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
