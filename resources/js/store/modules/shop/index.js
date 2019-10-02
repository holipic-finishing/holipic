import {
    get,
    post
} from '../../../api'
import {
    listApiRequest
} from './data';

const state = {
    packages: [],
    shopRooms: []
}

const actions = {
    getPackages(context, payload) {
        let path = listApiRequest.packages.path
        get(path)
            .then(res => {
                if (res && res.success) {
                    context.commit('packages', res.data)
                }
            })
            .catch(err => {
                console.log(err);
            });
    },
    photos(context, payload) {
        post('getRooms', {
            branch_id: payload
        })
        .then((res) => {
            if(res && res.success) {
                context.commit('shopRooms', res.data)
            }
        })
        .catch((err) => {
            console.log(err)
        })
    },
    viewPhotos(context, payload) {
        post('getPhotos', {
            room_hash: payload
        })
        .then((res) => {
            if(res && res.success) {
                console.log(res.data)
            }
        })
        .catch((err) => {
            console.log(err)
        })
    }
}

const mutations = {
    packages(state, data) {
        state.packages = data;
    },
    shopRooms(state, data) {
        state.shopRooms = data;
    }
}

const getters = {
    packages(state) {
        return state.packages;
    },
    shopRooms(state) {
        return state.shopRooms;
    }
}

export default {
    state,
    getters,
    actions,
    mutations
}
