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
            // console.log(payload.id);
            state.basket.items = state.basket.items.filter(item => item.bookable.id !== payload.id)
        },
        setBasket(state,payload){
            state.basket = payload;
        }
    },
    actions:{
        loadStoredState(context){
            const basket = localStorage.getItem('basket');
            if(basket){
                context.commit('setBasket',JSON.parse(basket));
            }
        },
        addToBasket({commit,state},payload){
            commit('addToBasket',payload);
            localStorage.setItem('basket',JSON.stringify(state.basket));
        },
        removeFromBasket({commit,state},payload){
            commit('removeFromBasket',payload);
            localStorage.setItem('basket',JSON.stringify(state.basket));
        }
    },
    getters: {
        itemsInBasket: state => {
            return state.basket.items.length
        }
    }
})

export default store;
