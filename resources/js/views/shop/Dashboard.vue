<template>
  <v-layout align-center justify-center>
    <v-container>
      <v-layout align-center justify-center class="p-custom">
        <template v-for="(n, key) in items">
          <v-flex xs12 lg3 md6 sm6 :key="key">
            <v-card
              @click="makeEvent(key)"
              class="m-md-3 m-sm-2 m-xs-1 elevation-2 cursor-pointer scale"
              color="#F5F5F5"
            >
              <v-card-text class="text-center">
                <v-img :src="n.src" class="d-inline-block" width="200px" />
              </v-card-text>
              <v-card-text class="font-weight-bold text-muted text-center h2 lead">{{n.title}}</v-card-text>
            </v-card>
          </v-flex>
        </template>
      </v-layout>
    </v-container>

    <v-dialog v-model="dialog" scrollable max-width="230px">
      <v-card v-if="shopRooms">
        <v-card-title class="lead border-bottom background-grey">Select Room</v-card-title>
        <v-card-text style="height: 200px;">
          <v-radio-group v-model="roomSelected" column class="mt-0 custom-radio-group">
            <template v-for="(room, key) in shopRooms">
              <v-radio
                color="#0EBFF6"
                :key="key"
                :label="`Room ${room.split('R')[1]}`"
                :value="room"
                class="custom-radio"
              ></v-radio>
            </template>
          </v-radio-group>
        </v-card-text>
        <v-card-actions class="justify-content-end">
          <v-btn color="#0EBFF6" class="font-weight-bold" flat @click="viewPhotos">View Photos</v-btn>
        </v-card-actions>
      </v-card>
      <v-card v-else>
        <v-card-text>There are currently no images to display</v-card-text>
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
import { mapGetters } from "vuex";

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
      roomNumber: "",
      roomSelected: null
    };
  },
  computed: {
    ...mapGetters({
      shopRooms: "shopRooms"
    })
  },
  methods: {
    async makeEvent(key) {
      if (key === 0) {
        let branch_id = JSON.parse(localStorage.getItem("user")).branch_id;
        await this.$store.dispatch("photos", branch_id);
        this.dialog = true;
      }
    },
    viewPhotos() {

      this.$router.push({
        name: "shop-photos",
        params: { roomId: this.roomSelected }
      });
      //   get("room/login?room=" + this.roomNumber)
      //     .then(res => {
      //       if (res && res.success) {
      //         var data = res.data;
      //         localStorage.setItem("roomLogin", JSON.stringify(data));
      //         this.$router.push({ path: "/shop/photos", params: { data: data } });
      //       }
      //     })
      //     .catch(err => {
      //       this.$notify({
      //         title: "Error",
      //         message: err.response.data.message,
      //         type: "error",
      //         duration: 2000
      //       });
      //     });
    }
  }
};
</script>

<style lang="scss" scoped>
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

@media (min-width: 768px) {
  .p-custom {
    padding-bottom: 3rem !important;
    padding-left: 10rem !important;
    padding-right: 10rem !important;
  }
}

.background-grey {
  background-color: #f5f5f5;
}
</style>
<style lang="scss">
.scale {
  &:hover {
    transform: scale(1.05);
    background-color: rgba(14, 191, 246, 0.1) !important;
  }
}

.custom-radio {
  &:hover {
    .v-label {
      color: rgba(14, 191, 246, 1) !important;
    }
  }
}
.custom-radio-group {
  .v-input__control {
    width: 100%;
  }
}
</style>
