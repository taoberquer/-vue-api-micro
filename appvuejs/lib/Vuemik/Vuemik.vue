<template>
    <div>
        <div v-if="errorMessage" class="alert alert-warning" role="alert">
            {{ errorMessage }}
        </div>
        <slot :handleSubmit="handleSubmit"></slot>
    </div>
</template>

<script>
export default {
    name: "Vuemik",
    data() {
        return {
            values: this.initialValues,
            error: this.errorMessage
        };
    },
    props: {
        initialValues: {
            type: Object,
            default: () => {
            },
        },
        onSubmit: {
            type: Function,
            default: () => {
            },
        },
        errorMessage: {
            type: String,
            default: null,
        }
    },
    methods: {
        handleSubmit: function () {
            this.onSubmit(this.values);
        },
        handleChange(name, value) {
            this.values[name] = value;
        },
    },
    provide() {
        return {
            vuemik: {
                values: this.values,
                handleSubmit: this.handleSubmit,
                change: this.handleChange,
            },
        };
    },
};
</script>

<style>
</style>
