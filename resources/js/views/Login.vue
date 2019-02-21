<template>
    <v-container fluid fill-height class="grey lighten-5">
        <v-layout align-center justify-center>
            <v-flex xs12 sm8 md4>
                <v-form @submit.prevent="login">
                    <v-card class="elevation-10">
                        <v-toolbar dark color="primary">
                            <v-toolbar-title>Šopko - Prijava Korisnika</v-toolbar-title>
                        </v-toolbar>
                        <v-card-text>
                            
                                <v-text-field 
                                    v-model="email"
                                    prepend-icon="email"
                                    name="email"
                                    label="Email"
                                    type="texdt"
                                />
                                <v-text-field 
                                    v-model="password"
                                    prepend-icon="lock"
                                    name="password"
                                    label="Password"
                                    type="password"
                                />

                        </v-card-text>
                        <v-card-actions>
                            <v-spacer></v-spacer>
                            <v-btn class="primary ml-2" :to="{name: 'register'}">Registruj Se</v-btn>
                            <v-btn type="submit" color="primary">Prijavi Se</v-btn>
                        </v-card-actions>
                    </v-card>
                </v-form>
            </v-flex>
        </v-layout>
    </v-container>
</template>

<script>

export default {
    data() {
        return {
            email: "",
            password: ""
        }
    },
    methods: {
        login() {
            const {email, password} = this;
            this.$store.dispatch('login', {email, password})
            .then(() => console.log("Success"))
            .catch(err => console.log(err))
        }
    }
}
</script>
