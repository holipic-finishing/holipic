import axios from 'axios';
import config from '../config';

axios.interceptors.response.use(
    function(response) {

        if (response && response.data) {
            return response.data
        }

        return response

    },
    function(err) {
        console.log(err)
    }
);

const API_URL = config.API_URL

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
