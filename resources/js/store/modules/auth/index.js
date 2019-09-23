/**
 * Auth Module
 */
import Nprogress from 'nprogress';
import router from '../../../router';
import config from '../../../config'
import {
    post,
    get
} from '../../../api'
import {
    vp
} from '../../../helpers/vp.js'


const state = {
    user: localStorage.getItem('user'),
    hasVerifiedEmail: false
}

// getters
const getters = {
    getUser: state => {
        return state.user;
    },
    IS_VERIFIED_EMAIL(state) {
        return state.hasVerifiedEmail;
    }
}

// actions
const actions = {
    signinUser(context, payload) {
        const {
            user
        } = payload;
        context.commit('loginUser');

        let params = {
            email: user.email,
            password: user.password
        }

        post('auth/signinUser', params)
            .then(response => {
                Nprogress.done();
                if (response && response.success) {

                    var access_token = response.data.authData.token_type + ' ' + response.data.authData.access_token;
                    localStorage.setItem('access_token', access_token);
                    localStorage.setItem('user', JSON.stringify(response.data.user))
                    context.commit('loginUserSuccess', response.data.user);

                    setTimeout(() => {
                        if (!response.data.authData.hasVerifiedEmail) {
                            router.push('email/verify')
                        } else {
                            context.dispatch('pushRouteWithRole', router)
                        }
                    }, 500)
                } else {

                    setTimeout(() => {
                        context.commit('loginUserFailure', response.message);
                    }, 500)
                }

            })
            .catch(error => {
                context.commit('loginUserFailure', error);
            });
    },
    changePasswordUserInDatabase(context, payload) {
        context.commit('loginUser');
        let url = config.API_URL + 'change-password'
        let params = {
            access_token: payload.params.access_token,
            newPassword: payload.params.newPassword,
            oldPassword: payload.params.oldPassword,
            confirmPassword: payload.params.confirmPassword,
            roleId: payload.params.role_id
        }

        post(url, params)
            .then((res) => {
                if (res.data && res.data.success) {
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
            .catch(err => {
                context.commit('changepasswordError', err);

            })
    },
    editUserProfileInDatabase(context, payload) {
        context.commit('loginUser');
        let url = config.API_URL + 'edit-user-profile'
        let params = {
            id: payload.params.id,
            username: payload.params.username,
            email: payload.params.email,
        }

        post(url, params)
            .then((res) => {
                if (res.data && res.data.success) {
                    let data = res.data.message
                    Nprogress.done();
                    setTimeout(() => {
                        context.commit('editProfileSuccess', data);
                    }, 500)

                } else {
                    let data = res.data.message
                    context.commit('editProfileError', data);

                }
            })
            .catch(err => {
                context.commit('editProfileError', err);
            })
    },
    logoutUserFromDatabase(context) {
        Nprogress.start();
        let url = '/auth/logout'
        get(url)
            .then((res) => {
                Nprogress.done();
                setTimeout(() => {
                    context.commit('logoutUser');
                }, 500)
            })
            .catch(error => {
                console.log(error);
                context.commit('loginUserFailure', error);
            })
    },
    registerUser(context, payload) {

        const user = payload.userDetail;
        Nprogress.start();

        post('auth/register', user)
            .then(response => {
                Nprogress.done();
                if (response && response.success) {
                    router.push("/login")
                    setTimeout(() => {
                        vp.$notify({
                            type: 'success',
                            title: response.message,
                            duration: 3000
                        })
                    }, 1000)
                }
            })
            .catch(error => {
                Nprogress.done();
                vp.$notify({
                    type: 'error',
                    title: error.message,
                    duration: 3000
                })
            });
    },
    hasVerifiedEmail(context, payload) {
        Nprogress.start();
        axios.defaults.headers.common['Authorization'] = localStorage.getItem('access_token');
        post('email/verify')
            .then(response => {
                Nprogress.done();
                if(response && response.success) {
                    context.commit('SET_HAS_VERIFIED_EMAIL', true)
                } else {
                    context.commit('SET_HAS_VERIFIED_EMAIL', false)
                }
            })
            .catch(error => {
                console.log("System error")
            })
    },
    verifyEmail(context, payload){
        Nprogress.start();
        const url = payload.queryURL.split(config.API_URL)[1]
        post(url)
            .then(response => {
                Nprogress.done();
                if(response && response.success) {
                    context.commit('SET_HAS_VERIFIED_EMAIL', true)
                } else {
                    context.commit('SET_HAS_VERIFIED_EMAIL', false)
                }
            })
            .catch(error => {
                console.log("System error")
            })
    },
    pushRouteWithRole(context, payload) {

        var role = context.getters.getUser.role_id

        switch(role) {
            case "1":
                payload.push('/super-admin/dashboard')
                break;
            case "2":
                payload.push('/company-admin/dashboard')
                break;
            case "3":
                payload.push('/branch-admin/dashboard')
                break;
            case "4":
                router.push('/customer/show-photo')
                break;
            case "5":
                router.push('/shop-selling/dashboard')
                break;
            default:
                break;
        }
    },
    resendEmail(context, payload){
        post('email/resend')
            .then(response => {
                Nprogress.done();
                if(response && response.success) {
                    vp.$notify({
                        type: 'success',
                        title: response.message,
                        duration: 2000,
                    })
                } else {

                }
            })
            .catch(error => {
                console.log("System error")
            })
    }

    /**********************************
    signinUserWithFacebook(context) {
        //     context.commit('loginUser');
        //     firebase.auth().signInWithPopup(facebookAuthProvider).then((result) => {
        //         Nprogress.done();
        //         setTimeout(() => {
        //             context.commit('loginUserSuccess', result.user);
        //         }, 500)
        //     }).catch(error => {
        //         context.commit('loginUserFailure', error);
        //     });
    },
    signinUserWithGoogle(context) {},
    signinUserWithTwitter(context) {},
    signinUserWithGithub(context) {},
    ***********************************/
}

// mutations
const mutations = {
    loginUser(state) {
        Nprogress.start();
    },
    loginUserSuccess(state, data) {

        state.user = data;
        vp.$notify({
            type: 'success',
            title: 'Logged in successfully!',
            duration: 2000,
        })
    },
    loginUserFailure(state, error) {
        Nprogress.done();
        vp.$notify({
            type: 'error',
            title: error,
            duration: 2000,
        })
    },
    logoutUser(state) {
        state.user = null
        localStorage.removeItem('access_token')
        localStorage.removeItem('user')
        localStorage.removeItem('id_one_signal')
        router.push("/login")
    },
    changepasswordSuccess(state, success) {
        Nprogress.done();
        router.push('/super-admin/dashboard');
        vp.$notify.success({
            title: 'Success',
            message: 'Change password successfully!',
            showClose: false,
            duration: 2000,
        })
    },
    changepasswordError(state, error) {
        Nprogress.done();
        vp.$notify.error({
            title: 'Error',
            message: error,
            showClose: false,
            duration: 2000,
        })
    },
    editProfileSuccess(state, success) {
        Nprogress.done();
        router.push('/super-admin/dashboard');
        vp.$notify.success({
            title: 'Success',
            message: 'Edited profile successfully!',
            showClose: false
        })
    },
    editProfileError(state, error) {
        Nprogress.done();
        vp.$notify.error({
            title: 'Error',
            message: error,
            showClose: false,
            duration: 2000,
        })
    },
    SET_HAS_VERIFIED_EMAIL(state, data) {
        state.hasVerifiedEmail = data;
    }
}

export default {
    state,
    getters,
    actions,
    mutations
}
