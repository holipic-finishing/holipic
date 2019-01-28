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

				<v-btn icon large @click="toggleFullScreen" class="full-screen ma-0">
					<v-icon color="grey">fullscreen</v-icon>
				</v-btn>
				
				<notifications v-show="role_id == '2' "></notifications>
				<!-- <cart :horizontal="horizontal"></cart> -->
				<activity-logs v-if="role_id == 2" v-show="role_id == '2'"></activity-logs>
				<language-provider></language-provider>
				<user></user>
			</div>
		</v-toolbar>
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

export default {
	components: {
		appSidebar: Sidebar,
		LanguageProvider,
		Notifications,
		User,
		ActivityLogs
	},
	props: {
		horizontal: {
			default: false,
			type: Boolean
		}
	},
	data() {
		return {
			collapsed: false, // collapse sidebar
			drawer: true, // sidebar drawer default true
			chatSidebar: false, // chat component right sidebar
			sidebarImages: "", // sidebar background images
			enableDefaultSidebar: false,
			role_id:''
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
		}
	},
	mounted(){
		this.$root.$emit('drawer-status', this.drawer)
	},
	created(){
        var userAuth = JSON.parse(localStorage.getItem('user'))
        this.role_id = userAuth.role_id
    },
	
};
</script>
