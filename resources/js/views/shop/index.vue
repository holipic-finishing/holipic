<template>
  <v-content :class="$route.path === '/shop/dashboard' ? 'vh-100 overflow-hidden' : ''">
    <shop-header></shop-header>
    <v-container fluid white fill-height>
      <router-view></router-view>
    </v-container>
  </v-content>
</template>

<script>
import ShopHeader from "./partials/Header";

export default {
  name: "Shop",
  components: {
    ShopHeader
  }
};
</script>

<style lang="scss" scoped>
</style>
