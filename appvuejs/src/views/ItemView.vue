<template>
    <div class="panel-body flex" style="flex-direction: row !important;">
        <Card>
            <template v-slot:img>
                <!--<img :src="item.thumbnail" />-->
                <img src="../assets/test.png" contain height="600" />
            </template>
            <template v-slot:infos>
                <div class="ml-5" style="max-width: 300px;">
                    <div class="mb-5">
                        <h4>{{ item.title }}</h4>
                        <p class="mb-4">{{ item.price }} €</p>
                        <p class="mb-4">{{ item.description }}</p>
                        <p><span class="font-weight-bold">Couleur : </span></p>
                    </div>
                    <p><span class="font-weight-bold">Taille : </span></p>
                    <div>
                        <button class="btn btn-primary">Ajouter au panier</button>
                    </div>
                </div>
            </template>
        </Card>
    </div>

</template>

<script>
import Card from "../components/Card";

export default {
    components: {
        Card,
    },
    data() {
        return {
            item: {
                id:"sldkjflksdjflksjd",
                title: "T-shirt",
                description: "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris id lacus in nisl semper consectetur.",
                thumbnail: "../assets/logo.png",
                price: "10",
            },
            isMounted: false
        }
    },
    beforeMount() {

    },
    methods: {
        showCategories(category) {
            this.$router.push(`/categories/${category.toLowerCase()}`);
        }
    }
};
</script>
