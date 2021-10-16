<template>
    <div>
        <div class="row">
            <div class="col-md-8" v-if="itemsInBasket">
                <div class="row">
                    <div class="form-group col-md-6">
                        <label for="fName">First name</label>
                        <input id="fName"
                               type="text"
                               class="form-control"
                               v-model="customer.first_name"
                               :class="[{'is-invalid':errorFor('customer.first_name')}]"
                        >
                        <validation-errors :errors="errorFor('customer.first_name')"></validation-errors>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="lName">Last name</label>
                        <input id="lName"
                               type="text"
                               class="form-control"
                               v-model="customer.last_name"
                               :class="[{'is-invalid':errorFor('customer.last_name')}]"
                        >
                        <validation-errors :errors="errorFor('customer.last_name')"></validation-errors>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-12">
                        <label for="email">Email</label>
                        <input id="email"
                               type="email"
                               class="form-control"
                               v-model="customer.email"
                               :class="[{'is-invalid':errorFor('customer.email')}]"
                        >
                        <validation-errors :errors="errorFor('customer.email')"></validation-errors>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-6">
                        <label for="city">City</label>
                        <input id="city"
                               type="text"
                               class="form-control"
                               v-model="customer.city"
                               :class="[{'is-invalid':errorFor('customer.city')}]"
                        >
                        <validation-errors :errors="errorFor('customer.city')"></validation-errors>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="street">Street</label>
                        <input id="street"
                               type="text"
                               class="form-control"
                               v-model="customer.street"
                               :class="[{'is-invalid':errorFor('customer.street')}]"
                        >
                        <validation-errors :errors="errorFor('customer.street')"></validation-errors>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-12 form-group">
                        <button class="btn btn-lg btn-secondary btn-block"
                                type="submit"
                                @click.prevent="book"
                                :disabled="loading"
                        >
                            Book now...
                        </button>
                    </div>
                </div>
            </div>
            <div v-else class="col-md-8">
                <div class="jumbotron jumbotron-fluid text-center">
                    <h1>Empty</h1>
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
    import validationErrors from './../shared/mixins/validationError';

    export default {
        mixins:[validationErrors],
        data(){
            return{
                loading:false,
                customer:{
                    first_name:null,
                    last_name:null,
                    email:null,
                    city:null,
                    street:null,
                },
                errors:null
            }
        },
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
            },
            async book(){
                this.loading = true;
                this.errors = null;
                try{
                    await axios.post(`/api/checkout`,{
                        customer:this.customer,
                        bookings:this.basket.map(basketItem => ({
                                bookable_id : basketItem.bookable.id,
                                from: basketItem.dates.from,
                                to: basketItem.dates.to,
                        }))
                    });
                    this.$store.dispatch("clearBasket");
                }catch(err){
                    this.errors = err.response && err.response.data.errors;
                }
                this.loading = false;
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
