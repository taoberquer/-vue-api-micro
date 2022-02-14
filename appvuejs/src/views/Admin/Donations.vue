<template>
    <div class="w-100">
        <h1 class="mb-3">Donations</h1>
        <div v-if="donations.length > 0" class="w-100 d-flex align-items-center flex-column">
            <table class="table table-striped w-75">
                <thead>
                <tr>
                    <th scope="col">Name</th>
                    <th scope="col">Actions</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="donation in donations" :key="donation.id">
                    <td>{{ donation.name }}</td>
                    <td>
                        <button @click="showModal(donation)" type="button" class="btn btn-primary" data-bs-toggle="modal"
                                :data-bs-target="`#modal`">
                            Update
                        </button>
                    </td>
                </tr>
                </tbody>
            </table>
            <button @click="showModal(null)" type="button" class="btn btn-primary" data-bs-toggle="modal"
                    :data-bs-target="`#modal`">
                Create
            </button>

            <div :id="`modal`" class="modal" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <Vuemik
                            :initialValues="{
                          name: ope === 'update' ? modalData.name : '',
                        }"
                            :onSubmit="ope == 'update' ? updateDon : createDon"
                            v-slot="{ handleSubmit }"
                        >
                            <div class="modal-header">
                                <h5 class="modal-title">{{ modalData.name }}</h5>
                                <button @click="resetModalData" type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label class="form-label">Name</label>
                                    <Field name="name" component="input" class="form-control"/>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button @click="resetModalData" type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Close
                                </button>
                                <Field data-bs-dismiss="modal" class="btn btn-primary" value="Save" name="submit"
                                       component="input" type="submit"
                                       @click="handleSubmit"/>
                            </div>
                        </Vuemik>
                    </div>
                </div>
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
            donations: [],
            modalData: {},
            modalShowed: false,
            ope: '',
        }
    },
    beforeMount() {
        this.fetchCategories();
        this.fetchDonations();
    },
    methods: {
        showModal(cat) {
            this.ope = cat == null ? 'create' : 'update';
            this.modalData = cat;
        },
        closeModal() {
            this.modalData = null;
        },
        updateDon(data) {
            this.setLoading(true);
            fetch(`${conf.apiUrl}/donations/${this.modalData.id}`, {
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
                this.fetchCategories();
            }).catch((err) => {
                console.log(err);
            });
        },
        createDon(data) {
            this.setLoading(true);
            fetch(`${conf.apiUrl}/donations`, {
                headers: {
                    "Accept": "application/json",
                    "Content-Type": "application/json",
                    "Authorization": `Bearer ${localStorage.getItem('token')}`
                },
                method: "POST",
                body: JSON.stringify(data)
            }).then((resp) => {
                return resp.json();
            }).then(() => {
                this.fetchCategories();
            }).catch((err) => {
                console.log(err);
            });
        },
        fetchCategories() {
            this.setLoading(true);
            fetch(`${conf.apiUrl}/donations?page=1`, {
                headers: {
                    "Accept": "application/json",
                    "Content-Type": "application/json",
                    "Authorization": `Bearer ${localStorage.getItem('token')}`
                },
                method: "GET"
            }).then((resp) => {
                return resp.json();
            }).then(data => {
                this.donations = data;
                this.setLoading(false);
            });
        },
        resetModalData() {
            this.modalData = {};
        },
        fetchDonations() {
            this.setLoading(true);
            fetch(`${conf.apiUrl}/donations?page=1`, {
                headers: {
                    "Accept": "application/json",
                    "Content-Type": "application/json",
                    "Authorization": `Bearer ${localStorage.getItem('token')}`
                },
                method: "GET"
            }).then((resp) => {
                return resp.json();
            }).then(data => {
                console.log(data)
                this.donations = data;
                this.setLoading(false);
            });
        }
    }
}
;
</script>
<style>
.cursor-pointer {
    cursor: pointer;
}
</style>
