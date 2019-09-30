<template>
  <v-content class="pb-md-20 pb-sm-5">
    <v-card class="shadow-none bg-color">
      <v-card-title
        class="font-weight-bold display-1 justify-content-center"
      >
        {{$t('message.loginToAdmin')}}
      </v-card-title>
      <v-card-text class="text-muted text-center h2 lead">
        Enter email and password to access control panel of Holipic.
      </v-card-text>

      <v-form v-model="valid" class="mb-4" ref="form">
        <v-text-field
          label="E-mail"
          v-model="email"
          :rules="emailRules"
          required
          @keyup.enter="login"
        ></v-text-field>

        <v-text-field
          label="Password"
          v-model="password"
          type="password"
          :rules="passwordRules"
          required
          @keyup.enter="login"
        ></v-text-field>

        <v-checkbox color="primary" label="Remember me" v-model="checkbox"></v-checkbox>

        <router-link class="mb-1" to="/session/forgot-password">{{ $t('message.forgotPassword') }}?</router-link>
        <div>
          <v-btn large @click="login" block color="primary">{{ $t('message.loginNow') }}</v-btn>
        </div>
      </v-form>
    </v-card>

    <notifications animation-type="velocity" />
  </v-content>
</template>

<script>
import { mapGetters } from "vuex";
import AppConfig from "../../constants/AppConfig";

export default {
  name: "Login",
  data() {
    return {
      valid: true,
      lazy: true,
      checkbox: false,
      password: "",
      email: "",
      emailRules: [
        v => !!v || "E-mail is required",
        v =>
          /^\w+([.-]?\w+)*@\w+([.-]?\w+)*(\.\w{2,3})+$/.test(v) ||
          "E-mail must be valid"
      ],
      passwordRules: [v => !!v || "Password is required"]
    };
  },
  methods: {
    submit() {
      const user = {
        email: this.email,
        password: this.password
      };

      this.$router.push({
        path: "/default/dashboard/ecommerce"
      });
    },

    login() {
      if (this.$refs.form.validate()) {
        const user = {
          email: this.email,
          password: this.password
        };

        this.$store.dispatch("signinUser", { user });
      }
    }
  }
};
</script>

<style lang="css" scoped>
.style-left {
  margin-left: 0px;
}
</style>
