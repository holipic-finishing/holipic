<template>
	<div>
	    <h2 class="mb-3">{{$t('message.emailVerify')}}</h2>
        <v-card class="shadow-none bg-color">
            <v-card-title primary-title class="justify-content-center">
                <div class="text-center">
                    <div
                        class="lead font-weight-bold"
                        v-if="!hasVerifiedEmail"
                    >
                        A verification link has been sent to your email account. Please check your email to active your account
                    </div>
                    <div
                        class="lead font-weight-bold"
                        v-else
                    >
                        Your email has been verification. Thanks!
                    </div>
                </div>
            </v-card-title>
            <v-card-actions>
                <v-btn
                    large
                    @click="resent"
                    block
                    color="primary"
                    v-if="!hasVerifiedEmail"
                >
                    {{ $t('message.resend') }}
                </v-btn>

                <v-btn
                    large
                    block
                    color="primary"
                    v-else
                    @click="$store.dispatch('pushRouteWithRole', $router)"
                >
                    Go to Dasboard
                </v-btn>
            </v-card-actions>
        </v-card>
        <notifications animation-type="velocity"/>
	</div>
</template>
<script>
import { mapGetters } from 'vuex'

export default {
	name: "VerifyEmail",
	data() {
        return {
        };
	},
	beforeCreate () {
        this.$store.dispatch("hasVerifiedEmail", {
            router: this.$router
        });
	},
	computed:{
		...mapGetters({
			hasVerifiedEmail: "IS_VERIFIED_EMAIL"
		})
	},
	methods: {
        verify(queryURL) {
            this.$store.dispatch("verifyEmail", {
                router: this.$router,
                queryURL: queryURL
            })
        },
        resent() {
            this.$store.dispatch('resendEmail', {
                router: this.$router,
            })
        },
    },
	mounted() {
        var queryURL = this.$route.query.queryURL;
        if (!$.isEmptyObject(queryURL)) {
            this.verify(queryURL);
        }
	}
};
</script>
<style lang="scss" scoped>
.bg-color{
	background-color: #fafafa;
}
</style>
