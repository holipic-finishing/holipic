<template>
  <v-app
  	:dark="darkMode"
  	id="inspire"
  	:class="[{ 
  		'box-layout': boxLayout, 
  		'collapse-sidebar': collapseSidebar, 
  		'rtl-layout': rtlLayout
  	}]"
  > 
    <router-view></router-view>
    <notifications 
      group="loggedIn" 
      position="bottom right"
      animation-type="velocity"
      class="z-index"
    />
  </v-app>
</template>

<script>
import { mapGetters } from "vuex";

// import AuthService from "./auth/AuthService";
// const auth = new AuthService();
// const { login, logout, authenticated, authNotifier } = auth;

export default {
  data() {
    // authNotifier.on("authChange", authState => {
    //   this.authenticated = authState.authenticated;
    // });
    return {
     //  auth,
     //  authenticated,
     //  animation: {
     //    enter: {
     //      opacity: [1, 0],
     //      translateX: [0, -300],
     //      scale: [1, 0.2]
     //    },
     //    leave: {
     //      opacity: 0,
     //      height: 0
     //    }
     // }
    };
  },
  mounted() {
    // if (
    //   this.selectedLocale.locale === "he" ||
    //   this.selectedLocale.locale === "ar"
    // ) {
    //   this.$store.dispatch("rtlLayout");
    // }
    // 
    this.$root.$on('offline', () => {
      this.$message({
        showClose: true,
        message: 'Network unstable! The website will work with offline mode.',
        type: 'warning',
        duration: 5000
      })
    })

    this.$root.$on('online', () => {
      this.$message({
        showClose: true,
        message: 'Network connected! The website will work with online mode.',
        type: 'success',
        duration: 5000
      })
    })
    // var OneSignal = window.OneSignal || [];
    //   OneSignal.push(["init", {
    //       appId: "d4cb0199-4846-481d-9388-39ba00fe2773",
    //       subdomainName: 'wbtotalter',
    //       autoRegister: false,
    //       safari_web_id: 'web.onesignal.auto.50d89199-747f-4818-96ca-50d4208129fc',
    //       httpPermissionRequest: {
    //        enable: true
    //       },
    //       notifyButton: {
    //           enable: true
    //       },
    //       welcomeNotification: {
    //           disable: true
    //       },
    //       promptOptions: {
    //           siteName: "Laravel Webpush Notification",
    //           actionMessage: "Can you use it when you can believe it or not?",
    //           acceptButtonText: "YES",
    //           cancelButtonText: "NO, THANK",
    //       }
    //   }]);
    //   OneSignal.push(function() {
    //       OneSignal.showHttpPrompt();
    //       // OneSignal.registerForPushNotifications();
    //       OneSignal.on('subscriptionChange', function (isSubscribed) {
    //         console.log("The user's subscription state is now:", isSubscribed);
    //       OneSignal.sendTag("user_id","4444", function(tagsSent)
    //       {
    //           // Callback called when tags have finished sending
    //           console.log("Tags have finished sending!");
    //       });
    //   });
    //   });
  },
  computed: {
    ...mapGetters([
      "darkMode",
      "collapseSidebar",
      "boxLayout",
      "rtlLayout",
      "selectedLocale"
    ])
  },
  components: {

  }
};
</script>
<style lang="scss" scoped>
  .z-index{
    z-index: 9999 !important;
  }
</style>
