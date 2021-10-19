<template>
    <div class="d-flex w-50 m-auto align-items-center">
        <div class="card card-body">
            <form @submit.prevent="login">
                <div class="form-group">
                    <label for="email">Email</label>
                    <input id="email"
                           name="email"
                           placeholder="Please enter your email"
                           class="form-control"
                           :class="[{'is-invalid':errorFor('email')}]"
                           v-model="email"
                    >
                    <validation-errors :errors="errorFor('email')"></validation-errors>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input id="password"
                           name="password"
                           placeholder="Please enter your password"
                           class="form-control"
                           :class="[{'is-invalid':errorFor('password')}]"
                           v-model="password"
                    >
                    <validation-errors :errors="errorFor('password')"></validation-errors>
                </div>
                <button type="submit" class="btn btn-secondary btn-lg btn-block" :disabled="loading">Log in</button>
                <hr />

                <div class="text-nowrap">
                    No account yet?

                    <router-link :to="{name:'register'}" class="font-weight-bold">Register</router-link>
                </div>

                <div class="text-nowrap">
                    Forget your password?

                    <router-link :to="{name:'home'}" class="font-weight-bold">Reset password</router-link>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
    import validationErrors from '../shared/mixins/validationError';
    import {logIn} from '../shared/utils/auth';
    export default{
        mixins:[validationErrors],
        data(){
            return{
                email:null,
                password:null,
                loading:false,
            }
        },
        created() {
            return this.pushIfUnauthenticated();
        },
        methods:{
            async login(){
                this.loading = true;
                this.errors = null;

                try{
                    await axios.get('/sanctum/csrf-cookie');
                    await axios.post('/login', {
                        email:this.email,
                        password:this.password
                    });
                    logIn();
                    this.$store.dispatch("loadUser");
                    this.$toast.success("The login was successful");
                    this.$router.push({name:'home'});
                }catch(err){
                    this.errors = err.response && err.response.data.errors;
                }

                this.loading = false;
            },
            pushIfUnauthenticated(){
                if (this.$store.state.isLoggedIn){
                    this.$router.push({name:'home'})
                }
            }
        }
    }
</script>
