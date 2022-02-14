<template>
    <div class="panel-body flex" style="flex-direction: row !important;">
        <Card>
            <template v-slot:img>
                <img :src="this.getImgUrl(item.filePath)" height="600"  alt="{{ item.description }}"/>
            </template>
            <template v-slot:infos>
                <div class="ml-5" style="max-width: 300px;">
                    <div class="mb-5">
                        <h4>{{ item.title }}</h4>
                        <p class="mb-4">{{ item.description }}</p>
                        <p><span class="font-weight-bold">Color : </span>{{ item.color }}</p>
                        <p><span class="font-weight-bold">Size : </span>{{ item.size }}</p>
                    </div>
                    <div>
                        <button v-if="this.cartContains(item.id) === false" @click="this.addToCart(item.id)" class="btn btn-primary">Add to cart</button>
                        <button v-else class="btn btn-default disabled">Added to cart</button>
                        <button v-if="this.cartContains(item.id) === true" @click="this.removeFromCart(item.id)" class="btn btn-danger">Remove from cart</button>
                    </div>
                </div>
            </template>
        </Card>
    </div>

</template>

<script>
import Card from "../components/Card";
import {conf} from "../conf";

export default {
    inject: ['setLoading', 'addToCart', 'removeFromCart', 'cartContains', 'getImgUrl'],
    components: {
        Card,
    },
    data() {
        return {
            item: {},
            isMounted: false
        }
    },
    beforeMount() {
        this.isMounted = true;
        this.getItem(this.$route.params.id);
    },
    methods: {
        getItem(id) {
            this.setLoading(true);
            fetch(`${conf.apiUrl}/pieces/${id}`, {
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
                    this.item = data;
                    this.setLoading(false);
                })
                .catch((err) => {
                    console.log(err);
                });
        },
    }
};
</script>
