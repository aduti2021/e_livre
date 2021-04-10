<template>
    <v-app id="inspire">

        <v-app-bar
            :clipped-left="$vuetify.breakpoint.lgAndUp"
            app
            color="blue darken-3"
            dark
        >
<!--            <v-app-bar-nav-icon  @click.stop="drawer = !drawer" />-->
            <v-btn
                icon
                large
                @click="Accueil"
            >
                <v-avatar
                    size="32px"
                    item

                >
                    <v-img
                        src="https://totobernard09.herokuapp.com/img/logo.jpg"
                        alt="Vuetify"
                    /></v-avatar>
            </v-btn>
            <v-toolbar-title
                v-if="!isMobile"
                style="width: 500px"
                class="ml-0"
            >


<!--                <span class="hidden-sm-and-down">Google Contacts</span>-->

                <v-hover v-slot="{ hover }">
                    <v-btn @click="Inscription"  v-if="!isConnected"  :elevation="hover ?  5 :  0 " color="blue darken-3"  depressed>
                      Inscription
                    </v-btn>
                </v-hover>

                <v-hover v-slot="{ hover }">
                    <v-btn  @click="Connexion" v-if="!isConnected" :elevation="hover ?  5 :  0 " color="blue darken-3"  depressed>
                        Connexion
                    </v-btn>
                </v-hover>

            </v-toolbar-title>
            <v-text-field
                flat
                solo-inverted
                rounded
                hide-details
                solo
                prepend-inner-icon="mdi-magnify"
                label="Rechercher un livre"
                class="hidden-sm-and-down"
            />
            <v-spacer />
            <v-btn icon v-if="isConnected" @click="dialog_deco = !dialog_deco">
                <v-icon>mdi-account</v-icon>
            </v-btn>
            <v-btn  v-if="nb_article_au_panier > 0"  @click="dialog_voir_panier = true" icon>
                <v-badge
                    color="orange"
                    depressed
                    :content="nb_article_au_panier"
                >
                    <v-icon>mdi-basket</v-icon>
                </v-badge>

            </v-btn>
            <v-btn
                icon
                large
            >
                <v-avatar
                    size="32px"
                    item
                    v-if="false"
                >
                    <v-img
                        src="https://cdn.vuetifyjs.com/images/logos/logo.svg"
                        alt="Vuetify"
                    /></v-avatar>
            </v-btn>
        </v-app-bar>
        <v-main>

                    <vue-page-transition>
                        <router-view/>
                    </vue-page-transition>


            <v-row justify="space-around">
                <v-col cols="auto">

                    <v-dialog
                        v-model="dialog_deco"
                        persistent

                        max-width="390"
                    >
                        <v-card>
                            <div v-if="isConnected">
                                <v-card-title class="headline">Déconnexion</v-card-title>

                                <v-card-text>
                                    Voulez-vous vraimment vous déconnecter ?
                                </v-card-text>

                                <v-card-actions>
                                    <v-spacer></v-spacer>

                                    <v-btn
                                        depressed  rounded color="primary"
                                        small
                                        :disabled="loadform"
                                        @click="dialog_deco = false"
                                    >
                                        Non
                                    </v-btn>

                                    <v-btn
                                        small
                                        depressed  rounded color="error"
                                        :loading="loadform"
                                        @click="this.Deco"
                                    >
                                        Oui
                                    </v-btn>
                                </v-card-actions>
                            </div>



                        </v-card>
                    </v-dialog>
                    <v-dialog
                        transition="dialog-bottom-transition"
                        max-width="700"
                        persistent
                        v-model="dialog_voir_panier"
                    >


                            <v-card>
                                <v-toolbar
                                    color="primary"
                                    dark
                                >Votre panier</v-toolbar>
                                <v-card-text>
                                    <v-row>
                                        <v-col
                                        v-for="item in panier"
                                        :key="item.id"
                                        lg="12"

                                        >
                                            <v-card>
                                            <v-row>
                                                <v-col lg="6">

                                                    <img  width="100"  height="133" :src="'assets/'+item.nom_img+'.png'" >
                                                </v-col>

                                                <v-col lg="6">
                                                    <h5>{{item.titre}}</h5>
                                                    <h4>{{ item.prix -  ((item.reduction * item.prix ) /100) }} FCFA</h4>
                                                </v-col>

                                            </v-row>
                                                <v-divider></v-divider>
                                                <v-btn
                                                    class="ma-2 mt-3"
                                                    color="orange"
                                                    outlined
                                                    block
                                                    @click="retirerPanier(item.id)"
                                                >
                                                    <v-icon>mdi-delete</v-icon> Retier
                                                </v-btn>
                                            </v-card>

                                        </v-col>
                                        <v-btn
                                            class="ma-2 mt-3 mb-2"
                                            color="orange"
                                            block
                                            @click="validerCommande"
                                        >VALIDER LA COMMANDE
                                        </v-btn>
                                    </v-row>


                                </v-card-text>



                                <v-card-actions class="justify-end">
                                    <v-btn
                                        outlined
                                        color="primary"
                                        @click="dialog_voir_panier = false"
                                    >Fermer <v-icon>mdi-close</v-icon></v-btn>

                                </v-card-actions>
                            </v-card>

                    </v-dialog>

                </v-col>
            </v-row>

        </v-main>



    </v-app>
</template>

<script>
export default {
    props: ['auth'],
    mounted() {
        this.isMobile = window.innerWidth < 700;

        this.$root.$on('setNbArticle', (data) => {

            //this.nb_article_au_panier = data;
            this.getPanier();

        });
        this.getPanier();
        this.isConnected =  this.auth > 0;

    },
    data: () => ({

        drawer: null,
        value: 1,
        isConnected :false,
        dialog_deco : false,
        loadform :false,
        panier : [],
        lien_site : location.protocol + '//' + location.host,
        chargementRetraitLivre: false,
        dialog_voir_panier :false,
        nb_article_au_panier : 0,
        isMobile: window.innerWidth < 700,

    }),

    methods:{
        validerCommande(){
            window.open(this.lien_site +'/validation_commande');

        },
        Deco(){
            let ce = this;
            this.loadform  = true;
            axios.post('/deconnexion').then(function(response){
                ce.loadform = false;
                ce.dialog_deco = false;
                location.reload();
            });

        },
        Inscription(){
            this.$router.push('/inscription');
        },
        Connexion(){
            this.$router.push('/connexion');
        },
        Accueil(){
            this.$router.push('/');
        },
        getPanier(){

            let ce = this;

                axios.post('/get_panier').then(function(response) {

                    if(!response.data.vide){
                        ce.panier = response.data.panier;
                        ce.nb_article_au_panier = response.data.nb_livre;
                    }else{
                        ce.nb_article_au_panier = 0;

                    }


                }).catch(error => {





            });
        },
        retirerPanier(id){


            axios.post('/retirer_panier?livre_id='+id).then(response => {

                if(response.data.retrait){
                    this.getPanier();
                }


            }).catch(error => {


            });

        },
    },
}
</script>
