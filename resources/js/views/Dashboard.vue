<template>
    <v-container>
        <h1 class="subheading grey--text">Proizvodi</h1>
        <v-btn @click="logout">Odjavi se</v-btn>
    </v-container>
</template>

<script>
export default {
    methods: {
        logout() {
            this.$store.dispatch('logout')
                .then(() => this.$router.push('/login'))
        }
    }
}
</script>
