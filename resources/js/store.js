import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);

const store = new Vuex.Store({
    state: {
        lastSearch: {
            from:null,
            to:null
        }
    },
    mutations: {
        setLastSearch(state,payload){
            state.lastSearch = payload;
        }
    }
})

export default store;
