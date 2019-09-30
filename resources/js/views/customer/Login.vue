<template>
	<v-container class="v-container-customer-login">
		<div class="box-shawdom-login">
			<div class="custom-box-shawdom row">
				<div class="col-md-8 left-col-login">
				<v-img src="customer/loginimage.jpg" max-width="100%" max-height="100%"/>
				</div>
				<div class="col-md-4 right-col-login">
					<v-card  tile flat >
			          	<v-card-title primary-title class="v-card-title-h1">WELCOME</v-card-title>
			          		<v-img src="shop_selling/logo-holipic-new.png" width="100px" style="display: inline-block;"/>
			          	<!-- <v-card-text v-if="checkFormLogin">Login to Start Selling Photos</v-card-text> -->
			          	<v-card-text v-if="checkFormLogin">Login to Download and Purchase Photos</v-card-text>

			          	<v-card-text v-if="checkFormPassword">Reset Password to Start Selling Photos</v-card-text>
			          	<v-card tile flat  class="v-card-shop">
			          		<div class="custom-shop-form" style="color:black !important;">
				          		<v-form
								    ref="form"
								    v-model="valid"
								    lazy-validation
								    v-if="checkFormLogin"
									>
								    <v-text-field
								      v-model="email"
								      :rules="emailRules"
								      label="Email"
								      required
								      @keyup.enter="login"

								    ></v-text-field>
								    <v-text-field
								      :type="'password'"
								      v-model="password"
								      :rules="passwordRules"
								      label="Password"
								      required
								      @keyup.enter="login"
								    ></v-text-field>
								    <v-btn
								      color="primary"
								      @click="login"
								      class="v-btn-shop"
								      round
								    >
								      Login
								    </v-btn>
								</v-form>

								<v-form ref="form" v-model="valid" lazy-validation v-if="checkFormPassword">
									<v-text-field
								      v-model="email"
								      :rules="emailRules"
								      label="Email"
								      required
								      @keyup.enter="login"
								    ></v-text-field>
								    <v-btn
								      color="primary"
								      @click="sendEmail()"
								      class="v-btn-shop"
								      round
								    >
								      Send Email
								    </v-btn>
								</v-form>
							</div>
			          	</v-card>
			          	<v-card-title class="right-col-login--action" v-if="checkFormLogin">
			          	  	<span style="color:#b5b3b3;"><i class="fas fa-check-circle" style="color:#0ebff6"></i>&nbsp;Remember me</span>
			          		<span style="color:#b5b3b3;cursor: pointer;" @click="resetPassword()" >Forgot password?</span>
			          	</v-card-title>
			        </v-card>
					<div style="margin-top:15px;">
			          		<v-card-title class="right-col-login--action">
				          		<span class="style-span">Term & Conditions</span>
				          		<span class="style-span">Privacy Policy</span>
				          		<span class="style-span">Return Policy</span>
			          		</v-card-title>
				          	<v-card-title class="right-col-login--action right-col-login--note">
				          		<span class="style-span--note">All Rights Reserved @ Holipic 2019</span>
				          	</v-card-title>
			        </div>
				</div>
			</div>
		</div>
	</v-container>
</template>

<script>
import { get, post, put, del, getWithData } from '../../api/index.js'
import config from '../../config/index.js'

export default {

  	name: 'Login',

	data () {
	    return {
	    	valid: true,
	    	email: '',
	    	password: '',
		    passwordRules: [
		    	v => !!v || 'Password is required',
		        v => (v && v.length <= 10) || 'Password must be less than 10 characters'
		    ],
		    emailRules: [
		        v => !!v || 'E-mail is required',
		        v => /.+@.+/.test(v) || 'E-mail must be valid'
	      	],
	      	checkFormLogin: true,
	      	checkFormPassword : false
	    }
	},
	mounted() {
		if(this.$route.params.notificationPassword){
			this.$notify({
              title: 'Notification',
              message: 'Change Password Success',
              type: 'success',
              duration: 2000
            })
		}
	},
	created() {
		
	},
	methods: {
	  	validate () {
	        if (this.$refs.form.validate()) {
	          this.snackbar = true
	        }
	    },
	    login() {
	    	if(this.$refs.form.validate()) {
		  		const user = {
			        email: this.email,
			        password: this.password
	      		};

	      		this.$store.dispatch("signinUserInDatabase", {user});
  			}
	    },
	    resetPassword()
	    {
	    	this.checkFormLogin = false
	    	this.checkFormPassword = true
	    },
	    sendEmail()
	    {
	    	if (this.$refs.form.validate()) {
		    	get(config.BASE_URL+'/auth/forgot-password?email='+this.email)
		    	.then(res => {
		    		if(res.data.success) {
		    			this.$notify({
	                      title: 'Success',
	                      message: res.data.message,
	                      type: 'success',
	                      duration: 2000
	                    })
		    		}else {
		    			this.$notify({
	                      title: 'Error',
	                      message: res.data.message,
	                      type: 'error',
	                      duration: 2000
	                    })
		    		}
		    	})
	    	}
	    }
	}
}
</script>

<style lang="scss" scoped>
.style-span{
	color:#8e8d8d;
	font-weight: bold;
	&--note {
		color:#8e8d8d;
	font-weight:none;
	}
}

</style>