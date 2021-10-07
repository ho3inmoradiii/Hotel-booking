import Vue from 'vue'
import VueRouter from 'vue-router'
import Bookables from "./bookables/Bookables";
import ExampleCmp from "./components/ExampleCmp";
import SingleBookable from "./bookables/SingleBookable";
import TheReview from "./review/TheReview";

Vue.use(VueRouter)

const routes = [
    { name:'home', path: '/', component: Bookables },
    { name:'bookable', path: '/bookable/:id', component: SingleBookable, props:true },
    { name:'review', path: '/review/:id', component: TheReview },
    { name:'second', path: '/second', component: ExampleCmp },
]

const router = new VueRouter({
    mode: 'history',
    routes // short for `routes: routes`
})

export default router;


