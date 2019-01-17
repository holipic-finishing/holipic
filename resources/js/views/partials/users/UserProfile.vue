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
                                <span>User Profile</span>
                            </v-toolbar-title>
                        </v-toolbar>
                        <v-divider></v-divider>
                        <v-container fluid grid-list-xl pt-0>
                              <v-form ref="form" @submit.prevent="saveFormEdit">
                                <span class="">Username:</span>
                                  <v-text-field 
                                    v-model="data.username" 
                                    :rules="[rules.required]"
                                  ></v-text-field>
                                <span class="">Email Address:</span>  
                                  <v-text-field 
                                    v-model="data.email" 
                                   :rules="[rules.required, rules.email]"
                                  ></v-text-field>
                                  <v-btn large type="submit" block color="primary">Edit</v-btn>
                              </v-form>
                        </v-container> 
                     </div>
                </app-card>
            </v-layout>
        </div>       
    </v-container>

</template>

<script>

import config from '../../../config/index.js'
import { get, post } from '../../../api/index.js'
import Vue from 'vue'
import { mapGetters } from "vuex";

export default {
  data() {
    return {
      valid: false,
      data: {},
      rules: {
        required: value => !!value || 'Required.',
        email: value => /^\w+([.-]?\w+)*@\w+([.-]?\w+)*(\.\w{2,3})+$/.test(value) || "E-mail must be valid."
      },
    };
  },
  mounted() {
    
  },
  methods: {
    fetchData() {
      const authUser = JSON.parse(localStorage.getItem('user')); 
      get(config.API_URL + 'get-user-profile/' + authUser.id)
      .then((res) => {
        if(res.data && res.data.success){
            this.data = res.data.data
          }
        })
      .catch((e) =>{
        console.log(e)
      })
    },
    saveFormEdit() {
      if (this.$refs.form.validate()) {
          const params = {
            id : this.data.id,
            username : this.data.username,
            email : this.data.email,
          }

          this.$store.dispatch("editUserProfileInDatabase", {
            params
          });  
      }
    } 
  },
  created() {
    this.fetchData();
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
