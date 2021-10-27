<template>
    <div class="d-flex w-50 m-auto align-items-center flex-column">
        <div class="card card-body w-100">
            <form @submit.prevent="signup">
                <div class="form-group">
                    <label for="name" class="label">Name</label>
                    <input id="name"
                           name="name"
                           placeholder="Please enter your name"
                           class="form-control"
                           :class="[{'is-invalid':errorFor('name')}]"
                           v-model="user.name"
                    >
                    <validation-errors :errors="errorFor('name')"></validation-errors>

                </div>
                <div class="form-group">
                    <label for="email" class="label">Email</label>
                    <input id="email"
                           name="email"
                           placeholder="Please enter your email"
                           class="form-control"
                           :class="[{'is-invalid':errorFor('email')}]"
                           v-model="user.email"
                    >
                    <validation-errors :errors="errorFor('email')"></validation-errors>
                </div>
                <div class="form-group">
                    <label for="password" class="label">Password</label>
                    <input id="password"
                           name="password"
                           placeholder="Please enter your password"
                           class="form-control"
                           :class="[{'is-invalid':errorFor('password')}]"
                           v-model="user.password"
                    >
                    <validation-errors :errors="errorFor('password')"></validation-errors>
                </div>
                <div class="form-group">
                    <label for="password_confirmation" class="label">ReType password</label>
                    <input id="password_confirmation"
                           name="password_confirmation"
                           placeholder="Please re enter your password"
                           class="form-control"
                           :class="[{'is-invalid':errorFor('password_confirmation')}]"
                           v-model="user.password_confirmation"
                    >
                    <validation-errors :errors="errorFor('password_confirmation')"></validation-errors>
                </div>
                <button type="submit" class="btn btn-success btn-lg btn-block" :disabled="loading">Register</button>
                <hr />

                <div class="text-nowrap loginItem">
                    You have an account?

                    <router-link :to="{name:'login'}" class="font-weight-bold">Login</router-link>
                </div>
            </form>
        </div>
        <button @click="LoginGoogle" class="btn btn-outline-danger mt-4 w-100">
            <i class="fab fa-google"></i>
            Login with google
        </button>
    </div>
</template>

<script>
    import validationErrors from '../shared/mixins/validationError';
    import {logIn} from '../shared/utils/auth';
    export default{
        mixins:[validationErrors],
        data(){
            return{
                user:{
                    email:null,
                    password:null,
                    name:null,
                    password_confirmation:null,
                },
                loading:false,
            }
        },
        created() {
            return this.pushIfUnauthenticated();
        },
        methods:{
            async signup(){
                this.loading = true;
                this.errors = null;

                try{
                    const response = await axios.post('/register',this.user);
                    if (response.status === 201) {
                        logIn();
                        this.$store.dispatch("loadUser");
                        this.$toast.success("The sign up was successful");
                        this.$router.push({name:'home'});
                    }
                }catch(err){
                    this.errors = err.response && err.response.data.errors;
                }

                this.loading = false;
            },
            pushIfUnauthenticated(){
                if (this.$store.state.isLoggedIn){
                    this.$router.push({name:'home'})
                }
            },
            LoginGoogle(){
                window.location.href = '/login/google'
                // this.$store.dispatch("loginUserGoogle").then((res) => {
                //     //console.log(res)
                //     if (res.data.url){
                //         window.location.href = res.data.url
                //         // console.log(res.data.url)
                //     }
                // })
            }
        }
    }
</script>
