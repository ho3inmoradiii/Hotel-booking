import Vue from 'vue'
import VueRouter from 'vue-router'
import ExampleComponent from "./components/ExampleComponent";
import ExampleCmp from "./components/ExampleCmp";

Vue.use(VueRouter)

const routes = [
    { name:'home', path: '/', component: ExampleComponent },
    { name:'second', path: '/second', component: ExampleCmp },
]

const router = new VueRouter({
    mode: 'history',
    routes // short for `routes: routes`
})

export default router;


