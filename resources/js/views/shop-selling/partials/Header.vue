<template>
	<v-toolbar dark color="primary">
    	<v-btn icon>
    		<i class="material-icons ">
				reply_all
			</i>
    	</v-btn>
    <v-spacer></v-spacer>

    <v-toolbar-items class="hidden-sm-and-down">
      	<v-btn flat @click="showPackage()">
	      	<i class="material-icons font-material-header">
				card_giftcard
			</i>
	      PACKGES
  		</v-btn>
      <v-btn flat>
      	<i class="material-icons font-material-header">
				add_a_photo
			</i>
      	ADD NEW PHOTO
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
					<v-flex xs12 sm6 md6 lg3 class="container-package-ramdom--flex">
						<div class="app-card text-xs-center">
							<div class="app-card-title primary d-custom-flex justify-space-between">
								<h3 class="mb-0 white--text">PACKAGE 1</h3>
								
							</div>
							<div class="app-full-content">
								<h2 class="font-3x">
									<span class="font-xl">2500000RP.</span>
									<sub>300000</sub>
								</h2>
								<ul class="list-unstyled list-group-flush">
									<li class="list-group-item">21 photos Print</li>
									<li class="list-group-item">Mini Album</li>
									<li class="list-group-item">21 photos on the disc</li>
									<li class="list-group-item">.....</li>
									
								</ul>
							</div>
							<div class="app-footer">
								<v-btn block color="primary" large>Buy Now</v-btn>
							</div>
						</div>
					</v-flex>
					<v-flex xs12 sm6 md6 lg3 class="container-package-ramdom--flex">
						<div class="app-card text-xs-center">
							<div class="app-card-title success white--text d-custom-flex justify-space-between">
								<h3 class="mb-0 white--text">PACKAGE 2</h3>
								
							</div>
							<div class="app-full-content">
								<h2 class="font-3x">
									<span class="font-xl">3500000RP.</span>
									<sub>450000</sub>
								</h2>
								<ul class="list-unstyled list-group-flush">
									<li class="list-group-item">30 photos Print</li>
									<li class="list-group-item">1 Photobook</li>
									<li class="list-group-item">30 photos on the disc</li>
									<li class="list-group-item">1 Poster (20x30)</li>
									<!-- <li class="list-group-item">1 GB Storage</li> -->
								</ul>
							</div>
							<div class="app-footer">
								<v-btn block color="success" large>Buy Now</v-btn>
							</div>
						</div>
					</v-flex>
					<v-flex xs12 sm6 md6 lg3 class="container-package-ramdom--flex">
						<div class="app-card text-xs-center">
							<div class="app-card-title warning white--text d-custom-flex justify-space-between">
								<h3 class="mb-0 white--text ">PACKAGE 3</h3>
								
							</div>
							<div class="app-full-content">
								<h2 class="font-3x">
									<span class="font-xl">4500000RP.</span>
									<sub>550000</sub>
								</h2>
								<ul class="list-unstyled list-group-flush">
									<li class="list-group-item">40 photos Print</li>
									<li class="list-group-item">Handmade Album</li>
									<li class="list-group-item">40 photos on the disc</li>
									<li class="list-group-item">2 Poster (20x30)</li>
									<!-- <li class="list-group-item">1 GB Storage</li> -->
								</ul>
							</div>
							<div class="app-footer">
								<v-btn block large color="warning">Buy Now</v-btn>
							</div>
						</div>
					</v-flex>
					<v-flex xs12 sm6 md6 lg3 class="container-package-ramdom--flex">
						<div class="app-card text-xs-center">
							<div class="app-card-title error white--text d-custom-flex justify-space-between">
								<h3 class="mb-0 white--text">PACKAGE 4</h3>
								
							</div>
							<div class="app-full-content">
								<h2 class="font-3x">
									<span class="font-xl">6000000RP.</span>
									<sub>750000</sub>
								</h2>
								<ul class="list-unstyled list-group-flush">
									<li class="list-group-item">50 photos Print</li>
									<li class="list-group-item">Large Albume</li>
									<li class="list-group-item">50 photos on the disc</li>
									<li class="list-group-item">2 Poster (20x30)</li>
									<!-- <li class="list-group-item">1 GB Storage</li> -->
								</ul>
							</div>
							<div class="app-footer">
								<v-btn block color="error" large>Buy Now</v-btn>
							</div>
						</div>
					</v-flex>
				</v-layout>
			</div>
		</v-container>
	</v-dialog>
  </v-toolbar>
</template>

<script>
export default {

  name: 'Header',

  data () {
    return {
    	dialog: false
    }
  },
  methods:{
  	showPackage()
  	{
  		this.dialog = true
  	}
  }
}
</script>

<style lang="css" scoped>
</style>