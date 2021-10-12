import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);

const store = new Vuex.Store({
    state: {
        lastSearch: {
            from:null,
            to:null
        },
        basket:{
            items:[]
        }
    },
    mutations: {
        setLastSearch(state,payload){
            state.lastSearch = payload;
        },
        addToBasket(state,payload){
            state.basket.items.push(payload);
        },
        removeFromBasket(state,payload){
            state.basket.items = state.basket.items.filter(item => item.bookable.id !== payload)
        }
    },
    getters: {
        itemsInBasket: state => {
            return state.basket.items.length
        }
    }
})

export default store;
