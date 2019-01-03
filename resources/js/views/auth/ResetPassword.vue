<template>
<div>
	<h2 class="mb-3">{{$t('message.resetPassword')}}</h2>
	<p class="fs-14">{{$t('message.pleaseEnterYourPasswordToReset')}}.</p>
	<v-form v-model="valid" class="mb-4">
		<v-text-field 
			label="New Password" 
			v-model="newPassword" 
			type="password" 
			:rules="passwordRules" 
			required
		></v-text-field>
		<v-text-field 
			label="Confirm Password" 
			v-model="confirmPassword" 
			type="password" 
			:rules="passwordRules" 
			required
		></v-text-field>
		<v-btn large @click="submit" block color="primary">{{$t('message.resetPassword')}}</v-btn>
	</v-form>
				</div>
</template>

<script>
// import SessionSliderWidget from "../../components/Widgets/SessionSlider";
import AppConfig from "../../constants/AppConfig";

export default {
  components: {
    // SessionSliderWidget
  },
  data() {
    return {
      valid: false,
      newPassword: "",
      confirmPassword: '',
			passwordRules: [v => !!v || "Password is required"],
      appLogo: AppConfig.appLogo2
    };
  },
  methods: {
    submit() {
      console.log("Reset Password");
    }
  }
};
</script>
