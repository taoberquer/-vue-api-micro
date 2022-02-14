<template>
    <div class="w-100">
        <div v-if="errorMessage" class="alert alert-warning" role="alert">
            {{ errorMessage }}
        </div>
        <h1 class="mb-3">Donations</h1>
        <div v-if="donations.length > 0" class="w-100 d-flex align-items-center flex-column">
            <table class="table table-striped w-75">
                <thead>
                <tr>
                    <th scope="col">User</th>
                    <th scope="col">Status</th>
                    <th scope="col">Actions</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="donation in donations" :key="donation.id">
                    <td>{{ donation.user.email }}</td>
                    <td>{{ donation.status }}</td>
                    <td>
                        <button @click="setModalData(donation)" type="button" class="btn btn-primary"
                                data-bs-toggle="modal"
                                :data-bs-target="`#modal`">
                            Validate
                        </button>
                    </td>
                </tr>
                </tbody>
            </table>

            <div :id="`modal`" class="modal" tabindex="-1">
                <div class="modal-dialog">

                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">{{ modalData.name }}</h5>
                            <button @click="resetModalData" type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"/>
                        </div>
                        <Vuemik
                            :initialValues="{
                              name: ope === 'update' ? modalData.name : '',
                            }"
                            :onSubmit="confirmDonation"
                            v-slot="{ handleSubmit }"
                        >
                            <div class="modal-body">
                                <p>Validate the donation ?</p>
                                <label class="form-label">Credits</label>
                                <Field class="col" component="input" name="credits" type="number"/>
                            </div>

                            <div class="modal-footer">
                                <button @click="resetModalData" type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Close
                                </button>
                                <Field data-bs-dismiss="modal" class="btn btn-primary" name="submit"
                                       component="input" type="submit"
                                       @click="handleSubmit">Save
                                </Field>
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
            errorMessage: null,
        }
    },
    beforeMount() {
        this.fetchCategories();
        this.fetchDonations();
    },
    methods: {
        closeModal() {
            this.modalData = null;
        },
        confirmDonation(data) {
            this.setLoading(true);
            fetch(`${conf.apiUrl}/donations/${this.modalData.id}/confirm`, {
                headers: {
                    "Accept": "application/json",
                    "Content-Type": "application/json",
                    "Authorization": `Bearer ${localStorage.getItem('token')}`
                },
                method: "POST",
                body: JSON.stringify(data)
            }).then((resp) => {
                this.modalData = {};
                return resp.json();
            }).then(() => {
                this.fetchCategories();
            }).catch((err) => {
                this.setLoading(false);
                this.errorMessage = 'An error occured';
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
            }).catch((err) => {
                console.log("plouf")
                this.setLoading(false);
                this.errorMessage = "An error occured..."
                console.log(err);
            });
        },
        resetModalData() {
            this.modalData = {};
        },
        setModalData(donation) {
            this.modalData = donation;
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
            }).catch((err) => {
                this.setLoading(false);
                this.errorMessage = "An error occured..."
                console.log(err);
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
