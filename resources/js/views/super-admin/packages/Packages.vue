<template>
  <div>
    <v-container fluid>
      <app-card
        class="pa-0"
        colClasses="xl12 lg12 md12 sm12 xs12"
        customClasses="pt-3 elevation-5 rp-search"
        :fullScreen="true"
        :reloadable="true"
        :closeable="false"
      >
        <package-item></package-item>
        <!-- <page-title-bar></page-title-bar> -->

        <v-toolbar flat color="white">
          <v-toolbar-title>Package List</v-toolbar-title>
          <v-spacer></v-spacer>
          <!-- <v-tooltip bottom>
            <v-btn
              @click="showAddItem()"
              color="btn-gradient-primary rp-btn-package"
              dark
              slot="activator"
              fab
              small
            >
              <v-icon dark>fas fa-plus</v-icon>
            </v-btn>
            <span>Add New Packages</span>
          </v-tooltip> -->
        </v-toolbar>
        <v-divider class="m-0"></v-divider>

        <!-- <v-card-title>
          <v-spacer></v-spacer>
          <div class="w-25">
            <v-text-field
              v-model="search"
              append-icon="search"
              label="Enter Search Value"
              single-line
              hide-details
              class="mr-3"
            ></v-text-field>
          </div>
        </v-card-title> -->
        <v-data-table
          :headers="headers"
          :items="desserts"
          class="elevation-1 custom-table"
          :disable-initial-sort="true"
          :pagination.sync="pagination"
          :loading="loadingCom"
          :search="search"
        >
          <template slot="items" slot-scope="props">
            <td class="text-xs-left">{{ props.item.package_name }}</td>
            <td class="text-xs-left">{{ props.item.short_description }}</td>
            <td class="text-xs-center">{{ props.item.file_upload }}</td>
            <td class="text-xs-left">{{ props.item.secure_storage }}</td>
            <td class="text-xs-left">
              <div v-if="props.item.email_service == true">yes</div>
              <div v-else>no</div>
            </td>
            <td class="text-xs-left">
              <div v-if="props.item.sms == true">yes</div>
              <div v-else>no</div>
            </td>
            <td class="text-xs-center">{{ props.item.fee }}</td>
            <td class="text-xs-center">{{ props.item.max_user }}</td>
            <td class="text-right action-width">
              <!-- <v-icon small class="mr-2" @click="settingItem(props.item)">settings</v-icon> -->
              <v-icon small class="mr-2" @click="editItem(props.item)">edit</v-icon>
              <v-icon
                small
                class="mr-2"
                @click="showDialog(props.item.id, props.item.setting_id)"
              >delete</v-icon>
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
  </div>
</template>

<script>
import { get, post, put, del, getWithData } from "../../../api/index.js";
import Vue from "vue";
import PackageItem from "./PackageItem";
export default {
  name: "Index",

  components: {
    PackageItem
  },

  data() {
    return {
      headers: [
        {
          text: "Package Name",
          align: "left",
          value: "package_name",
          width: "10%"
        },
        {
          text: "Short Description",
          value: "short_description",
          sortable: false,
          width: "20%"
        },
        { text: "Storage (Days)", value: "secure_storage", width: "10%" },
        { text: "Space (GB)", value: "secure_storage", width: "10%" },
        { text: "Email", value: "minimum_user", width: "10%" },
        { text: "SMS", value: "minimum_user", width: "10%" },
        { text: "Fee (%)", value: "fee", width: "10%" },
        { text: "Max Branch", value: "max_user", width: "10%" },
        { text: "Actions", sortable: false, width: "10%", align: "right" }
      ],
      desserts: [],
      dialog: false,
      pagination: {
        page: 1,
        rowsPerPage: 25,
        totalItems: 0
      },
      itemIdToDelete: {
        id: null,
        setting_id: null
      },
      loading: true,
      search: ""
    };
  },
  computed: {
    loadingCom() {
      return this.loading;
    }
  },
  methods: {
    fetchData() {
      let url = "packages";
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

    showAddItem() {
      let obj = {
        check: "add",
        showDialog: true
      };
      this.$root.$emit("change-status", obj);
    },

    settingItem(item) {
      let obj = {
        check: "setting",
        showDialog: true
      };
      this.$root.$emit("change-status", obj);
      this.$root.$emit("data-packages", item);
    },

    editItem(item) {
      let obj = {
        check: "edit",
        showDialog: true
      };

      this.$root.$emit("change-status", obj);
      this.$root.$emit("data-packages", item);
    },

    showDialog(id, setting_id) {
      this.dialog = true;
      this.itemIdToDelete.id = id;
      this.itemIdToDelete.setting_id = setting_id;
    },

    deleteItem(id, setting_id) {
      let url = "delete-package";

      let params = {
        id_packages: this.itemIdToDelete.id,
        id_setting: this.itemIdToDelete.setting_id
      };

      getWithData(url, params)
        .then(res => {
          this.loading = true;
          this.fetchData();
          this.dialog = false;
          Vue.notify({
            group: "loggedIn",
            type: "success",
            text: "Delete Item Success!"
          });
        })
        .catch(err => {
          console.log(err);
        });
    }
  },
  mounted() {
    this.$root.$on("reload-table", res => {
      this.loading = true;
      this.fetchData();
    });
  },
  created() {
    this.fetchData();
  }
};
</script>

<style lang="scss">
.h3-title-package {
  width: 200px;
}

.action-width {
  min-width: 130px;
  width: 130px;
}

.app-card-content{
  padding: 0!important;
}
</style>
