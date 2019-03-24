<template>
    <v-container fluid>
        <h1 class="title grey--text font-weight-light mb-3">Slike proizvoda</h1>
        <v-layout>
            <v-flex xs12>
                <v-card>
                    <v-card-title primary-title>
                        <h3 class="headline">Upravljanje slikama proizvoda</h3>
                        <v-spacer />
                        <div class="sp-d-flex justify-content-end">
                            <v-btn @click="dialog = true" class="skip-flex primary">Nova Slika</v-btn>
                        </div>
                    </v-card-title>
                    <v-container fluid>
                        <v-layout row wrap>
                            <v-flex
                            v-for="image in images"
                            :key="image.path"
                            xs3
                            d-flex
                            >
                            <v-card flat tile class="d-flex py-1 px-1">
                                <v-img
                                :src="image.path"
                                :lazy-src="image.path"
                                
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
                <v-card>
                    <v-card-title
                    class="headline"
                    primary-title
                    >
                        Dodajte Sliku
                        <h4 class="title grey--text font-weight-light mt-2 mb-1">(Postoji mogućnost prevlačenja slike)</h4>
                    </v-card-title>

                    <v-card-text>
                        <FileUpload ref="fileupload" />
                    </v-card-text>

                    <v-divider></v-divider>

                    <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn
                        color="primary"
                        flat
                        @click="handleDodaj"
                    >
                        Dodaj sliku
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
import FileUpload from '../components/FileUpload';

export default {
    components: {FileUpload},
    created() {
        this.$store.dispatch('images')
    },
    data() {
        return {
            dialog: false
        }
    },
    computed: {
       images() { return this.$store.state.images }
    },
    methods: {
        handleDodaj() {
            this.dialog = false
            this.$refs.fileupload.doFileUpload()
        }
    }
}
</script>
