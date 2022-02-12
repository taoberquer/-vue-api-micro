<template>
    <div>
        <h3>Sign In</h3>
        <Vuemik
            :initialValues="{
          email: user.email,
          password: user.password,
        }"
            :onSubmit="userRegister"
            :errorMessage="errorMessage"
            v-slot="{ handleSubmit }"
        >
            <div class="mb-3">
                <label class="form-label">Email address</label>
                <Field name="email" component="input" type="email" class="form-control"/>
            </div>
            <div class="mb-3">
                <label class="form-label">Password</label>
                <Field name="password" component="input" type="password" class="form-control"/>
            </div>
            <div class="mb-3">
                <label class="form-label">Password</label>
                <Field name="confirmPassword" component="input" type="password" class="form-control"/>
            </div>
            <Field name="submit" component="input" type="submit" @click="handleSubmit"/>
        </Vuemik>
    </div>
</template>

<script>
import Vuemik from "../../lib/Vuemik/Vuemik";
import Field from "../../lib/Vuemik/Field";

export default {
    name: "Form",
    components: {Field, Vuemik},
    data: () => ({
        user: {email: '', password: '', confirmPassword: ''},
        errorMessage: null,
    }),
    methods: {
        userRegister(user) {
            // register

            // good
            this.$router.push('/login');


            // pas good
            console.log(user)
            this.errorMessage = "Probleme sur l'inscription.";
        },
        checkSamePasswords: function(val) {
            return val == this.vm.password;
        }
    },
};
</script>
