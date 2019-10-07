import {
    get,
    post
} from '../../../api'
import {
    listApiRequest
} from './data';

const state = {
    packages: [],
    shopRooms: [],
    shopImages: [],
    photoPackages: [],
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
        post('getPhotosWithRoomHash', {
            room_hash: payload
        })
        .then((res) => {
            if(res && res.success) {
                context.commit('shopImages', res.data.images)
                context.commit('photoPackages', res.data.photo_packages)
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
    },
    shopImages(state, data) {
        state.shopImages = data;
    },
    photoPackages(state, data) {
        state.photoPackages = data;
    }
}

const getters = {
    packages(state) {
        return state.packages;
    },
    shopRooms(state) {
        return state.shopRooms;
    },
    shopImages(state) {
        return state.shopImages;
    },
    photoPackages(state) {
        return state.photoPackages;
    }
}

export default {
    state,
    getters,
    actions,
    mutations
}
