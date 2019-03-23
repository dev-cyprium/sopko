<template>
    <v-container fluid>
        <h1 class="title grey--text font-weight-light mb-3">Slike proizvoda</h1>
        <v-layout>
            <v-flex>
                <v-card>
                    <v-card-title primary-title>
                        <h3 class="headline">Slike Proizvoda</h3>
                        <v-spacer />
                        <div class="sp-d-flex justify-content-end">
                            <v-btn @click="dialog = true" class="skip-flex primary">Nova Slika</v-btn>
                        </div>
                    </v-card-title>
                    <v-container fluid>
                        <v-layout row wrap>
                            <v-flex
                            v-for="n in 9"
                            :key="n"
                            xs4
                            d-flex
                            >
                            <v-card flat tile class="d-flex py-1 px-1">
                                <v-img
                                :src="`https://picsum.photos/500/300?image=${n * 5 + 10}`"
                                :lazy-src="`https://picsum.photos/10/6?image=${n * 5 + 10}`"
                                width="300"
                                class="grey lighten-2"
                                >
                                <template v-slot:placeholder>
                                    <v-layout
                                    fill-height
                                    align-center
                                    justify-center
                                    ma-0
                                    >
                                    <v-progress-circular indeterminate color="grey lighten-5"></v-progress-circular>
                                    </v-layout>
                                </template>
                                </v-img>
                            </v-card>
                            </v-flex>
                        </v-layout>
                    </v-container>
                </v-card>
            </v-flex>
        </v-layout>

        <v-dialog
            v-model="dialog"
            width="500"
            >
                <template v-slot:activator="{ on }">
                    <v-btn
                        color="red lighten-2"
                        dark
                        v-on="on"
                    >
                    Click Me
                    </v-btn>
                </template>

                <v-card>
                    <v-card-title
                    class="headline"
                    primary-title
                    >
                    Dodajte Sliku
                    </v-card-title>

                    <v-card-text>
                        <v-layout class="file-upload" fill-height align-center justify-center>
                            <v-icon x-large>cloud_upload</v-icon>
                            <h3 class="ml-2">Upload a file</h3>
                        </v-layout>
                    </v-card-text>

                    <v-divider></v-divider>

                    <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn
                        color="primary"
                        flat
                        @click="dialog = false"
                    >
                        I accept
                    </v-btn>
                    </v-card-actions>
                </v-card>
            </v-dialog>
    </v-container>
</template>

<style>
    .file-upload {
        min-height: 15rem;
        border: 1px dashed gray;
    }
</style>


<script>
export default {
    data() {
        return {
            dialog: false
        }
    }
}
</script>
