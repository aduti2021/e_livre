<template>
    <div>
        <v-card class="mt-3">
            <v-toolbar
                flat
                dark
                color="primary"
            >
                <v-toolbar-title>Paramètres</v-toolbar-title>
            </v-toolbar>
            <v-tabs :vertical="!isMobile">
                <v-tab >
                    <v-icon  left>
                        fa-spinner
                    </v-icon>
                    Mon Compte
                </v-tab>
                <v-tab>
                    <v-icon left>
                        fa-check
                    </v-icon>
                    Mot de passe
                </v-tab>

                <v-tab-item>

                    <v-card flat>
                        <v-card-title class="blue lighten-3">
                            Informations du compte Administrateur
                        </v-card-title>
                        <v-row class="mx-2 mt-3">
                            <v-col
                                class="align-center justify-space-between"
                                cols="12"
                            >
                                <v-row
                                    align="center"
                                    class="mr-0"
                                >
                                    <v-avatar
                                        size="40px"
                                        class="mx-3"
                                    >
                                        <img
                                            :src="lien_site+'/img/user.png'"
                                            alt=""
                                        >
                                    </v-avatar>
                                    <v-text-field
                                        clearable
                                        v-model="FormAbs.nom"
                                        :disabled="loadform || !modifier_form"
                                        placeholder="Nom et prenom"
                                        class="mt-3"
                                        :error="ErrorB.nom"
                                        :error-messages="ErrorT.nom"

                                    />
                                </v-row>
                            </v-col>
                            <v-col cols="12">
                                <v-text-field
                                    prepend-icon="fa-user-tie"
                                    v-model="FormAbs.name"
                                    :disabled="loadform || !modifier_form"
                                    placeholder="Nom utilisateur"
                                    clearable
                                    :error="ErrorB.name"
                                    :error-messages="ErrorT.name"
                                />
                            </v-col>

                            <v-col cols="12">
                                <v-text-field
                                    prepend-icon="mdi-wallet-travel"
                                    v-model="FormAbs.post"
                                    :disabled="loadform || !modifier_form"
                                    placeholder="Poste occupé"
                                    clearable
                                    :error="ErrorB.post"
                                    :error-messages="ErrorT.post"
                                />
                            </v-col>



                            <v-col cols="12">
                                <v-text-field
                                    prepend-icon="mail"
                                    v-model="FormAbs.email"
                                    :disabled="loadform || !modifier_form"
                                    placeholder="Email"
                                    clearable
                                    :error="ErrorB.email"
                                    :error-messages="ErrorT.email"
                                />
                            </v-col>
                            <v-col cols="12">
                                <v-radio-group   :disabled="loadform || !modifier_form"  v-model="FormAbs.sex" row>
                                    <v-radio color="success"   label="Homme" value="H"></v-radio>
                                    <v-radio color="success"   label="Femme" value="F"></v-radio>
                                </v-radio-group>

                            </v-col>
                            <v-col cols="12">
                                <v-text-field
                                    type="number"
                                    prepend-icon="phone"
                                    v-model="FormAbs.tel"
                                    :disabled="loadform || !modifier_form"
                                    placeholder="(+225) 00-00-00-00-00"
                                    clearable
                                    :error="ErrorB.tel"
                                    :error-messages="ErrorT.tel"
                                />
                            </v-col>

                            <v-col cols="12" align="center"  class="mt-3 mb-2" justify="center">

<!--
                                <v-btn
                                    elevation="2"
                                    :x-small="isMobile"
                                    outlined
                                    :disabled="modifier_form"
                                    @click="modifier_form = !modifier_form ; "
                                ><v-icon>fa-edit</v-icon> Modifer</v-btn>
-->

                                <v-hover v-slot="{ hover }">
                                <v-btn
                                    elevation="2"
                                    :x-small="isMobile"
                                    class="ml-2"
                                    :outlined="!!hover"
                                    color="primary"
                                    :loading="!modifier_form"
                                    rounded
                                    @click="modifier_form = !modifier_form ;  enregistrerDonne()"
                                ><v-icon>fa-save </v-icon>  Enregistrer</v-btn>
                                </v-hover>

                            </v-col>

                        </v-row>


<!--                        <v-card >
                            <v-card-title class="blue lighten-3">
                                Informations de l'entreprise.
                            </v-card-title>


                        </v-card>-->



                    </v-card>
                </v-tab-item>
                <v-tab-item>
                    <v-card flat>
                        <v-row justify="center" align="center">

                            <v-col lg="8" sm="12" md="10"    >


                                <v-text-field
                                    id="password1"
                                    label="Ancien mot de passe"
                                    :error="EoorrPassB.an_pass"
                                    v-model="AdminPass.an_pass"
                                    :error-messages="EoorrPassT.an_pass"
                                    prepend-icon="lock"
                                    :disabled="loadform_pass"
                                    :type="voirpass1 ? 'text' : 'password'"
                                    :append-icon="voirpass1 ? 'mdi-eye' : 'mdi-eye-off'"
                                    @click:append="voirpass1 = !voirpass1"
                                />

                                <v-text-field
                                    id="password2"
                                    label="Nouveau mot de passe"
                                    :error="EoorrPassB.new_pass"
                                    v-model="AdminPass.new_pass"
                                    :error-messages="EoorrPassT.new_pass"
                                    prepend-icon="lock"

                                    :disabled="loadform_pass"
                                    :type="voirpass2 ? 'text' : 'password'"
                                    :append-icon="voirpass2 ? 'mdi-eye' : 'mdi-eye-off'"
                                    @click:append="voirpass2 = !voirpass2"
                                />

                                <v-text-field
                                    id="password3"
                                    label="Confirmation du mot de passe"
                                    prepend-icon="lock"
                                    :disabled="loadform_pass"
                                    :type="voirpass3 ? 'text' : 'password'"
                                    :error="EoorrPassB.confirmation_password"
                                    v-model="AdminPass.confirmation_password"
                                    :error-messages="EoorrPassT.confirmation_password"
                                    :append-icon="voirpass3 ? 'mdi-eye' : 'mdi-eye-off'"
                                    @click:append="voirpass3 = !voirpass3"
                                />



                            </v-col>
                        </v-row>
                        <v-row>
                            <v-col class="mt-3 mb-4" justify="center" align="center">

                                <v-hover v-slot="{ hover }">
                                    <v-btn
                                        elevation="2"
                                        :small="isMobile"
                                        class="ml-2"
                                        :outlined="!!hover"
                                        :loading="loadform_pass"
                                        color="primary"
                                        rounded
                                        @click="loadform_pass = !loadform_pass; enregistrerDonnePassword()"
                                    ><v-icon>fa-save </v-icon>  Enregistrer</v-btn>
                                </v-hover>

                            </v-col>
                        </v-row>

                    </v-card>
                </v-tab-item>
            </v-tabs>
        </v-card>
        <v-snackbar
            v-model="snackbar"
            :timeout="timeout"
            color="primary"

            absolute
            centered
        >
            {{ textToast }}

            <template v-slot:action="{ attrs }">
                <v-btn

                    text

                    v-bind="attrs"

                    @click="snackbar = false"
                >
                    Fermer
                </v-btn>
            </template>
        </v-snackbar>


    </div>

    <!--    -->
</template>
<script>
export default {
    mounted() {
        this.isMobile = window.innerWidth < 600;
        this.recupererInfoAdmin();


    },
    data () {
        return {

            lien_site : location.protocol + '//' + location.host,
            dialog_mes_retr : false,
            type_retour :'',
            voirpass1: false,
            voirpass2: false,
            voirpass3: false,
            modifier_form :  true,
            isMobile : false,
            snackbar: false,
            textToast: '',
            timeout: 4000,
            loadform_pass : false,
            FormAbs: {name : '', nom: '', post: '', email: '', tel: '', sex: ''},
            DataOriginal: {name : '', nom: '', post: '', email: '', tel: '', sex: ''},
            ErrorT: {name : '', nom: '', post: '', email: '', tel: '', raison_abs: '', compensation: ''},
            ErrorB: {name : false, nom: false, post: false, email: false, tel: false, raison_abs: false, compensation: false},
            AdminPass : {an_pass: '', new_pass :'', confirmation_password :''},
            EoorrPassB :{an_pass: false, new_pass :false, confirmation_password :false },
            EoorrPassT :{an_pass: '', new_pass :'', confirmation_password :'' },

            message_retour: '',

            loadform: false,
            reponse: {id: 0, mes_retour : 'Nous faisons suite au courrier cité en référence.  Nous avons le regret de ne pouvoir donner une suite favorable à votre demande. \n' +
                    '\n' +
                    '\n', statut : 0},
            dialog_ope_eff: false,
        }
    },
    methods :{
        enregistrerDonne(){
            /*if(!this.verificationChamp())
                return;*/

            let ce = this;
            axios.post('/admin/modifier_info_compte', this.toFormData(this.FormAbs))
                .then(function (response) {

                    ce.modifier_form = !ce.modifier_form;

                    if (response.data.success) {

                          ce.traitementAffichageErreur([]);
                          ce.textToast = "Les informations on été mofifiées.";
                          ce.snackbar = true;



                    } else {
                        let er = response.data.errors;

                        ce.traitementAffichageErreur(er);

                        //  console.log(response);


                    }


                })
                .catch(function (error) {

                })
                .then(function () {
                    // always executed
                });


        },
        verificationChamp(){

            return false;

        },
        enregistrerDonnePassword(){
            if(!this.verificationPassword()){
                this.loadform_pass = false;
                return;

            }

            let ce = this;

            ce.loadform_pass = true;
            axios.post('/admin/update_password', this.toFormData(this.AdminPass))
                .then(function (response) {
                    ce.loadform_pass = false;
                    if(!response.data.success){

                           ce.EoorrPassB.an_pass = true;
                           ce.EoorrPassT.an_pass = response.data.errors;

                    }else{
                        //Information mot de passe modifier

                        ce.AdminPass.an_pass = '';
                        ce.AdminPass.new_pass = '';
                        ce.AdminPass.confirmation_password = '';
                        ce.textToast = "Le mot de passe a été modifié.";
                        ce.snackbar = true;

                    }

                })
                .catch(function (error) {

                })
                .then(function () {
                    // always executed
                });


        },
        verificationPassword(){

            this.EoorrPassB.an_pass = false;
            this.EoorrPassT.an_pass = "";

            this.EoorrPassB.an_pass = false;
            this.EoorrPassT.new_pass = "";

            this.EoorrPassB.confirmation_password = false;
            this.EoorrPassT.confirmation_password = "";


            if(this.AdminPass.an_pass.length < 6)
            {
                this.EoorrPassB.an_pass = true;
                this.EoorrPassT.an_pass = "La longeur du mot de passe doit être supérieur à 7";
                return false;
            }
            this.EoorrPassB.an_pass = false;
            if(this.AdminPass.new_pass.length <6 )
            {
                this.EoorrPassB.new_pass = true;
                this.EoorrPassT.new_pass = "La longeur du mot de passe doit être supérieur à 7";
                return false;
            }
            this.EoorrPassB.an_pass = false;

            if(this.AdminPass.new_pass !== this.AdminPass.confirmation_password){

                this.EoorrPassB.confirmation_password = true;
                this.EoorrPassT.confirmation_password = "Le mot de passe ne correspond pas.";
                return false;
            }

            this.EoorrPassB.confirmation_password = false;

            return  true;
        },


        traitementAffichageErreur(er){

            let ce = this;
            let j = 0;
            Object.keys(ce.ErrorT).forEach(function (cle_O) {
                j = 0;
                Object.keys(er).forEach(function (cle_E) {
                    if (cle_O === cle_E) {
                        ce.ErrorB[cle_O] = true;
                        ce.ErrorT[cle_O] = er[cle_E];
                        j++;
                        return;
                    }


                });

                if (j === 0) {
                    ce.ErrorB[cle_O] = false;
                    ce.ErrorT[cle_O] = '';
                }


            });
        },




        toFormData: function(obj) {
            let formData = new FormData();
            for(let key in obj) {
                formData.append(key, obj[key]);
            }
            return formData;
        },
        recupererInfoAdmin(){
                let ce = this;
            axios.post('/admin/info_admin', this.toFormData(this.AdminPass))
                .then(function (response) {
                    let data = response.data.data;

                    ce.FormAbs.name = data.name;
                    ce.FormAbs.nom = data.nom;
                    ce.FormAbs.email = data.email;
                    ce.FormAbs.post = data.post;
                    ce.FormAbs.name = data.name;
                    ce.FormAbs.sex = data.sex;
                    ce.FormAbs.tel = data.tel;

                    ce.DataOriginal.name = data.name;
                    ce.DataOriginal.nom = data.nom;
                    ce.DataOriginal.email = data.email;
                    ce.DataOriginal.post = data.post;
                    ce.DataOriginal.name = data.name;
                    ce.DataOriginal.sex = data.sex;
                    ce.DataOriginal.tel = data.tel;



                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                })
                .then(function () {
                    // always executed
                });

        },
    }
}
</script>
<!--

DB_CONNECTION=mysql
DB_HOST=sql416.main-hosting.eu
DB_PORT=3306
DB_DATABASE=u510499444_reservation
DB_USERNAME=u510499444_reservation
DB_PASSWORD=Reservation@1234-->
