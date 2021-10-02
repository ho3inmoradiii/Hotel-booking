<template>
    <div v-if="loading" class="text-right">
        Data is loading...
    </div>
    <div class="container" v-else>
        <div class="row dir-rtl">
            <bookable-list-item
                v-for="(bookable,index) in bookables"
                :key="index"
                :title="bookable.title"
                :content="bookable.content"
                v-bind:price="bookable.price"
                class="col-12 col-lg-4"
            ></bookable-list-item>
        </div>
    </div>
</template>

<script>
    import BookableListItem from './BookableListItem';
    export default {
        components:{BookableListItem},
        data(){
            return{
                loading:false,
                bookables: null,
            }
        },
        created() {
            this.loading = true
            setTimeout(() => {
                this.bookables = {
                    bookable1:{
                        title:'ویلای ارزان',
                        content:'ویلای با کیفیت با بهترین قیمت',
                        price:1500
                    },
                    bookable2:{
                        title:'ویلای ارزان1',
                        content:'ویلای با کیفیت با بهترین قیمت1',
                        price:1000
                    }
                }
                this.loading = false
            },1000)
        }
    }
</script>

<style>
    .dir-rtl{
        direction: rtl;
    }
</style>
