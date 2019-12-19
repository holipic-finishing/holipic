<!-- Side Structure -->
<template>
  <!-- <div class="sidebar" :class="sidebarSelectedFilter.class"> -->
  <div class="sidebar">
    <!-- <vue-perfect-scrollbar class="scroll-area" :settings="settings"> -->
      <v-toolbar flat class="transparent scroll-area navigation">
        <v-list>
          <!-- <v-subheader><app-logo></app-logo></v-subheader> -->
          <v-list-item>
            <v-list-item-content>
              <app-logo></app-logo>
            </v-list-item-content>
          </v-list-item>
          <!-- <app-logo></app-logo> -->
          <template v-for="(category, key) in menus">
            <div :key="key">
              <!-- <div class="sidebar-title px-3">
							<span>{{$t(key)}}</span>
              </div>-->
              <template v-for="item in category">
                <template v-if="item.items!= null && item.role_id == user.role_id">
                  <v-list-group
                    :key="item.title"
                    prepend-icon="arrow_right"
                    append-icon
                    no-action
                    v-model="item.active"
                  >
                    <v-list-tile slot="activator">
                      <v-list-tile-content>
                        <v-list-tile-title>
                          <i class="mr-2 zmdi" :class="item.action"></i>
                          <br>
                          <span>{{ textTruncate($t(item.title)) }}</span>
                        </v-list-tile-title>
                      </v-list-tile-content>
                    </v-list-tile>
                    <v-list-tile
                      v-for="subItem in item.items"
                      v-bind:key="subItem.title"
                      v-if="subItem !== null"
                      :to="!subItem.exact ? `/${getCurrentAppLayoutHandler() + subItem.path}` : subItem.path"
                    >
                      <v-list-tile-content>
                        <v-list-tile-title>{{ textTruncate($t(subItem.title)) }}</v-list-tile-title>
                      </v-list-tile-content>
                    </v-list-tile>
                  </v-list-group>
                </template>
                <template v-else-if="item.role_id == user.role_id">
                  <v-list-tile
                    :to="!item.exact ? `/${getCurrentAppLayoutHandler() + item.path}` : item.path"
                    :key="item.path"
                  >
                    <!-- <v-list-tile-action class="pa-0">
                      <i class="zmdi zmdi-caret-right"></i>
                    </v-list-tile-action> -->
                    <v-list-tile-content>
                      <v-list-tile-title style="height:100%!important;" class="text-center">
                        <i class="zmdi lead" :class="item.action"></i>
                        <p style="font-size: 10px;">{{ textTruncate($t(item.title)) }}</p>
                      </v-list-tile-title>
                    </v-list-tile-content>
                  </v-list-tile>
                </template>
              </template>
            </div>
          </template>
        </v-list>
      </v-toolbar>
    <!-- </vue-perfect-scrollbar> -->
  </div>
</template>

<script>
import { textTruncate, getCurrentAppLayout } from "../../helpers/helpers";
import { mapGetters } from "vuex";
import AppLogo from "../../components/AppLogo/AppLogo";

export default {
  data() {
    return {
      settings: {
        maxScrollbarLength: 160
      },
      user: {}
    };
  },
  components: {
    AppLogo
  },
  computed: {
    ...mapGetters(["sidebarSelectedFilter", "menus"])
  },
  mounted() {
    this.$store.dispatch("setActiveMenuGroup", this.$router);
    this.user = JSON.parse(localStorage.getItem("user"));
    // console.log(sidebarSelectedFilter);
  },
  methods: {
    textTruncate(text) {
      return textTruncate(text, 18);
    },
    getCurrentAppLayoutHandler() {
      return getCurrentAppLayout(this.$router);
    }
  }
};
</script>
<style>
.sidebar * {
  color: #797878!important;
}
.v-navigation-drawer .navigation .v-list .v-list__tile--link{
  width: 80px!important;
}
</style>
