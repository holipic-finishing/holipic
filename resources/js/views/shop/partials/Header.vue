<template>
  <v-toolbar app flat>
    <v-container mx-auto py-0>
      <v-layout class="align-items-center" v-if="$route.path === '/shop/dashboard'">
        <v-toolbar-title>{{ branchName }}</v-toolbar-title>
        <v-spacer></v-spacer>
        <v-toolbar-items>
          <v-overflow-btn :items="currencies" label="currency" class="custom-overflow-btn"></v-overflow-btn>
          <v-overflow-btn :items="languages" label="language" class="custom-overflow-btn"></v-overflow-btn>
          <v-btn fab flat medium @click="logout" class="ml-md-4 ml-sm-2">
            <v-img src="images/LOGOUT.png" width="50px" height="45px" />
          </v-btn>
        </v-toolbar-items>
      </v-layout>

      <v-layout class="align-items-center" v-else>
        <v-btn large icon @click="$router.push('/shop/dashboard')">
          <i class="material-icons color-text-header">reply_all</i>
        </v-btn>
        <v-spacer></v-spacer>
        <v-toolbar-items>
          <v-btn flat @click="dialog = true" class="custom-header-btn">
            <i class="material-icons font-material-header">card_giftcard</i>
            <span>{{$t('message.albumPackage')}}</span>
          </v-btn>

          <v-btn flat class="custom-header-btn">
            <i class="material-icons font-material-header">add_a_photo</i>
            <span>{{$t('message.addNewPhoto')}}</span>
          </v-btn>
        </v-toolbar-items>
      </v-layout>
    </v-container>
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
import { mapGetters } from "vuex";

export default {
  name: "Header",

  data() {
    return {
      dialog: false,
      currencies: ["USD", "EURO"],
      languages: ["ENG", "INDO"],
      branchName: JSON.parse(localStorage.getItem("user")).branch_name
    };
  },
  created() {
    this.$i18n.locale = "en";
    this.$store.dispatch("getPackages");
  },
  computed: {
    ...mapGetters({
      packages: "packages"
    })
  },
  methods: {
    choosePackage(value) {
      alert("choose package");
      this.$root.$emit("typePackage", { name: value });
    },
    colorPackage(key) {
      let color = "";
      switch (key) {
        case 0:
          color = "primary";
          break;
        case 1:
          color = "success";
          break;
        case 2:
          color = "warning";
          break;
        default:
          color = "error";
      }
      return color;
    },
    logout() {
      localStorage.removeItem("shopSelling");
      localStorage.removeItem("roomLogin");
      localStorage.removeItem("photoSelected");
      localStorage.removeItem("thumbnailDir");

      this.$store.dispatch("logoutUser", {
        redirectAfterLogout: "/shop/login"
      });
    }
  }
};
</script>

<style lang="scss">
.custom-overflow-btn {
  min-width: 110px;
  .v-icon {
    font-size: 40px !important;
    color: #0ebff6 !important;
  }
  .v-messages {
    min-height: 0 !important;
  }
  .v-input__slot {
    box-shadow: none !important;
  }
  .v-input__slot:after {
    color: #0ebff6 !important;
  }
  .v-input__append-inner {
    width: 20px !important;
  }
}
.custom-header-btn {
  .v-btn__content {
    display: flex;
    flex-direction: column;
    align-items: center;
    span {
      color: #70778f;
      font-size: 14px;
    }
  }
}
</style>
