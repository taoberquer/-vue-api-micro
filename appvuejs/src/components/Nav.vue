<template>
    <div id="nav">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto d-flex justify-content-between w-100">
                    <div class="d-flex">
                        <li>
                            <router-link class="nav-link" to="/">Home</router-link>
                        </li>
                        <li v-if="this.user">
                            <router-link class="nav-link" to="/items">Items</router-link>
                        </li>
                        <li v-if="this.user">
                            <router-link class="nav-link" to="/categories">Categories</router-link>
                        </li>
                    </div>
                    <div class="d-flex">
                        <li v-if="!this.user">
                            <router-link class="nav-link" to="/register">Sign Up</router-link>
                        </li>
                        <li v-if="!this.user">
                            <router-link class="nav-link" to="/login">Login</router-link>
                        </li>
                        <li v-if="this.user">
                            <button type="submit" class="nav-link" @click="logout">Logout</button>
                        </li>
                    </div>
                </ul>
            </div>
        </nav>
    </div>
</template>

<script>
export default {
    inject: ['setAuth'],
    props: {
        user: null
    },
    name: 'Nav',
    methods: {
        logout() {
            localStorage.removeItem('user');
            this.setAuth(null);
        }
    }
};
</script>
<style>
</style>
