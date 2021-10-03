<template>
    <div>
        <div class="bookableBox">
            <router-link :to="{ name: 'bookable', params: { id: id }}">
                <h3>{{ title }}</h3>
            </router-link>

            <p>{{ description }}</p>
        </div>
    </div>
</template>

<script>
    export default {
        props:{
            title: String,
            description: String,
            id: Number
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
        height: 300px;
    }
</style>
