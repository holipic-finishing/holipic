<template>
  <transition name="modal">
    <div class="vgs custom-vgs">
      <div class="wrap-fancybox">
        <button type="button" class="vgs__close" @click="close">&times;</button>
        <button type="button" class="vgs__prev" v-if="isMultiple" @click.stop="onPrev">&lsaquo;</button>
        <div class="vgs__container" v-if="images">
          <div class="vgs_image">
            <button type="button" class="vgs-check" @click="checkItem(item)">
              <i class="material-icons cursor-v-card custom-icon active-image">check_circle</i>
            </button>
            <div>
              <img class="vgs__container__img" @click.stop="onNext" :src="imageUrl" />

              <div class="vgs_thumbnail">
                <template v-for="(image, i) in changeItem">
                  <img
                    class="vgs__gallery__container__img"
                    :src="image"
                    @click.stop="onClickThumb(image, i)"
                    :key="i"
                    :id="'chooess'+image.id"
                    :class="{'border-thumbnail': image.checked == true}"
                  />
                </template>
              </div>
              <div class="vgs_slideshow">
                <i class="far fa-play-circle" style="font-size:50px;"></i>
                <span>SLIDE SHOW</span>
              </div>
            </div>
          </div>
        </div>
        <button type="button" class="vgs__next" v-if="isMultiple" @click.stop="onNext">&rsaquo;</button>
      </div>
      <!-- <div class="vgs__gallery custom-gallery" v-if="isMultiple" ref="gallery">
				<div class="vgs__gallery__title" v-if="images">{{ imgIndex + 1 }} / {{ images.length }}</div>
				<div
					class="vgs__gallery__container custom-container"
					v-if="images"
				>
					<div v-for="(image, i) in changeItem">
						<img
							class="vgs__gallery__container__img"
							:src="thumbnailDir + image.name"
							@click.stop="onClickThumb(image, i)"
							:key="i"
							:id="'chooess'+image.id"
							:class="{'vgs__gallery__container__img--active': i === imgIndex}"
						>
					</div>
				</div>
      </div>-->
    </div>
  </transition>
</template>

<script>
import config from "../../../config";
import { get, post, put, del, getWithData } from "../../../api/index.js";
export default {
  props: ["images", "index"],
  data() {
    return {
      imgIndex: "",
      image: null,
      galleryXPos: 0,
      thumbnailWidth: 120,
      selectphoto: [],
      showGallery: false,
      thumbnail: []
    };
  },
  mounted() {
    window.addEventListener("keydown", e => {
      if (e.keyCode === 37) {
        this.onPrev();
      }
      if (e.keyCode === 39) {
        this.onNext();
      }
    });

    this.$root.$on("array-photos", res => {
      this.showGallery = true;
      var vm = this;

      if (res && res.length) {
        vm.selectphoto = res;
        _.forEach(res, (value, index) => {
          _.forEach(vm.images, (v, i) => {
            if (value.image_id === v.id) {
              $(document).ready(function() {
                // $('#chooess'+v.id).css("border", "3px solid #0074f9");
              });
            }
          });
        });
      }
    });

    var roomLogin = JSON.parse(localStorage.getItem("roomLogin"));
  },
  watch: {
    index(val) {
      this.imgIndex = val;
    }
  },
  methods: {
    showThumbnail(images, imgIndex) {
      var array = [];

      var arrayExcept = [];

      _.forEach(images, (value, index) => {
        if (index > imgIndex) {
          if (array.length <= 2) {
            array.push(value);
          }
        }
        if (index != imgIndex) {
          arrayExcept.push(value);
        }
      });

      if (array.length < 3) {
        _.forEach(arrayExcept, (value, index) => {
          if (array.length < 3) {
            array.push(value);
          }
        });
      }

      return array;
    },
    close() {
      this.imgIndex = null;
      this.showGallery = false;
      this.$root.$emit("photo-chosses", this.selectphoto);
      this.$emit("close");
    },
    onPrev() {
      if (this.imgIndex === null) return;
      if (this.imgIndex > 0) {
        this.imgIndex--;
      } else {
        this.imgIndex = this.images.length - 1;
      }
      var item = this.item;
      $(".active-image").css("color", "#fff");

      if (item.checked) {
        // $('#chooess'+item.id).css("border", "3px solid #0074f9");

        $(".active-image").css("color", "#244293");
      }
      this.updateThumbails();
    },
    onNext() {
      if (this.imgIndex === null) return;

      if (this.imgIndex < this.images.length - 1) {
        this.imgIndex++;
      } else {
        this.imgIndex = 0;
      }
      var item = this.item;

      $(".active-image").css("color", "#fff");

      if (item.checked) {
        // $('#chooess'+item.id).css({"border":"3px solid #0074f9"});

        $(".active-image").css("color", "#244293");
      }
    },
    onClickThumb(image, index) {
      // this.imgIndex = index;

      $(".active-image").css("color", "#fff");

      if (image.checked) {
        $(".active-image").css("color", "#244293");
      }

      this.imgIndex = _.findIndex(this.images, function(value) {
        return value.id == image.id;
      });

      this.updateThumbails();
    },
    updateThumbails() {
      if (!this.$refs.gallery) {
        return;
      }
      const galleryWidth = this.$refs.gallery.clientWidth;

      const currThumbsWidth = this.imgIndex * this.thumbnailWidth;

      const maxThumbsWidth = this.images.length * this.thumbnailWidth;

      const centerPos =
        Math.floor(galleryWidth / (this.thumbnailWidth * 2)) *
        this.thumbnailWidth;
      // Prevent scrolling of images if not needed
      if (maxThumbsWidth < galleryWidth) {
        return;
      }
      if (currThumbsWidth < centerPos) {
        this.galleryXPos = 0;
      } else if (
        currThumbsWidth >
        this.images.length * this.thumbnailWidth - galleryWidth + centerPos
      ) {
        this.galleryXPos = -(
          this.images.length * this.thumbnailWidth -
          galleryWidth -
          20
        );
      } else {
        this.galleryXPos = -(this.imgIndex * this.thumbnailWidth) + centerPos;
      }
    },
    checkItem(item) {
      this.acctionImage(item);
    },
    acctionImage(item) {
      var photoSelected = _.find(this.selectphoto, (value, key) => {
        return value.image_id == item.id;
      });

      if (photoSelected == undefined) {
        let newItem = {
          id: item.id,
          company_package_id: null,
          image_id: item.id,
          name: item.filename,
          photo_package_id: 2,
          price: 2.0,
          quantity: 1,
          size: "DIGITAL"
        };

        this.selectphoto.push(newItem);

        this.addPhotoSelectedIntoDB(newItem);

        this.$root.$emit("updatePhoto", { data: item, checked: true });
        $("#chooess" + item.id).css({ border: "3px solid #0074f9" });
        $(".active-image").css("color", "#244293");
      } else {
        var key = _.findIndex(this.selectphoto, function(value) {
          return value.image_id == item.id;
        });

        this.selectphoto.splice(key, 1);

        this.deletePhotoUnselected(item.id);

        this.$root.$emit("updatePhoto", { data: item, checked: false });

        $("#chooess" + item.id).css({ border: "" });

        $(".active-image").css("color", "#fff");
      }
    },
    addPhotoSelectedIntoDB(photo) {
      let params = { photo };
      post(config.API_URL + "cart/add-photo", params).then(res => {});
    },
    deletePhotoUnselected(imageId) {
      del(config.API_URL + "cart/delete-photo?imageId=" + imageId).then(res => {
        console.log(res.data);
      });
    }
  },
  computed: {
    imageUrl() {
      var arr_image = this.images;
      var index_image;
      if (this.imgIndex) {
        index_image = this.imgIndex;
      } else {
        index_image = 0;
      }

      $(document).ready(function() {
        if (arr_image[index_image]["checked"]) {
          $(".active-image").css("color", "#244293");
        } else {
          $(".active-image").css("color", "#fff");
        }
      });
      return this.images[index_image];
    },
    item() {
      return this.images[this.imgIndex];
    },
    isMultiple() {
      return this.images.length > 1;
    },
    changeItem() {
      return this.thumbnail;
    },
    autoSlide() {}
  }
};
</script>

<style lang="scss">
$black-alpha-80: rgba(0, 0, 0, 0.8);
$black: #000;
$white: #fff;
$radius-medium: 8px;
$radius-large: 12px;
// Breakpoints
$screen-xs: 480px;
$screen-sm: 500px;
$screen-md: 992px;
$screen-lg: 1200px;
// So media queries don't overlap when required, provide a maximum
$screen-xs-max: ($screen-sm - 1);
$screen-sm-max: ($screen-md - 1);
$screen-md-max: ($screen-lg - 1);
@mixin respond-to($media) {
  @if $media==xs {
    @media (max-width: $screen-xs-max) {
      @content;
    }
  } @else if $media==md {
    @media (min-width: $screen-md) and (max-width: $screen-md-max) {
      @content;
    }
  } @else if $media==lg {
    @media (min-width: $screen-lg) {
      @content;
    }
  }
}
@mixin modal-base() {
  transition: opacity 0.2s ease;
  position: fixed;
  z-index: 9998;
}
@mixin modal-mask() {
  @include modal-base();
  top: 0;
  left: 0;
  width: 100%;
  min-height: 100%;
  height: 100vh;
  background-color: $black-alpha-80;
  display: table;
}
.vgs {
  @include modal-mask();
  &__close {
    color: #fff;
    position: absolute;
    top: 0;
    right: 0;
    background-color: transparent;
    border: none;
    font-size: 25px;
    width: 50px;
    height: 50px;
    cursor: pointer;
    z-index: 999;
    &:focus {
      outline: 0;
    }
  }
  &__prev,
  &__next {
    position: absolute;
    top: 50%;
    margin-top: -25px;
    width: 50px;
    height: 50px;
    z-index: 999;
    cursor: pointer;
    font-size: 40px;
    color: #fff;
    background-color: transparent;
    border: none;
    &:focus {
      outline: 0;
    }
  }
  &__prev {
    left: 0;
  }
  &__next {
    right: 0;
  }
  &__container {
    padding: 47px;
    position: absolute;
    overflow: hidden;
    cursor: pointer;
    overflow: hidden;
    width: 70%;
    margin: 0.5rem auto 0;
    left: 0.5rem;
    right: 0.5rem;

    border-radius: $radius-large;
    @include respond-to(xs) {
      width: 100%;
      max-width: 100%;
      top: 50%;
      margin-top: -140px;
      left: 0;
      right: 0;
      border-radius: 0;
      height: 280px;
    }
    &__img {
      width: 100%;
      height: 100%;
      object-fit: contain;
      border-radius: 10px;
    }
    .vgs_thumbnail {
      color: red;
      position: absolute;
      top: 10%;
      right: 5%;
      width: 250px;
      .border-thumbnail {
        border: 3px solid #00c1f8 !important;
      }
    }
    .vgs_slideshow {
      color: white;
      display: flex;
      justify-content: center;
      flex-direction: column;
      align-items: center;
    }
  }
}
.vgs__gallery {
  @include respond-to(xs) {
    display: none;
  }
  overflow-x: hidden;
  overflow-y: hidden;
  position: absolute;
  bottom: 10px;
  margin: auto;
  max-width: 100vh;
  white-space: nowrap;
  left: 0.5rem;
  right: 0.5rem;
  &__title {
    color: #000;
    margin-left: 0.5rem;
    margin-bottom: 0.5rem;
  }
  &__container {
    overflow: visible;
    display: block;
    height: 100px;
    white-space: nowrap;
    transition: all 200ms ease-in-out;
    width: 100%;
    &__img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      display: inline-block;
      float: none;
      margin: 0px 10px 20px 0px;
      cursor: pointer;
      border: 2px solid white;
      border-radius: 3px;
    }
    &__img--active {
      width: 100%;
      height: 100%;
      display: inline-block;
      float: none;
      opacity: 1;
    }
  }
}
.modal-enter {
  opacity: 0;
}
.modal-leave-active {
  opacity: 0;
}
.custom-vgs {
  display: flex;
  flex-direction: row;
  flex-wrap: nowrap;
  justify-content: space-between;
}
.wrap-fancybox {
  flex: 1 1 80%;

  padding: 0;
  position: relative;
  padding: 50px;
  display: flex;
  justify-content: center;
  align-items: center;
}
.custom-gallery {
  position: relative;
  max-width: 20%;
  flex: 1 1 20%;
  margin: 0;

  padding-top: 20px;
  overflow-y: scroll;
  position: static;
}
.custom-container {
  display: block;
  flex-wrap: wrap;
  height: auto;
  justify-content: center;
}
.vgs-check {
  color: #fff;
  position: absolute;
  top: 0;
  right: 0;
  background-color: transparent;
  border: none;
  font-size: 25px;
  width: 50px;
  height: 50px;
  cursor: pointer;
  z-index: 999;
  &:focus {
    outline: 0;
  }
}
.custom-icon {
  font-size: 40px !important;
}
@media (max-width: 499px) {
  .wrap-fancybox {
    max-width: 100%;
  }
}
.vgs_image {
  position: relative;
}
.active-chosses {
  border: 3px solid #0074f9 !important;
}
</style>
