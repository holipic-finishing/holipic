<template>
  <v-container fluid px-0 py-0 class="fix-croll-container">
    <v-layout row wrap>
      <app-card
        colClasses="xl12 lg12 md12 sm12 xs12"
        customClasses="p-0 elevation-5 rp-search"
        :fullScreen="true"
        :reloadable="true"
        :closeable="false"
        :fullBlock="false"
      >
        <v-toolbar flat color="white">
          <v-toolbar-title>Customers Manage</v-toolbar-title>
        </v-toolbar>
        <v-divider class="m-0"></v-divider>
        <!--Search Component -->
        <v-card-title>
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

          <a
            :href="urlExport"
            target="_blank"
            slot="activator"
            class="btn btn-primary ml-2 btn-gradient-primary custom-btn custom-btn-customer rp-btn-package"
          >
            <v-icon small color="white">fas fa-file-excel</v-icon>
          </a>
        </v-card-title>

        <v-data-table
          :headers="headers"
          :items="items"
          class="body-2 custom-table-customer"
          :pagination.sync="pagination"
          :rows-per-page-items="rowsPerPageItems"
          default-sort="id:desc"
          :search="search"
        >
          <template slot="items" slot-scope="props">
            <td>{{ props.item.id }}</td>
            <td class="text-xs-left">{{ props.item.name }}</td>
            <td class="text-xs-left">{{ props.item.room.room_hash }}</td>
            <td class="text-xs-left">{{ props.item.user.email }}</td>
            <td class="text-xs-left">{{ props.item.customer_password }}</td>
            <td class="text-xs-left">
              <img :src="props.item.avatar" width="50px" slot="activator" />
            </td>
            <td class="text-xs-left">
              <v-btn color="success" small class="btn-customer btn-gradient-primary">Manage</v-btn>
            </td>
            <td class="text-xs-left">
              <v-btn color="success" small class="btn-customer btn-gradient-primary">Manage</v-btn>
            </td>
            <td class="text-xs-left">
              <v-btn color="success" small class="btn-customer btn-gradient-primary">100</v-btn>
            </td>
            <td class="text-xs-center center-input-customer">
              <v-text-field name="name" outline class="height-input-customer width-input"></v-text-field>
            </td>
            <td class="text-left action-width">
              <v-icon small class="mr-2 hover-icon" @click="showGift(props.item)">card_giftcard</v-icon>

              <v-icon small class="mr-2 hover-icon" @click="showFormEdit(props.item)">edit</v-icon>

              <v-icon small class="mr-2 hover-icon" @click="showDialog(props.item.id)">delete</v-icon>
            </td>
          </template>
        </v-data-table>
        <customer-edit></customer-edit>
      </app-card>
    </v-layout>
    <v-dialog v-model="dialog" persistent max-width="450">
      <v-card>
        <v-card-title class="headline font-weight-bold">
          <v-icon x-large color="yellow accent-3" class="mr-2">warning</v-icon>Do you want delete this item ?
        </v-card-title>
        <v-divider class="mt-0"></v-divider>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn flat @click="dialog = false">Disagree</v-btn>
          <v-btn flat @click="deleteItem">Agree</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </v-container>
</template>

<script>
import { get, post, put, del, getWithData } from "../../../api/index.js";
import config from "../../../config/index.js";
import CustomerEdit from "./CustomerEdit";

export default {
  name: "Customers",
  components: {
    CustomerEdit
  },

  data() {
    return {
      dialog: false,
      search: "",
      items: [],
      headers: [
        { text: "ID", value: "id" },
        { text: "Name", value: "name" },
        { text: "Room", value: "room.room_hash" },
        { text: "Email", value: "user.email" },
        { text: "Password", value: "customer_password" },
        { text: "Avatar", value: "avatar" },
        { text: "Order" },
        { text: "Invoice" },
        { text: "Rest Photo" },
        { text: "Set Offer(Rp)", width: "15%" },
        { text: "Action", sortable: false, width: "7%" }
      ],
      pagination: {
        rowsPerPage: 25
      },
      itemIdToDelete: "",
      rowsPerPageItems: [
        25,
        50,
        100,
        { text: "$vuetify.dataIterator.rowsPerPageAll", value: -1 }
      ],
      user: JSON.parse(localStorage.getItem("user")),
      urlExport:
        config.API_URL +
        "branch/customers/export?userId=" +
        JSON.parse(localStorage.getItem("user")).id
    };
  },
  created() {
    this.fetchData();
  },
  mounted() {
    this.$root.$on("reloadTableCustomer", res => this.fetchData());
  },
  methods: {
    fetchData() {
      let url = "branch/customers";
      post(url, this.user)
        .then(response => {
          if (response && response.success) {
            this.items = response.data;
          }
        })
        .catch(error => {
          console.log(error);
        });
    },
    deleteItem() {
      del("branch/" + this.itemIdToDelete)
        .then(res => {
          if (res && res.success) {
            setTimeout(() => {
              Vue.notify({
                group: "loggedIn",
                type: "success",
                text: "Delete Item Success!"
              });
            }, 1500);
            this.fetchData();
            this.dialog = false;
          }
        })
        .catch(e => {
          console.log(e);
        });
    },
    showDialog(item) {
      this.dialog = true;
      this.itemIdToDelete = item;
    },
    showFormEdit(item) {
      this.$root.$emit("showFormEditCustomer", {
        showNavigation: true,
        data: item
      });
    },
    showGift(item) {}
  }
};
</script>

<style lang="scss" scoped>
.hover-icon {
  &:hover {
    color: blue !important;
  }
}
.add-btn {
  right: 0px;
  position: absolute;
  top: 8px;
}
.center-input {
  margin-top: 30px;
}
.action-width {
  min-width: 130px;
  width: 130px;
}
</style>
