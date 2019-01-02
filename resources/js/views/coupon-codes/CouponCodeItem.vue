<template>
	<v-card class="h-100 position-relative">
		<v-toolbar>
	    <v-toolbar-title class="text-capitalize">{{ eventTypeToLoad }} Coupon Code</v-toolbar-title>
	      <v-spacer></v-spacer>
	      <v-toolbar-side-icon @click="closeDrawer">
	      	<v-icon>
	          fas fa-times
	        </v-icon>
	      </v-toolbar-side-icon>
	    </v-toolbar>
	    <v-divider class="mt-0 mb-0"></v-divider>

	  <v-list v-if="itemToLoad && eventType === 'edit'" class="heigth-list-title">
      <v-alert  v-model="alertStt" :type="alertType" dismissible>{{ alertMes }}</v-alert>

    	<v-list-tile class="height-80">
        <v-list-tile-content class="h-100">
          <v-list-tile-title class="content-flex-end h-100">
            <span class="font-weight-bold item-title position-item">Coupon Name</span>
            <span class="contain-text-field">
              <v-text-field
                class="font-weight-bold height-input"
                placeholder="Enter Coupon Code Name"
                v-model="itemToSave.name"
                outline
                :rules="[rules.required]"
              ></v-text-field>
            </span>
          </v-list-tile-title>
        </v-list-tile-content>
      </v-list-tile>
      <v-divider class="mt-0 mb-0"></v-divider>
    </v-list>
	</v-card>
</template>

<script>
export default {

  name: 'CouponCodeItem',
  props: ['eventType', 'item'],

  data () {
    return {
    	alertStt: false,
      alertType: 'success',
      alertMes: '',
      key: 0,
      date: '',
      rules: {
        required: value => !!value || 'Required.',
      	decimal: value => {
          const pattern = /^[0-9]\d*(\.\d+)?$/
          return pattern.test(value) || 'Please input number.'
      	}
      },
      itemToSave: {
      	name: '',
      	code: '',
      	discount: 0,
      	from_date: '',
      	to_date: '',
      	active: false
      }
    }
  },
  methods:{
  	closeDrawer(){
  		this.$root.$emit('closeDrawerItem', false)
  	},
  },
  computed:{
  	itemToLoad(){
  		return this.item
  	},
  	eventTypeToLoad(){
  		return this.eventType.replace('-', ' ')
  	}
  },
  mounted(){
  	this.$root.$on('disabled-transaction-item', res => {
      this.key = 0
      this.date = ''
    })
  }
};
</script>

<style lang="scss" scoped>
</style>