<template>
	<v-toolbar dark color="primary" class="custom-toolbar">
    	<v-btn icon @click="back">
    		<i class="material-icons color-text-header">
				reply_all
			</i>
    	</v-btn>

    <v-spacer></v-spacer>

    <v-toolbar-items class="hidden-sm-and-down">
      	<v-btn flat @click="showPackage()">
	      	<i class="material-icons font-material-header">
				card_giftcard
			</i>
	     <span class="color-text-header">{{$t('message.albumPackage')}}</span>
  		</v-btn>
      <v-btn flat>
      	<i class="material-icons font-material-header">
				add_a_photo
			</i>
      	<span class="color-text-header">{{$t('message.addNewPhoto')}}</span>
      </v-btn>
    </v-toolbar-items>
    <v-dialog
	 	v-model="dialog"
		content-class="v-dialog-package"
		temporary
	>
		<v-container fluid grid-list-xl pt-0 class="container-package-ramdom">
			<div class="pricing-wrapper">
				<v-layout row wrap>
					<template v-for="value in packages">

					<v-flex xs12 sm12 md3 lg3 xl12 class="container-package-ramdom--flex" v-if="value.package_name == 'Package 1'">
						<div class="app-card text-xs-center">
							<div class="app-card-title primary d-custom-flex justify-space-between">
								<h3 class="mb-0 white--text">{{value.package_name}}</h3>
							</div>

								<div class="app-full-content" >
									<h2 class="font-3x">
										<span class="font-xl">{{value.price}}RP.</span>
										<sub>{{value.offer}}</sub>
									</h2>
									<ul class="list-unstyled list-group-flush">
										<li class="list-group-item">21 photos Print</li>
										<li class="list-group-item">Mini Album</li>
										<li class="list-group-item">21 photos on the disc</li>
										<li class="list-group-item">.....</li>
									</ul>
								</div>
								<div class="app-footer">
									<v-btn block color="primary" large @click="choosePackage(value.package_name)">{{$t('message.buyNow')}}</v-btn>
								</div>

						</div>
					</v-flex>
					<v-flex xs12 sm12 md3 lg3 xl12 class="container-package-ramdom--flex" v-else-if="value.package_name == 'Package 2'">
						<div class="app-card text-xs-center">
							<div class="app-card-title success white--text d-custom-flex justify-space-between">
								<h3 class="mb-0 white--text">{{value.package_name}}</h3>

							</div>
							<div class="app-full-content">
								<h2 class="font-3x">
									<span class="font-xl">{{value.price}}RP.</span>
									<sub>{{value.offer}}</sub>
								</h2>
								<ul class="list-unstyled list-group-flush">
									<li class="list-group-item">30 photos Print</li>
									<li class="list-group-item">1 Photobook</li>
									<li class="list-group-item">30 photos on the disc</li>
									<li class="list-group-item">1 Poster (20x30)</li>

								</ul>
							</div>
							<div class="app-footer">
								<v-btn block color="success" large @click="choosePackage(value.package_name)">{{$t('message.buyNow')}}</v-btn>
							</div>
						</div>
					</v-flex>
					<v-flex xs12 sm12 md3 lg3 xl12 class="container-package-ramdom--flex" v-else-if="value.package_name == 'Package 3'">
						<div class="app-card text-xs-center">
							<div class="app-card-title warning white--text d-custom-flex justify-space-between">
								<h3 class="mb-0 white--text ">{{value.package_name}}</h3>

							</div>
							<div class="app-full-content">
								<h2 class="font-3x">
									<span class="font-xl">{{value.price}}RP.</span>
									<sub>{{value.offer}}</sub>
								</h2>
								<ul class="list-unstyled list-group-flush">
									<li class="list-group-item">40 photos Print</li>
									<li class="list-group-item">Handmade Album</li>
									<li class="list-group-item">40 photos on the disc</li>
									<li class="list-group-item">2 Poster (20x30)</li>

								</ul>
							</div>
							<div class="app-footer">
								<v-btn block large color="warning" @click="choosePackage(value.package_name)">{{$t('message.buyNow')}}</v-btn>
							</div>
						</div>
					</v-flex>
					<v-flex xs12 sm12 md3 lg3 xl12 class="container-package-ramdom--flex" v-else>
						<div class="app-card text-xs-center">
							<div class="app-card-title error white--text d-custom-flex justify-space-between">
								<h3 class="mb-0 white--text">{{value.package_name}}</h3>

							</div>
							<div class="app-full-content">
								<h2 class="font-3x">
									<span class="font-xl">{{value.price}}RP.</span>
									<sub>{{value.offer}}</sub>
								</h2>
								<ul class="list-unstyled list-group-flush">
									<li class="list-group-item">50 photos Print</li>
									<li class="list-group-item">Large Albume</li>
									<li class="list-group-item">50 photos on the disc</li>
									<li class="list-group-item">2 Poster (20x30)</li>
								</ul>
							</div>
							<div class="app-footer">
								<v-btn block color="error" large @click="choosePackage(value.package_name)">{{$t('message.buyNow')}}</v-btn>
							</div>
						</div>
					</v-flex>
					</template>
				</v-layout>
			</div>
		</v-container>
	</v-dialog>
  </v-toolbar>
</template>

<script>
import  { get, post, put, del, getWithData } from '../../../api/index.js'

export default {

  name: 'Header',

  data () {
    return {
    	dialog: false,
    	packages :[]
    }
  },
  mounted(){
  	this.$i18n.locale = 'en';

  	this.showAllPackages()
  },
  methods:{
  	showPackage()
  	{
  		this.dialog = true
  	},
  	showAllPackages()
  	{
  		get('shop-selling/packages')
  		.then(res => {
  			if(res && res.data.success) {
  				this.packages = res.data.data
  			}
  		})
  		.catch(err => {
  			console.log(err.response)
  		})
  	},
  	choosePackage(value)
  	{
  		this.$root.$emit('typePackage',{name: value})
  	},
  	back()
  	{
  		this.$router.push('/shop-selling/dashboard')
  	}
  }
}
</script>

<style lang="scss" scoped>
.color-text-header{
	color: #70778F !important;
}
</style>
