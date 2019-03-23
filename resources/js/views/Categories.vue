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
                                transition
                                item-key="name"
                            >    
                                <template v-slot:prepend="{ item, open }">
                                    <v-icon v-if="item.children" class="primary--text">
                                        {{ open ? 'folder_open' : 'folder' }}
                                    </v-icon>
                                    <v-icon class="primary--text" v-else>
                                        filter_list
                                    </v-icon>
                                </template>
                                <template v-slot:label="{item}">
                                    <v-menu offset-y>
                                        <template v-slot:activator="{ on }">
                                            <a color="primary" v-on="on">
                                                {{ item.name }}
                                            </a>
                                        </template>
                                        <v-list class="py-0">
                                            <v-list-tile @click="edit(item)">
                                                <v-list-tile-title>
                                                    <v-icon>edit</v-icon>
                                                    Edit
                                                </v-list-tile-title>
                                            </v-list-tile>
                                            <v-list-tile @click="handleCategoryDelete(item)" class="error white--text my-0">
                                                <v-list-tile-title>
                                                    <v-icon class="white--text">delete</v-icon>
                                                    Delete
                                                </v-list-tile-title>
                                            </v-list-tile>
                                        </v-list>
                                    </v-menu>
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
                <v-btn color="error"   flat @click="dialog = false; editing = false; categoryName = ''">Zatvori</v-btn>
                <v-btn color="primary" flat @click="handleDialog">{{ dialogLabel }}</v-btn>
                </v-card-actions>
            </v-card>
            </v-dialog>
    </v-container>    
</template>

<script>
import Vue from 'vue'
import { mapState } from 'vuex'

export default {
    mounted() {
        this.$store.dispatch('categories')
    },
    data() {
        return {
            dialog: false,
            editing: false,
            search: '',
            open: ['Aktivne Kategorije'],
            tree: [],
            parent: '',
            categoryName: '',
            editCategoryText: ''
        }
    },
    watch: {
        dialog(newDialog, oldDialog) {
            if(!newDialog && oldDialog)
                this.editing = false
        }
    },
    computed: { 
        ...mapState({
            allCategories: state => state.productCategories.map(category => category.title)
        }),
        items() {
            const state = this.parseAPIState(this.$store.state.productCategories)
            this.open = ['Aktivne Kategorije']
            return state;
        },
        dialogLabel() {
            return this.editing ? "Sačuvaj Izmene" : "Dodaj Kategoriju"
        }
    },
    methods: {
        extractPath(root, meta) {
            let path = []
            let failSafe = 0
            while(meta[root.id]) {
                path.push(root.name)
                root = meta[root.id]

                failSafe++
                if(failSafe > 500) break
            }

            return path
        },
        bfs(parent, items, withPath = false) {
            let queue = [...items]
            let meta = {};
            while(queue.length > 0) {
                const item = queue.shift()
                
                if(item.id === parent) {
                    if(withPath) {
                        return {item, path: this.extractPath(item, meta)}
                    }
                    return {item, path: []}
                }

                if(item.children) {
                    item.children.forEach(child => {
                        if(withPath) {
                            meta[child.id] = item
                        }
                        queue.unshift(child)
                    })
                }
            }
            return {item: null, path: []}
        },
        edit(item) {
            if(item === 'Aktivne Kategorije') {
                return
            }

            this.dialog  = true
            this.editing = true
            this.categoryName = item.name
            this.editCategoryText = item.name
        },
        parseAPIState(categories) {
            let failSafe = 0
            let items = [{
                name: 'Aktivne Kategorije',
                children: []
            }]
            let categ = [...categories]

            while(items.length <= categ.length) {
                const c = categ.pop()
                if(c.parent_category_id === null) {
                    items[0].children.push({name: c.title, id: c.id})
                } else {
                    const {item: node} = this.bfs(c.parent_category_id, items)
                    if(node) {
                        if(node.children) {
                            node.children.push({name: c.title, id: c.id})
                        } else {
                            node.children = [{name: c.title, id: c.id}]
                        }
                    } else {
                        categ.unshift(c)
                    }
                }

                failSafe++
                if(failSafe > 500) break
            }
            return items
        },
        handleDialog() {
            if(this.editing) {
                this.editCategory()
            } else {
                this.newCategory()
            }
        },
        editCategory() {
            let data = {};
            const id = this.$store.getters.categoryID(this.editCategoryText)
            data.title = this.categoryName
            if(this.parent !== '') {
                data.parent_category_id = this.$store.getters.categoryID(this.parent)
            } else {
                data.parent_category_id = null;
            }
            
            this.editCategoryText = ''
            this.$store.dispatch('update_category', {data, id}).then(() => {
                this.dialog = false
                this.editing = false
                this.parent = ''
            });
        },
        newCategory() {
            const title = this.categoryName
            const parent_category_id = this.$store.getters.categoryID(this.parent)
            
            this.$store.dispatch('new_category', {title, parent_category_id})
                .then(() => {
                    if(this.parent.length > 0) {
                        const {path} = this.bfs(parent_category_id, this.items, true)
                        path.forEach(elem => this.open.push(elem))
                    }
                    
                    this.categoryName = ''
                    this.parent = ''
                })
        },
        handleAddNew() {
            const title = this.search
            const parent_category_id = null;
            this.$store.dispatch('new_category', {title, parent_category_id})
            .then(() => {
                this.parent = title
            })
        },
        handleCategoryDelete({id}) {
            this.$store.dispatch('delete_category', id)
        }
    }
}
</script>

