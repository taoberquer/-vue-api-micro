<template>
    <div id="app">
        <Nav :token="token"/>
        <router-view class="d-flex justify-content-center align-items-center flex-column w-100 mt-5"></router-view>
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
            token: null
        }
    },
    provide() {
        const provider = {
            setAuth: (token) => {
                this.token = token
                localStorage.setItem('token', JSON.stringify(token))
            },
            apiUrls: this.apiUrls
        }
        Object.defineProperty(provider, 'token', {
            enumerable: true,
            get: () => this.token,
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
