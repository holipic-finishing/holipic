<template>
	<div>
		<h2 class="mb-3">{{$t('message.forgotPassword')}}</h2>
		<p class="fs-14">{{$t('message.enterYourEmailToSendYouAResetLink')}}.</p>
		<v-form v-model="valid" class="mb-4">
				<v-text-field 
				label="E-mail ID" 
				v-model="email" 
				:rules="emailRules" 
				required
			></v-text-field>						
			<v-btn color="primary" block @click="submitPassword">Send Email</v-btn>
			<!-- <v-btn color="primary" block @click="submitPassword" to="/session/reset-password"	>Send Email</v-btn> -->
		</v-form>
		<div>
			<router-link to="/session/login">{{$t('message.backToSignIn')}}</router-link>
		</div>
	</div>
</template>


<script>
import SessionSliderWidget from "../../components/Widgets/SessionSlider";
import AppConfig from "../../constants/AppConfig";
import { post } from '../../api/index.js'
import config from '../../config/index.js'

export default {
  components: {
    SessionSliderWidget
  },
  data() {
    return {
		email: '',
      	valid: false,
			emailRules: [
	        v => !!v || "E-mail is required",
	        v =>
	          /^\w+([.-]?\w+)*@\w+([.-]?\w+)*(\.\w{2,3})+$/.test(v) ||
	          "E-mail must be valid"
	      ],
      appLogo: AppConfig.appLogo2
    }
  },
   methods: {
    	submitPassword() {
    		// let url = config.API_URL+'get-email'
    		// let params = {
    		// 	email : this.email
    		// }
    		// console.log(params)
    		// post(url,params)
    		// .then((res)=> {

    		// })
    		// .catch(err => {
    			
    		// })
    	}
    }
};
</script>
