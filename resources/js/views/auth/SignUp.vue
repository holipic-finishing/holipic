<template>
	<div>
		<h2 class="mb-3">{{$t('message.signUp')}}</h2>
		<p class="fs-14">
			{{$t('message.havingAnAccount')}}
			<router-link to="/session/login">{{$t('message.login')}}</router-link>
		</p>
		<v-form ref="form" v-model="valid" :lazy-validation="lazy" class="mb-4">
			<v-text-field
                label="First name"
                v-model="first_name"
                :rules="nameRules"
                :counter="20"
                required
            ></v-text-field>

            <v-text-field
                label="Last name"
                v-model="last_name"
                :rules="nameRules"
                :counter="20"
                required
            ></v-text-field>

            <v-text-field
                label="Your company name"
                v-model="company_name"
                :rules="nameRules"
                :counter="20"
                required
            ></v-text-field>

			<v-text-field
                label="E-mail ID"
                v-model="email"
                :rules="emailRules"
                required
            ></v-text-field>

			<v-text-field
				label="Password"
				v-model="password"
				:rules="passwordRules"
				type="password"
                required
			></v-text-field>

            <v-checkbox
                v-model="checkbox"
                :label="`I read and agree to Terms & Conditions`"
                :rules="[v => !!v || 'You must agree to continue!']"
                required
            ></v-checkbox>

			<v-btn large @click="submit" block color="primary" class="mt-3 mb-3">{{$t('message.signUp')}}</v-btn>

			<p>{{$t('message.bySigningUpYouAgreeTo')}} {{brand}}</p>
			<!-- <router-link to="">{{$t('message.termsOfService')}}</router-link> -->
		</v-form>
		<div class="session-social-links d-inline-block">
			<ul class="list-inline">
				<li @click="signInWithFacebook">
					<span class="facebook-bg session-icon">
						<i class="ti-facebook"></i>
					</span>
				</li>
				<li @click="signInWithGoogle">
					<span class="google-bg session-icon">
						<i class="ti-google"></i>
					</span>
				</li>
				<li @click="signInWithTwitter">
					<span class="twitter-bg session-icon">
						<i class="ti-twitter-alt"></i>
					</span>
				</li>
				<li @click="signInWithGithub">
					<span class="github-bg session-icon">
						<i class="ti-github"></i>
					</span>
				</li>
			</ul>
		</div>
	</div>
</template>

<script>
import AppConfig from "../../constants/AppConfig";

export default {
    name: "SignUp",
	data() {
		return {
            valid: true,
            lazy: true,
			first_name: "",
            last_name: "",
            email: "",
            password: "",
            company_name: "",
            checkbox: false,
            nameRules: [
				v => !!v || "Name is required",
				v => v.length <= 20 || "Name must be less than 20 characters"
			],
			emailRules: [
				v => !!v || "E-mail is required",
				v =>
					/^\w+([.-]?\w+)*@\w+([.-]?\w+)*(\.\w{2,3})+$/.test(v) ||
					"E-mail must be valid"
			],
			passwordRules: [v => !!v || "Password is required"],
			brand: AppConfig.brand
		};
	},
	methods: {
		submit() {
			if (this.$refs.form.validate()) {
				let userDetail = {
                    first_name: this.first_name,
					last_name: this.last_name,
					email: this.email,
                    password: this.password,
                    company_name: this.company_name,
                    checkbox: this.checkbox
                };

				this.$store.dispatch("registerUser", {
					userDetail,
					router: this.$router
				});
			}
		},
		signInWithFacebook() {
			this.$store.dispatch("signinUserWithFacebook", {
				router: this.$router
			});
		},
		signInWithGoogle() {
			this.$store.dispatch("signinUserWithGoogle", {
				router: this.$router
			});
		},
		signInWithTwitter() {
			this.$store.dispatch("signinUserWithTwitter", {
				router: this.$router
			});
		},
		signInWithGithub() {
			this.$store.dispatch("signinUserWithGithub", {
				router: this.$router
			});
		}
	}
};
</script>
<style lang="scss">
label {
    margin-bottom: 0;
}
</style>

<style lang="scss" scoped>
.list-inline {
    li{
        &:hover{
            cursor: pointer;
        }
    }
}
</style>

