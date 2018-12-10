<template>
	<div>
		 <page-title-bar></page-title-bar>
     <v-container fluid grid-list-xl pt-0>
      <v-form ref="form" @submit.prevent="savePassword">
        <v-text-field 
          label="Old Password" 
          v-model="oldPassword" 
          type="password" 
          :rules="[rules.required]"
        ></v-text-field>
        <v-text-field 
          label="New Password" 
          v-model="newPassword" 
          type="password" 
         :rules="[rules.required]"
        ></v-text-field>
        <v-text-field 
          label="Confirm Password" 
          v-model="confirmPassword" 
          type="password" 
          :rules="[rules.required]"
        ></v-text-field>
        <v-btn large type="submit" block color="primary">{{$t('message.resetPassword')}}</v-btn>
      </v-form>
      </v-container>  
	</div>
</template>

<script>
// import api from "../../api/index.js";
import config from '../../config/index.js'
import { post } from '../../api/index.js'
import Vue from 'vue'
export default {
  data() {
    return {
      valid: false,
      newPassword: "",
      confirmPassword: '',
      oldPassword:'',
      rules: {
            required: value => !!value || 'Required.',
      },
      // appLogo: AppConfig.appLogo2
    };
  },
  mounted() {
  
  },
  methods: {
    savePassword() {
      if (this.$refs.form.validate()) {
          let url = config.API_URL+'change-password'
          let params = {
            access_token : localStorage.getItem('access_token'),
            newPassword : this.newPassword,
            oldPassword : this.oldPassword,
            confirmPassword : this.confirmPassword,
          }
          post(url,params)
          .then((res) => {
            if(res.data && res.data.success){
                setTimeout(function(){
                    Vue.notify({
                        group: 'loggedIn',
                        type: 'success',
                        text: 'Update Password Success!'
                    });
               },500);
             }
             this.$router.push('/default/dashboard/index')
          })
          .catch(err =>{
            console.log(err)
             if(err.response.status == 404){
                setTimeout(function(){
                    Vue.notify({
                        group: 'loggedIn',
                        type: 'error',
                        text: 'Old Password Incorrect'
                    });
               },500);
             }
          })
      }
    } 
  }
};
</script>
