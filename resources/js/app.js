
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
        index: Index
    },
    async beforeCreate(){
        this.$store.dispatch("loadStoredState");
        this.$store.dispatch("loadUser");
    }
});
