import {defineStore} from "pinia";
import {userStore} from "@/stores/userStore";
import axios from "axios";

export const scoreCounterStore = defineStore("scoreCounter", {
    state: () => ({score: 18}),
    actions: {
        add(amount) {
            const user = userStore();
            if (user.isLoggedIn) {
                axios.put(user.website + "/api/score/add/" + amount)
                    .then((response) => {
                    }).catch((error) => {
                    console.log(error);
                });
            }
            this.score += amount;
        },
        subtract(amount) {
            const user = userStore();
            if (this.score - amount < 0) {
                alert("You don't have enough money! How did you get here? :O Here are some more coins.");
                this.score = 10;
                return;
            }
            if (user.isLoggedIn) {
                axios.put(user.website + "/api/score/subtract/" + amount)
                    .then((response) => {
                    }).catch((error) => {
                    console.log(error);
                });
            }
            this.score -= amount;
        },
        getScore() {
            return this.score;
        },
    }
});