<template>
  <v-content>
    <v-container fluid fill-height white>
      <v-layout align-center justify-center>
        <v-flex xs12 sm8 md4>
          <div class="session-content text-center">
            <p class="display-2"><b>Welcome</b></p>
            <v-img
              :src="appLogo"
              class="d-inline-block img-responsive mb-3 rounded"
              width="150"
              height="150"
            />
            <router-view></router-view>
          </div>
        </v-flex>
      </v-layout>
    </v-container>
  </v-content>
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
