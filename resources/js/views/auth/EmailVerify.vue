<template>
  <v-content class="pb-md-20 pb-sm-5">
    <v-card class="shadow-none bg-color">
      <v-card-title
        class="font-weight-bold display-1 justify-content-center"
      >{{$t('message.emailVerify')}}</v-card-title>
      <v-card-text class="text-muted text-center h2 lead">
        <span
          v-if="!hasVerifiedEmail"
        >A verification link has been sent to your email account. Please check your email to active your account</span>
        <span v-else>Your email has been verification. Thanks!</span>
      </v-card-text>
      <v-card-actions class="pl-md-5 pr-md-5">
        <v-btn
          dark
          large
          block
          color="#2EA3F2"
          v-if="!hasVerifiedEmail"
          class="font-weight-bold rounded"
          @click="resent"
        >{{ $t('message.resend') }}</v-btn>

        <v-btn
          dark
          large
          block
          color="#2EA3F2"
          class="font-weight-bold rounded"
          v-else
          @click="$store.dispatch('pushRouteWithRole', $router)"
        >Go to Dasboard</v-btn>
      </v-card-actions>
    </v-card>
    <notifications animation-type="velocity" />
  </v-content>
</template>
<script>
import { mapGetters } from "vuex";

export default {
  name: "VerifyEmail",
  data() {
    return {};
  },
  beforeCreate() {
    this.$store.dispatch("hasVerifiedEmail", {
      router: this.$router
    });
  },
  computed: {
    ...mapGetters({
      hasVerifiedEmail: "IS_VERIFIED_EMAIL"
    })
  },
  methods: {
    verify(queryURL) {
      this.$store.dispatch("verifyEmail", {
        router: this.$router,
        queryURL: queryURL
      });
    },
    resent() {
      this.$store.dispatch("resendEmail", {
        router: this.$router
      });
    }
  },
  mounted() {
    var queryURL = this.$route.query.queryURL;
    if (!$.isEmptyObject(queryURL)) {
      this.verify(queryURL);
    }

    var _this = this;
    window.addEventListener("focus", function() {
      _this.$store.dispatch("hasVerifiedEmail", {
        router: this.$router
      });
    });
  }
};
</script>
<style lang="scss" scoped>
@media (min-width: 768px) {
    .pb-md-20 {
        padding-bottom: 20rem !important;
    }
}
</style>
