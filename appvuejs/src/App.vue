<template>
    <div id="app">
        <Nav :token="token"/>
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

export default {
    name: 'App',
    components: {
        Nav,
    },
    data () {
        return {
            token: localStorage.getItem('token')
            isLoading: false,
        }
    },
    provide() {
        const provider = {
            setAuth: (token) => {
                this.token = token
                localStorage.setItem('token', token)
            },
            setLoading: (isLoading) => {
                this.isLoading = isLoading
            },
            apiUrls: this.apiUrls
        }
        Object.defineProperty(provider, 'token', {
            enumerable: true,
            get: () => this.token,
        })
        Object.defineProperty(provider, 'isLoading', {
            enumerable: true,
            get: () => this.isLoading,
        })
        return provider
    }
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
