<template>
    <v-container fluid>
        <h1 class="title grey--text font-weight-light mb-3">Kategorije</h1>
        <v-layout>
            <v-flex xs12>
                <v-card>
                    <v-card-title primary-title>
                        <div class="w-100">
                            <div class="d-flex mb-3 w-100">
                                <h3 class="headline">Postojeće kategorije</h3>
                                <v-spacer />
                                <div class="sp-d-flex justify-content-end">
                                    <v-btn @click="dialog = !dialog" class="skip-flex primary">Nova Kategorija</v-btn>
                                </div>
                            </div>
                            <v-treeview 
                                v-model="tree"
                                :open="open"
                                :items="items"
                                activable
                                item-key="name"
                                open-on-click
                            >    
                                <template v-slot:prepend="{ item, open }">
                                    <v-icon v-if="item.children" class="primary--text">
                                        {{ open ? 'folder_open' : 'folder' }}
                                    </v-icon>
                                    <v-icon class="primary--text" v-else>
                                        filter_list
                                    </v-icon>
                                </template>
                            </v-treeview>
                        </div>
                    </v-card-title>
                </v-card>
            </v-flex>
        </v-layout>

        <v-dialog v-model="dialog" max-width="600px">
            <v-card>
                <v-card-title>
                    <span class="headline">Nova Kategorija</span>
                </v-card-title>
                <v-card-text>
                    <v-container grid-list-md>
                        <v-layout wrap>
                            <v-flex xs12>
                                <v-text-field v-model="categoryName" label="Naziv Kategorije*" required></v-text-field>
                            </v-flex>
                            <v-flex xs12>
                                <v-autocomplete
                                    v-model="parent"
                                    :search-input.sync="search"
                                    :items="allCategories"
                                    label="Nad Kategorija"
                                >
                                    <template v-slot:no-data>
                                        <v-layout>
                                            <h3 class="px-2 py-2">Nema podataka</h3>
                                            <v-btn @click="handleAddNew">Dodaj? {{ search }}</v-btn>
                                        </v-layout>
                                    </template>
                                    <template v-slot:item="{item}">
                                        <v-list-tile-avatar>
                                            <v-icon class="primary--text">filter_list</v-icon>
                                        </v-list-tile-avatar>
                                        <v-list-tile-title>
                                            {{ item }}
                                        </v-list-tile-title>
                                    </template>
                                </v-autocomplete>
                            </v-flex>
                        </v-layout>
                    </v-container>
                </v-card-text>
                <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn color="error"   flat @click="dialog = false">Zatvori</v-btn>
                <v-btn color="primary" flat @click="newCategory">Doadj Kategoriju</v-btn>
                </v-card-actions>
            </v-card>
            </v-dialog>
    </v-container>    
</template>

<script>
import Vue from 'vue'

export default {
    data() {
        return {
            dialog: false,
            search: '',
            allCategories: ['Tehnologija', 'Namirnice', 'Razno'],
            open: ['Aktivne Kategorije'],
            tree: [],
            items: [
                {
                    name: 'Aktivne Kategorije',
                    children: [
                        {
                            name: 'Tehnologija',
                        },
                        {
                            name: 'Namirnice',
                        },
                        {
                            name: 'Razno'
                        }
                    ]
                }
            ],
            parent: '',
            categoryName: ''

        }
    },
    methods: {
        newCategory() {
            this.dialog = false
            this.addNew(this.categoryName, this.parent)
            this.allCategories = [...this.allCategories, this.categoryName]
            
            console.log(this.parent.length)
            if(this.parent.length > 0) 
                this.open = [...this.open, this.parent]
            
            this.categoryName = ''
            this.parent = ''
        },
        handleAddNew() {
            this.allCategories = [...this.allCategories, this.search]
            this.parent  = this.search
            this.search = ''
        },
        addNew(category, parent) {
            const queue = [...this.items[0].children];

            if(parent === '') {
                this.items[0].children = [...this.items[0].children, {name: category}]
                return
            }

            while(queue.length > 0) {
                let item = queue.shift()

                if(item.name === parent) {
                    if(item.children) {
                        item.children = [...item.children, {name: category}]
                        return
                    } else {
                        Vue.set(item, 'children', [{name: category}])
                        return
                    }
                }

                if(item.children) {
                    item.children.forEach(child => queue.unshift(child))
                }
            }

            this.items[0].children = [...this.items[0].children, {name: category}]
        }
    }
}
</script>

