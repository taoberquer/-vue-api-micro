<template>
    <div id="app">
        <Nav :user="user"/>
        <router-view class="d-flex justify-content-center align-items-center flex-column w-100 mt-5"></router-view>
    </div>
</template>

<script>
import Nav from './components/Nav.vue';

export default {
    name: 'App',
    components: {
        Nav,
    },
    data () {
        return {
            user: {}
        }
    },
    provide() {
        const provider = {
            setAuth: (user) => {
                this.user = user
                localStorage.setItem('user', JSON.stringify(user))
            },
            apiUrls: this.apiUrls
        }
        Object.defineProperty(provider, 'user', {
            enumerable: true,
            get: () => this.user,
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
