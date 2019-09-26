import router from '../../../router';
import config from '../../../config/index.js'
import {
    post,
    get
} from '../../../api/index.js'


const state = {
    user: localStorage.getItem('user'),
}

// getters
const getters = {
    getAuthUser: state => {
        return state.user;
    }
}

// actions
const actions = {
    connectionPushNotification(context, payload) {

        const {
            user
        } = payload;

        var data = {
            company_id: payload.user.company_id,
            user_id: payload.user.id,
            email: payload.user.email
        }

        OneSignal.push(function () {
            OneSignal.sendTag("user_id", JSON.stringify(data), function (tagsSent) {
                context.commit('connectiononesignal');
            });

        });
    },
}

// mutations
const mutations = {
    connectiononesignal(state) {
        OneSignal.push(function () {
            OneSignal.getTags(function (tags) {
                var data = JSON.parse(tags.user_id)
                var url = config.API_URL + 'update-onesignal-id'
                let params = {
                    email: data.email,
                    id_one_signal: localStorage.getItem('id_one_signal')
                }
                post(url, params)
                    .then(res => {

                    })
                    .catch(err => {
                        console.log(err)
                    })
            });
        });
    },
}

export default {
    state,
    getters,
    actions,
    mutations
}
