<template>
    <div class="d-flex">
        <i class="fas fa-star" v-for="star in fullStars" :key="'full' + star"></i>
<!--        <i class="fas fa-star-half-alt"></i>-->
        <i class="far fa-star" v-for="star in emptyStars" :key="'empty' + star"></i>
    </div>
</template>

<script>
    export default{
        props:{
            starRating:Number
        },
        computed:{
            fullStars(){
                return this.starRating;
            },
            emptyStars(){
                return 5-this.starRating;
            }
        },
        created() {

        }
    }
</script>
