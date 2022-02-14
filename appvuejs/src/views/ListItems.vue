<template>
    <div class="panel">
        <div v-if="errorMessage" class="alert alert-warning" role="alert">
            {{ errorMessage }}
        </div>
        <div class="separator mb-2">{{ nbItems }} items found</div>
        <div v-if="this.nbItems > 0" class="panel-body row justify-content-center">
            <Card class="col-2 m-2 flex-column" v-for="item in items" :key="item.id">
                <template v-slot:img>
                    <!--<img :src="item.thumbnail" />-->
                    <img v-if="!item.sold" class="pointer" @click="showDetails(item.id)" :src="getImgUrl(item.filePath)" height="300"/>
                    <img v-else style="opacity: 0.5" :src="getImgUrl(item.filePath)" height="300"/>
                </template>
                <template v-slot:infos>
                    <h5 style="max-width: fit-content;">
                        {{ item.title }}
                        <span class="ml-2" style="color: red;" v-if="item.sold">SOLD</span>
                    </h5>
                </template>
            </Card>
        </div>
    </div>
</template>

<script>
import Card from "../components/Card";
import {conf} from "../conf";

export default {
    inject: ['setLoading'],
    components: {
        Card,
    },
    data() {
        return {
            items: [],
            errorMessage: null
        };
    },
    computed: {
        nbItems() {
            return this.items.length;
        },
    },
    created() {
        this.getItems();
    },
    methods: {
        getItems() {
            this.setLoading(true);
            fetch(`${conf.apiUrl}/pieces`, {
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
                    this.items = data;
                    this.setLoading(false);
                })
                .catch((err) => {
                    this.setLoading(false);
                    this.errorMessage = "An error occured...";
                    console.log(err);
                });
        },
        showDetails(id) {
            this.$router.push(`/items/${id}`);
        },
        getImgUrl(filePath) {
            return conf.apiUrl + filePath;
        },
    },
};
</script>
