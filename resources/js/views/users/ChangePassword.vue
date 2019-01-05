<template>
    <v-container fluid pt-0 class="h-100">
        <div class="panel-changepass h-100 elevation-5">
            <v-layout row wrap fill-height>
                <app-card
                    colClasses="xl12 lg12 md12 sm12 xs12"
                    customClasses="mb-0 sales-widget app-changepass"
                    :fullScreen="true"
                    :reloadable="true"
                    :closeable="false"
                >
                    <div class="row-changepass elevation-5">
                        <v-toolbar flat color="white">
                            <v-toolbar-title>
                                <span>Change Password</span>
                            </v-toolbar-title>
                        </v-toolbar>
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
                     </div>
                </app-card>
            </v-layout>
        </div>       
    </v-container>

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

    .panel-changepass{
        margin: 30px 15px;
    } 

    .h-90{
        height: 90% !important;
    }   
</style>
