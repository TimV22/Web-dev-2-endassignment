<template>
    <div class="row justify-content-center align-items-center h-100 p-5">
        <form class="login-width">
            <h1 class="text-center">Sign up</h1>
            <div class="mb-2">
                <label for="username">Username</label>
                <input type="text" v-model="users.username" class="form-control" :class="{ 'is-invalid': !validateUsername() }" id="username" name="username" placeholder="Username"
                       required>
            </div>
            <span v-if="!validateUsername()" class="text-danger">Username must be at least 3 characters long and contain only letters and numbers</span>
            <div class="mb-2">
                <label for="email">Email</label>
                <input type="email"  v-model="users.email" class="form-control" :class="{ 'is-invalid': !validateEmail() }" id="email" name="email" placeholder="Email" required>
            </div>
            <span v-if="!validateEmail()" class="text-danger">Please enter a valid email</span>
            <div class="mb-2">
                <label for="password">Password</label>
                <input type="password" v-model="users.password" class="form-control" :class="{ 'is-invalid': !passwordMatch() }" id="password" name="password" placeholder="Password"
                       required>
            </div>
            <div class="mb-2">
                <label for="confirm-password">Confirm password</label>
                <input type="password" v-model="users.confirmPassword" class="form-control" :class="{ 'is-invalid': !passwordMatch() }" id="confirm-password" name="password" placeholder="Password"
                       required>
            </div>
            <span v-if="!passwordMatch()" class="text-danger">Passwords do not match</span>
            <div class="d-grid gap-2 mb-3">
                <button @click="signUp" type="button" class="btn btn-primary mt-3">Sign up</button>
            </div>
        </form>
    </div>
</template>

<script>
import {userStore} from "@/stores/userStore";
export default {
    name: "signUpForm",
    setup() {
        const users = userStore();
        users.password = '';
        users.confirmPassword = '';
        return {
            users
        }
    },
    methods: {
        validateEmail() {
            const re = /\S+@\S+\.\S+/;
            return re.test(this.users.email) || this.users.email === '';
        },
        validateUsername() {
            const re = /^[a-zA-Z0-9]{3,}$/;
            return re.test(this.users.username) || this.users.username === '';
        },
        passwordMatch() {
            return this.users.password === this.users.confirmPassword;
        },
        async signUp() {
            if (this.validateEmail() && this.validateUsername() && this.passwordMatch() && this.users.username !== '' && this.users.email !== '' && this.users.password !== '' && this.users.confirmPassword !== '') {
                if (this.users.register()) {
                    alert("something went wrong trying to sign up")
                } else {
                    this.$router.push("/login")
                }
            } else {
                alert("Please fill out the form correctly");
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