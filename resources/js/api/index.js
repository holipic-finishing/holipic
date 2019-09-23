import axios from 'axios';
import config from '../config';
import router from '../router'

const API_URL = config.API_URL;
var access_token = localStorage.getItem('access_token');

axios.defaults.baseURL = API_URL;
axios.defaults.headers.common['Authorization'] = access_token;
axios.defaults.headers.post['Content-Type'] = 'application/x-www-form-urlencoded';

axios.interceptors.response.use(
    function(response) {

        if (response && response.data) {
            return response.data
        }

        return response

    },
    function(err) {

        // expired token error
        if (err && err.response && err.response.status === 401) {
            localStorage.removeItem('access_token');
            localStorage.removeItem('user');

            router.push({
                path: '/login'
            });

            return;
        }

        // validate error
        if (err && err.response && err.response.status === 422) {
            return Promise.reject(err.response.data);
        }

        return Promise.reject(err);
    }
);


export function get(url) {
    return axios({
    	method: 'GET',
    	url: API_URL + url
    })
}

export function getWithData(url, data) {
    return axios({
        method: 'GET',
        url: API_URL + url,
        params: data
    })
}

export function post(url, data) {
    return axios({
    	method: 'POST',
    	url: API_URL + url,
    	data: data
    })
}

export function put(url, data) {
    return axios({
        method: 'PUT',
        url: API_URL + url,
        data: data
    })
}

export function del(url) {
    return axios({
        method: 'DELETE',
        url: API_URL + url
    })
}
