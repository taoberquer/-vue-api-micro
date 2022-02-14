<template>
    <button @click="showModal(null)" type="button" class="btn btn-primary" data-bs-toggle="modal"
            :data-bs-target="`#modal`">
        Create
    </button>
    <div v-if="pieces.length > 0">
        <div v-for="piece in pieces" :key="piece.id">
            <div>
                {{ piece.title }}
            </div>
            <button @click="showModal(piece)" type="button" class="btn btn-primary" data-bs-toggle="modal"
                    :data-bs-target="`#modal`">
                Update
            </button>
        </div>
    </div>
    <div :id="`modal`" class="modal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <Vuemik
                    :initialValues="{
                          name: ope === 'update' ? modalData.name : '',
                        }"
                    :onSubmit="ope === 'update' ? updatePiece : createPiece"
                    v-slot="{ handleSubmit }"
                >
                    <div class="modal-header">
                        <h5 class="modal-title">{{ modalData ? modalData.name : '' }}</h5>
                        <button @click="resetModalData" type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Quality</label>
                            <Field class="col" component="select" name="gallery" type="select">
                                <template v-slot:default>
                                    <option v-for="n in 10" :key="n" :value="n">{{ n }}</option>
                                </template>
                            </Field>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Color</label>
                            <Field name="color" component="input" class="form-control"/>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Size</label>
                            <Field name="size" component="input" class="form-control"/>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <Field name="description" component="input" class="form-control"/>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Title</label>
                            <Field name="title" component="input" class="form-control"/>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Damage</label>
                            <Field name="damage" component="input" class="form-control"/>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Sold out</label>
                            <Field name="sold" component="input" class="form-control"/>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Category</label>
                            <Field name="category" component="select" class="form-control">
                                <template v-slot:default>
                                    <option v-for="cat in categories" :key="cat" :value="cat.name">{{ cat.name }}</option>
                                </template>
                            </Field>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Image</label>
                            <Field name="file" component="input" class="form-control" type="file"/>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button @click="resetModalData" type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            Close
                        </button>
                        <Field data-bs-dismiss="modal" class="btn btn-primary" value="Save" name="submit"
                               component="input" type="submit"
                               @click="handleSubmit"/>
                    </div>
                </Vuemik>
            </div>
        </div>
    </div>
</template>

<script>
import Vuemik from "../../../lib/Vuemik/Vuemik";
import Field from "../../../lib/Vuemik/Field";
import {conf} from "../../conf";

export default {
    inject: ['setLoading'],
    components: {
        Vuemik,
        Field,
    },
    data() {
        return {
            pieces: [],
            modalData: {},
            modalShowed: false,
            ope: '',
            categories: []
        }
    },
    beforeMount() {
        this.fetchPieces();
        this.fetchCategories();
    },
    methods: {
        showModal(piece) {
            this.ope = piece == null ? 'create' : 'update';
            this.modalData = piece;
        },
        closeModal() {
            this.modalData = null;
        },
        updatePiece(data) {
            this.setLoading(true);
            fetch(`${conf.apiUrl}/pieces/${this.modalData.id}`, {
                headers: {
                    "Accept": "application/json",
                    "Content-Type": "application/json",
                    "Authorization": `Bearer ${localStorage.getItem('token')}`
                },
                method: "PUT",
                body: JSON.stringify(data)
            }).then((resp) => {
                return resp.json();
            }).then(() => {
                this.fetchPieces();
            }).catch((err) => {
                console.log(err);
            });
        },
        createPiece(data) {
            this.setLoading(true);

            const formData  = new FormData();
            for(const name in data) {
                formData.append(name, data[name]);
            }

            fetch(`${conf.apiUrl}/pieces`, {
                method: 'POST',
                body: formData,
                headers: {
                    "Accept": "application/json",
                    "Content-Type": "multipart/form-data",
                    "Authorization": `Bearer ${localStorage.getItem('token')}`
                },
            }).then((resp) => {
                return resp.json();
            }).then(() => {
                this.fetchPieces();
            }).catch((err) => {
                console.log(err);
            });


            // fetch(`${conf.apiUrl}/pieces`, {
            //     headers: {
            //         "Accept": "application/json",
            //         "Content-Type": "multipart/form-data",
            //         "Authorization": `Bearer ${localStorage.getItem('token')}`
            //     },
            //     method: "POST",
            //     body: JSON.stringify(data)
            // }).then((resp) => {
            //     return resp.json();
            // }).then(() => {
            //     this.fetchPieces();
            // }).catch((err) => {
            //     console.log(err);
            // });
        },
        fetchPieces() {
            this.setLoading(true);
            fetch(`${conf.apiUrl}/pieces?page=1`, {
                headers: {
                    "Accept": "application/json",
                    "Content-Type": "application/json",
                    "Authorization": `Bearer ${localStorage.getItem('token')}`
                },
                method: "GET"
            }).then((resp) => {
                return resp.json();
            }).then(data => {
                this.pieces = data;
                console.log(data);
                this.setLoading(false);
            });
        },
        resetModalData() {
            this.modalData = {};
        },
        fetchCategories() {
            this.setLoading(true);
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
                this.setLoading(false);
            });
        }
    }
}
;
</script>

<style scoped>
</style>
