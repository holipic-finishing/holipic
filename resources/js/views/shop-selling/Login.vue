<template>
	<v-container fluid white class="container-shop-login">
    	<v-layout row class= "v-layout-shop-login">
    		<v-flex xs3>

		    </v-flex>
		    <v-flex xs6>
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
						</div>
		          	</v-card>
		        </v-card>
		    </v-flex>
		    <v-flex xs3>

		    </v-flex>
    	</v-layout>
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
      	]
    }
  },
  methods: {
  	 reset () {
        this.$refs.form.reset()
      },
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
	      		this.$store.dispatch("signinUser", {user});
  			}
	    }
  }
}
</script>

<style lang="css" scoped>
</style>
