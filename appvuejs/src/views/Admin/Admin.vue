<template>
    <div>
        <div @click="showDonations">See donations</div>
        <div @click="showCategories">See categories</div>
    </div>
</template>

<script>


export default {
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
        showCategories() {
            this.$router.push(`/admin/categories`);
        },
        showDonations() {
            this.$router.push(`/admin/donations`);
        }
    }
};
</script>
