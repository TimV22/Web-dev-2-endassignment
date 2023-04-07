<script setup>
import {RouterLink, RouterView} from 'vue-router'
import {scoreCounterStore} from "@/stores/scoreCounter";
import {userStore} from "@/stores/userStore";

const scoreCounter = scoreCounterStore();
const users = userStore();
</script>

<template>
    <header>
        <nav class="navbar bg-body-tertiary p-3">
            <div class="container-fluid">
                <router-link to="/" class="navbar-brand">BlackJack</router-link>
                <div class="d-flex align-items-center">
                    <p class="h2">Score: {{ scoreCounter.getScore() }}</p>
                    <router-link v-if="!users.isLoggedIn" class="btn btn-outline-warning mx-3" to="/signup">Sign up</router-link>
                    <router-link v-if="!users.isLoggedIn" class="btn btn-outline-success" to="/login">Log in</router-link>
                    <button v-else class="btn btn-outline-danger mx-3" @click="users.logout()">Log out</button>
                </div>
            </div>
        </nav>
    </header>
    <router-view v-slot="{ Component }">
        <transition name="fade" mode="out-in">
            <component :is="Component" :key="$route.path"/>
        </transition>
    </router-view>
</template>

<style scoped>
.fade-enter-active, .fade-leave-active {
    transition: opacity .3s;
}

.fade-enter, .fade-leave-to {
    opacity: 0;
}

</style>
