<template>
	<div class="container fix-container">
		 <!-- <page-title-bar></page-title-bar> -->
         <div class="content-row">
                <app-card
                  :heading="$t('message.changePassword')"
                  :fullScreen="true"  
                  colClasses="xl12 lg12 md12 sm12 xs12"
                    >
                    <v-divider></v-divider>
                    <v-container fluid grid-list-xl pt-0>
                        <v-form ref="form" @submit.prevent="savePassword">
                            <v-text-field 
                              label="Current password" 
                              v-model="oldPassword" 
                              type="password" 
                              :rules="[rules.required]"
                            ></v-text-field>
                            <v-text-field 
                              label="New password" 
                              v-model="newPassword" 
                              type="password" 
                             :rules="[rules.required]"
                            ></v-text-field>
                            <v-text-field 
                              label="Confirm password" 
                              v-model="confirmPassword" 
                              type="password" 
                              :rules="[rules.required]"
                            ></v-text-field>
                            <v-btn large type="submit" block color="primary">Submit Change</v-btn>
                        </v-form>
                    </v-container> 
                </app-card> 
         </div>
       
	</div>
</template>

<script>
// import api from "../../api/index.js";
import config from '../../config/index.js'
import { post } from '../../api/index.js'
import Vue from 'vue'
import { mapGetters } from "vuex";

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
          const authUser = JSON.parse(localStorage.getItem('user'))
          const params = {
            access_token : localStorage.getItem('access_token'),
            newPassword : this.newPassword,
            oldPassword : this.oldPassword,
            confirmPassword : this.confirmPassword,
            roleId : authUser.role_id
          }

          this.$store.dispatch("changePasswordUserInDatabase", {
            params
          });  
      }
    } 
  }
};
</script>
<style lang="scss" scoped>
    .fix-container {
        width: 100%;
        height: 100%;
        text-align: center;

    }
    .content-row {
        display:flex;
        position: relative;
        top: 25%;
        padding: 0px 150px;
    }
   @media (max-width: 760px) {
        .content-row {
            padding:0px 30px;
        }
    }


    
</style>
