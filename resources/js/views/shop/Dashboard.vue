<template>
  <v-layout align-center justify-center>
    <v-container>
      <v-layout align-center justify-center class="pb-md-5">
        <template v-for="(n, key) in items">
          <v-flex xs12 lg3 md6 sm6 :key="key">
            <v-card
              @click="showRoomLogin"
              class="m-md-3 m-sm-2 m-xs-1 elevation-2 cursor-pointer scale"
              color="#F5F5F5"
            >
              <v-card-text class="text-center">
                <v-img :src="n.src" class="d-inline-block" width="300px" />
              </v-card-text>
              <v-card-text class="text-muted text-center h2 lead">{{n.title}}</v-card-text>
            </v-card>
          </v-flex>
        </template>
      </v-layout>
    </v-container>

    <v-dialog v-model="dialog" width="400" temporary content-class="v-dialog-custom">
      <v-card class="v-card-room">
        <v-container fluid class="container-room">
          <v-layout row wrap class="v-layout-room">
            <v-flex xs12 lg12 md12 sm12 class="flex-text-room">
              <div class="text-field-room">
                <v-text-field v-model="roomNumber" label="Type here room number" required></v-text-field>
              </div>
            </v-flex>
            <v-flex xs12 lg12 md12 sm12 class="flex-number-room">
              <div class="number-circle" @click="typeNumberRoom(1)">1</div>
              <div class="number-circle" @click="typeNumberRoom(2)">2</div>
              <div class="number-circle" @click="typeNumberRoom(3)">3</div>
            </v-flex>
            <v-flex xs12 lg12 md12 sm12 class="flex-number-room">
              <div class="number-circle" @click="typeNumberRoom(4)">4</div>
              <div class="number-circle" @click="typeNumberRoom(5)">5</div>
              <div class="number-circle" @click="typeNumberRoom(6)">6</div>
            </v-flex>
            <v-flex xs12 lg12 md12 sm12 class="flex-number-room">
              <div class="number-circle" @click="typeNumberRoom(7)">7</div>
              <div class="number-circle" @click="typeNumberRoom(8)">8</div>
              <div class="number-circle" @click="typeNumberRoom(9)">9</div>
            </v-flex>
            <v-flex xs12 lg12 md12 sm12 class="flex-number-room">
              <div class="number-circle" @click="typeNumberRoom('remove')">x</div>
              <div class="number-circle" @click="typeNumberRoom(0)">0</div>
              <div class="number-circle" @click="typeNumberRoom('removeOne')">
                <i class="fas fa-arrow-left"></i>
              </div>
            </v-flex>
            <v-flex xs12 lg12 md12 sm12 class="flex-action-room">
              <v-btn color="primary" @click="loginRoom">
                ENTER &nbsp;
                <i class="fas fa-arrow-right"></i>
              </v-btn>
            </v-flex>
          </v-layout>
        </v-container>
      </v-card>
    </v-dialog>

    <div class="footer">
      <span class="span-footer">Term & Conditions</span>
      <span class="span-footer">Privacy Policy</span>
      <span class="span-footer">Refund Policy</span>
    </div>
  </v-layout>
</template>

<script>
import { get, post, put, del, getWithData } from "../../api/index.js";
import config from "../../config/index.js";

export default {
  name: "Dashboard",

  data() {
    return {
      items: [
        {
          src: "shop_selling/ICONEYE.png",
          title: "See Photos"
        },
        {
          src: "shop_selling/appointment.png",
          title: "Make Appointment"
        },
        {
          src: "shop_selling/add-photo.png",
          title: "Add Photos"
        },
        {
          src: "shop_selling/snapphoto2.png",
          title: "Snap(daily) Photos"
        }
      ],
      textChange: "",
      dialog: false,
      roomNumber: ""
    };
  },
  methods: {
    showRoomLogin() {
      this.dialog = true;
    },
    typeNumberRoom(value) {
      if (value == "remove") {
        this.roomNumber = "";
      } else if (value == "removeOne") {
        this.roomNumber = this.roomNumber.substring(
          0,
          this.roomNumber.length - 1
        );
      } else {
        this.roomNumber = this.roomNumber + value;
      }
    },
    loginRoom() {
      get("room/login?room=" + this.roomNumber)
        .then(res => {
          if (res && res.success) {
            var data = res.data;
            localStorage.setItem("roomLogin", JSON.stringify(data));
            this.$router.push({ path: "/shop/photos", params: { data: data } });
          }
        })
        .catch(err => {
          this.$notify({
            title: "Error",
            message: err.response.data.message,
            type: "error",
            duration: 2000
          });
        });
    }
  }
};
</script>

<style lang="scss" scoped>
.color-text-header {
  color: #70778f !important;
}
.footer-shop-selling {
  height: 50px;
  background-color: #5d92f4 !important;
  color: white;
}
.footer {
  position: fixed;
  left: 0;
  bottom: 0;
  width: 100%;
  height: 50px;
  background-color: #e5e5e5 !important;
  color: #70778f !important;
  text-align: center;
  padding-top: 10px !important;
}
.span-footer {
  margin: 0px 15px !important;
  padding: 15px 0px;
  font-size: 17px;
}

.scale {
  &:hover {
    transform: scale(1.05);
  }
}
</style>
<style lang="scss">
.scale {
  &:hover {
    transform: scale(1.05);
    background-color: rgba(93, 146, 244, 0.1) !important;
  }
}
</style>
