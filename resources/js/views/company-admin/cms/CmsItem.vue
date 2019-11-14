<template>
  <v-navigation-drawer fixed v-model="drawerRight" right clipped app this.width="this.getCurrentWithContentWrap()" :width="widthComputed" temporary>
    <v-card class="h-100 position-relative">
      <v-toolbar>
        <!-- <v-toolbar-title class="text-capitalize">{{ check ? 'Add Package' : 'Update Package'}}</v-toolbar-title> -->
        <v-toolbar-title v-if="check == 'edit'" class="text-capitalize">Update Package</v-toolbar-title>
        <v-spacer></v-spacer>
        <v-toolbar-side-icon @click.stop="stopdrawerRight()">
          <v-icon>fas fa-times</v-icon>
        </v-toolbar-side-icon>
      </v-toolbar>
      <v-divider class="mt-0 mb-0"></v-divider>

      <!-- Edit package -->
      <v-form ref="form2" v-show="check == 'edit'" class="heigth-list-title">
        <v-list two-line>
          <v-alert v-model="alertStt" :type="alertType" dismissible>{{ alertMes }}</v-alert>

          <v-list-tile class="height-80">
            <v-list-tile-content class="h-100">
              <v-list-tile-title class="content-flex-end h-100">
                <span class="font-weight-bold item-title position-item">Title:</span>
                <span class="contain-text-field">
                  <v-text-field
                    placeholder="Title"
                    v-model="data.page_title"
                    :rules="[rules.required]"
                    @blur="editItem('page_title', data.page_title)"
                    @keyup.enter="editItem('page_title', data.page_title)"
                  ></v-text-field>
                </span>
              </v-list-tile-title>
            </v-list-tile-content>
          </v-list-tile>
          <v-divider class="mt-0 mb-0"></v-divider>

          <v-list-tile class="height-80">
            <v-list-tile-content class="h-100">
              <v-list-tile-title class="content-flex-end h-100">
                <span class="font-weight-bold item-title position-item">Package name:</span>
                <span class="contain-text-field">
                  <!-- <v-text-field
                    placeholder="Enter package name"
                    v-model="data.package_name"
                    :rules="[rules.required]"
                    @blur="editItem('package_name', data.package_name)"
                    @keyup.enter="editItem('package_name', data.package_name)"
                  ></v-text-field> -->
                  <ckeditor
        				    id="editor1"
        			      v-model="data.page_content"
        			      :config="config"
        			      v-validate="'required'"
        			      name="page_content"
                    @blur="editItem('page_title', data.page_content)"
                    class="style-ckeditor"
      			      >
      			     </ckeditor>
                </span>
              </v-list-tile-title>
            </v-list-tile-content>
          </v-list-tile>
          <v-divider class="mt-0 mb-0"></v-divider>

        </v-list>
      </v-form>
      <!-- End Edit Package -->
    </v-card>
  </v-navigation-drawer>
</template>

<script>
import { post, put } from "../../../api/index.js";
import Vue from "vue";
import Ckeditor from 'vue-ckeditor2';
import config from '../../../config';
import { getWithContentWrap } from "../../../helpers/helpers";

export default {
  name: 'CmsItem',
  data() {
    return {
      drawerRight: false,
      check: "",
      rules: {
        required: value => !!value || "Required."
      },
      item: {
        sms: false,
        email_service: false
      },
      alertStt: false,
      alertType: "success",
      alertMes: "",
      key: 0,
      data: {},
      width: 0,
      drawerHeaderStt: null,
      config: {
	        toolbar: [
	          ['Undo','Redo'],
	          ['Bold','Italic','Strike'],
            [ 'Link', 'Unlink', 'Anchor' ],
            [ 'Image', 'Table', 'HorizontalRule', 'SpecialChar', 'PageBreak' ],
            ['NumberedList','BulletedList'],
            ['Cut','Copy','Paste'],
            [ 'Styles', 'Format', 'Font', 'FontSize' ],
	          [ 'Maximize','Source'],
	        ],
	        height: 270,
	        width: '100%',
	    },
    };
  },
  computed: {
    widthComputed() {
      return this.width;
    }
  },
  components: { Ckeditor },
  methods: {
    getCurrentWithContentWrap() {
      return getWithContentWrap(this.drawerHeaderStt);
    },
    resetData() {
      this.$refs.form2.reset();
    },
    stopdrawerRight() {
      this.drawerRight = false;
    },
    savePackageAdd() {
      if (this.$refs.form.validate()) {
        let url = "packages";
        post(url, this.item)
          .then(res => {
            if (res && res.success) {
              setTimeout(function() {
                Vue.notify({
                  group: "loggedIn",
                  type: "success",
                  text: "Add Package Success!"
                });
              }, 500);
              this.drawerRight = false;
              this.$root.$emit("reload-table", true);
              this.item = {
                sms: false,
                email_service: false
              };
            }
          })
          .catch(err => {
            console.log(err);
          });
      }
    },
    unDisableItem(key) {
      this.key = key;
    },
    editItem(field_name, value) {
      var field = {
        field_name: field_name,
        value: value
      };

      // console.log(field.value);

      this.fetchData(field);
    },

    fetchData(field) {
      post("edit/page/" + this.data.id, field)
        .then(res => {
          console.log(res);
          if (res && res.success) {
            this.alertStt = true;
            this.alertType = "success";
            this.alertMes = "Update Successfully";
            setTimeout(() => {
              this.alertStt = false;
            }, 1500);
            this.key = 0;
            this.$root.$emit("editItemSucess");
          }
        })
        .catch(e => {
          console.log(e);
          this.alertStt = true;
          this.alertType = "error";
          this.alertMes = "System Error Occurred";
          setTimeout(() => {
            this.alertStt = false;
          }, 1500);
        });
    },

    editSetting(field_name, value) {
      var field = {
        field_name: field_name,
        value: value
      };

      // this.fetchDataSetting(field);
    },
  },
  mounted() {
    this.$root.$on("change-status", res => {
      this.drawerRight = res.showDialog;
      this.check = res.check;
      this.resetData();
      this.width = this.getCurrentWithContentWrap();
    });

    this.$root.$on("data-packages", res => {
      this.data = res;
    });
  }
};
</script>

<style lang="scss" scoped>
.text-center {
  display: block !important;
}

.style-content {
  margin: 0px !important;
}

.style-flex {
  padding: 15px 12px !important;
  font-weight: 500 !important;
}

h4 {
  padding-left: 10px;
}

.style-flex p {
  margin-bottom: 0px !important;
}

.fix-contain-text-field {
  display: block;
  right: 0px;
  position: absolute;
  width: 150px;
}

.fix-style-flex {
  float: right;
}
</style>
