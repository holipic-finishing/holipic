<template>
  <v-container fluid pt-0 grid-list-xl mt-3>
    <v-layout row wrap>
      <app-card
        colClasses="xl12 lg12 md12 sm12 xs12"
        customClasses="p-0 elevation-5"
        :fullScreen="true"
        :reloadable="true"
        :closeable="false"
      >
        <!-- <v-toolbar flat color="white">
          <v-toolbar-title>Ewallet Withdraw</v-toolbar-title>
        </v-toolbar>
        <v-divider class="m-0"></v-divider> -->

        <!--Search Component -->
        <v-card-title>
          <p class="headline">Ewallet Withdraw</p>
          <v-spacer></v-spacer>
          <div class="w-25">
            <v-text-field
              v-model="search"
              append-icon="search"
              label="Enter Search Value"
              single-line
              hide-details
            ></v-text-field>
          </div>
          <!-- <v-btn small fab dark color="indigo" @click="showFromAdd()" class="ml-2 btn-gradient-primary">
							<v-icon dark>add</v-icon>
          </v-btn>-->
        </v-card-title>
        <!--Search Component -->

        <v-data-table
          :headers="headers"
          :items="items"
          class="elevation-5 body-2 global-custom-table"
          :pagination.sync="pagination"
          :rows-per-page-items="rowsPerPageItems"
          default-sort="id:desc"
          :search="search"
        >
          <v-progress-linear slot="progress" color="blue" indeterminate></v-progress-linear>

          <template slot="headers" slot-scope="props">
            <tr>
              <th
                v-for="header in props.headers"
                :key="header.text"
                :class="['column sortable', pagination.descending ? 'desc' : 'asc', header.value === pagination.sortBy ? 'active' : '']"
                @click="changeSort(header.value)"
              >
                <div class="custom-header">
                  <v-tooltip bottom>
                    <span
                      slot="activator"
                      class="text-capitalize font-weight-bold"
                    >{{ header.text }}</span>
                    <span>{{ header.text }}</span>
                  </v-tooltip>
                  <v-icon v-if="header.text != 'Action' && header.text != 'No.'">arrow_upward</v-icon>
                </div>
              </th>
            </tr>
          </template>

          <template slot="items" slot-scope="props">
            <td>{{props.index}}</td>
            <td class="text-xs-left">{{props.item.company.name}}</td>
            <td class="text-xs-left">{{props.item.account_holder_name}}</td>
            <td class="text-xs-left">{{props.item.bank_account_number}}</td>
            <td class="text-xs-left">{{props.item.bank_name}}</td>
            <td class="text-xs-left">{{props.item.amount}}</td>
            <td class="text-xs-left custom-v-select">
              <!-- <v-btn color="btn-gradient-primary" small v-if="props.item.status === 'DONE'">{{props.item.status}}</v-btn>
              <v-btn color="btn-gradient-pink" small v-else>{{props.item.status}}</v-btn>-->
              <v-select
                :items="selectStatus"
                v-model="props.item.status"
                outline
                class="height-input-customer width-input"
                :readonly="props.item.status == 'DONE' ? true : false"
                @change="updateStatusEwallet(props.item)"
              ></v-select>
            </td>
            <td class="text-xs-left action-width-photographer">
              <v-icon small class="mr-2 hover-icon" @click="showInfo(props.item)">visibility</v-icon>
            </td>
          </template>

          <!--No data -->
          <template slot="no-data">
            <v-alert :value="true" color="error" icon="warning">Sorry, nothing to display here :(</v-alert>
          </template>

          <!--Search no result -->
          <v-alert
            slot="no-results"
            :value="true"
            color="error"
            icon="warning"
          >Your search for "{{ search }}" found no results.</v-alert>
        </v-data-table>

        <ewallet-withdraw></ewallet-withdraw>
      </app-card>
    </v-layout>

    <!-- confirm delete -->
    <!-- <v-dialog v-model="dialog" persistent max-width="450">
	      <v-card>
	        <v-card-title class="headline font-weight-bold">
	          <v-icon x-large color="yellow accent-3" class="mr-2">
	            warning
	          </v-icon>
	          Do you want delete this item ?
	        </v-card-title>
	        <v-divider class="mt-0"></v-divider>
	        <v-card-actions>
	          <v-spacer></v-spacer>
	          <v-btn flat @click="dialog = false">Disagree</v-btn>
	          <v-btn flat @click="deleteItem">Agree</v-btn>
	        </v-card-actions>
	      </v-card>
    </v-dialog>-->
    <!-- confirm delete -->
  </v-container>
</template>

<script>
import { get, post, put, del, getWithData } from "../../../api/index.js";
import EwalletInformation from "./EwalletInformation.vue";
import Vue from "vue";

export default {
  name: "EwalletWithdraw",
  components: {
    "ewallet-withdraw": EwalletInformation
  },

  data() {
    return {
      headers: [
        { text: "No.", sortable: false },
        { text: "Company name", value: "company.name", sortable: false },
        {
          text: "Account Holder Name",
          value: "bank_account_number",
          sortable: false
        },
        {
          text: "Bank account number",
          value: "bank_account_number",
          sortable: false
        },
        { text: "Bank name", value: "bank_name", sortable: false },
        { text: "Amount", value: "amount", sortable: false },
        { text: "Status", value: "status", sortable: false },
        { text: "Action", sortable: false }
      ],
      items: [],
      pagination: {
        rowsPerPage: 25
      },
      rowsPerPageItems: [
        25,
        50,
        100,
        { text: "$vuetify.dataIterator.rowsPerPageAll", value: -1 }
      ],
      loading: false,
      dialog: false,
      search: "",
      selectStatus: ["DONE", "PENDING"],
      valueSelect: ""
    };
  },
  mounted() {
    this.fetchData();
  },
  methods: {
    fetchData() {
      get("ewallet-withdraw")
        .then(res => {
          if (res && res.success) {
            this.items = res.data;
          }
        })
        .catch(error => {
          console.log(error.response);
        });
    },
    changeSort(column) {
      var columnsNoSearch = ["actions"];
      if (columnsNoSearch.indexOf(column) > -1) {
        return;
      }
      this.loading = true;
      if (this.pagination.sortBy === column) {
        this.pagination.descending = !this.pagination.descending;
      } else {
        this.pagination.sortBy = column;
        this.pagination.descending = false;
      }
      this.loading = false;
    },
    updateStatusEwallet(item) {
      put(
        "ewallet-withdraw/update-status/" + item.id,
        item
      ).then(res => {
        if (res && res.success) {
          Vue.notify({
            group: "loggedIn",
            type: "success",
            text: "Update status success"
          });
        }
      });
    },
    showInfo(item) {
      this.$root.$emit("showInfoEwallet", { showNavigation: true, data: item });
    }
  }
};
</script>

<style lang="css" scoped>
</style>
