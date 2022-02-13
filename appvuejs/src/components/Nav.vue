<template>
    <div id="nav">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto d-flex justify-content-between w-100">
                    <div class="d-flex">
                        <li>
                            <router-link class="nav-link" to="/">Home</router-link>
                        </li>
                        <li v-if="this.token">
                            <div class="dropdown">
                                <button class="nav-link dropdown-toggle dropdown-nav pointer" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                    Items
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                    <span class="ml-3 font-weight-bold">Categories</span>
                                    <li><hr class="dropdown-divider"></li>
                                    <li v-for="cat in categories" :key="cat.id"><a class="dropdown-item pointer" @click="getCategory(cat.name)">{{ cat.name }}</a></li>
                                </ul>
                            </div>
                        </li>
                    </div>
                    <div class="d-flex">
                        <li v-if="!this.token">
                            <router-link class="nav-link" to="/register">Sign Up</router-link>
                        </li>
                        <li v-if="!this.token">
                            <router-link class="nav-link" to="/login">Login</router-link>
                        </li>
                        <li v-if="this.token">
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
    data() {
        return {
            categories: [
                {
                    id: 'sldjkflksjdflks',
                    name: "Shoes",
                },
                {
                    id: 'lskdjflkdsdf',
                    name: "Trousers",
                },
                {
                    id: 'lskdjfdlksdf',
                    name: "T-shirts",
                },
                {
                    id: 'lsdkdjflksdf',
                    name: "Sweat",
                },
            ]
        }
    },
    inject: ['setAuth'],
    props: {
        token: null
    },
    name: 'Nav',
    methods: {
        logout() {
            localStorage.removeItem('token');
            this.setAuth(null);
        },
        getCategory(name) {
            this.$router.push(`/categories/${name.toLowerCase()}`);
        }
    }
};
</script>
<style>
</style>
