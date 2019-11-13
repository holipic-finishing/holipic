<template>
  <v-container fluid pt-0 grid-list-xl mt-3 class="container-wrapper">
    <v-layout row wrap>
      <app-card
        colClasses="xl12 lg12 md12 sm12 xs12"
        customClasses="p-0 elevation-5 rp-search"
        :fullScreen="true"
        :reloadable="true"
        :closeable="false"
      >
        <!-- <v-toolbar flat color="white">
          <v-toolbar-title>
            <p>Company List</p>

          </v-toolbar-title>
        </v-toolbar>
        <v-divider class="m-0"></v-divider> -->

        <!--Search Component -->
        <v-card-title>
          <p class="headline">Companies</p>
          <!-- <v-spacer></v-spacer>
			        <div class="w-25">
			  	      <v-text-field
			  	        v-model="search"
			  	        append-icon="search"
			  	        label="Enter Search Value"
			  	        single-line
			  	        hide-details
			  	      ></v-text-field>
			        </div>
				    <v-tooltip bottom>
					    <a :href="urlExport" target="_blank" slot="activator" class="btn btn-primary ml-2 btn-gradient-primary fix-btn-priamry">
								<v-icon small color="white">fas fa-file-excel</v-icon>
							</a>
					    <span>Export companies</span>
			   		 </v-tooltip>
          </v-card-title>-->

          <!--End Search Component -->
          <v-spacer></v-spacer>
          <div class="w-25">
            <v-text-field
            class="pt-0 mt-0"
              v-model="search"
              append-icon="search"
              label="Search"
              single-line
              hide-details
            ></v-text-field>
          </div>
          <!-- <v-tooltip bottom>
            <a
              :href="urlExport"
              target="_blank"
              slot="activator"
              class="btn btn-primary custom-btn"
            > -->
              <!-- <v-icon small color="white">fas fa-file-excel</v-icon> -->
              <v-btn :href="urlExport" color="white" icon>
                <v-icon small color="grey">cloud_download</v-icon>
              </v-btn>
            <!-- </a>
            <span>Export companies</span>
          </v-tooltip> -->
        </v-card-title>
        <!--End Search Component -->

        <v-data-table
          :headers="headers"
          :items="desserts"
          class="elevation-5 body-2 global-custom-table"
          :pagination.sync="pagination"
          :rows-per-page-items="rowsPerPageItems"
          default-sort="id:desc"
          :search="search"
        >
          <v-progress-linear slot="progress" color="blue" indeterminate></v-progress-linear>
          <!--Header -->
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
                  <v-icon v-if="header.value != 'actions'">arrow_upward</v-icon>
                </div>
              </th>
            </tr>
          </template>

          <template slot="items" slot-scope="props">
            <td>{{ props.item.id }}</td>
            <td class="text-xs-left">{{ props.item.name }}</td>
            <td class="text-xs-left">{{ props.item.fullname }}</td>
            <td class="text-xs-left">{{ props.item.email }}</td>
            <td class="text-xs-left">{{ props.item.phone }}</td>
            <td class="text-xs-left action-width">
              <v-tooltip top v-if="props.item.coupon_codes_id">
                <v-icon
                  small
                  class="mr-2 hover-icon"
                  @click="addCouponAction(props.item, 'Coupon Code List')"
                  color="red darken-1"
                  slot="activator"
                >mdi-alpha-c-circle</v-icon>
                <span>Coupon Code Added</span>
              </v-tooltip>

              <v-icon
                small
                class="mr-2 hover-icon"
                @click="addCouponAction(props.item, 'Coupon Code List')"
                v-else
              >mdi-alpha-c-circle</v-icon>

              <v-icon
                small
                class="mr-2 hover-icon"
                @click.stop="drawerRight = !drawerRight"
                @click="showTransaction(props.item)"
              >monetization_on</v-icon>

              <v-icon small class="mr-2 hover-icon" @click="showInfo(props.item)">visibility</v-icon>

              <v-icon small class="mr-2 hover-icon" @click="showFormEdit(props.item)">edit</v-icon>

              <v-icon small class="mr-2 hover-icon" @click="showDialog(props.item.id)">delete</v-icon>
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
      <!-- Dialog -->

      <v-dialog v-model="dialog" persistent max-width="300">
        <v-card>
          <!-- <v-card-title class="headline font-weight-bold text-center">
            <v-icon x-large color="yellow accent-3" class="mr-2">error_outline</v-icon>
          </v-card-title>
          <v-divider class="mt-0"></v-divider> -->

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
      <!-- <v-dialog v-model="dialog" persistent max-width="450">
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
      </v-dialog> -->
      <!-- component -->
      <coupon-code-component :typeEvent="typeEvent" :item="item"></coupon-code-component>
      <transaction-component></transaction-component>
      <company-information></company-information>
      <company-edit-component></company-edit-component>
    </v-layout>
  </v-container>
</template>

<script>
import { get, post, put, del, getWithData } from "../../../api/index.js";
import config from "../../../config/index.js";
import Vue from "vue";
import Lodash from "lodash";
import moment from "moment";
import ShowTransaction from "./ShowTransaction.vue";
import CompanyInformation from "./NavigationCompanyInformation";
import CompanyEdit from "./NavigationCompanyEdit";
import CouponCode from "./CouponCode";

export default {
  name: "Companies",
  components: {
    "transaction-component": ShowTransaction,
    "company-information": CompanyInformation,
    "company-edit-component": CompanyEdit,
    "coupon-code-component": CouponCode
  },

  data() {
    return {
      headers: [
        { text: "ID", value: "id" },
        { text: "Company Name", value: "name" },
        { text: "Owner/ Manager", value: "fullname" },
        { text: "Email", value: "email" },
        { text: "Phone", value: "phone" },
        { text: "Action", value: "actions", sortable: false }
      ],
      desserts: [],
      search: "",
      dialog: false,
      itemIdToDelete: "",
      listPackage: [],
      urlExport: config.API_URL + "companies/export-excel",
      drawerRight: false,
      pagination: {
        rowsPerPage: 25,
        sortBy: "id",
        descending: true
      },
      rowsPerPageItems: [
        25,
        50,
        100,
        { text: "$vuetify.dataIterator.rowsPerPageAll", value: -1 }
      ],
      typeEvent: "",
      item: {}
    };
  },

  created() {
    this.fetchData();
    this.getListPackage();
  },

  mounted() {
    this.$root.$on("editCompanySuccess", res => this.fetchData());
    this.$root.$on("load-data-after-coupon-code_event", () => {
      this.fetchData();
    });
  },

  methods: {
    fetchData() {
      get("companies")
        .then(res => {
          if (res && res.success) {
            this.desserts = res.data;
          }
        })
        .catch(e => {
          console.log(e);
        });
    },

    doReset() {
      this.search.keywords = "";
      this.search.filterPackage = "";
      this.fetchData();
    },

    getListPackage() {
      var data = [];
      data.push("All");

      get("list-package")
        .then(res => {
          _.forEach(res.data, function(value) {
            data.push(value.package_name);
          });
        })
        .catch(e => {
          console.log(e);
        });

      this.listPackage = data;
    },

    showItem(item) {
      this.$root.$router.push({
        path: "/default/widgets/mana-company-chart",
        query: { companyId: item.id }
      });
    },

    showTransaction(items) {
      let obj = {
        typeTime: "Day",
        showDrawerRight: true,
        companyId: items.id,
        userId: items.owner_id
      };

      this.$root.$emit("showTransactionStatus", obj);
    },

    showInfo(item) {
      this.$root.$emit("sendEventCompanyInformation", {
        showNavigation: true,
        data: item
      });
    },

    showFormEdit(item) {
      this.$root.$emit("sendEventCompanyEdit", {
        showNavigation: true,
        data: item
      });
    },
    showDialog(item) {
      this.dialog = true;
      this.itemIdToDelete = item;
    },
    deleteItem() {
      del("companies/" + this.itemIdToDelete).then(
        response => {
          if (response && response.success) {
            this.fetchData();
            this.dialog = false;
          }
        }
      );
    },
    toggleAll() {
      if (this.selected.length) this.selected = [];
      else {
        this.selected = this.desserts.slice();
      }
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
    addCouponAction(item, typeEvent) {
      this.typeEvent = typeEvent;
      this.item = item;
      this.$root.$emit("show-coupon-code-component", item);
    }
  }
};
</script>

<style lang="scss" scoped>
.input-style {
  width: 160px;
}

.company-table {
  margin-top: 30px;
}

.search-tool {
  margin-left: 30px;
  margin-top: 18px;
  margin-bottom: 10px;
}

.elevation-fix {
  margin-top: 20px;
}

.h3-title-company {
  width: 290px;
}

#inspire {
  overflow: hidden !important;
}

.hover-icon {
  &:hover {
    color: blue !important;
  }
}

.action-width {
  min-width: 170px;
  width: 170px;
}
</style>
