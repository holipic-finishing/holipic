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


    <v-form
      ref="form"
      lazy-validation
      class="heigth-list-title"
    >    
      <!-- Add New Coupon -->
      <v-list v-if="!itemToLoad && eventType === 'add-new'">
        <v-alert  v-model="alertStt" :type="alertType" dismissible>{{ alertMes }}</v-alert>

        <v-list-tile class="height-80">
          <v-list-tile-content class="h-100">
            <v-list-tile-title class="content-flex-end h-100">
              <span class="font-weight-bold item-title position-item">Coupon Name</span>
              <span class="contain-text-field">
                <v-text-field
                  class="font-weight-bold height-input"
                  placeholder="Enter Coupon Name"
                  v-model="itemToSave.name"
                  outline
                  :rules="[rules.required, rules.coupon_name]"
                ></v-text-field>
              </span>
            </v-list-tile-title>
          </v-list-tile-content>
        </v-list-tile>
        <v-divider class="mt-0 mb-0"></v-divider>

        <v-list-tile class="height-80">
          <v-list-tile-content class="h-100">
            <v-list-tile-title class="content-flex-end h-100">
              <span class="font-weight-bold item-title position-item">Code</span>
              <span class="contain-text-field">
                <v-text-field
                  class="font-weight-bold height-input"
                  placeholder="Enter Code"
                  v-model="itemToSave.code"
                  outline
                  :rules="[rules.required]"
                ></v-text-field>
              </span>
            </v-list-tile-title>
          </v-list-tile-content>
        </v-list-tile>
        <v-divider class="mt-0 mb-0"></v-divider>

        <v-list-tile class="height-80">
          <v-list-tile-content class="h-100">
            <v-list-tile-title class="content-flex-end h-100">
              <span class="font-weight-bold item-title position-item">Discount</span>
              <span class="contain-text-field">
                <v-text-field
                  type="number"
                  class="font-weight-bold height-input"
                  placeholder="Enter Coupon Code Name"
                  v-model="itemToSave.discount"
                  outline
                  :rules="[rules.required, rules.decimal]"
                ></v-text-field>
              </span>
            </v-list-tile-title>
          </v-list-tile-content>
        </v-list-tile>
        <v-divider class="mt-0 mb-0"></v-divider>

        <v-list-tile class="height-80">
          <v-list-tile-content class="h-100">
            <v-list-tile-title class="content-flex-end h-100">
              <span class="font-weight-bold item-title position-item">From Date</span>
              <span class="contain-text-field">
                <v-menu
                  :close-on-content-click="false"
                  v-model="menu1"
                  :nudge-right="40"
                  lazy
                  transition="scale-transition"
                  offset-y
                  full-width
                >
                  <v-text-field
                    slot="activator"
                    v-model="computedFromDateFormatted"
                    readonly
                    class="font-weight-bold height-input"
                    placeholder="Enter From Date"
                    outline
                  ></v-text-field>
                  <v-date-picker v-model="from_date" no-title  @input="menu1 = false"></v-date-picker>
                </v-menu>
              </span>
            </v-list-tile-title>
          </v-list-tile-content>
        </v-list-tile>
        <v-divider class="mt-0 mb-0"></v-divider>

        <v-list-tile class="height-80">
          <v-list-tile-content class="h-100">
            <v-list-tile-title class="content-flex-end h-100">
              <span class="font-weight-bold item-title position-item">To Date</span>
              <span class="contain-text-field">
                <v-menu
                  :close-on-content-click="false"
                  v-model="menu2"
                  :nudge-right="40"
                  lazy
                  transition="scale-transition"
                  offset-y
                  full-width
                >
                  <v-text-field
                    slot="activator"
                    v-model="computedToDateFormatted"
                    readonly
                    class="font-weight-bold height-input"
                    placeholder="Enter To Date"
                    outline
                  ></v-text-field>
                  <v-date-picker v-model="to_date" no-title  @input="menu2 = false"></v-date-picker>
                </v-menu>
              </span>
            </v-list-tile-title>
          </v-list-tile-content>
        </v-list-tile>
        <v-divider class="mt-0 mb-0"></v-divider>

        <v-list-tile>
          <v-list-tile-content>
            <v-list-tile-title class="d-flex">
              <span class="font-weight-bold item-title">Active</span>
              <span class="contain-text-field">
                <v-switch
                  v-model="itemToSave.active"
                ></v-switch>
              </span>
            </v-list-tile-title>
          </v-list-tile-content>
        </v-list-tile>
        <v-divider class="mt-0 mb-0"></v-divider>

        <v-list-tile class="height-50">
          <v-list-tile-content class="h-100 align-items-end">
            <v-list-tile-title class="d-flex h-100 align-items-center">
              <v-btn small @click="resetData">Reset</v-btn>
              <v-btn small color="success" @click="saveCoupon">Save</v-btn>
            </v-list-tile-title>
          </v-list-tile-content>
        </v-list-tile>
        <v-divider class="mt-0 mb-0"></v-divider>

      </v-list>
      <!-- End Add New Coupon -->

      <!-- Edit Coupon -->
      <v-list v-if="itemToLoad && eventType === 'edit'">
        <v-alert  v-model="alertStt" :type="alertType" dismissible>{{ alertMes }}</v-alert>

        <v-list-tile class="height-80">
          <v-list-tile-content class="h-100">
            <v-list-tile-title class="content-flex-end h-100">
              <span class="font-weight-bold item-title position-item">Coupon Name</span>
              <span class="contain-text-field">
                <v-text-field
                  class="font-weight-bold height-input"
                  placeholder="Enter Coupon Name"
                  v-model="itemToLoad.name"
                  outline
                  :rules="[rules.required, rules.coupon_name]"
                  :disabled="key == 1 ? false : true"
                  @blur="editItem('name', itemToLoad.name)"
                  @keyup.enter="editItem('name', itemToLoad.name)"
                ></v-text-field>
              </span>
              <span class="position-item">
                <v-btn flat icon @click="unDisableItem(1)"><v-icon small>fas fa-marker</v-icon></v-btn>
              </span>
            </v-list-tile-title>
          </v-list-tile-content>
        </v-list-tile>
        <v-divider class="mt-0 mb-0"></v-divider>

        <v-list-tile class="height-80">
          <v-list-tile-content class="h-100">
            <v-list-tile-title class="content-flex-end h-100">
              <span class="font-weight-bold item-title position-item">Code</span>
              <span class="contain-text-field">
                <v-text-field
                  class="font-weight-bold height-input"
                  placeholder="Enter Code"
                  v-model="itemToLoad.code"
                  outline
                  :rules="[rules.required]"
                  :disabled="key == 2 ? false : true"
                  @blur="editItem('code', itemToLoad.code)"
                  @keyup.enter="editItem('code', itemToLoad.code)"
                ></v-text-field>
              </span>
              <span class="position-item">
                <v-btn flat icon @click="unDisableItem(2)"><v-icon small>fas fa-marker</v-icon></v-btn>
              </span>
            </v-list-tile-title>
          </v-list-tile-content>
        </v-list-tile>
        <v-divider class="mt-0 mb-0"></v-divider>

        <v-list-tile class="height-80">
          <v-list-tile-content class="h-100">
            <v-list-tile-title class="content-flex-end h-100">
              <span class="font-weight-bold item-title position-item">Discount</span>
              <span class="contain-text-field">
                <v-text-field
                  type="number"
                  class="font-weight-bold height-input"
                  placeholder="Enter Coupon Code Name"
                  v-model="itemToLoad.discount"
                  outline
                  :rules="[rules.required, rules.decimal]"
                  :disabled="key == 3 ? false : true"
                  @blur="editItem('discount', itemToLoad.discount)"
                  @keyup.enter="editItem('discount', itemToLoad.discount)"
                ></v-text-field>
              </span>
              <span class="position-item">
                <v-btn flat icon @click="unDisableItem(3)"><v-icon small>fas fa-marker</v-icon></v-btn>
              </span>
            </v-list-tile-title>
          </v-list-tile-content>
        </v-list-tile>
        <v-divider class="mt-0 mb-0"></v-divider>

        <v-list-tile class="height-80">
          <v-list-tile-content class="h-100">
            <v-list-tile-title class="content-flex-end h-100">
              <span class="font-weight-bold item-title position-item">From Date</span>
              <span class="contain-text-field">
                <v-menu
                  :close-on-content-click="false"
                  v-model="menu1"
                  :nudge-right="40"
                  lazy
                  transition="scale-transition"
                  offset-y
                  full-width
                  :disabled="key == 4 ? false : true"
                >
                  <v-text-field
                    slot="activator"
                    v-model="computedFromDateFormattedEdit"
                    readonly
                    class="font-weight-bold height-input"
                    placeholder="Enter From Date"
                    outline
                    :disabled="key == 4 ? false : true"
                  ></v-text-field>
                  <v-date-picker v-model="from_date" no-title  @input="editItem('from_date', from_date)"></v-date-picker>
                </v-menu>
              </span>
              <span class="position-item">
                <v-btn flat icon @click="unDisableItem(4)"><v-icon small>fas fa-calendar-day</v-icon></v-btn>
              </span>
            </v-list-tile-title>
          </v-list-tile-content>
        </v-list-tile>
        <v-divider class="mt-0 mb-0"></v-divider>

        <v-list-tile class="height-80">
          <v-list-tile-content class="h-100">
            <v-list-tile-title class="content-flex-end h-100">
              <span class="font-weight-bold item-title position-item">To Date</span>
              <span class="contain-text-field">
                <v-menu
                  :close-on-content-click="false"
                  v-model="menu2"
                  :nudge-right="40"
                  lazy
                  transition="scale-transition"
                  offset-y
                  full-width
                  :disabled="key == 5 ? false : true"
                >
                  <v-text-field
                    slot="activator"
                    v-model="computedToDateFormattedEdit"
                    readonly
                    class="font-weight-bold height-input"
                    placeholder="Enter To Date"
                    outline
                    :disabled="key == 5 ? false : true"
                  ></v-text-field>
                  <v-date-picker v-model="to_date" no-title @input="editItem('to_date', to_date)"></v-date-picker>
                </v-menu>
              </span>
              <span class="position-item">
                <v-btn flat icon @click="unDisableItem(5)"><v-icon small>fas fa-calendar-day</v-icon></v-btn>
              </span>
            </v-list-tile-title>
          </v-list-tile-content>
        </v-list-tile>
        <v-divider class="mt-0 mb-0"></v-divider>

        <v-list-tile>
          <v-list-tile-content>
            <v-list-tile-title class="d-flex">
              <span class="font-weight-bold item-title">Active</span>
              <span class="contain-text-field">
                <v-switch
                  v-model="itemToLoad.active"
                  :disabled="key == 6 ? false : true"
                  @change="editItem('active', itemToLoad.active)"
                ></v-switch>
              </span>
              <span class="position-item">
                <v-btn flat icon @click="unDisableItem(6)"><v-icon small>fas fa-marker</v-icon></v-btn>
              </span>
            </v-list-tile-title>
          </v-list-tile-content>
        </v-list-tile>
        <v-divider class="mt-0 mb-0"></v-divider>

      </v-list>
      <!-- End Edit Coupon -->


    </v-form>

    <!-- Close drawer button -->
    <v-card-actions class="w-100 border border-left-0 border-right-0 border-bottom-0 pr-4 bottom-position flex-end">
      <v-btn @click="closeDrawer">Close</v-btn>
    </v-card-actions>
    <!-- End close drawer button -->

  </v-card>
</template>

<script>
import { post, put } from '../../api'
import config from '../../config'

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
        required: value => !!value || 'This field is required.',
      	decimal: value => {
          const pattern = /^[\d]+[\.][\d]{2}$/
          return pattern.test(value) || 'Please input discount format. E.g:1.00'
      	},
        coupon_name: value => {
          const pattern = /^[a-zA-Z]{3,}(?: [a-zA-Z]+){0,2}$/
          return pattern.test(value) || 'E.g: Example coupon'
        }
      },
      itemToSave: {
      	name: '',
      	code: '',
      	discount: 0,
      	from_date: '',
      	to_date: '',
      	active: false
      },
      menu1: false,
      menu2: false,
      from_date: new Date().toISOString().substr(0, 10),
      to_date: new Date().toISOString().substr(0, 10),
      key: 0,
    }
  },
  methods:{
    errorAlert(errorMesg){
      this.alertStt = true
      this.alertType = 'error'
      this.alertMes = errorMesg
      setTimeout(() => {this.alertStt = false}, 2000)         
    },
    successAlert(successMesg){
      this.alertStt = true
      this.alertType = 'success'
      this.alertMes = successMesg
      setTimeout(() => {this.alertStt = false}, 1000)         
    },
  	closeDrawer(){
  		this.$root.$emit('closeDrawerItem', false)
  	},
    saveCoupon(){
      if (this.$refs.form.validate()) {
        let start_day = Date.parse(this.itemToSave.from_date)
        let end_day =  Date.parse(this.itemToSave.to_date)

        if(start_day >= end_day){
          this.errorAlert('From day must before To day')
          return
        }

        if(this.itemToSave.discount > 50){
          this.errorAlert('Discount cannot be greater than 50%')
          return
        }

        let url = config.API_URL + 'coupon_codes'

        post(url,this.itemToSave)
          .then((res) => {
            if(res.data && res.data.success){
              this.successAlert('Add new coupon successfully')
              setTimeout(() => {
                this.closeDrawer()
              }, 1000)
              this.$root.$emit('reload-table')
            }
          })
          .catch((err) =>{
            console.log(err)
          })
      }
    },
    resetData () {
      this.$refs.form.reset()
      console.clear()
    },
    unDisableItem(key){
      this.key = key
    },
    validateBeforeEdit(field_name, value){
      if(field_name === 'from_date' || field_name === 'to_date'){

        if (field_name === 'from_date') {
          let start_day = Date.parse(value)
          let end_day =  Date.parse(this.itemToLoad.to_date)
          if(start_day >= end_day){
            this.errorAlert('From day must before To day')
            return false
          }
        }

        if (field_name === 'to_date') {
          let start_day = Date.parse(this.itemToLoad.from_date)
          let end_day =  Date.parse(value)
          if(start_day >= end_day){
            this.errorAlert('From day must before To day')
            return false
          }
        }
      }

      if(field_name === 'discount' && value > 50){
        this.errorAlert('Discount cannot be greater than 50%')
        return false
      }

      return true
    },
    transformer(field){
      if(field.field_name === 'from_date' || field.field_name === 'to_date'){
        let date = new Date(field.value)
        let dateFormated = this.$moment(date).format('YYYY-MM-DD')
        field.value = dateFormated
        this.menu1 = false
        this.menu2 = false
      }

      if(field.field_name === 'active'){
        if (field.value) {
          field.value = 1
        }else{
          field.value = 0
        }
      }

      return field
    },
    editItem(field_name, value){

      let validateResult = this.validateBeforeEdit(field_name, value)

      if(!validateResult){
        return
      }

      var field = {
        field_name: field_name,
        value: value
      }

      let fieldTransf = this.transformer(field)

      this.fetchData(fieldTransf)
    },
    fetchData(field){
      post(config.API_URL + 'edit/coupon-codes/' + this.itemToLoad.id, field)
      .then((res) => {
        if(res.data && res.data.success){
          this.successAlert('Update Successfully')
          this.key = 0
          this.$root.$emit('editItemSucess')
          // this.$root.$emit('closeDrawerItem', false)
        }
      })
      .catch((e) =>{
        this.errorAlert('System Error Occurred')
      })
    }
  },
  computed:{
  	itemToLoad(){
  		return this.item
  	},
  	eventTypeToLoad(){
  		return this.eventType.replace('-', ' ')
  	},
    computedFromDateFormatted(){
      if(this.from_date){
        this.itemToSave.from_date = this.from_date
      }

      var dateFormated = this.$moment(this.itemToSave.from_date).format("DD/MM/YYYY")
      return dateFormated
    },
    computedToDateFormatted(){
      if(this.to_date){
        this.itemToSave.to_date = this.to_date
      }

      var dateFormated = this.$moment(this.itemToSave.to_date).format("DD/MM/YYYY")
      return dateFormated
    },

    computedFromDateFormattedEdit(){
      if(this.from_date){
        this.item.from_date = this.from_date
      }

      var dateFormated = this.$moment(this.item.from_date).format("DD/MM/YYYY")
      return dateFormated
    },

    computedToDateFormattedEdit(){
      if(this.to_date){
        this.item.to_date = this.to_date
      }

      var dateFormated = this.$moment(this.item.to_date).format("DD/MM/YYYY")
      return dateFormated
    }
  },
  mounted(){
  	this.$root.$on('disabled-coupon-code-item', res => {
      this.key = 0
      this.from_date = ''
      this.to_date = ''
    })

    this.$root.$on('reset-form', res => {
      this.resetData()
    })
  }
};
</script>

<style lang="scss" scoped>
</style>