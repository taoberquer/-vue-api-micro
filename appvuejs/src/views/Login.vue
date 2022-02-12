<template>
    <div>
        <h3>Sign In</h3>
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

export default {
    inject: ['setAuth'],
    name: "Form",
    components: {Field, Vuemik},
    data: () => ({
        user: {email: '', password: ''}
    }),
    methods: {
        userLogin(user) {
            console.log(user.email);
            console.log(user.password);
            this.setAuth(user);

            localStorage.setItem('user', JSON.stringify({token: 'slkdjflkj', email: 'joe@joe.com', role: 'Admin'}))
            this.$router.push("/home");
        }
    },
};
</script>
