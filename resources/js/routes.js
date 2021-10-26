import Vue from 'vue'
import VueRouter from 'vue-router'
import Bookables from "./bookables/Bookables";
import ExampleCmp from "./components/ExampleCmp";
import SingleBookable from "./bookables/SingleBookable";
import TheReview from "./review/TheReview";
import TheBasket from "./basket/TheBasket";
import TheLogin from "./auth/TheLogin";
import TheSignup from "./auth/TheSignup";
import store from "./store";
import LoginGoogle from './auth/LoginGoogle';
import Home from "./bookables/Home";

Vue.use(VueRouter)

const routes = [
    { name:'home', path: '/', component: Bookables },
    { name:'homeAfterLoginGoogle', path: '/home', component: Home },
    { name:'bookable', path: '/bookable/:id', component: SingleBookable, props:true },
    { name:'review', path: '/review/:id', component: TheReview },
    { name:'second', path: '/second', component: ExampleCmp },
    {
        name:'basket',
        path: '/basket',
        component: TheBasket,
        beforeEnter: (to, from, next) => {
            if (!store.state.isLoggedIn) next({ name: 'login' })
            else next()
        }
    },
    {
        name:'loginGoogle',
        path: '/login/google/callback',
        component: LoginGoogle,
    },
    {
        name:'login',
        path: '/auth/login',
        component: TheLogin,
        beforeEnter: (to, from, next) => {
            if (store.state.isLoggedIn){
                console.log(store.state.isLoggedIn)
                next({ name: 'home' })
                return
            }
            else{
                console.log(store.state.isLoggedIn)
                next()
            }
        }
    },
    {
        name:'register',
        path: '/auth/signup',
        component: TheSignup,
        beforeEnter: (to, from, next) => {
            if (store.state.isLoggedIn) next({ name: 'home' })
            else next()
        }
    },
    {
        path: '/auth/:provider/callback',
        component: {
            template: '<div class="auth-component"></div>'
        }
    },
]

const router = new VueRouter({
    mode: 'history',
    routes // short for `routes: routes`
})

export default router;


