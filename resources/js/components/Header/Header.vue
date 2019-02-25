<!-- Header Structure -->
<template>
	<div>
		<v-navigation-drawer
			app
			fixed
			mini-variant-width="80"
			v-if="!horizontal"
			v-model="drawer"
			class="Vuely-sidebar"
			:mini-variant.sync="collapseSidebar"
			:width="250"
			:style="{backgroundImage: 'url(' + selectedSidebarBgImage.url + ')'}"
			:class="{'background-none': !backgroundImage}"
			:right="rtlLayout"
			@input="updateDrawerHeaderStt"
		>
			<!-- App Sidebar -->
			<app-sidebar></app-sidebar>
		</v-navigation-drawer>
		<v-toolbar
			class="Vuely-toolbar"
			app
			:color="activeHeaderFilter.class"
			fixed
		>
			<div class="d-custom-flex align-items-center navbar-left">
				<div v-if="!horizontal">
					<v-toolbar-side-icon icon large @click="emitDrawer" class="v-step-0"></v-toolbar-side-icon>
				</div>
				<div class="site-logo-wrap d-custom-flex ml-0 align-items-center" v-else>
					<router-link to="/horizontal/dashboard/ecommerce" class="grayish-blue site-logo-img">
						<img src="/images/HOLIPIC-LOGO.png" alt="site logo" width="100" height="30">
					</router-link>
				</div>
			</div>
			<div class="navbar-right">
				<!-- Full screen -->
				<v-btn icon large @click="toggleFullScreen" class="full-screen ma-0">
					<v-icon color="grey">fullscreen</v-icon>
				</v-btn>
				<!-- Notifications -->
				<notifications v-show="role_id == '2' "></notifications>
				<!-- Activity Logs -->
				<activity-logs v-if="role_id == 2" v-show="role_id == '2'"></activity-logs>
				<!-- Language -->
				<language-provider></language-provider>
				<!-- User Info -->
				<v-tooltip bottom>
					<user slot="activator"></user>
					<span>Image Profile</span>
				</v-tooltip>
				<!-- E-Wallet -->
				<v-tooltip bottom>
					<v-btn v-if="role_id == 2" v-show="role_id == '2' " class="ma-0" flat @click="openEWallet" slot="activator">
						<div class="icon-ewallet">
							<v-icon color="grey">ti-wallet</v-icon>
						</div>
						<div class="v-menu v-menu--inline">
							<span class="ewallet-style">$ {{money_ewallet}}</span>
						</div>
					</v-btn>
		      <span>E-Wallet</span>
		    </v-tooltip>

			</div>
		</v-toolbar>
		<EWallet></EWallet>
	</div>
</template>

<script>
import Sidebar from "../Sidebar/Sidebar.vue";
import screenfull from "screenfull";
import LanguageProvider from "./LanguageProvider";
import Notifications from "./Notifications";
import User from "./User";
import { getCurrentAppLayout } from "../../helpers/helpers";
import { mapGetters } from "vuex";
import ActivityLogs from "./ActivityLogs.vue"
import EWallet from "./EWallet/EWallet.vue"
import config from '../../config'
import { getWithData, put, get, post } from '../../api'

export default {
	components: {
		appSidebar: Sidebar,
		LanguageProvider,
		Notifications,
		User,
		ActivityLogs,
		EWallet
	},
	props: {
		horizontal: {
			default: false,
			type: Boolean
		}
	},
	data() {
		return {
			user: JSON.parse(localStorage.getItem('user')),
			collapsed: false, // collapse sidebar
			drawer: true, // sidebar drawer default true
			chatSidebar: false, // chat component right sidebar
			sidebarImages: "", // sidebar background images
			enableDefaultSidebar: false,
			role_id: '',
			money_ewallet: 0,
		};
	},
	computed: {
		...mapGetters([
			"rtlLayout",
			"backgroundImage",
			"backgroundImage",
			"selectedSidebarBgImage",
			"darkMode",
			"collapseSidebar",
			"activeHeaderFilter"
		])
	},
	methods: {
		// toggle full screen method
		toggleFullScreen() {
			if (screenfull.enabled) {
				screenfull.toggle();
			}
		},
		toggleSearchForm() {
			// this.$store.dispatch('toggleSearchForm');
		},
		emitDrawer(){
			this.drawer = !this.drawer
			this.$root.$emit('drawer-status', this.drawer)
		},
		updateDrawerHeaderStt(){
			this.$root.$emit('drawer-status', this.drawer)
		},
		openEWallet(){
			let obj = {
  				role_id : this.role_id,
  				showDialog: true,
	  		}
			this.$root.$emit('open-EWallet', obj)
		},
		callWallet(){
	  		let url = config.API_URL + 'e-wallet/total-ewallet'
			let params = {
				company_id : this.user.company_id,
				user_id : this.user.id
			}
			getWithData(url,params)
			.then(res => {
				if(res.data){
					let data = res.data
					this.money_ewallet = data.toFixed(3)

					if(this.money_ewallet <= 0) {
			  			this.money_ewallet = 0
			  		}
				}
			})
			.catch(err => {
				console.log(err)
			})
	  	},
	},
	mounted(){
		this.$root.$emit('drawer-status', this.drawer)
	},
	created(){
        var userAuth = JSON.parse(localStorage.getItem('user'))
        this.role_id = userAuth.role_id
        this.callWallet()
    }

};
</script>
<style lang="css" scoped>
	.ewallet-style {
		font-weight: 700;
	    color: gray;
	    font-size: 16px;
	}
	.icon-ewallet {
		margin-right: 10px;
	}
</style>
