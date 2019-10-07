<template>
  <v-layout row wrap>
    <v-container mx-auto py-0>
      <div class="cart" @click="checkout()">
        <i class="material-icons">shopping_cart</i>
        <popup-card></popup-card>
      </div>

      <v-flex xs12>
        <v-layout class="d-flex align-items-center mb-5">
          <v-flex xs2>
            <div class="ml-md-3 d-flex align-items-center">
              <span>{{$t('message.selectedPhoto')}}</span>
              <div>
                <v-btn fab dark small color="#1EC8F9" @click="removeAllItem()">
                  <v-icon dark>clear</v-icon>
                </v-btn>
                ({{countSelected}})
              </div>
              <v-icon large>keyboard_arrow_down</v-icon>
            </div>
          </v-flex>
          <v-flex xs10>
            <!-- select currency and language -->
          </v-flex>
        </v-layout>
      </v-flex>

      <v-flex xs12>
        <v-layout wrap>
          <template v-for="(photo,index) in changePhotos2">
            <v-flex
              xs12
              sm6
              md4
              lg3
              :key="index"
              class="pl-md-3 pr-md-3 pt-md-3 pl-sm-2 pr-sm-2 pt-sm-2"
            >
              <figure class="img-wrapper-1">
                <v-img
                  aspect-ratio="1.7778"
                  :src="photo"
                  :lazy-src="photo"
                  height="350"
                  class="rounded grey lighten-2"
                >
                  <div class="pt-end">
                    <v-icon color="white" large @click="removeItem(index, photo)">cancel</v-icon>
                  </div>
                  <template v-slot:placeholder>
                    <v-layout fill-height align-center justify-center ma-0>
                      <v-progress-circular indeterminate color="grey lighten-5"></v-progress-circular>
                    </v-layout>
                  </template>
                </v-img>
                <!-- <figcaption>
                  <h4>Holipic</h4>
                </figcaption>-->
              </figure>

              <!--  -->
              <v-menu
                offset-y
                transition="slide-y-transition"
                bottom
                :close-on-content-click="false"
              >
                <template slot="activator">
                  <div class="pt-select-print">
                    <v-flex xs12 class="pt-select-l1 pt-1">
                      <span class="pl-2 text-muted h4 mb-0">Select Print</span>
                      <!-- <span class="select-detail" :class="'select-detail'+photo.id">{{photo.size}}</span> -->
                      <v-icon class="pr-2">fas fa-caret-down</v-icon>
                    </v-flex>
                    <v-flex xs12>
                      <v-divider></v-divider>
                    </v-flex>
                  </div>
                </template>
                <v-list>
                  <v-list-tile
                    v-for="(item, index) in photoPackages"
                    :key="index"
                    class="pt-menu-hover-list"
                  >
                    <v-list-tile-content class="lead">{{ item.size }}</v-list-tile-content>
                    <div>
                      <v-btn flat icon>
                        <v-icon small>fas fa-minus</v-icon>
                      </v-btn>
                      <span>5</span>
                      <v-btn flat icon>
                        <v-icon small>fas fa-plus</v-icon>
                      </v-btn>
                    </div>
                  </v-list-tile>
                </v-list>
              </v-menu>
            </v-flex>
          </template>
        </v-layout>
      </v-flex>

      <v-flex xs12>
        <v-layout class="d-flex align-items-center mb-5">
          <v-flex xs2>
            <div class="ml-md-3 d-flex align-items-center">
              <span>{{$t('message.otherPhoto')}}</span>
              <v-icon large>filter</v-icon>
              <span>({{countOtherPhoto}})</span>
              <v-icon large>keyboard_arrow_down</v-icon>
            </div>
          </v-flex>
          <v-flex xs10>
            <v-divider style="border-width: 1px;"></v-divider>
          </v-flex>
        </v-layout>
      </v-flex>

      <v-flex xs12>
        <v-layout wrap>
          <template v-for="(photo,index) in shopImages">
            <v-flex
              xs12
              sm6
              md4
              lg3
              :key="index"
              class="pl-md-3 pr-md-3 pt-md-3 pl-sm-2 pr-sm-2 pt-sm-2"
            >
              <figure class="img-wrapper-2">
                <v-img
                  aspect-ratio="1.7778"
                  :src="photo"
                  :lazy-src="photo"
                  @click="selectPhoto(photo,index)"
                  height="350"
                  class="rounded grey lighten-2"
                >
                  <template v-slot:placeholder>
                    <v-layout fill-height align-center justify-center ma-0>
                      <v-progress-circular indeterminate color="grey lighten-5"></v-progress-circular>
                    </v-layout>
                  </template>
                </v-img>
                <figcaption>
                  <h4>Holipic</h4>
                </figcaption>
              </figure>

              <div class="pt-flex justify-content-between">
                <v-btn flat icon @click="showSildeWithImageId(index)" class="ml-0 mr-0">
                  <v-icon>zoom_out_map</v-icon>
                </v-btn>
                <v-btn flat icon class="ml-0 mr-0" disabled>
                  <!-- :class="'active-image'+photo.id" -->
                  <v-icon>check_circle</v-icon>
                </v-btn>
              </div>
            </v-flex>
          </template>
        </v-layout>
      </v-flex>

      <v-dialog v-model="dialog" fullscreen>
        <v-carousel
          hide-delimiters
          :cycle="slideAction"
          height="100%"
          dark
          prev-icon="fas fa-chevron-circle-left"
          next-icon="fas fa-chevron-circle-right"
          class="pt-custom-carousel"
          @click.native="click"
        >
          <v-carousel-item v-for="(item,i) in slidePhotosComputed" :key="i" @click="click">
            <v-img
              :src="item"
              :lazy-src="item"
              aspect-ratio="1.7778"
              contain
              class="reponsive-img-carousel"
              :id="`carousel-item-${i}`"
            >
              <div class="pt-pos-child" :id="`pt-img-key-${i}`">
                <template v-for="(s, key) in threePhotosComputed">
                  <v-img
                    :key="key"
                    :src="s"
                    :lazy-src="s"
                    aspect-ratio="1.7778"
                    contain
                    width="200"
                    height="150"
                    class="rounded border-white mb-2"
                  >
                    <template v-slot:placeholder>
                      <v-layout fill-height align-center justify-center ma-0>
                        <v-progress-circular indeterminate color="grey lighten-5"></v-progress-circular>
                      </v-layout>
                    </template>
                  </v-img>
                </template>
              </div>
              <v-icon
                class="position-absolute"
                large
                color="white"
                :id="`pt-icon-key-${i}`"
              >check_circle</v-icon>
              <template v-slot:placeholder>
                <v-layout fill-height align-center justify-center ma-0>
                  <v-progress-circular indeterminate color="grey lighten-5"></v-progress-circular>
                </v-layout>
              </template>
            </v-img>
            <div class="pt-slide-show">
              <div>
                <v-btn flat icon @click="slideShow">
                  <v-icon
                    large
                    color="white"
                  >far {{ slideAction ? "fa-pause-circle" : "fa-play-circle"}}</v-icon>
                </v-btn>
              </div>
              <div>
                <span class="white--text">SLIDE SHOW {{slideAction ? 'OPEN' : 'CLOSE'}}</span>
              </div>
            </div>
            <!-- <v-btn flat icon dark class="pt-close-slide"> -->
            <v-icon @click="closeSlide" color="white" large class="pt-close-slide">fas fa-times</v-icon>
            <!-- </v-btn> -->
          </v-carousel-item>
        </v-carousel>
      </v-dialog>

      <!-- <div v-if="activeGallery">
        <vue-gallery-slideshow
          :images="shopImages"
          index="5"
          @close="index = null"
        ></vue-gallery-slideshow>
      </div>-->
    </v-container>
  </v-layout>
</template>
<script>
import { mapGetters } from "vuex";
import VueGallerySlideshow from "./components/GallerySlideshow.vue";
import PopupCard from "./components/PopupCard";

export default {
  name: "ShopPhotos",

  components: {
    "popup-card": PopupCard,
    VueGallerySlideshow
  },

  data() {
    return {
      dialog: false,
      slideAction: false,
      slidePhotos: [],
      threePhotos: [],
      index: 1,
      //   currencies: ["USD"],
      //   languages: ["ENG", "EST", "RUS", "FIN"],
      //   selectCurrency: "USD",
      //   selectLanguage: "ENG",
      //   photos: [],
      //   photos2: [],
      //   dialog: false,
      //   dialog_nouse: false,
      //   dialog2: false,
      //   photoId: "",
      number: 0,
      //   typeDetail: "Select detail",
      //   count: 0,
      //   countOther: 0,
      //   photoZoom: [],
      //   thumbnailDir: config.BASE_URL + "/static/img/",
      //   activeText: true,
      photoTypes: [],
      photoOpened: null,
      //   total: 0,
      //   index: null,
      //   room: JSON.parse(localStorage.getItem("roomLogin")),
      //   packageId: ""
      activeGallery: true
    };
  },

  mounted() {
    //     console.log($(window).width());
    //     this.$i18n.locale = "en";
    //     this.$root.$on("typePackage", res => {
    //       this.checkCondition(res.name, this.count);
    //     });
    //     this.$root.$on("photo-chosses", res => {
    //       this.photos2 = res;
    //       _.forEach(res, (value, index) => {
    //         _.forEach(this.photos, (v, i) => {
    //           if (value.image_id === v.id) {
    //             $(document).ready(function() {
    //               $(".active-image" + v.id).css("color", "#00C1F8");
    //             });
    //           } else {
    //             $(".active-image" + v.id).css("color", "#464D69");
    //           }
    //         });
    //       });
    //       this.getPricePackage(this.photos2);
    //     });
    //     this.$root.$on("updatePhoto", res => {
    //       var key = _.findIndex(this.photos, function(value) {
    //         return value.id == res.data.id;
    //       });
    //       this.photos[key].checked = res.checked;
    //     });
  },
  computed: {
    ...mapGetters({
      shopImages: "shopImages",
      photoPackages: "photoPackages"
    }),
    threePhotosComputed() {
      return this.threePhotos;
    },
    slidePhotosComputed() {
      return this.slidePhotos;
    },

    //     typeDetailReturn() {
    //       return this.typeDetail;
    //     },
    countSelected() {
      //   return this.count;
      return 5;
    },
    countOtherPhoto() {
      return this.shopImages.length;
    },
    //     changePhotos() {
    //       return this.photos;
    //     },
    changePhotos2() {
      let tmp = [];
      this.shopImages.forEach((element, key) => {
        if (key < 5) tmp.push(element);
      });
      return tmp;
    }
  },
  async created() {
    let roomId = this.$route.params.roomId;
    await this.$store.dispatch("viewPhotos", roomId);

    // this.countOther = this.photos.length;

    // this.getPhotoFromRoom();
  },
  methods: {
    closeSlide() {
      this.dialog = false;
      this.slideAction = false;
    },
    slideShow() {
      this.slideAction = !this.slideAction;
    },

    removeItem(index, photo) {
      //       this.photos2.splice(index, 1);
      //       let totalNew = 0;
      //       if (this.photos2.length > 0) {
      //         this.getPricePackage(this.photos2);
      //       } else {
      //         this.total = 0;
      //       }
      //       this.count--;
      //       this.deletePhotoUnselected(photo.image_id);
      //       this.photos[index].checked = false;
      //       $(".active-image" + photo.image_id).css("color", "#464D69");
    },
    removeAllItem() {
      //       _.forEach(this.photos2, (value, index) => {
      //         this.deletePhotoUnselected(value.image_id);
      //       });
      //       this.getPhotoFromRoom();
      //       this.photos2 = [];
      //       this.count = 0;
      //       _.forEach(this.photos, (value, index) => {
      //         $(".active-image" + value.id).css("color", "#464D69");
      //       });
      //       // localStorage.setItem('photoSelected', JSON.stringify(this.photos2))
      //       this.total = 0;
    },
    showDetail(photo) {
      //       this.dialog = true;
      //       this.photoId = photo.id;
      //       this.photoOpened = photo;
      //       _.forEach(this.photoTypes, (item, index) => {
      //         if (item.size == photo.size) {
      //           this.photoTypes[index]["active"] = true;
      //         }
      //         this.photoTypes[index]["quantity"] = 1;
      //       });
    },
    activeClass(type) {
      //       this.typeDetail = type.size;
      //       _.forEach(this.photoTypes, (item, index) => {
      //         this.photoTypes[index]["active"] = false;
      //         if (item.size == type.size) {
      //           this.photoTypes[index]["active"] = true;
      //         }
      //       });
      //       this.addPhotoSelectedIntoDB(this.photoOpened);
      //       let numberActive = 0;
      //       _.forEach(this.photos2, (value, index) => {
      //         if (value["id"] == this.photoId) {
      //           this.photos2[index]["size"] = type.size;
      //           this.photoOpened = this.photos2[index];
      //           this.photoOpened.quantity = 1;
      //         }
      //         get("photo-package/search?size=" + value["size"]).then(res => {
      //           if (res && res.success) {
      //             numberActive = numberActive + value["quantity"] * res.data.dollar;
      //             this.total = numberActive;
      //           }
      //         });
      //       });
      //       this.$root.$emit("updatePopupCard", this.photos2);
    },
    increase(photoOpened, quantity) {
      //       this.photoOpened.quantity++;
      //       this.dialog = false;
      //       this.dialog = true;
      //       this.setQuantity(this.photoOpened, this.photoOpened.quantity);
      //       this.addPhotoSelectedIntoDB(this.photoOpened);
    },
    decrease() {
      //       if (this.photoOpened.quantity > 1) {
      //         this.photoOpened.quantity--;
      //         this.dialog = false;
      //         this.dialog = true;
      //         this.setQuantity(this.photoOpened, this.photoOpened.quantity);
      //         this.addPhotoSelectedIntoDB(this.photoOpened);
      //       }
    },
    selectPhoto(photo, index) {
      //       var photoSelected = _.find(this.photos2, (value, key) => {
      //         return value.image_id == photo.id;
      //       });
      //       if (photoSelected == undefined) {
      //         photo.checked = true;
      //         photo.image_id = photo.id;
      //         this.photos2.push(photo);
      //         var length = this.photos2.length;
      //         this.photos2[length - 1].size = "DIGITAL";
      //         this.photos2[length - 1].quantity = 1;
      //         $(".active-image" + photo.id).css("color", "#00C1F8");
      //         this.count++;
      //         this.getPricePackage(this.photos2);
      //         this.addPhotoSelectedIntoDB(photo);
      //       } else {
      //         var key = _.findIndex(this.photos2, function(value) {
      //           return value.image_id == photo.id;
      //         });
      //         this.photos2.splice(key, 1);
      //         photo.checked = false;
      //         this.deletePhotoUnselected(photo.id);
      //         var totalNew = 0;
      //         if (this.photos2.length > 0) {
      //           this.getPricePackage(this.photos2);
      //         } else {
      //           this.total = 0;
      //         }
      //         $(".active-image" + photo.id).css("color", "#464D69");
      //         this.count--;
      //       }
      //       // _.forEach(this.photoTypes, (item, index) => {
      //       // 	this.photoTypes[index]['quantity'] = 1
      //       // })
      //       this.$root.$emit("updatePopupCard", this.photos2);
    },
    //     addPhotoSelectedIntoDB(photo) {
    //       let params = { photo };
    //       post("cart/add-photo", params).then(res => {});
    //     },
    //     deletePhotoUnselected(imageId) {
    //       del("cart/delete-photo?imageId=" + imageId).then(res => {});
    //     },
    //     getPricePackage(photos) {
    //       var totalNew = 0;
    //       _.forEach(photos, (value, index) => {
    //         get("photo-package/search?size=" + value["size"]).then(res => {
    //           if (res && res.success) {
    //             totalNew = totalNew + value["quantity"] * res.data.dollar;
    //             this.total = totalNew;
    //           }
    //         });
    //       });
    //     },
    getIndex() {},
    async click(e) {
      if (
        e.target.className === "v-icon fas fa-chevron-circle-right theme--dark"
      ) {
        // await this.createSlideWithIndex(this.shopImages, this.index);
        // this.createSlideWithIndex(this.nextIndex);
        // this.nextIndex++;

        // let wItems = e.path[4].getElementsByClassName("v-window-item");
        // let element;
        // for (var i = 0; i < wItems.length; i++) {
        //   if ($(wItems[i]).css("display") === "block") {
        //     element = wItems[i];
        //     element = element.getElementsByClassName(
        //       "v-responsive v-image reponsive-img-carousel"
        //     );
        //     id = element[0].getAttribute("id").split("carousel-item-")[1];
        //     element = element.getElementsByClassName(
        //       "v-image__image v-image__image--contain"
        //     )[0];
        //   }
        // }

        // this.calculatePos(element, id);

        // await this.createSlideWithIndex(id);
        // wItems.forEach((e, k) => {
        //   console.log(e.style);
        // });
        // let carouselItem = document.getElementById(`carousel-item-${index}`);
        // let imgItems = carouselItem.getElementsByClassName(
        //   "v-image__image v-image__image--contain"
        // );
      }
      // console.log(e)
      // console.log(e.path[4])
      // this.showSildeWithImageId(callback)
      // console.log(callback)
      //   console.log(callback);
    },
    createSlideWithIndex(arr, index) {
      let photos = arr;
      let tmp1 = [],
        tmp2 = [];
      photos.forEach((p, key) => {
        if (key >= index) {
          tmp1.push(p);
        } else {
          tmp2.push(p);
        }
      });

      this.slidePhotos = tmp1.concat(tmp2);
      this.threePhotos = [
        photos[index + 1],
        photos[index + 2],
        photos[index + 3]
      ];
    },
    async showSildeWithImageId(index) {
      this.dialog = true;
      this.index = index
      await this.createSlideWithIndex(this.shopImages, index);
      // after load array. index begin 0
      index = 0;
      let carouselItem = document.getElementById(`carousel-item-${index}`);
      let imgItems = carouselItem.getElementsByClassName(
        "v-image__image v-image__image--contain"
      );

      this.calculatePos(imgItems[0], index);
    },
    calculatePos(mainImg, index) {
      var url = $(mainImg)
        .css("background-image")
        .replace("url(", "")
        .replace(")", "")
        .replace("'", "")
        .replace('"', "");
      url = url.split('"')[0];

      var bgImg = $("<img />");
      bgImg.hide();
      bgImg.bind("load", function() {
        var height = $(this).height();
        var width = $(this).width();

        let padding = 0;
        if ($(window).width() >= 768) {
          padding = 70 * 2;
        } else {
          padding = 30 * 2;
        }

        let widthResize = (width * ($(window).height() - padding)) / height;
        let widthFromScreenEdgeToImg = ($(window).width() - widthResize) / 2;

        let left = widthFromScreenEdgeToImg + widthResize - 200 - 20;
        let top = ($(window).height() - 150 * 3 - 8 * 3 - padding) / 2;
        let left2 = widthFromScreenEdgeToImg + widthResize - 36 - 20;
        let top2 = 20;

        $(`#pt-img-key-${index}`)
          .css("top", top)
          .css("left", left);

        $(`#pt-icon-key-${index}`)
          .css("top", top2)
          .css("left", left2);
      });
      $(mainImg).append(bgImg);
      bgImg.attr("src", url).attr("slide-img" + index);
    },
    setQuantity: _.debounce(function(photo, quantity) {
      //       let totalNew = 0;
      //       _.forEach(this.photos2, (value, index) => {
      //         if (value["id"] == photo.id) {
      //           this.photos2[index]["quantity"] = quantity;
      //         }
      //         get("photo-package/search?size=" + value["size"]).then(res => {
      //           if (res && res.success) {
      //             totalNew = totalNew + value["quantity"] * res.data.dollar;
      //             this.total = totalNew;
      //           }
      //         });
      //       });
      //       this.addPhotoSelectedIntoDB(photo);
      //       this.$root.$emit("updatePopupCard", this.photos2);
    }, 2000),
    //     changeLanguage() {
    //       if (this.selectLanguage == "EST") {
    //         this.$i18n.locale = "es";
    //       } else if (this.selectLanguage == "RUS") {
    //         this.$i18n.locale = "ru";
    //       } else if (this.selectLanguage == "FIN") {
    //         this.$i18n.locale = "fi";
    //       } else {
    //         this.$i18n.locale = "en";
    //       }
    //     },
    //     getPhotoFromRoom() {
    //       get("room/show-photo?room=" + this.room.id)
    //         .then(res => {
    //           if (res && res.success) {
    //             this.thumbnailDir = res.data[1];
    //             this.photos = res.data[0]["images"];

    //             _.forEach(this.photos, (value, index) => {
    //               if (value["image_selected"] !== null) {
    //                 this.photos2.push(value["image_selected"]);
    //               }
    //             });

    //             this.$root.$emit("updatePopupCard", this.photos2);

    //             this.count = this.photos2.length;

    //             this.countOther = this.photos.length;

    //             this.getPricePackage(this.photos2);

    //             _.forEach(this.photos2, value => {
    //               $(document).ready(function() {
    //                 $(".active-image" + value.image_id).css("color", "#00C1F8");
    //               });
    //             });
    //           }
    //         })
    //         .then(res => {
    //           this.activeGallery = true;
    //         })
    //         .catch(err => {
    //           console.log(err.response);
    //         });
    //     },
    //     checkCondition(namePackage, count) {
    //       var messagePackage = "";

    //       var packageId = "";

    //       if (namePackage == "Package 1" && count < 3) {
    //         messagePackage = "Please choose 21 image";
    //       } else if (namePackage == "Package 2" && count < 30) {
    //         messagePackage = "Please choose 30 image";
    //       } else if (namePackage == "Package 3" && count < 40) {
    //         messagePackage = "Please choose 40 image";
    //       } else if (namePackage == "Package 4" && count < 50) {
    //         messagePackage = "Please choose 50 image";
    //       }

    //       if (messagePackage != "") {
    //         this.$notify({
    //           title: "Notification",
    //           message: messagePackage,
    //           type: "error",
    //           duration: 2000
    //         });
    //       } else {
    //         switch (namePackage) {
    //           case "Package 1":
    //             this.packageId = 1;
    //             break;
    //           case "Package 2":
    //             this.packageId = 2;
    //             break;
    //           case "Package 3":
    //             this.packageId = 3;
    //             break;
    //           default:
    //             this.packageId = 4;
    //         }
    //       }
    //     },
    checkout() {
      //       localStorage.setItem("photoSelected", JSON.stringify(this.photos2));
      //       localStorage.setItem("thumbnailDir", this.thumbnailDir);
      //       if (this.photos2.length > 0) {
      //         this.$router.push("/shop-selling/confirm-booking");
      //       }
    }
  }
};
</script>

<style lang="scss" scoped>
figure {
  margin: 0 !important;
}
.pt-flex {
  display: flex;
}
.cart {
  position: fixed;
  z-index: 1;
  background-color: white !important;
  right: 50px;
  border-radius: 8px;
  box-shadow: 0 0 5px #888;
  margin: 0 auto !important;
  padding: 10px 10px 3px 11px;
  cursor: pointer;
  top: 190px;
}
.cart .detail-cart {
  display: none;
}
.cart:hover .detail-cart {
  color: #00c1f8;
  display: block;
}
.pt-end {
  display: flex;
  justify-content: flex-end;
}
.pt-select-print {
  width: 100%;
  display: flex;

  flex-wrap: wrap;
  .pt-select-l1 {
    display: flex;
    align-items: center;
    justify-content: space-between;
  }
  hr {
    margin-bottom: 0;
    border-width: 1px;
  }
}
.pt-menu-hover-list {
  &:hover {
    background-color: #f5f5f5;
  }
}
.pt-slide-show {
  display: flex;
  flex-direction: column;
  align-items: center;
}

//////////////////

.width-select {
  width: 55px !important;
}
.top-relative {
  top: 5px;
  position: relative;
}
.custom-grid-item {
  height: 300px !important;
  margin-top: 20px !important;
}
.custom-primary {
  background-color: hsla(0, 0%, 0%, 0.2) !important;
}

.footer-shop-selling {
  height: 50px;
  background-color: #5d92f4 !important;
  color: white;
}

.line-cart {
  border-right: 2px solid #00c1f8;
  padding-right: 20px;
}

.line-cart-1 {
  border-right: 2px solid #00c1f8;
  padding-right: 20px;
  margin-left: 20px;
}

.select-detail {
  margin-left: 100px;
}

.number-detail {
  float: right;
  margin-right: 100px;
}

.line-detail {
  height: 1px;
  width: 50%;
  margin: 0 auto;
  background-color: black;
}

.parent-select-detail {
  cursor: pointer;
}

.thumbnailfade-leave-active,
.thumbnailfade-enter-active {
  transition: all 0.4s ease;
}

.thumbnailfade-enter-active {
  transition-delay: 0.4s;
}

.thumbnailfade-enter,
.thumbnailfade-leave-to {
  opacity: 0;
}

.borderless td,
.borderless th {
  border: none;
}
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

<style lang="scss">
.pt-custom-carousel {
  background-color: rgba(0, 0, 0, 0.8);
  padding: 70px 0;
  .v-window__container .v-window-item {
    height: 100% !important;
  }
  .reponsive-img-carousel {
    height: 100%;
  }
  .pt-slide-show {
    position: fixed;
    bottom: 0;
    width: 100%;
  }
}
@media screen and (min-width: 576px) and (max-width: 767px) {
  .pt-custom-carousel {
    padding: 30px 0;
    background-color: rgba(0, 0, 0, 0.8);
    .v-window__container .v-window-item {
      height: 100% !important;
    }
    .reponsive-img-carousel {
      height: 100%;
    }
    .pt-slide-show {
      position: fixed;
      bottom: 0;
      width: 100%;
    }
    i {
      font-size: 30px !important;
    }
  }
}
@media screen and (min-width: 320px) and (max-width: 575px) {
  .pt-custom-carousel {
    padding: 30px 0;
    background-color: rgba(0, 0, 0, 0.8);
    .v-window__container .v-window-item {
      height: 100% !important;
    }
    .reponsive-img-carousel {
      height: 100%;
    }
    .pt-slide-show {
      position: fixed;
      bottom: 0;
      width: 100%;
    }
    i {
      font-size: 25px !important;
    }
  }
}
.pt-close-slide {
  position: fixed;
  top: 5px;
  right: 5px;
  z-index: 1;
}

.pt-pos-child {
  position: absolute;
}
</style>
