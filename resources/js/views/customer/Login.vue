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
			          	<v-card-text>Login to Start Selling Photos</v-card-text>
			          	<v-card tile flat  class="v-card-shop">
			          		<div class="custom-shop-form" style="color:black !important;">
				          		<v-form
								    ref="form"
								    v-model="valid"
								    lazy-validation
									>
								    <v-text-field
								      v-model="email"
								      :rules="emailRules"
								      label="Email"
								      required
								    ></v-text-field>
								    <v-text-field
								      v-model="password"
								      :rules="passwordRules"
								      label="Password"
								      required
								    ></v-text-field>
								    <v-btn
								      color="primary"
								      @click="validate"
								      class="v-btn-shop"
								      round
								    >
								      Login
								    </v-btn>
								</v-form>
							</div>
			          	</v-card>
			          	<v-card-title class="right-col-login--action">
			          	  	<span style="color:#b5b3b3;"><i class="fas fa-check-circle" style="color:#0ebff6"></i>&nbsp;Remember me</span>
			          		<span style="color:#b5b3b3;">Forgot password?</span>
			          	</v-card-title>
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
    }
  },
  methods: {
  	validate () {
        if (this.$refs.form.validate()) {
          this.snackbar = true
        }
     },
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