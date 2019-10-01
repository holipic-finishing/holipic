<template>
  <div class="detail-cart">
    <span class="title-table">Order Detail</span>
    <table class="table table-striped borderless">
      <thead>
        <tr>
          <th>Formate</th>
          <th>Quantity</th>
          <th>Cost</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="detail in detailBooking">
          <td>{{detail.size}}</td>
          <td v-if="detail.priceNew != 0">{{detail.quantity}}</td>
          <td v-else>0</td>
          <td>{{detail.priceNew}}</td>
        </tr>
      </tbody>
    </table>
    <div class="checkout-table">
      <span>Checkout</span>
      <span>.....</span>
    </div>
  </div>
</template>

<script>
import { get, post, put, del, getWithData } from "../../../api/index.js";

export default {
  name: "PopupCard",
  data() {
    return {
      albumPhotos: "",
      detailBooking: []
    };
  },
  mounted() {
    this.$root.$on("updatePopupCard", res => {
      this.detailBooking = [];

      this.handleGroupType(res);
    });
  },
  created() {
    // this.handleGroupType(this.albumPhotos)
  },
  methods: {
    handleGroupType(photos) {
      var groupArray = _.groupBy(photos, "size");
      var quantity = 0;
      var newArray = [];

      _.forEach(groupArray, (value, index) => {
        _.forEach(value, (value2, index2) => {
          quantity += value2["quantity"];
        });

        newArray.push({ name: index, quantity: quantity });

        quantity = 0;
      });
      this.getDataPackage(newArray);
    },
    getDataPackage(array) {
      get("photo_packages")
        .then(res => {
          if (res && res.success) {
            _.forEach(res.data, (value, index) => {
              _.forEach(array, (value2, index2) => {
                if (value["size"] == value2["name"]) {
                  value["quantity"] = value2["quantity"];
                  value["priceNew"] = value2["quantity"] * value["dollar"];
                }
              });

              if (!value["priceNew"]) {
                value["priceNew"] = 0;
              }

              this.detailBooking.push(value);
            });
          }
        })
        .catch(err => {
          console.log(err.response);
        });
    }
  }
};
</script>

<style lang="scss" scoped>
.title-table {
  display: flex;
  justify-content: center;
  font-size: 20px;
  font-weight: bold;
}

table {
  width: 270px;
  margin-bottom: 0px !important;
}

.checkout-table {
  background-color: #00c1f8;
  border-bottom: 5px;
  border-radius: 0px 0px 8px 8px;
  height: 40px;
  padding: 10px 10px;
  color: white;
  display: flex;
  justify-content: space-between;
  font-weight: bold;
  font-size: 16px;
}
</style>
