/**
 * Auth Module
 */
import Vue from 'vue'
import firebase from 'firebase';
import Nprogress from 'nprogress';
import router from '../../../router';
import config from '../../../config/index.js'
// import {
//     facebookAuthProvider,
//     googleAuthProvider,
//     twitterAuthProvider,
//     githubAuthProvider
// } from '../../../firebase';
import  { post } from '../../../api/index.js'


const state = {
    user: localStorage.getItem('user'),
    isUserSigninWithAuth0: Boolean(localStorage.getItem('isUserSigninWithAuth0'))
}

// getters
const getters = {
    getUser: state => {
        return state.user;
    },
    isUserSigninWithAuth0: state => {
        return state.isUserSigninWithAuth0;
    }
}

// actions
const actions = {
    signinUserInFirebase(context, payload) {
        const { user } = payload;
        context.commit('loginUser');
        firebase.auth().signInWithEmailAndPassword(user.email, user.password)
            .then(user => {
                Nprogress.done();
                setTimeout(() => {
                    context.commit('loginUserSuccess', user);
                }, 500)
            })
            .catch(error => {
                context.commit('loginUserFailure', error);
            });
    },
    signinUserInDatabase(context, payload) {
        const { user } = payload;
        context.commit('loginUser');

        let params = {
            email: user.email,
            password: user.password
        }

        post('/auth/loginSuperAdmin',params)
        .then(res => {
           if(res && res.data.success) {

            let data = res.data.data.user
             Nprogress.done();
                setTimeout(() => {
                    context.commit('loginUserSuccess', data);
                }, 500)     
           } else {
                 setTimeout(() => {
                    context.commit('loginUserFailure', res.data);
                }, 500) 
           }
            
        })
        .catch(error => {
                context.commit('loginUserFailure', error);
        });
    },
    changePasswordUserInDatabase(context, payload) {
        context.commit('loginUser');
        let url = config.API_URL+'change-password'
        let params = {
            access_token : payload.params.access_token,
            newPassword : payload.params.newPassword,
            oldPassword : payload.params.oldPassword,
            confirmPassword : payload.params.confirmPassword,
            roleId : payload.params.role_id
        }
       
        post(url,params)
          .then((res) => {
            if(res.data && res.data.success){
                let data = res.data.message
                Nprogress.done();
                setTimeout(() => {
                    context.commit('changepasswordSuccess', data);
                }, 500)
                
             } else {
                let data = res.data.message
                context.commit('changepasswordError', data);
               
             }
          })
          .catch(err =>{
            context.commit('changepasswordError', err);
          
          })
    },
    // logoutUserFromFirebase(context) {
    //     Nprogress.start();
    //     firebase.auth().signOut()
    //         .then(() => {
    //             Nprogress.done();
    //             setTimeout(() => {
    //                 context.commit('logoutUser');
    //             }, 500)
    //         })
    //         .catch(error => {
    //             context.commit('loginUserFailure', error);
    //         })
    // },
    // signinUserWithFacebook(context) {
    //     context.commit('loginUser');
    //     firebase.auth().signInWithPopup(facebookAuthProvider).then((result) => {
    //         Nprogress.done();
    //         setTimeout(() => {
    //             context.commit('loginUserSuccess', result.user);
    //         }, 500)
    //     }).catch(error => {
    //         context.commit('loginUserFailure', error);
    //     });
    // },
    // signinUserWithGoogle(context) {
    //     context.commit('loginUser');
    //     firebase.auth().signInWithPopup(googleAuthProvider).then((result) => {
    //         Nprogress.done();
    //         setTimeout(() => {
    //             context.commit('loginUserSuccess', result.user);
    //         }, 500)
    //     }).catch(error => {
    //         context.commit('loginUserFailure', error);
    //     });
    // },
    // signinUserWithTwitter(context) {
    //     context.commit('loginUser');
    //     firebase.auth().signInWithPopup(twitterAuthProvider).then((result) => {
    //         Nprogress.done();
    //         setTimeout(() => {
    //             context.commit('loginUserSuccess', result.user);
    //         }, 500)
    //     }).catch(error => {
    //         context.commit('loginUserFailure', error);
    //     });
    // },
    // signinUserWithGithub(context) {
    //     context.commit('loginUser');
    //     firebase.auth().signInWithPopup(githubAuthProvider).then((result) => {
    //         Nprogress.done();
    //         setTimeout(() => {
    //             context.commit('loginUserSuccess', result.user);
    //         }, 500)
    //     }).catch(error => {
    //         context.commit('loginUserFailure', error);
    //     });
    // },
    signupUserInFirebase(context, payload) {
        let { userDetail } = payload;
        context.commit('signUpUser');
        firebase.auth().createUserWithEmailAndPassword(userDetail.email, userDetail.password)
            .then(() => {
                Nprogress.done();
                setTimeout(() => {
                    context.commit('signUpUserSuccess', userDetail);
                }, 500)
            })
            .catch(error => {
                context.commit('signUpUserFailure', error);
            })
    },
    signInUserWithAuth0(context, payload) {
        context.commit('signInUserWithAuth0Success', payload);
    },
    signOutUserFromAuth0(context) {
        context.commit('signOutUserFromAuth0Success');
    }
}

// mutations
const mutations = {
    loginUser(state) {
        Nprogress.start();
    },
    loginUserSuccess(state, user) {
        
        state.user = user;
        localStorage.setItem('user',JSON.stringify(user))
        state.isUserSigninWithAuth0 = false
        var access_token = user.access_token        
        localStorage.setItem('access_token',access_token)     
        router.push('/super-admin/dashboard')
        setTimeout(function(){
            Vue.notify({
                group: 'loggedIn',
                type: 'success',
                text: 'User Logged In Success!'
            });
       },1500);
    },
    loginUserFailure(state, error) {
        Nprogress.done();
        Vue.notify({
            group: 'loggedIn',
            type: 'error',
            text: error.message
        });
    },
    logoutUser(state) {
        state.user = null
        localStorage.removeItem('user');
        router.push("/login");
    },
    signUpUser(state) {
        Nprogress.start();
    },
    signUpUserSuccess(state, user) {
        state.user = localStorage.setItem('user', user);
        router.push("/super-admin/dashboard");
        Vue.notify({
            group: 'loggedIn',
            type: 'success',
            text: 'Account Created!'
        });
    },
    signUpUserFailure(state, error) {
        Nprogress.done();
         Vue.notify({
            group: 'loggedIn',
            type: 'error',
            text: error.message
        });
    },
    signInUserWithAuth0Success(state, user) {
        state.user = user;
        localStorage.setItem('user',JSON.stringify(user));
        state.isUserSigninWithAuth0 = true;
    },
    signOutUserFromAuth0Success(state) {
        state.user = null
        localStorage.removeItem('user')
    },
    changepasswordSuccess(state, success){
        Nprogress.done();
        Vue.notify({
            group: 'loggedIn',
            type: 'success',
            title: 'Message',
            text: success,
            duration: 5000
        });
         router.push('/super-admin/dashboard');
    },
     changepasswordError(state, error){
        Nprogress.done();
        Vue.notify({
            group: 'loggedIn',
            type: 'error',

            text: error
        });
    }
}

export default {
    state,
    getters,
    actions,
    mutations
}
