<template>
    <div class="d-flex">
        <i class="fas fa-star"
           v-for="star in fullStars"
           :key="'full' + star"
           @click="$emit('input',star)"
        ></i>
<!--        <i class="fas fa-star-half-alt"></i>-->
        <i class="far fa-star"
           v-for="star in emptyStars"
           :key="'empty' + star"
           @click="$emit('input',fullStars+star)"
        ></i>
    </div>
</template>

<script>
    export default{
        props:{
            value:Number
        },
        computed:{
            fullStars(){
                return this.value;
            },
            emptyStars(){
                return 5-this.value;
            }
        },
        created() {

        }
    }
</script>
