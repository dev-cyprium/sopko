<template>
    <v-container fluid>
        <h1 class="title grey--text font-weight-light">Proizvodi</h1>
        <v-layout mt-5 row wrap>
            <v-flex xs12 md3 class="px-2 py-2">
                <AdminCard color="primary" icon="trending_up">
                    <h3 class="font-weight-light text-xs-right w-100">Uvezeno danas</h3>
                    <p class="primary--text text-xs-right w-100 display-2 font-weight-thin">503</p>
                </AdminCard>
            </v-flex>
            <v-flex xs12 md3 class="px-2 py-2">
                <AdminCard color="info" icon="trending_up">
                    <h3 class="font-weight-light text-xs-right w-100">Izevzeno danas</h3>
                    <p class="info--text text-xs-right w-100 display-2 font-weight-thin">150</p>
                </AdminCard>
            </v-flex>
            <v-flex xs12 md3 class="px-2 py-2">
                <AdminCard color="orange" icon="attach_money">
                    <h3 class="font-weight-light text-xs-right w-100">Mesečna Zarada</h3>
                    <p class="orange--text text-xs-right w-100 display-2 font-weight-thin">
                        2200.94 RSD
                    </p>
                </AdminCard>
            </v-flex>
            <v-flex xs12 md3 class="px-2 py-2">
                <AdminCard color="indigo" icon="shop">
                    <h3 class="font-weight-light text-xs-right w-100">Aktivnih popusta</h3>
                    <p class="indigo--text text-xs-right w-100 display-2 font-weight-thin">4</p>
                </AdminCard>
            </v-flex>
        </v-layout>

        <v-layout>
            <v-flex xs12 class="px-2 py-2">
                <v-card>
                    <v-card-title>
                        <h1>Proizvodi</h1>
                    </v-card-title>
                        <v-data-table 
                            :headers="headers" 
                            :items="serverProducts" 
                            :pagination.sync="pagination"
                            :loading="loading"
                            :total-items="total"
                            class="elevation-1">
                            <template v-slot:items="{item}">
                                <td class="pt-2 pb-1">
                                    <img src="https://via.placeholder.com/75">
                                </td>
                                <td class="text-xs-left">{{ item.name }}</td>
                                <td class="text-xs-left">{{ item.prices[0].price }}</td>
                                <td class="text-xs-left">100</td>
                                <td class="text-xs-left">
                                    <a href="#">
                                        {{ item.storages[0].address }}
                                    </a>
                                </td>
                            </template>
                        </v-data-table>
                </v-card>
            </v-flex>
        </v-layout>

    </v-container>
</template>

<script>
    import AdminCard from '../components/AdminCard'
    import products from './mocks/products'
    import axios from 'axios'

    export default {
        components: {
            AdminCard
        },
        data() {
            return {
                headers: [{
                        text: 'Slika Proizvoda',
                        align: 'left',
                        sortable: false,
                        value: 'img'
                    },
                    {
                        text: 'Naziv',
                        value: 'name'
                    },
                    {
                        text: 'Trenutna Cena',
                        value: 'current_price'
                    },
                    {
                        text: 'Stanje',
                        value: 'quantity'
                    },
                    {
                        text: 'Skladište',
                        value: 'storage.location'
                    }
                ],
                products,
                serverProducts: [],
                loading: true,
                pagination: {},
                total: 0
            }
        },
        watch: {
            pagination: {
                handler () {
                    this.getDataFromApi()
                        .then(data => {
                            this.serverProducts = data.products
                        })
                },
                deep: true
            }
        },
        mounted() {
            
        },
        methods: {
            getDataFromApi() {
                this.loading = true
                return new Promise(resolve => {
                    const { page, rowsPerPage } = this.pagination

                    setTimeout(() => {
                        const uri = `/api/admin/products?per_page=${rowsPerPage}&page=${page}`;
                        axios.get(uri)
                            .then(resp => { 
                                this.total = resp.data.meta.total
                                this.loading = false
                                resolve(resp.data) 
                            })
                    }, 1300)
                })
            }
        }
    }

</script>
