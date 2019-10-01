import {
    get,
    post
} from '../../../api'
import { listApiRequest } from './data';


const state = {
    packages: [],
}

const getters = {
    packages(state) {
        return state.packages;
    }
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
    }
}

const mutations = {
    packages(state, data) {
        state.packages = data;
    }
}

export default {
    state,
    getters,
    actions,
    mutations
}
