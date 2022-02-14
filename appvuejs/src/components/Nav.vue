<template>
    <div id="nav">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto d-flex justify-content-between w-100">
                    <div class="d-flex">
                        <li>
                            <router-link class="nav-link" to="/">Home</router-link>
                        </li>
                        <li>
                            <div class="dropdown">
                                <button class="nav-link dropdown-toggle dropdown-nav pointer" type="button"
                                        id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                    Admin
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                    <li>
                                        <router-link class="nav-link" to="/admin/donations">Donations</router-link>
                                    </li>
                                    <li>
                                        <router-link class="nav-link" to="/admin/categories">Categories</router-link>
                                    </li>
                                    <li>
                                        <router-link class="nav-link" to="/admin/pieces">Pieces</router-link>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <li v-if="this.token">
                            <div class="dropdown">
                                <button class="nav-link dropdown-toggle dropdown-nav pointer" type="button"
                                        id="dropdownMenuButton2" data-bs-toggle="dropdown" aria-expanded="false">
                                    Items
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                    <span class="ml-3 font-weight-bold">Categories</span>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                    <li v-for="cat in categories" :key="cat.id">
                                        <router-link class="nav-link" :to="`/categories/${cat.id}`">{{ cat.name }}</router-link>
                                    </li>
                                </ul>
                            </div>
                        </li>
                    </div>
                    <div class="d-flex">
                        <li class="align-self-center mr-2" v-show="cart.length > 0 && this.token">
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#cart-modal">
                                Cart ({{ cart.length }})
                            </button>

                            <!-- Modal -->
                            <div class="modal fade" id="cart-modal" tabindex="-1" aria-labelledby="cart-modal" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Your cart</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <table class="table table-borderless">
                                                <tbody>
                                                    <tr v-for="item in cartItems" :key="item.id">
                                                        <td class="align-middle"><img :src="this.getImgUrl(item.filePath)" height="150" alt="{{ item.description }}"/></td>
                                                        <td class="align-middle">{{ item.title }}</td>
                                                        <td class="align-middle">{{ 1 }} credits</td>
                                                    </tr>
                                                    <tr>
                                                        <td></td>
                                                        <td></td>
                                                        <td class="align-middle font-weight-bold">{{ cart.length }} credits</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div data-bs-dismiss="modal" class="modal-footer">
                                            <router-link class="btn btn-primary" to="/payment">Go to payment</router-link>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li v-if="!this.token">
                            <router-link class="nav-link" to="/register">Sign Up</router-link>
                        </li>
                        <li v-if="!this.token">
                            <router-link class="nav-link" to="/login">Login</router-link>
                        </li>
                        <li v-if="this.token">
                            <button type="submit" class="btn btn-secondary" @click="logout">Logout</button>
                        </li>
                    </div>
                </ul>
            </div>
        </nav>
    </div>
</template>

<script>
import {conf} from "../conf";

export default {
    data() {
        return {
            categories: [],
        }
    },
    inject: ['setAuth', 'getImgUrl', 'setLoading', 'removeFromCart'],
    props: {
        token: null,
        cart: null,
    },
    name: 'Nav',
    methods: {
        logout() {
            localStorage.removeItem('token');
            this.setAuth(null);
        },
        getCategory(name) {
            this.$router.push(`/categories/${name.toLowerCase()}`);
        },
        getCartItems() {
            this.setLoading(true);
            let cartItems = [];
            for (let item of this.cart) {
                fetch(`${conf.apiUrl}/pieces/${item}`, {
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
                    cartItems.push(data);
                })
                .catch((err) => {
                    console.log(err);
                });
            }
            this.setLoading(false);
            return cartItems;
        },
    },
    mounted() {
        fetch(`${conf.apiUrl}/categories?page=1`, {
            headers: {
                "Accept": "application/json",
                "Content-Type": "application/json",
                "Authorization": `Bearer ${localStorage.getItem('token')}`
            },
            method: "GET"
        }).then((resp) => {
            return resp.json();
        }).then(data => {
            this.categories = data;
        });
    },
    computed: {
        cartItems() {
            return this.getCartItems();
        },
    }
};
</script>
<style>
</style>
