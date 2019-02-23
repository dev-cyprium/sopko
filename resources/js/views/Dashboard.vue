<template>
    <v-content>
        <v-container>
            <h1 class="display-1">Dashboard</h1>
            <v-btn @click="logout">Log Out</v-btn>
        </v-container>
    </v-content>
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
-->