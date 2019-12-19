<template>
  <v-container fluid pt-0 grid-list-xl mt-3>
    <v-layout row wrap>
      <v-flex xs12>
        <v-navigation-drawer
          fixed
          v-model="drawerRight"
          right
          temporary
          app
          this.width="this.getCurrentWithContentWrap()"
          :width="widthComputed"
        >
          <v-card class="h-100 position-relative">
            <v-toolbar>
              <v-toolbar-title class="text-capitalize">{{company.name}}</v-toolbar-title>
              <v-spacer></v-spacer>
              <v-toolbar-side-icon @click.stop="drawerRight = !drawerRight">
                <v-icon>fas fa-times</v-icon>
              </v-toolbar-side-icon>
            </v-toolbar>
            <v-divider class="no-mg-bottom"></v-divider>
            <v-layout row wrap>
              <!-- Show information -->
              <v-list class="heigth-list-title">
                <v-flex d-flex xs12 sm12 md12 class="flex-padding-2">
                  <v-list-tile>
                    <v-list-tile-content>
                      <v-list-tile-title class="content-flex">
                        <span class="font-weight-bold item-title">Package name:</span>
                        <span class="max-value">{{company.package_name}}</span>
                      </v-list-tile-title>
                    </v-list-tile-content>
                  </v-list-tile>
                </v-flex>
                <v-flex d-flex xs12 sm12 md12 class="flex-padding-2">
                  <v-divider class="no-mg-bottom"></v-divider>
                </v-flex>

                <v-flex d-flex xs12 sm12 md12 class="flex-padding-2">
                  <v-list-tile>
                    <v-list-tile-content>
                      <v-list-tile-title class="content-flex">
                        <span class="font-weight-bold item-title">Added date:</span>
                        <span class="max-value">{{company.created_at}}</span>
                      </v-list-tile-title>
                    </v-list-tile-content>
                  </v-list-tile>
                </v-flex>
                <v-flex d-flex xs12 sm12 md12 class="flex-padding-2">
                  <v-divider class="no-mg-bottom"></v-divider>
                </v-flex>

                <v-flex d-flex xs12 sm12 md12 class="flex-padding-2">
                  <v-list-tile>
                    <v-list-tile-content>
                      <v-list-tile-title class="content-flex">
                        <span class="font-weight-bold item-title">Address:</span>
                        <span class="max-value">{{company.address}}</span>
                      </v-list-tile-title>
                    </v-list-tile-content>
                  </v-list-tile>
                </v-flex>
                <v-flex d-flex xs12 sm12 md12 class="flex-padding-2">
                  <v-divider class="no-mg-bottom"></v-divider>
                </v-flex>

                <!-- <v-flex d-flex xs12 sm12 md12 class="flex-padding-2">
                  <v-list-tile>
                    <v-list-tile-content>
                      <v-list-tile-title class="content-flex">
                        <span class="font-weight-bold item-title">Total customer:</span>
                        <span class="max-value">...</span>
                      </v-list-tile-title>
                    </v-list-tile-content>
                  </v-list-tile>
                </v-flex>

                <v-flex d-flex xs12 sm12 md12 class="flex-padding-2">
                  <v-divider class="no-mg-bottom"></v-divider>
                </v-flex> -->

                <v-flex d-flex xs12 sm12 md12 class="flex-padding-2">
                  <v-list-tile>
                    <v-list-tile-content>
                      <v-list-tile-title class="content-flex">
                        <span class="font-weight-bold item-title">Storage GB:</span>
                        <span class="max-value">{{company.file_upload}}GB</span>
                      </v-list-tile-title>
                    </v-list-tile-content>
                  </v-list-tile>
                </v-flex>
                <v-flex d-flex xs12 sm12 md12 class="flex-padding-2">
                  <v-divider class="no-mg-bottom"></v-divider>
                </v-flex>

                <v-flex d-flex xs12 sm12 md12 class="flex-padding-2">
                  <v-list-tile>
                    <v-list-tile-content>
                      <v-list-tile-title class="content-flex">
                        <span class="font-weight-bold item-title">Income :</span>
                        <span class="max-value">{{company.total_income}}</span>
                      </v-list-tile-title>
                    </v-list-tile-content>
                  </v-list-tile>
                </v-flex>
                <v-flex d-flex xs12 sm12 md12 class="flex-padding-2">
                  <v-divider class="no-mg-bottom"></v-divider>
                </v-flex>

                <v-flex d-flex xs12 sm12 md12 class="flex-padding-2">
                  <v-list-tile>
                    <v-list-tile-content>
                      <v-list-tile-title class="content-flex">
                        <span class="font-weight-bold item-title">Login:</span>
                        <span class="max-value">{{company.email}}</span>
                      </v-list-tile-title>
                    </v-list-tile-content>
                  </v-list-tile>
                </v-flex>
                <v-flex d-flex xs12 sm12 md12 class="flex-padding-2">
                  <v-divider class="no-mg-bottom"></v-divider>
                </v-flex>

                <v-flex d-flex xs12 sm12 md12 class="flex-padding-2">
                  <v-list-tile>
                    <v-list-tile-content>
                      <v-list-tile-title class="content-flex">
                        <span class="font-weight-bold item-title">Password:</span>
                        <span class="max-value">{{company.show_password}}</span>
                      </v-list-tile-title>
                    </v-list-tile-content>
                  </v-list-tile>
                </v-flex>
                <v-flex d-flex xs12 sm12 md12 class="flex-padding-2">
                  <v-divider class="no-mg-bottom"></v-divider>
                </v-flex>

                <v-flex d-flex xs12 sm12 md12 class="flex-padding-2">
                  <v-list-tile>
                    <v-list-tile-content>
                      <v-list-tile-title class="content-flex">
                        <span class="font-weight-bold item-title">Signature :</span>
                        <span class="max-value">...</span>
                      </v-list-tile-title>
                    </v-list-tile-content>
                  </v-list-tile>
                </v-flex>
                <v-flex d-flex xs12 sm12 md12 class="flex-padding-2">
                  <v-divider class="no-mg-bottom"></v-divider>
                </v-flex>
              </v-list>
            </v-layout>

            <v-list v-if="lengthCode > 0">
              <v-list-tile>
                <v-list-tile-content>
                  <v-list-tile-title class="content-flex">
                    <span class="font-weight-bold item-title">COUPON CODE</span>
                  </v-list-tile-title>
                </v-list-tile-content>
              </v-list-tile>

              <v-list-tile>
                <v-list-tile-content>
                  <v-list-tile-title class="content-flex">
                    <span class="font-weight-bold item-title">Name Code:</span>
                    <span>{{couponCode.name}}</span>
                  </v-list-tile-title>
                </v-list-tile-content>
              </v-list-tile>
              <v-divider class="no-mg-bottom"></v-divider>

              <v-list-tile>
                <v-list-tile-content>
                  <v-list-tile-title class="content-flex">
                    <span class="font-weight-bold item-title">Discount:</span>
                    <span>{{couponCode.discount}}</span>
                  </v-list-tile-title>
                </v-list-tile-content>
              </v-list-tile>
              <v-divider class="no-mg-bottom"></v-divider>

              <v-list-tile>
                <v-list-tile-content>
                  <v-list-tile-title class="content-flex">
                    <span class="font-weight-bold item-title">From Date:</span>
                    <span>{{couponCode.from_date}}</span>
                  </v-list-tile-title>
                </v-list-tile-content>
              </v-list-tile>
              <v-divider class="no-mg-bottom"></v-divider>

              <v-list-tile>
                <v-list-tile-content>
                  <v-list-tile-title class="content-flex">
                    <span class="font-weight-bold item-title">To Date:</span>
                    <span>{{couponCode.to_date}}</span>
                  </v-list-tile-title>
                </v-list-tile-content>
              </v-list-tile>
              <v-divider class="no-mg-bottom"></v-divider>
            </v-list>
            <!-- End show information -->
          </v-card>
        </v-navigation-drawer>
      </v-flex>
    </v-layout>
  </v-container>
</template>

<script>
import { getWithContentWrap } from "../../../helpers/helpers";

export default {
  name: "CompanyInformation",
  data() {
    return {
      drawerRight: false,
      drawerRightEdit: false,
      company: [],
      companyId: "",
      couponCode: [],
      lengthCode: "",
      width: 0,
      drawerHeaderStt: null
    };
  },
  computed: {
    widthComputed() {
      return this.width;
    }
  },
  mounted() {
    this.$root.$on("sendEventCompanyInformation", response => {
      this.drawerRight = response.showNavigation;
      this.companyId = response.data.id;
      this.company = response.data;
      this.informationCompany(this.companyId);
      this.width = this.getCurrentWithContentWrap();
    });

    this.$root.$on("drawer-status", res => {
      this.drawerHeaderStt = res;
    });
  },
  methods: {
    getCurrentWithContentWrap() {
      return getWithContentWrap(this.drawerHeaderStt);
    },
    informationCompany(companyId) {
      axios
        .get("companies/information?companyId=" + this.companyId)
        .then(response => {
          if (response && response.success) {
            this.company = response.data[0];

            this.couponCode = response.data[1][0];

            var array = response.data[1];

            this.lengthCode = array.length;
          }
        });
    }
  }
};
</script>
<style lang="scss" scoped>
.content-flex {
  height: auto !important;
  white-space: inherit !important;
}
.max-value {
  max-width: 63%;
  flex: 0 0 63%;
}
@media only screen and (min-width: 320px) and (max-width: 767px) {
  .item-title {
    margin-left: 10px !important;
  }
  .flex-padding {
    .heigth-list-title .v-list__tile {
      height: auto !important;
    }
  }
}
</style>
