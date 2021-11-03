<template>
    <div>
        <div class="bookableBox">
            <router-link :to="{ name: 'bookable', params: { id: id }}">
                <h3>{{ title }}</h3>
            </router-link>

            <p>{{ description }}</p>
            <hr />

            <div class="priceBox">
                <h5>Price:</h5>
                <span>{{ price }}$ per day</span>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props:{
            title: String,
            description: String,
            id: Number,
            price: Number
        }
    }
</script>

<style scoped>
    .bookableBox {
        border: 1px solid #cccccc;
        display: flex;
        justify-content: space-between;
        flex-direction: column;
        align-items: center;
        padding: 10px;
        margin-bottom: 40px;
        height: 340px;
        border-radius: 20px;
    }

    .priceBox{
        display: flex;
        justify-content: space-between;
        direction: ltr;
        width: 100%;
    }
</style>
