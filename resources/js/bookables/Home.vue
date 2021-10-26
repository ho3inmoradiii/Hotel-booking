<template>

</template>

<script>
    import {logIn} from '../shared/utils/auth';
    export default {
        created() {
            logIn();
            this.$store.dispatch("loadUser");
            this.$toast.success("The login was successful");
            this.$router.push({name:'home'});
        }
    }
</script>
