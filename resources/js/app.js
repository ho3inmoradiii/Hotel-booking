
require('./bootstrap');

window.Vue = require('vue').default;


// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

import router from './routes';
import Index from './Index';
import StarRating from './shared/components/StarRating';
import FatalError from './shared/components/FatalError';
import ValidationErrors from './shared/components/ValidationErrors';

Vue.component('star-rating',StarRating);
Vue.component('fatal-error',FatalError);
Vue.component('validation-errors',ValidationErrors);

const app = new Vue({
    el: '#app',
    router,
    components:{
        index: Index
    }
});
