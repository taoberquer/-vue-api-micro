<template>
    <div style="width: 80%">
        <Card>
            <template v-slot:header>
                {{ item.title }}
            </template>
            <template v-slot:content>
                {{ item.content }}
                <div @click="showDetails(item.id)" class="btn btn-primary">View details</div>
            </template>
        </Card>

        <div>{{ item.description }}</div>
        <div class="btn btn-primary" @click="showCategories(item.category)">See other items of <b>{{ item.category }}</b></div>
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
                title: 'My title',
                quality: 'good',
                color: 'red',
                size: 'XL',
                damage: null,
                description: 'What is Lorem Ipsum?\n' +
                    'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.',
                category: 'T-shirt'
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
