<template>
    <div>
        <h3>Sign In</h3>
        <div v-if="isLoading === true" class="d-flex justify-content-center">
            <div class="spinner-border" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
            </div>
        <Vuemik v-else
                :initialValues="{
          email: user.email,
          password: user.password,
        }"
                :onSubmit="userLogin"
                v-slot="{ handleSubmit }"
        >
            <div class="mb-3">
                <label class="form-label">Email address</label>
                <Field name="email" component="input" class="form-control"/>
            </div>
            <div class="mb-3">
                <label class="form-label">Password</label>
                <Field name="password" component="input" type="password" class="form-control"/>
            </div>
            <Field name="submit" component="input" type="submit" @click="handleSubmit"/>
        </Vuemik>

    </div>
</template>

<script>
import Vuemik from "../../lib/Vuemik/Vuemik";
import Field from "../../lib/Vuemik/Field";
import {conf} from "../conf";

export default {
    inject: ['setAuth'],
    name: "Form",
    components: {Field, Vuemik},
    data: () => ({
        user: {email: '', password: ''},
        isLoading: false
    }),
    methods: {
        userLogin(user) {
            this.isLoading = true;
            fetch(`${conf.apiUrl}/authentication_token`, {
                headers: {
                    "Accept": "application/json",
                    "Content-Type": "application/json",
                },
                method: "POST",
                body: JSON.stringify({
                    email: user.email,
                    password: user.password
                })
            }).then((resp) => {
                return resp.json();
            }).then(data => {
                console.log(data.token);
                this.setAuth(data.token);
                this.isLoading = false;
                this.$router.push("/");
            });
        }
    },
};
</script>
