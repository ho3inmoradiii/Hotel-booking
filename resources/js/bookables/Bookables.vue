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
                :description="bookable.description"
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
            axios.get('/api/bookables')
            .then(res => {
                this.bookables = res.data
                this.loading = false
            })
            .catch(error => console.log(error.response.data))
        }
    }
</script>

<style>
    .dir-rtl{
        direction: rtl;
    }
</style>
