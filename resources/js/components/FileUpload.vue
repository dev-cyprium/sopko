<template>
    <form ref="fileform">
        <v-layout v-if="!file" class="file-upload" fill-height align-center justify-center>
            <div>
                <div class="text-xs-center">
                    <v-icon x-large>cloud_upload</v-icon>
                </div>
                <h3 class="ml-2 text-xs-center">(jpeg,jpg,png,gif)</h3>  
                <v-btn class="primary mt-2" for="selected-image" tag="label">Izaberite sliku</v-btn>
                <input ref="myFile" @input="fileChoosen" class="d-none" id="selected-image" type="file">
            </div>

        </v-layout>
        <v-layout v-else>
            <v-img :src="src" height="200">
                <template v-slot:placeholder>
                    <v-layout
                    fill-height
                    align-center
                    justify-center
                    ma-0
                    >
                    <v-progress-circular indeterminate color="primary"></v-progress-circular>
                    </v-layout>
                </template>
            </v-img>
        </v-layout>
    </form>
</template>

<script>
export default {
    data() {
        return {
            dragAndDropCapable: false,
            file: null,
            src: ''
        }
    },
    mounted() {
        this.dragAndDropCapable = this.determineDragAndDropCapable()

        if(this.dragAndDropCapable) {
            ['drag', 'dragstart', 'dragend', 'dragover', 'dragenter', 'dragleave', 'drop'].forEach((evt) => {
                this.$refs.fileform.addEventListener(evt, (e) => {
                    e.preventDefault()
                    e.stopPropagation()
                }, false)
            })

            this.$refs.fileform.addEventListener('drop', (e) => {
                const file = e.dataTransfer.files[0]
                this.processFile(file)
            })
        }
    },
    methods: {
        determineDragAndDropCapable() {
            let div = document.createElement('div')

            return ( ( 'draggable' in div )
                    || ( 'ondragstart' in div && 'ondrop' in div ) )
                    && 'FormData' in window
                    && 'FileReader' in window
        },
        fileChoosen(ev) {
            this.processFile(this.$refs.myFile.files[0])
        },
        processFile(file) {
            if(/\.(jpe?g|png|gif)$/i.test(file.name)) {
                    let reader = new FileReader()
                    
                    reader.onload = () => {
                        setTimeout(() => {
                            this.src = reader.result
                        }, 500)
                    }

                    this.file = file
                    reader.readAsDataURL(file)
                }
        },
        doFileUpload() {
            return new Promise(resolve => {
                let reader = new FileReader()
                reader.onload = () => {
                    const bytes = new Uint8Array(reader.result)
                    this.$store.dispatch('new_image', {contentType: this.file.type, binary: bytes})
                        .then(() => { 
                            this.file = null
                            this.src = ''
                            resolve() 
                        })
                }
            
                reader.readAsArrayBuffer(this.file)
            })
        }
    }
}
</script>
