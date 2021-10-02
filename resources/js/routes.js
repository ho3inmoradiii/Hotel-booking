import Vue from 'vue'
import VueRouter from 'vue-router'
import Bookables from "./bookables/Bookables";
import ExampleCmp from "./components/ExampleCmp";

Vue.use(VueRouter)

const routes = [
    { name:'home', path: '/', component: Bookables },
    { name:'second', path: '/second', component: ExampleCmp },
]

const router = new VueRouter({
    mode: 'history',
    routes // short for `routes: routes`
})

export default router;


