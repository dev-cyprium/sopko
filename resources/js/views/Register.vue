<template>
    <v-container fluid fill-height class="show-pattern">
        <v-layout align-center justify-center>
            <v-flex xs12 sm8 md4>
                <v-card class="elevation-10">
                    <v-toolbar dark color="primary">
                        <v-toolbar-title>Šopko - Registracija</v-toolbar-title>
                    </v-toolbar>
                    <v-card-text>
                        <p>Trebaće nam Vaši kredencijali kako bi ste se prijavili kasnije</p>
                        <v-form>
                            <v-text-field 
                                prepend-icon="email"
                                name="email"
                                label="Email"
                                type="texdt"
                            />
                            <v-text-field 
                                prepend-icon="lock"
                                name="password"
                                label="Password"
                                type="password"
                            />
                        </v-form>
                    </v-card-text>
                    <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn class="primary ml-2" :to="{name: 'register'}">Registruj Se</v-btn>
                        <v-btn color="primary">Prijavi Se</v-btn>
                    </v-card-actions>
                </v-card>
            </v-flex>
        </v-layout>
    </v-container>
</template>

<script>
import '../img/folk-pattern.png'

export default {

}
</script>
