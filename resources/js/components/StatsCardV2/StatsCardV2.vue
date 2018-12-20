<template>
   <v-flex :class="colClasses">
      <div class="app-card" :class="customClasses">
         <v-card-text>
            <div class="layout justify-space-between pa-3">
               <div class="align-item-start">
                  <h3 class="fw-bold mb-1"><countTo :startVal='0' :endVal="amount" :duration='5000'></countTo></h3>
                  <p class="ma-0 fs-12 grey--text">{{heading}}</p>
               </div>
               <div class="align-item-end">
                  <h3 class="dash-icon"><i :class="icon"></i></h3>
               </div>
            </div>
         </v-card-text>
        <slot></slot>
      </div>
   </v-flex>
</template>
<script>
import countTo from "vue-count-to";
export default {
  props: ["heading", "amount", "colClasses", "customClasses", "icon"],
  components: {
    countTo
  }
};
</script>
<style lang="css" scoped>
.style-card-user{
  background-color:  #FFB64D !important;
}
.style-card-basic{
  background-color:  #5d91f4 !important;
}
.style-card-pro{
  background-color:  #ffb70d !important;
}
.style-card-image{
  background-color:  #FFB64D !important;
}
.grey--text {
    color: #FFFFFF !important;
    font-weight: bold;
    font-size: 15px;
}
</style>
