<template>
    <div class="panel">
        <div class="separator mb-2">{{ nbItems }} items found</div>
        <div v-if="this.nbItems > 0" class="panel-body row justify-content-center">
            <Card class="col-2 m-2 flex-column" v-for="item in items" :key="item.id">
                <template v-slot:img>
                    <!--<img :src="item.thumbnail" />-->
                    <img class="pointer" @click="showDetails(item.id)" src="../assets/test.png" contain height="300"/>
                </template>
                <template v-slot:infos>
                    <h5 style="max-width: fit-content;">{{ item.title }}</h5>
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
                    console.log(data);
                    this.items = data;
                    this.setLoading(false);
                })
                .catch((err) => {
                    console.log(err);
                });
        },
        showDetails(id) {
            this.$router.push(`/items/${id}`);
        }
    },
};
</script>
