<template>
    <v-container class="v-container-customer-login">
        <div class="box-shawdom-login">
            <div class="custom-box-shawdom">
                <div class="col-md-8 left-col-login">
                <v-img src="customer/loginimage.jpg" max-width="100%" max-height="100%"/>
                </div>
                <div class="col-md-4 right-col-login">
                    <v-card  tile flat >
                        <v-card-title primary-title class="v-card-title-h1">WELCOME</v-card-title>
                            <v-img src="shop_selling/logo-holipic-new.png" width="150px" style="display: inline-block;"/>
                        <v-card-text >Change Password to Start Selling Photos</v-card-text>
                        
                        <v-card tile flat  class="v-card-shop">
                            <div class="custom-shop-form" style="color:black !important;" v-if="token !== null && exp == null">
                                <v-form
                                    ref="form"
                                    v-model="valid"
                                    lazy-validation
                                    >
                                    <v-text-field
                                      v-model="email"
                                      label="Email"
                                      disabled
                                    ></v-text-field>

                                    <v-text-field
                                      :type="'password'"
                                      v-model="password"
                                      :rules="passwordRules"
                                      label="New Password"
                                      required
                                      @keyup.enter="login"
                                    ></v-text-field>

                                    <v-text-field
                                      :type="'password'"
                                      v-model="passwordConfirm"
                                      :rules="passwordRules"
                                      label="New Password Confirm"
                                      required
                                      @keyup.enter="changePassword"
                                    ></v-text-field>
                                   
                                    <v-btn
                                      color="primary"
                                      @click="changePassword"
                                      class="v-btn-shop"
                                      round
                                    >
                                      Change Password
                                    </v-btn>
                                </v-form>

                            </div>
                            <h1 v-if="token == null && exp == null" style="color:#00C1F8;">The system cannot find a token to process </h1>
                            <h1 v-if="exp !== null " style="color:#00C1F8;">You have expired to change the password</h1>
                        </v-card>
                       
                        <div style="margin-top:100px;">
                            <v-card-title class="right-col-login--action">
                                <span class="style-span">Term & Conditions</span>
                                <span class="style-span">Privacy Policy</span>
                                <span class="style-span">Return Policy</span>
                            </v-card-title>
                            <v-card-title class="right-col-login--action right-col-login--note">
                                <span class="style-span--note">All Rights Reserved @ Holipic 2019</span>
                            </v-card-title>
                        </div>
                        
                    </v-card>
                </div>
            </div>
        </div>
    </v-container>
</template>

<script>
import { get, post, put, del, getWithData } from '../../api/index.js'
import config from '../../config/index.js'

export default {

  name: 'ResetPassword',

  data () {
    return {
        valid: true,
    	password: '',
        passwordConfirm: '',
        passwordRules: [
            v => !!v || 'Password is required',
            v => (v && v.length <= 10) || 'Password must be less than 10 characters'
        ],
        token: null,
        email:null,
        exp:null  
    }
  },
  mounted() {
    if(this.$route.query.token || this.$route.query.email) {
        this.token = this.$route.query.token
        this.email = this.$route.query.email
        // var exp = this.parseJwt(this.$route.query.token).exp
        // var time = new Date().getTime().toString()
        // var lengthTime = time.length
        // time = parseInt(time.substring(0, lengthTime-3));
        // if(exp > time) {
        //     this.token = this.$route.query.token
        // }else {
        //     this.exp = 'expried'
        // }

    }

    if(this.$route.query.exp) {
        this.exp = this.$route.query.exp
    }    
  },
  created() {
       
  },
  methods: {
    changePassword()
    {
        if(this.password !== this.passwordConfirm)
        {
            alert('not')
        }else {
            let params = {token : this.token, email: this.email, password: this.password}

            post(config.BASE_URL+'/auth/customer/update-password', params)
            .then(res => {
                if(res.data.success) {
                    this.$router.push({ name: 'CustomerLogin', params: { notificationPassword:true }})
                }else {
                    this.$notify({
                      title: 'Notification',
                      message: res.data.message,
                      type: 'error',
                      duration: 2000
                    })
                }
            })
        }
    },
    parseJwt(token)
    {
        var base64Url = token.split('.')[1];
        var base64 = decodeURIComponent(atob(base64Url).split('').map(function(c) {
            return '%' + ('00' + c.charCodeAt(0).toString(16)).slice(-2);
        }).join(''));

        return JSON.parse(base64);
    }
  }
}
</script>

<style lang="css" scoped>
</style>