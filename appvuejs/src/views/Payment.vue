<template>
    <div>
        <h3>Payment</h3>
        <Vuemik
            :initialValues="{}"

            :onSubmit="sendPayment"
            :errorMessage="errorMessage"
            v-slot="{ handleSubmit }"
        >
            <div class="mb-3">
                <label class="form-label">Address</label>
                <Field name="address" component="input" type="text" class="form-control"/>
            </div>
            <div class="mb-3">
                <label class="form-label">City</label>
                <Field name="city" component="input" type="text" class="form-control"/>
            </div>
            <div class="mb-3">
                <label class="form-label">Zip Code</label>
                <Field name="zip_code" component="input" type="number" class="form-control"/>
            </div>
            <div class="mb-3">
                <p>Your credits : <span style="’color: ${user.credits > cart.length ? 'black' : 'red'}’" >{{ user.credits }}</span></p>
                <p>Payment Total : {{ cart.length }}</p>
            </div>
            <Field name="submit" component="input" type="submit" @click="handleSubmit"/>
        </Vuemik>
    </div>
</template>

<script>
import Vuemik from "../../lib/Vuemik/Vuemik";
import Field from "../../lib/Vuemik/Field";
import {conf} from "../conf.js";

export default {
    inject: ['setLoading', 'getUser'],
    name: "payment",
    components: {Field, Vuemik},
    data: () => ({
        errorMessage: null,
        cart: JSON.parse(localStorage.getItem('cart')) || [],
        user: JSON.parse(localStorage.getItem('realUser')) || {},
    }),
    mounted() {
        console.log(this.user);
    },
    methods: {
        sendPayment(proxy) {
            const data = {
                "piece_ids": this.cart,
                "address": proxy.address,
                "city": proxy.city,
                "zip_code": proxy.zip_code,
            };
            console.log(data);
            const requestOptions = {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "Authorization": "Bearer " + localStorage.getItem('token'),
                },
                body: JSON.stringify(data),
            };
            fetch(conf.apiUrl + '/orders/confirm', requestOptions)
                .then(data => {
                    if (data.error) {
                        this.errorMessage = data.error;
                    } else {
                        this.errorMessage = null;
                        this.cart = [];
                        localStorage.setItem('cart', JSON.stringify(this.cart));
                    }
                });
        },
    },
}
</script>
