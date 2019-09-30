<template>
  <v-card class="custom-card-ewth">
    <v-card-title>
      <v-spacer></v-spacer>
      <v-text-field
        v-model="search"
        append-icon="search"
        label="Search"
        single-line
        hide-details
        class="w150"
      ></v-text-field>
    </v-card-title>
    <v-divider></v-divider>
    <v-list two-line>
      <template v-for="(item, index) in items">
        <v-list-tile :key="item.id" avatar ripple @click="toggle(index)">
          <v-list-tile-avatar v-if="item.title === 'System Fee'">
            <v-icon>far fa-credit-card</v-icon>
          </v-list-tile-avatar>

          <v-list-tile-avatar v-if="item.title === 'Customer Paid'">
            <v-icon>fas fa-money-check-alt</v-icon>
          </v-list-tile-avatar>

          <v-list-tile-content>
            <v-list-tile-title class="font-weight-bold">{{ item.title }}</v-list-tile-title>
            <v-list-tile-sub-title
              class="text-muted caption"
            >{{ item.dated | moment("DD/MM/YYYY") }}</v-list-tile-sub-title>
          </v-list-tile-content>

          <v-list-tile-action>
            <v-list-tile-action-text
              class="success--text body-2"
              v-if="item.status == 'RECIVED'"
            >$ +{{item.new_amount}}</v-list-tile-action-text>
            <v-list-tile-action-text class="warning--text body-2" v-else>$ -{{item.new_amount}}</v-list-tile-action-text>
          </v-list-tile-action>
        </v-list-tile>
        <v-divider v-if="index < items.length" :key="index"></v-divider>
      </template>
    </v-list>
  </v-card>
</template>

<script>
import { getWithData, put, get, post } from "../../../../api";
import moment from "moment";

export default {
  name: "EWalletTransactionsHistory",

  data() {
    return {
      user: JSON.parse(localStorage.getItem("user")),
      items: [],
      settings: {
        maxScrollbarLength: 160
      },
      items: [],
      search: ""
    };
  },
  methods: {
    fetchData() {
      let url = "e-wallet/transaction-history";
      let params = {
        company_id: this.user.company_id,
        user_id: this.user.id
      };
      getWithData(url, params)
        .then(res => {
          if (res && res.success) {
            let data = res.data;
            this.items = data;
          }
        })
        .catch(err => {
          console.log(err);
        });
    }
  },
  created() {
    if (this.user.role_id == 2) {
      this.fetchData();
    }
  }
};
</script>

<style lang="scss" scoped>
</style>
