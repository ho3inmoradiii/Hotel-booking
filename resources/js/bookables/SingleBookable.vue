<template>
    <section>
        <div v-if="!bookable">
            Data is loading...
        </div>
        <div class="row">
            <div class="col-md-8 pb-4">
                <div class="card" v-if="bookable">
                    <div class="card-body">
                        <h5 class="card-title">{{ bookable.title }}</h5>
                        <hr />
                        <p class="card-text">{{ bookable.description }}</p>
                    </div>
                </div>
                <review-list></review-list>
            </div>
            <div class="col-md-4">
                <availability @availability="checkPrice($event)" class="mb-4"></availability>
                <transition name="fade">
                    <price-breakdown v-if="price" :price="price" class="mb-4"></price-breakdown>
                </transition>
                <transition name="fade">
                    <button class="btn btn-outline-secondary btn-block"
                            v-if="price && bookable"
                            @click="addToBasket"
                            :disabled="inBasketAlready"
                    >
                        Book now
                    </button>
                </transition>
                <div v-if="bookable">
                    <button class="btn btn-secondary btn-block mt-4"
                            v-if="inBasketAlready"
                            @click="removeFromBasket"
                    >
                        Remove
                    </button>
                </div>
                <div v-if="bookable">
                    <div v-if="inBasketAlready" class="mt-4 text-muted warning">
                        Seems like you have added this object to basket. to change dates remove first remove from basket.
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
    import Availability from './Availability';
    import ReviewList from './ReviewList';
    import { mapState } from 'vuex';
    import PriceBreakdown from './PriceBreakdown';
    export default {
        components:{Availability,ReviewList,PriceBreakdown},
        data(){
            return{
                bookable:null,
                price:null,
            }
        },
        props:['id'],
        created() {
            axios.get(`/api/bookables/${this.id}`)
                .then(res => {
                    this.bookable = res.data.data
                });
        },
        computed:{
            ...mapState({
                lastSearchComputed: 'lastSearch'
            }),
            inBasketAlready(){
                if(this.$store.state.basket.items.length === 0){
                    return false;
                }
                const filteredItem = this.$store.state.basket.items.filter(item => item.bookable.id === this.bookable.id);
                if (Object.keys(filteredItem).length !== 0){
                    return true;
                }
            }
        },
        methods:{
            async checkPrice(hasAvailability){
                if (!hasAvailability){
                    this.price = null;
                }

                try{
                    this.price = (await axios.get(`/api/bookables/${this.bookable.id}/price?from=${this.lastSearchComputed.from}&to=${this.lastSearchComputed.to}`)).data.data;
                }catch (e) {
                    this.price = null;
                }
            },
            addToBasket(){
                this.$store.dispatch('addToBasket',{
                    bookable: this.bookable,
                    price: this.price,
                    dates: this.lastSearchComputed
                });
            },
            removeFromBasket(){
                this.$store.dispatch('removeFromBasket',{
                    id: this.bookable.id
                });
            },
            showState(){
                console.log(this.$store.state.basket)
            }
        }
    }
</script>
