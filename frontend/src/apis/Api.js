import axios from "axios";

let BaseApi = axios.create({
    baseURL: "http://api.terer.tech:80/api"
});
let Api = function() {
    let token = localStorage.getItem('token');

    if(token) {
        BaseApi.defaults.headers.common["Authorization"] = `Bearer ${token}`;
    }
    return BaseApi;
}

// Api.defaults.withCredentials = true;

export default Api;