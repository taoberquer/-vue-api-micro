<template>
    <div>


        <!-- Modal -->


        <div v-for="cat in categories" :key="cat.id">
            <div>
                {{ cat.name }}
            </div>
            <button @click="showModal(cat)" type="button" class="btn btn-primary" data-bs-toggle="modal"
                    :data-bs-target="`#modal-update`">
                Update
            </button>
        </div>
        <div :id="`modal-update`" class="modal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <Vuemik
                        :initialValues="{
                                  name: modalData.name,
                                }"
                        :onSubmit="updateCat"
                        v-slot="{ handleSubmit }"
                    >
                        <div class="modal-header">
                            <h5 class="modal-title">{{ modalData.name }}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label class="form-label">Name</label>
                                <Field name="name" component="input" class="form-control"/>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <Field class="btn btn-primary" value="Save" name="submit" component="input" type="submit"
                                   @click="handleSubmit"/>
                        </div>
                    </Vuemik>
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
    components: {
        Vuemik,
        Field,
    },
    data() {
        return {
            categories: [{
                name: "Slips",
            },
                {
                    name: "Others",
                }],
            modalData: {},
            modalShowed: false,
        }
    },
    beforeMount() {
        fetch(`${conf.apiUrl}/categories`, {
            headers: {
                "Accept": "application/json",
                "Content-Type": "application/json",
                "Authorization": `Bearer ${}`
            },
            method: "GET"
        }).then((resp) => {
            return resp.json();
        }).then(data => {
            console.log(data);
        });
    },
    methods: {
        showModal(cat) {
            this.modalData = cat;
        },
        closeModal() {
            this.modalData = null;
        },
        updateCat() {
            fetch(`${conf.apiUrl}/categories/${this.modalData.id}`, {
                headers: {
                    "Accept": "application/json",
                    "Content-Type": "application/json",
                },
                method: "PUT",
                body: JSON.stringify(this.modalData)
            }).then((resp) => {
                return resp.json();
            }).then(data => {
                console.log(data.token);
            })
            ;
        }
    }
};
</script>
<style>
.cursor-pointer {
    cursor: pointer;
}
</style>
