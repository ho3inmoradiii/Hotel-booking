
require('./bootstrap');

window.Vue = require('vue').default;


// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

import router from './routes';
import Index from './Index';
import StarRating from './shared/components/StarRating';
import FatalError from './shared/components/FatalError';
import ValidationErrors from './shared/components/ValidationErrors';
import TheSuccess from './shared/components/TheSuccess';
import store from './store';
import Toast from "vue-toastification";
import "vue-toastification/dist/index.css";

import VueDatePicker from '@mathieustan/vue-datepicker';
import '@mathieustan/vue-datepicker/dist/vue-datepicker.min.css';


const options = {
    position: "top-center",
    timeout: 3000,
    closeOnClick: true,
    pauseOnFocusLoss: true,
    pauseOnHover: true,
    draggable: true,
    draggablePercent: 0.6,
    showCloseButtonOnHover: false,
    hideProgressBar: true,
    closeButton: "button",
    icon: true,
    rtl: false
};


Vue.use(Toast, options);
Vue.use(VueDatePicker);
// Vue.use(VueAxios, axios)
// Vue.use(VueSocialauth, {
//
//     providers: {
//         google: {
//             clientId: '1047287869682-mbrj4fcgjmgleindrskdbo5ap8c9kpvh.apps.googleusercontent.com',
//             redirectUri: 'http://127.0.0.1:8000/api/auth/google/callback' // Your client app URL
//         }
//     }
// })



Vue.component('star-rating',StarRating);
Vue.component('fatal-error',FatalError);
Vue.component('validation-errors',ValidationErrors);
Vue.component('the-success',TheSuccess);

window.axios.interceptors.response.use(
    response => {
        return response;
    },
    error => {
        if(error.response.status === 401) {
            this.$store.dispatch("logout");
        }

        return Promise.reject(error);
    }
)

const app = new Vue({
    el: '#app',
    router,
    store,
    components:{
        index: Index,
    },
    async beforeCreate(){
        this.$store.dispatch("loadStoredState");
        this.$store.dispatch("loadUser");
    }
});
