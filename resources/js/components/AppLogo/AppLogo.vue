<template>
    <div class="site-logo">
        <router-link to="/">
            <img :src="darkLogo" alt="site logo" width="100%" v-if="sidebarSelectedFilter.class == 'sidebar-overlay-light'">
            <img :src="appLogo" alt="site logo" width="100%" v-else>
        </router-link>
    </div>
</template>

<script>
import AppConfig from "../../constants/AppConfig";
import { mapGetters } from "vuex";

export default {
   computed: {
      ...mapGetters(["sidebarSelectedFilter"])
   },
   data() {
      return {
          appLogo: AppConfig.appLogo2,
          darkLogo: AppConfig.appLogo2
      }
   }
}
</script>
<style scoped>
  .collapse-sidebar .Vuely-sidebar.v-navigation-drawer:hover .site-logo .router-link-active{
    max-width: 35px!important;
  }
  .sidebar .site-logo {
    padding: 0 1.75rem!important;
  }
</style>
