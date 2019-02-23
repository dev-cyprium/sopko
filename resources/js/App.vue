<template>
    <v-app class="grey lighten-4">
        <Navigation/>
        
        <v-content>
            <router-view />
        </v-content>
    </v-app>
</template>

<script>

import Navigation from './components/Navigation'

export default {

    components: {
        Navigation
    }
}
</script>
