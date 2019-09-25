<template>
  <v-navigation-drawer
    fixed
    v-model="drawerRight"
    right
    temporary
    app
    clipped
    :width="widthComputed"
  >
    <v-card class="h-100 position-relative">
      <v-toolbar class="mb-3">
        <v-toolbar-title class="text-capitalize">Edit Customer</v-toolbar-title>
        <v-spacer></v-spacer>
        <v-toolbar-side-icon @click="stopdrawerRight()">
          <v-icon>fas fa-times</v-icon>
        </v-toolbar-side-icon>
      </v-toolbar>

      <v-form ref="form" v-model="valid" lazy-validation>
        <v-list class="heigth-list-title">
          <v-list-tile class="height-55">
            <v-list-tile-content class="h-100">
              <v-list-tile-title class="content-flex-end h-100">
                <span class="item-title position-item">Name:</span>
                <span class="contain-text-field">
                  <v-text-field
                    class="height-input"
                    placeholder="Enter Name"
                    v-model="customer.name"
                    @blur="editCustomer('name', customer.name)"
                    @keyup.enter="editCustomer('name', customer.name)"
                  ></v-text-field>
                </span>
              </v-list-tile-title>
            </v-list-tile-content>
          </v-list-tile>
          <v-divider class="m-0"></v-divider>

          <v-list-tile class="height-55">
            <v-list-tile-content class="h-100">
              <v-list-tile-title class="content-flex-end h-100">
                <span class="item-title position-item">Email:</span>
                <span class="contain-text-field">
                  <template v-if="customer.user">
                    <v-text-field
                      class="height-input"
                      placeholder="Enter Email"
                      v-model="customer.user.email"
                      @blur="editCustomer('email', customer.user.email)"
                      @keyup.enter="editCustomer('email', customer.user.email)"
                    ></v-text-field>
                  </template>
                </span>
              </v-list-tile-title>
            </v-list-tile-content>
          </v-list-tile>
          <v-divider class="m-0"></v-divider>

          <v-list-tile class="height-55">
            <v-list-tile-content class="h-100">
              <v-list-tile-title class="content-flex-end h-100 content-image">
                <span class="item-title position-item custom-avatar">Avatar:</span>
                <span class="contain-text-field image-filed">
                  <input type="file" ref="image" accept="images/*" @change="onFilePicked($event)" />
                </span>
              </v-list-tile-title>
            </v-list-tile-content>
          </v-list-tile>

          <v-list-tile class="height-55" v-if="imageUrl">
            <v-list-tile-content class="h-100">
              <v-list-tile-title class="content-flex-end h-100">
                <span class="item-title position-item"></span>
                <span
                  class="contain-text-field text-xs-center text-sm-center text-md-center text-lg-center"
                >
                  <img :src="imageUrl" height="60" v-if="imageUrl" />
                </span>
                <span class="position-item"></span>
              </v-list-tile-title>
            </v-list-tile-content>
          </v-list-tile>
          <v-divider class="m-0"></v-divider>

          <v-list-tile class="height-55">
            <v-list-tile-content class="h-100">
              <v-list-tile-title class="content-flex-end h-100">
                <span class="item-title position-item">Address:</span>
                <span class="contain-text-field">
                  <v-text-field
                    class="height-input"
                    placeholder="Enter Address"
                    v-model="customer.address"
                    @blur="editCustomer('address', customer.address)"
                    @keyup.enter="editCustomer('address', customer.address)"
                  ></v-text-field>
                </span>
              </v-list-tile-title>
            </v-list-tile-content>
          </v-list-tile>
          <v-divider class="m-0"></v-divider>

          <v-list-tile class="height-55">
            <v-list-tile-content class="h-100">
              <v-list-tile-title class="content-flex-end h-100">
                <span class="item-title position-item">Status:</span>
                <span class="contain-text-field">
                  <v-select
                    class="height-input"
                    :items="status"
                    v-model="selectStatus"
                    @change="editCustomer('status', selectStatus)"
                  ></v-select>
                </span>
              </v-list-tile-title>
            </v-list-tile-content>
          </v-list-tile>
          <v-divider class="m-0"></v-divider>
        </v-list>
      </v-form>
    </v-card>
  </v-navigation-drawer>
</template>

<script>
import { get, post, put, del, getWithData } from "../../../api/index.js";
import { getWithContentWrap } from "../../../helpers/helpers";

export default {
  name: "CustomerEdit",

  data() {
    return {
      drawerRight: false,
      customer: [],
      rules: {
        required: value => !!value || "This field is required."
      },
      valid: true,
      alertStt: false,
      alertType: "success",
      alertMes: "",
      key: 0,
      status: ["Active", "Inactive"],
      selectStatus: "",
      imageName: "",
      imageUrl: "",
      imageFile: "",
      dialog: "",
      width: 0,
      drawerHeaderStt: null
    };
  },
  computed: {
    widthComputed() {
      return this.width;
    }
  },
  mounted() {
    this.$root.$on("drawer-status", res => {
      this.drawerHeaderStt = res;
    });

    this.$root.$on("showFormEditCustomer", res => {
      this.drawerRight = res.showNavigation;
      this.customer = res.data;
      if (res.data.status == 1) {
        this.selectStatus = "Active";
      } else {
        this.selectStatus = "Inactive";
      }
      this.width = this.getCurrentWithContentWrap();
    });
  },
  methods: {
    getCurrentWithContentWrap() {
      return getWithContentWrap(this.drawerHeaderStt);
    },
    unDisableItem(index) {
      return getWithContentWrap(this.drawerHeaderStt);
    },
    pickFile() {
      this.$refs.image.click();
    },
    onFilePicked(e) {
      e.preventDefault();
      var file = e.target.files;

      if (file[0] !== undefined) {
        this.imageName = file[0].name;
        if (this.imageName.lastIndexOf(".") <= 0) {
          return;
        }

        const fr = new FileReader();
        fr.readAsDataURL(file[0]);
        fr.addEventListener("load", () => {
          this.imageUrl = fr.result;
          this.imageFile = file[0]; // this is an image file that can be sent to server...
        });

        var fd = new FormData();
        fd.append("_method", "PATCH");
        fd.append("avatar", file[0]);

        axios
          .post("company/branches/customer/" + this.customer.id, fd)
          .then(response => {
            if (response && response.success) {
              this.alertType = "success";
              this.alertMes = response.message;
              this.$notify({
                title: "Success",
                message: this.alertMes,
                type: this.alertType,
                duration: 2000
              });
              this.key = 0;
              this.$root.$emit("reloadTableCustomer");
            }
          })
          .catch((e, value) => {
            this.alertType = "error";
            this.alertMes = "Please upload with file image";
            this.$notify({
              title: "Success",
              message: this.alertMes,
              type: this.alertType,
              duration: 2000
            });
            this.$root.$emit("reloadTableCustomer");
            this.key = 0;
          });
      } else {
        this.imageName = "";
        this.imageFile = "";
        this.imageUrl = "";
      }
    },
    checkValue() {
      if (
        this.customer.name == "" ||
        this.customer.address == "" ||
        this.customer.status == ""
      ) {
        this.alertType = "error";
        this.alertMes = "Please type text";
        this.$notify({
          title: "Error",
          message: this.alertMes,
          type: this.alertType,
          duration: 2000
        });
        this.$root.$emit("reloadTablePhotographer");
        this.key = 0;
        return false;
      }
      return true;
    },
    editCustomer(field, value) {
      let params = {};

      switch (field) {
        case "name":
          params = { name: value };
          break;
        case "email":
          params = { email: value };
          break;
        case "address":
          params = { address: value };
          break;
        case "status":
          params = { status: value };
          break;
        default:
      }

      if (this.checkValue()) {
        axios
          .patch(
            "company/branches/customer/" + this.customer.id,
            { params: params }
          )
          .then(response => {
            if (response && response.success) {
              this.alertType = "success";
              this.alertMes = response.message;
              this.$notify({
                title: "Success",
                message: this.alertMes,
                type: this.alertType,
                duration: 2000
              });
              this.key = 0;
              this.$root.$emit("reloadTableCustomer");
            }
          })
          .catch(e => {
            this.alertType = "error";
            this.alertMes = e.message;
            this.$notify({
              title: "Error",
              message: this.alertMes,
              type: this.alertType,
              duration: 2000
            });
            this.$root.$emit("reloadTableCustomer");
            this.key = 0;
          });
      }
    },
    stopdrawerRight() {
      this.drawerRight = false;
      this.key = 0;
      this.imageUrl = "";
      this.$refs.image.value = "";
    }
  },
  computed: {
    widthComputed() {
      return this.width;
    }
  }
};
</script>

<style lang="scss" scoped>
.fix-height-55 {
  height: 200px !important;
}
.image-filed {
  display: flex;
}
</style>
