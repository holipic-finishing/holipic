<template>
  <v-container fluid grid-list-xl>
    <v-layout row wrap>
      <app-card
        colClasses="xl12 lg12 md12 sm12 xs12"
        :fullScreen="true"
        :reloadable="true"
        :closeable="false"
        :fullBlock="true"
        class="p-0"
      >
        <v-navigation-drawer
          fixed
          v-model="drawer"
          :right="!rtlLayout"
          temporary
          app
          this.width="this.getCurrentWithContentWrap()"
          :width="widthComputed"
        >
          <transaction-item :eventType="eventType" :item="item"></transaction-item>
        </v-navigation-drawer>

        <v-toolbar flat color="white">
          <v-toolbar-title>
            <v-hover>
              <router-link
                slot-scope="{ hover }"
                :class="`elevation-${hover ? 10 : 2}`"
                class="black--text"
                :to="{ path: '/default/transaction/histories' }"
              >Transactions</router-link>
            </v-hover>
          </v-toolbar-title>
        </v-toolbar>
        <v-divider></v-divider>
        <!--Search Component -->
        <v-card-title>
          <v-spacer></v-spacer>
          <v-text-field
            v-model="search"
            append-icon="search"
            label="Enter Search Value"
            single-line
            hide-details
          ></v-text-field>
        </v-card-title>
        <!--End Search Component -->
        <!--Data Table Component -->
        <v-data-table
          v-model="selected"
          :headers="headers"
          :items="itemsToView"
          class="elevation-5"
          :pagination.sync="pagination"
          :loading="loadingCom"
          select-all
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
                :class="['column sortable', pagination.descending ? 'desc' : 'asc', header.value === pagination.sortBy ? 'active' : '']"
                @click="changeSort(header.value)"
              >
                <div class="custom-header">
                  <v-tooltip bottom>
                    <span
                      slot="activator"
                      class="text-capitalize subheading font-weight-bold"
                    >{{ header.text }}</span>
                    <span>{{ header.text }}</span>
                  </v-tooltip>
                  <v-icon v-if="header.value != 'actions'">arrow_upward</v-icon>
                </div>
              </th>
            </tr>
          </template>

          <!--Prop data -->
          <template slot="items" slot-scope="props">
            <td>{{ props.item.id }}</td>
            <td>{{ props.item.company_name }}</td>
            <td>{{ props.item.invoice }}</td>
            <td>{{ props.item.dated | moment("DD/MM/YYYY") }}</td>
            <td>{{ props.item.title }}</td>
            <td>
              <div
                v-if="props.item.status === 'RECIVED'"
                style="color:green"
              >+ {{ props.item.amount_with_symbol }}</div>
              <div v-else>{{ - props.item.amount_with_symbol }}</div>
            </td>
            <td>
              <v-btn
                color="success"
                small
                v-if="props.item.status === 'RECIVED'"
              >{{ props.item.status }}</v-btn>
              <v-btn color="error" small v-else>{{ props.item.status }}</v-btn>
            </td>
            <td class="action-width">
              <v-icon
                small
                class="mr-2 hover-icon"
                @click="transactionEvent('show', props.item)"
              >visibility</v-icon>
              <v-icon
                small
                class="mr-2 hover-icon"
                @click="transactionEvent('edit', props.item)"
              >edit</v-icon>
              <v-icon small class="mr-2 hover-icon" @click="showDialog(props.item.id)">delete</v-icon>
            </td>
            <!-- </tr> -->
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
        <!--End Data Table Component -->
      </app-card>
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
    </v-layout>
  </v-container>
</template>

<script>
//import files
import { get, post, put, del } from "../../../api";
import { mapGetters } from "vuex";
import TransactionItem from "./TransactionItem";
import Vue from "vue";
import { getWithContentWrap } from "../../../helpers/helpers";

export default {
  name: "Transactions",

  components: {
    TransactionItem
  },
  data() {
    return {
      dialog: false,
      desserts: [],
      headers: [
        {
          text: "ID",
          align: "left",
          value: "id",
          width: "3%"
        },
        {
          text: "Company Name",
          align: "left",
          value: "company_name",
          width: "10%"
        },
        {
          text: "Invoice",
          align: "right",
          value: "invoice"
        },
        {
          text: "Date",
          align: "right",
          value: "dated"
        },
        {
          text: "Transaction",
          align: "left",
          value: "title"
        },
        {
          text: "Amount($)",
          align: "right",
          value: "amount_with_symbol",
          sortable: false
        },
        {
          text: "Status",
          align: "right",
          value: "status"
        },
        {
          text: "Action",
          value: "actions",
          align: "center",
          sortable: false
        }
      ],
      pagination: {},
      loading: true,
      search: "",
      selected: [],
      drawer: false,
      item: null,
      eventType: "",
      params: {
        defaultDay: "default"
      },
      itemIdToDelete: null,
      rowsPerPageItems: [
        20,
        50,
        100,
        { text: "$vuetify.dataIterator.rowsPerPageAll", value: -1 }
      ],
      width: 0,
      drawerHeaderStt: null
    };
  },
  computed: {
    ...mapGetters(["rtlLayout"]),
    loadingCom() {
      return this.loading;
    },
    itemsToView() {
      return this.desserts;
    },
    widthComputed() {
      return this.width;
    }
  },
  mounted() {
    this.$root.$on("loadTransactionsWithTime", res => {
      let params = res.params;
      this.params = params;
      this.loading = true;
      this.fetchData(params);
    });

    this.$root.$on("closeDrawerItem", res => {
      this.drawer = res;
    });

    this.$root.$on("editItemSucess", res => {
      this.loading = true;
      this.fetchData(this.params);
      this.$root.$emit("load-total-transactions", {
        params: this.params
      });
    });
  },
  methods: {
    getCurrentWithContentWrap() {
      return getWithContentWrap(this.drawerHeaderStt);
    },
    fetchData(params) {
      post("history-transactions", params)
        .then(res => {
          if (res && res.success) {
            this.desserts = res.data;
            this.loading = false;
            this.$root.$emit("total-companies", this.desserts.length);
          }
        })
        .catch(e => {
          console.log(e);
        });
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
    transactionEvent(event, item) {
      this.drawer = true;
      this.$root.$emit("disabled-transaction-item");
      this.eventType = event;
      this.item = item;
      this.width = this.getCurrentWithContentWrap();
    },
    showDialog(id) {
      this.dialog = true;
      this.itemIdToDelete = id;
    },
    deleteItem() {
      del("transactions/" + this.itemIdToDelete)
        .then(res => {
          if (res && res.success) {
            this.$notify.success({
              title: "Success",
              message: "Delete Item Successfully!",
              showClose: false
            });
            this.loading = true;
            this.fetchData(this.params);
            this.dialog = false;
            this.$root.$emit("load-total-transactions", {
              params: this.params
            });
          }
        })
        .catch(e => {
          console.log(e);
        });
    }
  },

  created() {
    this.loading = true;
    this.fetchData(this.params);
  }
};
</script>

<style lang="scss" scoped>
.action-width {
  min-width: 130px;
  width: 130px;
}

.hover-icon {
  &:hover {
    color: blue;
  }
}
</style>
