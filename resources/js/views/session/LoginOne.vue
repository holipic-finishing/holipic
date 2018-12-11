<template>
	<div>
		<h2 class="mb-3">{{$t('message.loginToAdmin')}}</h2>
		<p class="fs-14">{{$t('message.enterUsernameAndPasswordToAccessControlPanelOfHolipic')}}.</p>
		<v-form v-model="valid" class="mb-4">
			<v-text-field 
			label="E-mail ID" 
			v-model="email" 
			:rules="emailRules" 
			required
			></v-text-field>

			<v-text-field 
			label="Password" 
			v-model="password" 
			type="password" 
			:rules="passwordRules" 
			required
			></v-text-field>

			<v-checkbox 
			color="primary" 
			label="Remember me" 
			v-model="checkbox"
			></v-checkbox>

			<router-link class="mb-1" to="/session/forgot-password">{{$t('message.forgotPassword')}}?</router-link>
			<div>
				<v-btn large @click="login" block color="primary">{{$t('message.loginNow')}}</v-btn>
			</div>
		</v-form>
	</div>

</template>

<script>
// import firebase from "firebase";
import { mapGetters } from "vuex";
// import SessionSliderWidget from "../../components/Widgets/SessionSlider";
import AppConfig from "../../constants/AppConfig";

// import AuthService from "../../auth/AuthService";

// const auth = new AuthService();
// const { login, logout, authenticated, authNotifier } = auth;
// import {SnotifyPosition} from 'vue-snotify';

export default {
	components: {
    // SessionSliderWidget
},
data() {
	return {
		checkbox: false,
		valid: false,
		email: "admin@gmail.com",
		emailRules: [
		v => !!v || "E-mail is required",
		v =>
		/^\w+([.-]?\w+)*@\w+([.-]?\w+)*(\.\w{2,3})+$/.test(v) ||
		"E-mail must be valid"
		],
		password: "test#123",
		passwordRules: [v => !!v || "Password is required"],
		appLogo: AppConfig.appLogo2,
		brand: AppConfig.brand
	};
},
methods: {
	submit() {
		const user = {
			email: this.email,
			password: this.password
		};

		this.$router.push({
			path: '/default/dashboard/ecommerce'
		});
	},
  	login () {
      // localStorage.getItem('access_token')
  		axios.post('/auth/loginSuperAdmin', {
  			email: this.email,
  			password: this.password,
  		})
  		.then(response => {
  			if(response.data.success && response.data.data){
				Vue.notify({
					group: 'loggedIn',
					type: 'success',
					text: 'Login success',
					duration: 2000,
				})  
			var access_token = response.data.data.user.access_token
			localStorage.setItem('access_token',access_token)	 
  			this.$router.push('/default/dashboard/index')
  			}else{

  				Vue.notify({
					group: 'loggedIn',
					type: 'Faill',
					text: 'E-mail or Password Incorrect',
					duration: 2000,
				})
  			}

  		})
  		.catch(error => {
  			console.log(error)
  		})
  }
}
};
</script>

<style lang="css" scoped>
.style-left {
	margin-left: 0px;
}
</style>
