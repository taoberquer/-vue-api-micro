<template>
    <div id="app">
        <Nav :token="token" :cart="cart" />
        <div v-if="isLoading === true" class="d-flex justify-content-center mt-5">
            <div class="spinner-border" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>
        <div v-show="isLoading === false">
            <router-view class="d-flex justify-content-center align-items-center flex-column w-100 mt-5"></router-view>
        </div>
    </div>
</template>
<style>
    @import './assets/app.css';
</style>

<script>
import Nav from './components/Nav.vue';
import {conf} from "./conf";

export default {
    name: 'App',
    components: {
        Nav,
    },
    data () {
        return {
            token: localStorage.getItem('token'),
            isLoading: false,
            cart: JSON.parse(localStorage.getItem('cart')) || [],
            user: JSON.parse(localStorage.getItem('realUser')) || [],
        }
    },
    provide() {
        const provider = {
            setAuth: (token) => {
                this.token = token
                localStorage.setItem('token', token)
            },
            getImgUrl: (filePath) => {
                return conf.apiUrl + filePath
            },
            apiUrls: this.apiUrls,
            addToCart: this.addToCart,
            removeFromCart: this.removeFromCart,
            cartContains: this.cartContains,
            getUser: this.getUser,
            setLoading: this.setLoading,
        }
        Object.defineProperty(provider, 'token', {
            enumerable: true,
            get: () => this.token,
        });
        Object.defineProperty(provider, 'isLoading', {
            enumerable: true,
            get: () => this.isLoading,
        });
        return provider
    },
    created() {
        this.getUser();
    },
    methods: {
        setLoading(isLoading) {
            this.isLoading = isLoading
        },
        addToCart(id) {
            this.cart.push(id);
            this.saveCart();
        },
        removeFromCart(id) {
            this.cart.splice(this.cart.indexOf(id), 1);
            this.saveCart();
        },
        cartContains(id) {
            return this.cart.includes(id);
        },
        saveCart() {
            localStorage.setItem('cart', JSON.stringify(this.cart));
        },
        getUser() {
            this.setLoading(true);
            fetch(`${conf.apiUrl}/users/me`, {
                headers: {
                    "Accept": "application/json",
                    "Content-Type": "application/json",
                    "Authorization": `Bearer ${localStorage.getItem("token")}`,
                },
                method: "GET",
            }).then((resp) => {
                return resp.json();
            })
                .then((data) => {
                    localStorage.setItem('realUser', JSON.stringify(data));
                    this.setLoading(false);
                })
                .catch((err) => {
                    console.log(err);
                });
        },
    },
}
</script>

<style>
#app {
    font-family: Avenir, Helvetica, Arial, sans-serif;
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
    text-align: center;
    color: #2c3e50;
    margin-top: 60px;
}
</style>
