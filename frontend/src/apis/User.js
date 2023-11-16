import Api from "./Api";
import Csrf from "./Csrf";
export default {
    async register(form) {
        await Csrf.getCookie();

        return Api.post("/auth/register", form)
    },

    async  login(form) {
        await Csrf.getCookie();

        return Api.post("/auth/login", form);
    }
};