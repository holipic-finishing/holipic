<template>
  <v-container fluid>
    <app-card>
      <v-navigation-drawer
        fixed
        v-model="drawer"
        :right="!rtlLayout"
        temporary
        app
        class="chat-sidebar-wrap"
        width="450"
      >
        <coupon-code-item :eventType="eventType" :item="item"></coupon-code-item>
      </v-navigation-drawer>

      <!-- <page-title-bar></page-title-bar> -->

      <v-toolbar flat color="white">
        <p class="headline">Coupon Code List</p>
        <v-spacer></v-spacer>
        <v-text-field
          v-model="search"
          append-icon="search"
          label="Search"
          single-line
          hide-details
          class="mr-3"
        ></v-text-field>
        <v-tooltip bottom>
          <v-btn
            @click="couponCodeEvent('add-new', null)"
            color="grey"
            dark
            depressed
            slot="activator"
            fab
            small
          >
            <v-icon dark>fas fa-plus</v-icon>
          </v-btn>
          <span>Add New Coupon Code</span>
        </v-tooltip>
      </v-toolbar>

      <v-data-table
        :headers="headers"
        :items="desserts"
        :pagination.sync="pagination"
        :loading="loading"
        item-key="id"
        :search="search"
        :rows-per-page-items="rowsPerPageItems"
      >
        <v-progress-linear slot="progress" color="blue" indeterminate></v-progress-linear>

        <!--Header -->
        <template slot="headers" slot-scope="props">
          <tr>
            <th
              v-for="header in props.headers"
              :key="header.text"
              :class="['column sortable ', pagination.descending ? 'desc' : 'asc', header.value === pagination.sortBy ? 'active' : '']"
              @click="changeSort(header.value)"
            >
              <div class="custom-header text-center">
                <v-tooltip bottom>
                  <span
                    slot="activator"
                    class="text-capitalize subheading font-weight-bold"
                  >{{ header.text }}</span>
                  <span>{{ header.text }}</span>
                </v-tooltip>
                <v-icon v-if="header.value != 'actions' && header.value != 'code'">arrow_upward</v-icon>
              </div>
            </th>
          </tr>
        </template>
        <!--Prop data -->
        <template slot="items" slot-scope="props">
          <td>{{ props.item.name }}</td>
          <td>{{ props.item.code }}</td>
          <td>{{ props.item.discount }}</td>
          <td>{{ props.item.from_date | moment("DD/MM/YYYY") }}</td>
          <td>{{ props.item.to_date | moment("DD/MM/YYYY") }}</td>
          <td v-if="props.item.active == '0' ">Inactive</td>
          <td v-if="props.item.active == '1' ">Active</td>
          <td class="action-width">
            <v-icon small class="mr-2" @click="couponCodeEvent('edit', props.item)">edit</v-icon>
            <v-icon small @click="showDialog(props.item.id)">delete</v-icon>
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
    </app-card>
    <v-dialog v-model="dialog" persistent max-width="300">
      <v-card>
        <v-card-text class="text-center">
          <v-icon size="80" color="orange darken-1" class="mr-2">error_outline</v-icon>
          <p class="headline">Are you sure?</p>
          <p class="subtitle-2">You will not be able to recover this Module!</p>
        </v-card-text>
        <v-card-actions>
          <v-btn round dark color="grey" @click="dialog = false">Disagree</v-btn>
          <v-spacer />
          <v-btn round dark color="error" @click="deleteItem">Agree</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </v-container>
</template>

<script>
import { get, del } from "../../../api/index.js";
import Vue from "vue";
import CouponCodeItem from "./CouponCodeItem";
import moment from "moment";
import { mapGetters } from "vuex";

export default {
  name: "CouponCodes",

  data() {
    return {
      search: "",
      desserts: [],
      headers: [
        { text: "Name", value: "name", width: "20%" },
        { text: "Code", value: "code", width: "10%", sortable: false },
        { text: "Discount (%)", value: "discount", width: "10%" },
        { text: "From Date", value: "from_date", width: "15%" },
        { text: "To Date", value: "to_date", width: "15%" },
        { text: "Active", value: "active" },
        { text: "Actions", value: "actions", sortable: false }
      ],
      pagination: {},
      loading: true,
      search: "",
      rowsPerPageItems: [
        20,
        50,
        100,
        { text: "$vuetify.dataIterator.rowsPerPageAll", value: -1 }
      ],
      drawer: false,
      item: null,
      eventType: "",
      dialog: false,
      itemIdToDelete: 0
    };
  },
  created() {
    this.loading = true;
    this.fetchData();
  },
  methods: {
    changeSort(column) {
      var columnsNoSearch = ["code", "actions"];
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
    fetchData() {
      let url = "coupon_codes";
      get(url)
        .then(res => {
          if (res && res.success) {
            this.desserts = res.data;
            this.loading = false;
          }
        })
        .catch(err => {
          console.log(err);
        });
    },
    couponCodeEvent(event, item) {
      this.drawer = true;
      this.$root.$emit("disabled-coupon-code-item");
      this.eventType = event;
      if (this.eventType === "add-new") {
        this.$root.$emit("reset-form");
      }
      this.item = item;
    },
    deleteItem() {
      let url = "coupon_codes/" + this.itemIdToDelete;
      del(url)
        .then(res => {
          this.dialog = false;
          this.fetchData();
          setTimeout(function() {
            Vue.notify({
              type: "success",
              text: "Delete Item Success!"
            });
          }, 1000);
        })
        .catch(err => {
          console.log(err);
        });
    },
    showDialog(id) {
      this.dialog = true;
      this.itemIdToDelete = id;
    }
  },
  components: {
    "coupon-code-item": CouponCodeItem
  },
  mounted() {
    this.$root.$on("closeDrawerItem", res => {
      this.drawer = res;
    });

    this.$root.$on("reload-table", res => {
      this.fetchData();
    });

    this.$root.$on("editItemSucess", res => {
      this.loading = true;
      this.fetchData();
    });
  },
  computed: {
    ...mapGetters(["rtlLayout"])
  }
};
</script>

<style lang="scss" scoped>
</style>
