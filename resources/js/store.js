import Vue from 'vue';
import Vuex from 'vuex';
import {isLoggedIn, logOut} from './shared/utils/auth';

Vue.use(Vuex);

const store = new Vuex.Store({
    state: {
        lastSearch: {
            from:null,
            to:null
        },
        basket:{
            items:[]
        },
        isLoggedIn:false,
        user:{},
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
        },
        setUser(state,payload){
            state.user = payload;
        },
        setLoggedIn(state,payload){
            state.isLoggedIn = payload;
        }
    },
    actions:{
        loadStoredState(context){
            const basket = localStorage.getItem('basket');
            if(basket){
                context.commit('setBasket',JSON.parse(basket));
            }
            context.commit('setLoggedIn',isLoggedIn());
        },
        addToBasket({commit,state},payload){
            commit('addToBasket',payload);
            localStorage.setItem('basket',JSON.stringify(state.basket));
        },
        removeFromBasket({commit,state},payload){
            commit('removeFromBasket',payload);
            localStorage.setItem('basket',JSON.stringify(state.basket));
        },
        clearBasket({commit,state},payload) {
            commit("setBasket",{items:[]});
            localStorage.setItem("basket",JSON.stringify(state.basket));
        },
        async loadUser({commit,dispatch},payload){
            if(isLoggedIn()){
                try{
                    const user = (await axios.get('/user')).data;
                    commit("setUser",user);
                    commit("setLoggedIn",true);
                }catch(err){
                    // if (err.response.status === 401){
                        dispatch("logout");
                    // }
                }
            }
        },
        logout({commit},payload) {
            commit("setUser", {});
            commit("setLoggedIn",false);
            logOut();
        }
    },
    getters: {
        itemsInBasket: state => {
            return state.basket.items.length
        }
    }
})

export default store;
