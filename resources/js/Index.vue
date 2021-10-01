<template>
    <div>
        <router-link :to="{ name:'home' }">صفحه اصلی</router-link>
        <router-link :to="{ name:'second' }">صفحه دوم</router-link>
        <router-view></router-view>
    </div>
</template>

<script>

</script>
