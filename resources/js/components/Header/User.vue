<template>
   <v-menu offset-y origin="right top" left content-class="language-dropdown" transition="slide-y-transition" nudge-top="-10" class="user-block-wrap">
		<v-btn icon large slot="activator">
         <i data-v-be2d629e="" class="zmdi grey--text zmdi-account infinite wobble zmdi-hc-fw font-lg"></i>
			<!-- <img v-if="user.role_id == 1" src="/static/avatars/user-13.jpg" alt="avatar" height="40" width="40" class="img-responsive rounded-circle" />
         <img v-if="user.role_id != 1" :src="user.company_logo" alt="avatar" height="40" width="40" class="img-responsive rounded-circle" /> -->
		</v-btn>
		<div class="dropdown-content">
         <div class="dropdown-top white--text primary">
            <span class="white--text fs-14 fw-bold d-block">{{ user.full_name }}</span>
            <span class="d-block fs-12 fw-light">{{ user.email }}</span>
         </div>
         <v-list class="dropdown-list">
            <template v-for="userLink in userLinks" v-if="userLink.id !== 4">
               <v-list-tile :to="role_id == '1' ? getMenuLink(userLink.path) : getMenuLink(userLink.pathCom)" :key="userLink.id">
                  <i :class="userLink.icon"></i>
                  <span>{{$t(userLink.title)}}</span>
               </v-list-tile>
            </template>
            <template v-else>
               <v-list-tile @click="logoutUser" :key="userLink.id">
                  <i :class="userLink.icon"></i>
                  <span>{{$t(userLink.title)}}</span>
               </v-list-tile>
            </template>
         </v-list>
      </div>
	</v-menu>
</template>
<script>
   import { getCurrentAppLayout } from "../../helpers/helpers";

   export default{
      data() {
         return {
            userLinks: [
               {
                  id: 1,
                  title: 'message.userProfile',
                  icon: 'ti-user mr-3 primary--text',
                  path: '/users/user-profile',
                  pathCom: '/users/user-profile'
               },
               // {
               //    id: 2,
               //    title: 'message.inbox',
               //    icon: 'ti-email mr-3 success--text',
               //    path: '/inbox'
               // },
               // {
               //    id: 3,
               //    title: 'message.usersList',
               //    icon: 'ti-bell mr-3 info--text',
               //    path: '/users/users-list'
               // },
               {
                  id: 2,
                  title: 'message.plan',
                  icon: 'ti-book mr-3 info--text',
                  path: '/user/plans'
               },
               {
                  id: 3,
                  title: 'message.changePassword',
                  icon: 'ti-lock mr-3 info--text',
                  path: '/change-password',
                  pathCom : '/change-password'
               },
               {
                  id: 4,
                  title: 'message.logOut',
                  icon: 'ti-power-off mr-3 error--text'
               },
            ],
            user: {},
            role_id : '',
         }
      },
      methods: {
         logoutUser() {
            // this.$store.dispatch("logoutUserFromFirebase", this.$router);
            localStorage.removeItem('access_token')
            localStorage.removeItem('user')
           // this.$router.push('/session/login')
            this.$router.push('/login')
            this.$store.dispatch("logoutUserFromDatabase", this.$router);

         },
         getMenuLink(path) {
            return '/' + getCurrentAppLayout(this.$router) +  path
         }
      },
      created(){
         var userAuth = JSON.parse(localStorage.getItem('user'))
         this.role_id = userAuth.role_id
         this.user = userAuth
      }
   }
</script>
