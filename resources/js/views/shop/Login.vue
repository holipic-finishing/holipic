<template>
  <v-content>
    <v-container fluid fill-height white>
      <v-layout align-center justify-center>
        <v-flex xs12 sm8 md4>
          <v-card tile flat>
            <v-card-title class="font-weight-bold display-1 justify-content-center">WELCOME</v-card-title>
            <v-card-text class="text-center">
              <v-img src="shop_selling/logo-holipic-new.png" width="150px" class="d-inline-block" />
            </v-card-text>
            <v-card-text class="text-muted text-center h2 lead">Login to Start Selling Photos</v-card-text>
            <v-card-text class="pl-md-5 pr-md-5">
              <v-form ref="form" v-model="valid" lazy-validation>
                <v-text-field
                  v-model="email"
                  :rules="emailRules"
                  label="Email"
                  required
                  @keyup.enter="login"
                  color="#0EBFF6"
                ></v-text-field>

                <v-text-field
                  :type="'password'"
                  v-model="password"
                  :rules="passwordRules"
                  label="Password"
                  required
                  @keyup.enter="login"
                  color="#0EBFF6"
                ></v-text-field>
              </v-form>
            </v-card-text>
            <v-card-actions class="pl-md-5 pr-md-5 pt-4">
              <v-btn color="#0EBFF6" dark large @click="login" block round class="font-weight-bold">Login</v-btn>
            </v-card-actions>
          </v-card>
        </v-flex>
      </v-layout>
    </v-container>
  </v-content>
</template>

<script>
export default {
  name: "Login",

  data() {
    return {
      valid: true,
      email: "",
      password: "",
      passwordRules: [
        v => !!v || "Password is required",
        v => (v && v.length <= 10) || "Password must be less than 10 characters"
      ],
      emailRules: [
        v => !!v || "E-mail is required",
        v => /.+@.+/.test(v) || "E-mail must be valid"
      ]
    };
  },
  methods: {
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

<style lang="scss" scoped>
</style>
