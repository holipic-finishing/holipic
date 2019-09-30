<template>
  <v-menu
    offset-y
    origin="right top"
    left
    content-class="language-dropdown"
    transition="slide-y-transition"
    nudge-top="-10"
    class="user-block-wrap"
  >
    <v-btn icon slot="activator">
      <v-icon color="grey">fas fa-user-alt</v-icon>
    </v-btn>
    <div class="dropdown-content">
      <div class="dropdown-top white--text primary">
        <span class="white--text fs-14 fw-bold d-block">{{ user.full_name }}</span>
        <span class="d-block fs-12 fw-light">{{ user.email }}</span>
      </div>
      <v-list class="dropdown-list">
        <template v-for="userLink in userLinks" v-if="userLink.id !== 4">
          <v-list-tile
            :to="role_id == '1' ? getMenuLink(userLink.path) : getMenuLink(userLink.pathCom)"
            :key="userLink.id"
          >
            <i :class="userLink.icon"></i>
            <span>{{$t(userLink.title)}}</span>
          </v-list-tile>
        </template>
        <template v-else>
          <v-list-tile @click="$store.dispatch('logoutUser', $router)" :key="userLink.id">
            <i :class="userLink.icon"></i>
            <span>{{$t(userLink.title)}}</span>
          </v-list-tile>
        </template>
      </v-list>
    </div>
  </v-menu>
</template>
<script>
import { getCurrentAppLayout } from "../../helpers/helpers";

export default {
  data() {
    return {
      userLinks: [
        {
          id: 1,
          title: "message.userProfile",
          icon: "ti-user mr-3 primary--text",
          path: "/users/user-profile",
          pathCom: "/users/user-profile"
        },
        {
          id: 2,
          title: "message.plan",
          icon: "ti-book mr-3 info--text",
          path: "/user/plans"
        },
        {
          id: 3,
          title: "message.changePassword",
          icon: "ti-lock mr-3 info--text",
          path: "/change-password",
          pathCom: "/change-password"
        },
        {
          id: 4,
          title: "message.logOut",
          icon: "ti-power-off mr-3 error--text"
        }
      ],
      user: {},
      role_id: ""
    };
  },
  methods: {
    getMenuLink(path) {
      return "/" + getCurrentAppLayout(this.$router) + path;
    }
  },
  created() {
    var userAuth = JSON.parse(localStorage.getItem("user"));
    this.role_id = userAuth.role_id;
    this.user = userAuth;
  }
};
</script>
<style lang="scss" scoped>
.user-block-wrap {
  margin: -10px;
}
</style>
