import Api from "./Api";

export default {
    register(form) {
        return Api.post("/auth/register", form)
    }
};
