<template>
    <div class="row justify-content-center align-items-center h-100 p-5">
        <form class="login-width">
            <h1 class="text-center">Login</h1>
            <div class="mb-2">
                <label for="email">Email</label>
                <input type="email" v-model="users.email" class="form-control" :class="{ 'is-invalid': !validateEmail() }" id="email" name="email"
                       placeholder="Email" required>
            </div>
            <span v-if="!validateEmail()" class="text-danger">Please enter a valid email</span>
            <div class="mb-3">
                <label for="password">Password</label>
                <input type="password" v-model="users.password" class="form-control" id="password" name="password"
                       placeholder="Password"
                       required>
            </div>
            <div class="d-grid gap-2 mb-3">
                <button @click="login" type="button" class="btn btn-primary">Login</button>
            </div>
        </form>
    </div>
</template>

<script>
import {userStore} from "@/stores/userStore";

export default {
    name: "loginForm",
    setup() {
        const users = userStore();
        users.password = '';
        return {
            users
        }
    },
    methods: {
        validateEmail() {
            const re = /\S+@\S+\.\S+/;
            return re.test(this.users.email) || this.users.email === '';
        },
        login() {
            if (!this.users.login()) {
                alert("something went wrong trying to login")
            } else {
                this.$router.push("/")
            }
        }
    }
}
</script>

<style scoped>
.login-width {
    width: 350px;
}
</style>