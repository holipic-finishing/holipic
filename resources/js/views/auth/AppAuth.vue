<template>
  <div class="session-wrapper">
    <div class="session-right text-xs-center ml-0">
      <div class="session-table-cell">
        <div class="session-content text-center">
          <img
            :src="appLogo"
            class="d-inline-block img-responsive mb-3 rounded"
            width="100"
            height="100"
          />
          <router-view></router-view>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import AppConfig from "../../constants/AppConfig";
export default {
  name: "AppAuth",
  data() {
    return {
      appLogo: AppConfig.appLogo2
    };
  }
};
</script>

<style lang="scss" scoped>
</style>
