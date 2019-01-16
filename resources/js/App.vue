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
