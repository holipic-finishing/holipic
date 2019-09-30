<template>
  <v-toolbar dark color="primary" class="custom-toolbar">
    <v-btn icon @click="back">
      <i class="material-icons color-text-header">reply_all</i>
    </v-btn>
    <v-spacer></v-spacer>

    <v-toolbar-items class="hidden-sm-and-down">
      <v-btn flat @click="showPackage()">
        <i class="material-icons font-material-header">card_giftcard</i>
        <span class="color-text-header">{{$t('message.albumPackage')}}</span>
      </v-btn>
      <v-btn flat>
        <i class="material-icons font-material-header">add_a_photo</i>
        <span class="color-text-header">{{$t('message.addNewPhoto')}}</span>
      </v-btn>
    </v-toolbar-items>

    <v-dialog v-model="dialog" content-class="v-dialog-package" temporary>
      <v-container fluid grid-list-xl pt-0 class="container-package-ramdom">
        <div class="pricing-wrapper">
          <v-layout row wrap>
            <template v-for="(value, key) in packages">
              <v-flex xs12 sm12 md3 lg3 xl12 class="container-package-ramdom--flex" :key="key">
                <div class="app-card text-xs-center">
                  <div
                    class="app-card-title d-custom-flex justify-space-between"
                    :class="colorPackage(key)"
                  >
                    <h3 class="mb-0 white--text">{{value.package_name}}</h3>
                  </div>

                  <div class="app-full-content">
                    <h2 class="font-3x">
                      <span class="font-xl">{{value.price}}RP.</span>
                      <sub>{{value.offer}}</sub>
                    </h2>
                    <ul class="list-unstyled list-group-flush">
                      <li class="list-group-item">{{value.total_photo}} photos Print</li>
                      <li class="list-group-item">{{value.album}}</li>
                      <li class="list-group-item">{{value.photo_on_disc}} photos on the disc</li>
                      <li
                        class="list-group-item"
                      >{{key == 0 ? '.........' : ( key == 1 ? 1 + ' Poster (20x30)' : 2 + ' Poster (20x30)') }}</li>
                    </ul>
                  </div>
                  <div class="app-footer">
                    <v-btn
                      block
                      :color="colorPackage(key)"
                      large
                      @click="choosePackage(value.package_name)"
                    >{{$t('message.buyNow')}}</v-btn>
                  </div>
                </div>
              </v-flex>
            </template>
          </v-layout>
        </div>
      </v-container>
    </v-dialog>
  </v-toolbar>
</template>

<script>
import { get, post, put, del, getWithData } from "../../../api";

export default {
  name: "Header",

  data() {
    return {
      dialog: false,
      packages: []
    };
  },
  mounted() {
    this.$i18n.locale = "en";

    this.showAllPackages();
  },
  methods: {
    showPackage() {
      this.dialog = true;
    },
    showAllPackages() {
      axios.defaults.headers.common["Authorization"] = localStorage.getItem(
        "access_token"
      );
      get("shop-selling/packages")
        .then(res => {
          if (res && res.success) {
            this.packages = res.data;
          }
        })
        .catch(err => {
          console.log(err.response);
        });
    },
    choosePackage(value) {
      this.$root.$emit("typePackage", { name: value });
    },
    back() {
      this.$router.push("/shop/dashboard");
    },
    colorPackage(key) {
      if (key == 0) {
        return "primary";
      } else if (key == 1) {
        return "success";
      } else if (key == 2) {
        return "warning";
      } else {
        return "error";
      }
    }
  }
};
</script>

<style lang="scss" scoped>
.color-text-header {
  color: #70778f !important;
}
</style>
