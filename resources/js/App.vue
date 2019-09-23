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
  </v-app>
</template>

<script>
import { mapGetters } from "vuex";

export default {
  mounted() {
    // if (
    //   this.selectedLocale.locale === "he" ||
    //   this.selectedLocale.locale === "ar"
    // ) {
    //   this.$store.dispatch("rtlLayout");
    // }
    //
    this.$root.$on("offline", () => {
      this.$message({
        showClose: true,
        message: "Network unstable! The website will work with offline mode.",
        type: "warning",
        duration: 5000
      });
    });

    this.$root.$on("online", () => {
      this.$message({
        showClose: true,
        message: "Network connected! The website will work with online mode.",
        type: "success",
        duration: 5000
      });
    });
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
  components: {}
};
</script>
<style lang="scss" scoped>
</style>
