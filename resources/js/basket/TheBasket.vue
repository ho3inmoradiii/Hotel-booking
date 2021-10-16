<template>
    <div>
        <div class="row">
            <div class="col-md-8">
                <div class="row">
                    <div class="form-group col-md-6">
                        <label for="fName">First name</label>
                        <input id="fName" type="text" class="form-control">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="lName">Last name</label>
                        <input id="lName" type="text" class="form-control">
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-12">
                        <label for="email">Email</label>
                        <input id="email" type="email" class="form-control">
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-6">
                        <label for="city">City</label>
                        <input id="city" type="text" class="form-control">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="street">Street</label>
                        <input id="street" type="text" class="form-control">
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-12 form-group">
                        <button class="btn btn-lg btn-secondary btn-block" type="submit">Book now...</button>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="d-flex justify-content-between">
                    <h6 class="text-uppercase text-secondary font-weight-bolder">Your cart</h6>
                    <h6 class="badge badge-secondary text-uppercase">
                        <span v-if="itemsInBasket">Items: {{ itemsInBasket }}</span>
                        <span v-else>Empty</span>
                    </h6>
                </div>
                <transition-group name="fade">
                    <div v-for="item in basket" :key="item.bookable.id">
                        <div class="pt-2 pb-2 border-top d-flex justify-content-between">
                        <span>
                            <router-link :to="{name:'bookable',params:{id:item.bookable.id}}">{{ item.bookable.title }}</router-link>
                        </span>
                            <span class="font-weight-bold">
                            {{ item.price.total }}$
                        </span>
                        </div>
                        <div class="pt-2 pb-2 d-flex justify-content-between">
                        <span>
                            From: {{ item.dates.from }}
                        </span>
                            <span>
                            To: {{ item.dates.to }}
                        </span>
                        </div>
                        <div class="pt-2 pb-2 text-right">
                            <button class="btn btn-small btn-outline-secondary" @click="removeItem(item.bookable.id)">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </div>
                    </div>
                </transition-group>

            </div>
        </div>
    </div>
</template>

<script>
    import {mapGetters,mapState} from 'vuex';

    export default {
        computed:{
            ...mapGetters(['itemsInBasket']),
            ...mapState({
                basket: state => state.basket.items
            })
        },
        methods:{
            removeItem(id){
                this.$store.dispatch('removeFromBasket',{
                    id:id
                })
            }
        }
    }
</script>

<style scoped>
    h6.badge{
        font-size: 100%;
    }

    a{
        color: black;
    }
</style>
