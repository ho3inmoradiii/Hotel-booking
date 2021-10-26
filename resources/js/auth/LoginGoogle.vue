<template>
    <div>
        <h5>Login with google, please wait.</h5>
    </div>
</template>

<script>
    import {mapActions} from 'vuex';

    export default {
        methods:{
            ...mapActions({
                login:'loginGoogleCallback'
            }),
            loginUser(){
                // console.log(this.$route.query.code)
                this.login({
                    code: this.$route.query.code
                }).then((res) => {
                    // console.log(res);
                })
            }
        },
        created() {
            this.loginUser();
        }
    }
</script>
