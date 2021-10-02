<template>
    <div>
        <div class="bookableBox">
            <h1>{{ title }}</h1>
            <p>{{ content }}</p>
            <p>قیمت:{{ price }}</p>
        </div>
    </div>
</template>

<script>
    export default {
        props:{
            title: String,
            content: String,
            price: Number
        }
    }
</script>

<style scoped>
    .bookableBox {
        border: 1px solid #cccccc;
        display: flex;
        justify-content: center;
        flex-direction: column;
        align-items: center;
        padding: 10px;
    }
</style>
