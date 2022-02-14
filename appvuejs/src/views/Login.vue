<template>
    <div>
        <h3>Login</h3>
        <Vuemik
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
    inject: ['setAuth', 'setLoading'],
    name: "Form",
    components: {Field, Vuemik},
    data: () => ({
        user: {email: '', password: ''},
    }),
    methods: {
        userLogin(user) {
            this.setLoading(true);
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
                this.setAuth(data.token);
                this.setLoading(false);
                this.$router.push("/");
            })
                .catch((err) => {
                    this.setLoading(false);
                    console.log(err);
                });
            localStorage.setItem('cart', JSON.stringify([]));
        }
    },
};
</script>
