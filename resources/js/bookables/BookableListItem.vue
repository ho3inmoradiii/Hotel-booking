<template>
    <div>
        <div class="bookableBox">
            <h1>{{ title }}</h1>
            <p>{{ description }}</p>
        </div>
    </div>
</template>

<script>
    export default {
        props:{
            title: String,
            description: String,
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
        margin-bottom: 40px;
        min-height: 300px;
    }
</style>
