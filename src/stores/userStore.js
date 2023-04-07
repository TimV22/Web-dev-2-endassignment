import {defineStore} from "pinia";
import axios from "axios";
import {scoreCounterStore} from "@/stores/scoreCounter";

export const userStore = defineStore({
    id: "login",
    state: () => ({
        id: 0,
        username: "",
        email: "",
        password: "",
        confirmPassword: "",
        token: "",
        isLoggedIn: false,
        website: "http://localhost"
    }),
    actions: {
        async login() {
            if (this.isLoggedIn) {
                alert("You are already logged in!");
                return true;
            }

            let body = JSON.stringify({
                password: this.password,
                email: this.email,
            });


            await axios.post(this.website + "/api/login", body)
                .then((response) => {
                    this.username = response.data.username;
                    this.token = response.data.jwt;
                    if (response.status === 200) {
                        this.isLoggedIn = true;
                        axios.defaults.headers.common = {'Authorization': `bearer ${this.token}`}
                    } else {
                        this.isLoggedIn = false;
                        return false;
                    }
                }).catch((error) => {
                    console.log(error);
                    return false;
                });

            const score = scoreCounterStore();

            axios.get(this.website + "/api/score")
                .then((response) => {
                    score.score = response.data.score;
                }).catch((error) => {
                console.log("Could not find score for user, creating new score");
                //create score for user
                axios.post(this.website + "/api/score", JSON.stringify({score: 18}))
                    .then((response) => {
                        return true;
                    }).catch((error) => {
                    console.log(error);
                    return false;
                });
            });
            return true;
        },
        logout() {
            const score = scoreCounterStore();
            if (this.isLoggedIn) {
                this.username = "";
                this.email = "";
                this.password = "";
                this.token = "";
                this.isLoggedIn = false;
                score.score = 18;
            } else {
                alert("You are not logged in!");
            }
        },
        register() {
            if (this.isLoggedIn) {
                alert("You are already logged in!");
                return false;
            }

            let body = JSON.stringify({
                username: this.username,
                password: this.password,
                email: this.email,
            });

            axios.post(this.website + "/api/register", body)
                .then((response) => {
                }).catch((error) => {
                console.log(error);
                return false;
            });
        }
    }
});