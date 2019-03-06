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
import { mapState } from 'vuex'

export default {
    mounted() {
        this.$store.dispatch('categories')
    },
    data() {
        return {
            dialog: false,
            search: '',
            // allCategories: ['Tehnologija', 'Namirnice', 'Razno'],
            open: [],
            tree: [],
            /*
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
            ], */
            parent: '',
            categoryName: ''

        }
    },
    computed: { 
        ...mapState({
            allCategories: state => state.productCategories.map(category => category.title)
        }),
        items() {
            return this.parseAPIState(this.$store.state.productCategories)
        }
    },
    methods: {
        bfs(parent, items) {
            let queue = [...items]
            while(queue.length > 0) {
                const item = queue.shift()
                
                if(item.id === parent) {
                    return item
                }

                if(item.children) {
                    item.children.forEach(child => queue.unshift(child))
                }
            }
            return null
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
                    const node = this.bfs(c.parent_category_id, items)
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
            this.open = ['Aktivne Kategorije']
            return items
        },
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
    }
}
</script>

