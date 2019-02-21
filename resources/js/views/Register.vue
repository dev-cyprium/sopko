<template>
    <v-container fluid fill-height class="grey lighten-5">
        <v-layout align-center justify-center>
            <v-flex xs12 sm8 md4>
                <v-card class="elevation-10">
                    <v-toolbar dark color="primary">
                        <v-toolbar-title>Šopko - Registracija</v-toolbar-title>
                    </v-toolbar>
                    <v-card-text>
                        <v-stepper v-model="el" class="elevation-0">
                            <v-stepper-header class="elevation-0">
                                <v-stepper-step :complete="el > 1" step="1">
                                    Kredencijali
                                </v-stepper-step>

                                <v-divider></v-divider>

                                <v-stepper-step :complete="el > 2" step="2">
                                    Kontakt
                                </v-stepper-step>

                                <v-divider></v-divider>

                                <v-stepper-step :complete="el > 3" step="3">
                                    Integracija
                                </v-stepper-step>
                            </v-stepper-header>
                           <v-stepper-items>
                               <v-stepper-content step="1" class="elevation-0">
                                   <p>Trebaće nam Vaši kredencijali kako bi ste se prijavili kasnije</p>
                                        <v-form v-model="valid" ref="form1">
                                            <v-text-field 
                                                v-model="email"
                                                :rules="emailRules"
                                                prepend-icon="email"
                                                label="Email"
                                                type="text"
                                            />
                                            <v-text-field 
                                                v-model="password"
                                                :rules="passwordRules"
                                                :append-icon="show1 ? 'visibility_off' : 'visibility'"
                                                @click:append="show1 = !show1"
                                                prepend-icon="lock"
                                                label="Lozinka"
                                                :type="show1 ? 'text' : 'password'"
                                            />
                                            <v-text-field 
                                                v-model="passwordConfirm"
                                                :error-messages='passwordConfirmation()'
                                                prepend-icon="lock"
                                                label="Ponvljena Lozinka"
                                                type="password"
                                            />
                                        </v-form>
                               </v-stepper-content>
                               <v-stepper-content step="2" class="elevation-0">
                                   <p>Sada, trebaće nam Vaš kontakt kako bi bili dostupni za eventualna pitanja</p>
                                        <v-form v-model="valid" ref="form2">
                                            <v-text-field 
                                                v-model="telephone1"
                                                :rules="telephoneRules"
                                                prepend-icon="phone"
                                                label="Telefon 1"
                                                type="text"
                                            />
                                            <v-text-field 
                                                v-model="telephone2"
                                                :rules="telephoneRules"
                                                prepend-icon="phone"
                                                label="Telefon 2"
                                                type="text"
                                            />
                                            <v-text-field 
                                                v-model="fullName"
                                                :rules="fullNameRules"
                                                prepend-icon="person"
                                                label="Puno Ime"
                                                type="text"
                                            />
                                        </v-form>
                               </v-stepper-content>
                               <v-stepper-content step="3" class="elevation-0">
                                   <p class="body-2">Hvala Vam što ste se regitrovali. Hajdemo da krenemo sa integracijom</p>
                                    <v-btn block class="orange white--text mt-4">
                                        Kreni sa API integracijom
                                        <v-icon right dark>public</v-icon>
                                    </v-btn>
                                    <v-btn block class="success mt-4">
                                        Kreni sa WEB integracijom
                                        <v-icon right dark>perm_media</v-icon>
                                    </v-btn>
                               </v-stepper-content>
                           </v-stepper-items>
                        </v-stepper>
                    </v-card-text>
                    <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn v-show="el != 3" color="primary" @click="validateStep()">Nastavi</v-btn>
                    </v-card-actions>
                </v-card>
            </v-flex>
        </v-layout>
    </v-container>
</template>

<script>

export default {
    data: () => ({
        el: 1,
        valid: true,
        show1: false,
        email: '',
        emailRules: [
            v => !!v || 'Email polje je obavezno',
            v => /.+@.+/.test(v) || 'Email mora biti validan'
        ],
        password: '',
        passwordRules: [
            v => !!v || 'Lozinka polje je obavezno',
            v => /^(?=.*[A-Z])(?=.*[\$\@\.\&\?\%\#\!]).{6,}$/.test(v) 
                || 'Lozinka mora biti najmanje 6 karaktera i sadrzati veliko slovo i bar jedan specijalni karakter'
        ],
        passwordConfirm: '',
        telephone1: '',
        telephone2: '',
        telephoneRules: [
            v => v === "" || /^\+?\d{4,12}$/.test(v) || 'Telefon nije u dobrom formatu'
        ],
        fullName: '',
        fullNameRules: [
            v => !!v || 'Puno Ime polje je obavezno'
        ]
    }),
    methods: {
        passwordConfirmation() {
            return (this.password === this.passwordConfirm) ? '' : 'Lozinke nisu iste'
        },
        validateStep() {
            const form = this.$refs['form' + this.el]
            form.validate()

            if(this.valid) {
                this.valid = false;
                this.el +=  1
            }
        }
    }
}
</script>
