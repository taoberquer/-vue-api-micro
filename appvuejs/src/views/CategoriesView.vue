<template>
    <div v-for="cat in categories" :key="cat.id">
        <a class="card cursor-pointer">
            <div @click="showDetails(cat.name)" class="card-body">
                {{ cat.name }}
            </div>
        </a>
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
    methods: {
        showDetails(name) {
            this.$router.push(`/categories/${name.toLowerCase()}`);
        }
    },
};
</script>
<style>
.cursor-pointer {
    cursor: pointer;
}
</style>
