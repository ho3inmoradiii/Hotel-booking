<template>
    <div class="bodyBox">
        <nav class="navbar justify-content-between">


            <div class="d-flex justify-content-between logoBox">
                <router-link class="navbar-brand mr-auto" :to="{ name:'home' }">
                    Home
                </router-link>
                <input
                    @change="toggleTheme"
                    id="checkbox"
                    type="checkbox"
                    class="switch-checkbox"
                />
                <label for="checkbox" class="switch-label mt-2">
                    <span>☀️</span>
                    <span>🌙</span>
                    <div
                        class="switch-toggle"
                        :class="{ 'switch-toggle-checked': userTheme === 'dark-theme' }"
                    ></div>
                </label>
            </div>

            <ul class="navbar-nav d-flex justify-content-between flex-row">
                <li class="nav-item" v-if="isLoggedIn">
                    <router-link class="btn nav-button basket" :to="{name:'basket'}">
                        Basket
                        <span class="badge badge-secondary" v-if="itemsInBasket">{{ itemsInBasket }}</span>
                    </router-link>
                </li>
                <li class="nav-item" v-if="!isLoggedIn">
                    <router-link :to="{name:'register'}" class="nav-link">Sign Up</router-link>
                </li>

                <li class="nav-item" v-if="!isLoggedIn">
                    <router-link :to="{name:'login'}" class="nav-link">Login</router-link>
                </li>

                <li class="nav-item" v-if="isLoggedIn">
                    <a href="#" @click.prevent="logout" class="nav-link">Logout</a>
                </li>
            </ul>

        </nav>

        <div class="container mt-4 mb-4 pr-4 pl-4">
            <router-view></router-view>
        </div>
    </div>
</template>

<script>
    import { mapState,mapGetters } from 'vuex';
    export default {
        data(){
            return{
                lastSearch: this.$store.state.lastSearch,
                userTheme: "light-theme",
            }
        },
        computed:{
            ...mapState({
                lastSearchComputed: 'lastSearch',
                isLoggedIn: 'isLoggedIn'
            }),
            ...mapGetters({
                itemsInBasket: 'itemsInBasket'
            })

        },
        mounted() {
            const initUserTheme = this.getMediaPreference();
            this.setTheme(initUserTheme);
        },
        methods:{
            async logout(){
                try {
                    await axios.post('/logout');
                    this.$toast.success("The logout was successful");
                    this.$store.dispatch('logout');
                }catch (e) {
                    this.$toast.success("The logout was successful");
                    this.$store.dispatch('logout');
                }

            },
            setTheme(theme) {
                localStorage.setItem("user-theme", theme);
                this.userTheme = theme;
                document.documentElement.className = theme;
            },
            toggleTheme() {
                const activeTheme = localStorage.getItem("user-theme");
                if (activeTheme === "light-theme") {
                    this.setTheme("dark-theme");
                } else {
                    this.setTheme("light-theme");
                }
            },
            getMediaPreference() {
                const hasDarkPreference = window.matchMedia(
                    "(prefers-color-scheme: dark)"
                ).matches;
                if (hasDarkPreference) {
                    return "dark-theme";
                } else {
                    return "light-theme";
                }
            },

        }
    }
</script>

<style>
    .switch-checkbox {
        display: none;
    }

    .switch-label {
        /* for width, use the standard element-size */
        width: var(--element-size);
        border-radius: var(--element-size);
        border: calc(var(--element-size) * 0.025) solid var(--accent-color);
        font-size: calc(var(--element-size) * 0.25);
        height: calc(var(--element-size) * 0.4);
        align-items: center;
        background: var(--text-primary-color);
        cursor: pointer;
        display: flex;
        position: relative;
        transition: background 0.5s ease;
        justify-content: space-between;
        z-index: 1;
    }

    .switch-toggle {
        position: absolute;
        background-color: var(--background-color-primary);
        border-radius: 50%;
        left: calc(var(--element-size) * 0.0001);
        height: calc(var(--element-size) * 0.4);
        width: calc(var(--element-size) * 0.4);
        transform: translateX(0);
        transition: transform 0.3s ease, background-color 0.5s ease;
    }

    .switch-toggle-checked {
        transform: translateX(calc(var(--element-size) * 0.6)) !important;
    }

    .navbar-nav li{
        padding: 5px;
    }

    .logoBox > a , .logoBox > input {
        padding: 8px;
    }

</style>
