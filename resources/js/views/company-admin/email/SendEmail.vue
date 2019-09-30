<template>
  <v-card class="h-100 position-relative">
    <v-toolbar>
      <v-toolbar-title class="text-capitalize">Send Email</v-toolbar-title>
      <v-spacer></v-spacer>
      <v-toolbar-side-icon @click="closeDrawer">
        <v-icon>fas fa-times</v-icon>
      </v-toolbar-side-icon>
    </v-toolbar>
    <v-divider class="mt-0 mb-0"></v-divider>

    <v-list class="heigth-list-title">
      <v-list-tile class="height-65 fix-height-80">
        <v-list-tile-content class="h-100">
          <v-list-tile-title class="content-flex-end h-100 align-items-center">
            <span class="item-title position-item">To:</span>
            <span class="contain-text-field">
              <v-checkbox
                v-model="selectEmail"
                label="Select all"
                hide-details
                class="btn-style"
                color="indigo"
                @change="onCheckboxChange"
              ></v-checkbox>
            </span>
          </v-list-tile-title>
        </v-list-tile-content>
      </v-list-tile>
      <v-divider class="mt-0 mb-0"></v-divider>

      <v-list-tile class="margin-select-email" v-if="!selectEmail">
        <v-flex xs12 sm12>
          <v-select
            v-model="value"
            :items="customers"
            chips
            label="Email customers"
            multiple
            persistent-hint
          ></v-select>
        </v-flex>
      </v-list-tile>
    </v-list>
  </v-card>
</template>

<script>
import { get, post, del, put, getWithData } from "../../../api";

export default {
  name: "SendEmail",
  props: ["item"],
  data() {
    return {
      selectEmail: true,
      drawerRight: false,
      value: [],
      customers: [],
      company: JSON.parse(localStorage.getItem("user")),
      alertStt: false,
      alertType: "success",
      alertMes: ""
    };
  },
  mounted() {
    this.getCustomers();
  },
  methods: {
    closeDrawer() {
      this.$root.$emit("closeDrawerItem", false);
      this.value = [];
      this.selectEmail = true;
    },
    getCustomers() {
      get("customer-emails/?company_id=" + this.company.company_id)
        .then(response => {
          if (response && response.success) {
            this.customers = response.data;
          }
        })
        .catch(error => {
          this.$notify({
            title: "Error",
            message: "Cannot Load Customers.",
            type: "error",
            duration: 2000
          });
        });
    },
    onCheckboxChange() {
      console.log(this.selectEmail);
    },
    sendMail() {
      let params = {};

      if (this.selectEmail) {
        params = {
          email: "all",
          templateId: this.item.id,
          companyId: this.company.company_id
        };
      } else {
        if (this.value == "") {
          this.alertType = "error";
          this.alertMes = "Please choose email customer";
          this.$notify({
            title: "Error",
            message: this.alertMes,
            type: this.alertType,
            duration: 2000
          });
          return;
        }

        params = { email: this.value, templateId: this.item.id };
      }

      getWithData("customer/send-email", params).then(
        response => {
          if (response && response.success) {
            this.alertType = "success";
            this.alertMes = "Send mail success";
            this.$notify({
              title: "Success",
              message: this.alertMes,
              type: this.alertType,
              duration: 2000
            });
          }
        }
      );
    }
  }
};
</script>

<style lang="scss" scoped>
.btn-style {
  margin-top: 0px !important;
}
.margin-select-email {
  padding-top: 40px !important;
}
</style>
