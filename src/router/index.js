import {createRouter, createWebHistory} from 'vue-router'
import MainView from '../views/MainView.vue'
import LoginView from "@/views/LoginView.vue";
import NotFound from "@/views/NotFound.vue";
import SignUpView from "@/views/SignUpView.vue";


const router = createRouter({
    history: createWebHistory(import.meta.env.BASE_URL),
    routes: [
        {
            path: '/',
            name: 'home',
            component: MainView
        },
        {
            path: '/login',
            name: 'login',
            component: LoginView,
            meta: { transition: 'slide-right' }
        },
        {
            path: '/signup',
            name: 'signup',
            component: SignUpView
        },
        {
            path: '/:pathMatch(.*)*',
            name: 'not-found',
            component: NotFound
        }
    ]
})

export default router
