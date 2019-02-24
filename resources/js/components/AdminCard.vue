<template>
    <v-card class="pt-1 admin-card">
        <v-flex d-flex justify-center align-center :class="`box-icon ${color} elevation-3`">
            <v-icon dark>{{icon}}</v-icon>
        </v-flex>
        <v-card-title primary-title>
            <slot></slot>
        </v-card-title>
    </v-card>
</template>

<script>
export default {
    props: ['color', 'icon']
}
</script>
