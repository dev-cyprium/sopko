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
                            <v-btn v-if="selectedImages.length == 0" @click="dialog = true" class="skip-flex primary">Nova Slika</v-btn>
                            <v-btn v-else class="skip-flex error" @click="deleteItems" >Obriši {{ selectedImages.length }}</v-btn>
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
                                <Selectable @click="itemClicked($event, image.path)">
                                    <v-img
                                    :src="image.path"
                                    :lazy-src="image.path"
                                    class="grey lighten-2 h100"
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
                                </Selectable>
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

        <v-dialog
            v-model="deletingProgress"
            width="500"
            persistent
            >
            <v-card>
                <v-card-title
                class="headline"
                primary-title
                >
                    Brisanje u toku
                </v-card-title>

                <v-card-text>
                    <div class="text-xs-center">
                        <v-progress-circular
                        :rotate="90"
                        :size="100"
                        :width="15"
                        :value="progressPercent"
                        color="red"
                        >
                        {{ progress }} / {{ totalItems }}
                        </v-progress-circular>
                    </div>
                </v-card-text>

                <v-card-actions>
                <v-spacer></v-spacer>
                    <v-btn color="error" flat>
                        Zaustavi
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

    .h100 {
        height: 100%;
    }
</style>


<script>
import FileUpload from '../components/FileUpload'
import Selectable from '../components/Selectable'

export default {
    components: {
        FileUpload,
        Selectable,
    },
    created() {
        this.$store.dispatch('images')
    },
    data() {
        return {
            dialog: false,
            deletingProgress: false,
            selectedImages: [],
            progress: 0,
            progressPercent: 0
        }
    },
    computed: {
       images() { return this.$store.state.images },
       totalItems() { return this.selectedImages.length }
    },
    methods: {
        handleDodaj() {
            this.dialog = false
            this.$refs.fileupload.doFileUpload()
        },
        itemClicked(selected, path) {
            if(selected) {
                this.selectedImages.push(path)
            } else {
                this.selectedImages = this.selectedImages.filter(item => item != path)
            } 
        },
        deleteItems() {
            this.deletingProgress = true
            this.progress = 0
            this.selectedImages.forEach(imagePath => {
                const hash = imagePath.split('/')[1];
                this.$store.dispatch('delete_image', hash)
                    .then(() => { 
                        this.progress++;
                        this.progressPercent = Math.floor((this.progress / this.totalItems) * 100)

                        if(this.progress === this.totalItems) {
                            this.selectedImages = []
                            this.deletingProgress = false
                        }
                     })
            })   
        }

    }
}
</script>
