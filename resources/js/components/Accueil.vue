<template>

    <v-container  fill-height fluid>



        <v-row align="center">
            <v-col
                class="d-flex"
                cols="12"
                filled
                sm="6"
            >
                <v-select
                    v-model="cat_select"
                    :items="list_categorie"
                    item-text="lib"
                    item-value="id"
                    return-object
                    @input="remplirCategorie"
                    single-line
                    label="Choisir une categorie"
                ></v-select>
            </v-col>
        </v-row>

        <v-row dense>





                <v-col v-if="chargement" style="margin-top: 250px"  justify="center" class="d-flex justify-center ">

                    <v-btn
                        color="primary"
                        elevation="2"
                        icon
                        loading
                        x-large
                    ></v-btn>

                </v-col>

            <v-col
                v-if="!chargement"
                v-for="card in data_livres"
                :key="card.id"
                lg="3"
                md="4"
                sm="6"

            >
                <v-hover v-slot="{ hover }">
                    <v-card :elevation="hover ? 9 : 1" :outlined="!!hover" :shaped="!!hover">

                        <v-img

                            :height="!isMobile ? 350 : 200"

                            :max-width="isMobile ? 150 : 250"
                            :src="'assets/'+card.nom_img+'.png'"
                            class="white--text align-end"
                            gradient="to bottom, rgba(0,0,0,.1), rgba(0,0,0,.5)"

                        >
                            <v-card-title v-text="card.title"></v-card-title>
                        </v-img>
                        <div style="display: block"><p class="text-h4 ml-3">{{ card.prix -  ((card.reduction * card.prix ) /100) }} FCFA </p>
                            <p class="ml-3 text--disabled text-decoration-line-through"> {{ card.prix }}FCFA</p>
                        </div>
                        <v-divider></v-divider>
                        <v-card-text>


                            <div class="my-4 title">
                                <p> {{ card.titre}}</p>

                            </div>
                        </v-card-text>
                        <v-divider class="mx-4"></v-divider>
                        <v-card-actions>


                            <v-rating
                                :value="4.5"
                                color="amber"
                                dense

                                half-increments
                                readonly
                                size="25"
                            ></v-rating>

                            <div class="grey--text ml-4">
                                4.5 (413)
                            </div>


                            <v-btn icon large @click="plusDinfoSurLivre(card)">
                                <v-icon>mdi-plus</v-icon>
                            </v-btn>

                            <v-btn  @click="selectionPanier(card)" icon large>
                                <v-icon>mdi-basket</v-icon>
                            </v-btn>

                            <v-btn  icon large>
                                <v-icon>mdi-share-variant</v-icon>
                            </v-btn>

                        </v-card-actions>

                    </v-card>
                </v-hover>
            </v-col>
            <v-col v-if="!chargement" align="center" justify="center" lg="12">

                <template>
                    <div class="text-center">
                        <v-pagination
                            :disabled="chargement"
                            v-model="page"
                            @input="remplirListeLivre"
                            :length="nb_total_page"
                            total-visible="4"
                        ></v-pagination>
                    </div>
                </template>

            </v-col>
        </v-row>


        <v-snackbar
            :timeout="temps_snak"
            color="orange"
            absolute
            v-model="snack_info"
            right
            shaped
            outlined
            top
        >
           {{message_snak}}
        </v-snackbar>

        <v-row justify="space-around">
            <v-col cols="auto">
                <v-dialog
                    transition="dialog-top-transition"
                    persistent
                    fullscreen
                    v-model="dialog_article"
                >

                    <template v-slot:default="dialog">
                        <v-card>
                            <v-toolbar
                                color="primary"
                                dark
                            >
                                <v-btn icon large @click="dialog_article = !dialog_article">
                                    <v-icon>mdi-close</v-icon>
                                </v-btn>

                            </v-toolbar>
                            <v-card-text class="mt-5">

                               <v-row>
                                <v-col lg="3">
                                <img

                                    :height="isMobile ? 400 : 500"
                                    src="assets/1.png"


                                >

                                </v-col>
                                   <v-col  lg="5">

                                       <v-card outlined elevation="2">
                                           <v-card-text>
                                               <h2 class="mt-3"> Titre :  <span class="subtitle-1">  {{livre_selec.titre}} </span> </h2>
                                               <h2 class="mt-3"> Auteur :  <span class="subtitle-1">{{livre_selec.auteur}} </span> </h2>
                                               <h2 class="mt-3"> Année :  <span class="subtitle-1">{{livre_selec.annee}} </span> </h2>
                                               <h2 class="mt-3"> Langue :  <span class="subtitle-1">{{livre_selec.langue}} </span> </h2>
                                               <h2 class="mt-3"> Maison d'édition :  <span class="subtitle-1">{{livre_selec.maison_ed}} </span> </h2>
                                               <h2 class="mt-3"> ISBN :  <span class="subtitle-1">{{livre_selec.isbn}} </span> </h2>
                                               <h2 class="mt-3"> Nombre Page :  <span class="subtitle-1">{{livre_selec.nb_page}} </span> </h2>

                                           </v-card-text>

                                       </v-card>

                                       <v-card outlined elevation="2" class="mt-3">
                                           <v-card-text>
                                               <h2 class="mt-3"> Résumé :  <span class="subtitle-1">Aucun </span> </h2>

                                           </v-card-text>

                                       </v-card>



                                       <v-card outlined elevation="2" class="mt-3">
                                           <div style="display: block"><p class="text-h4 ml-3">{{ (livre_selec.prix - (livre_selec.reduction * livre_selec.prix ) /100 )}} FCFA </p>
                                               <p class="ml-3 text--disabled text-decoration-line-through">{{livre_selec.prix}}FCFA</p>
                                           </div>

                                           <v-rating
                                               :value="4.5"
                                               color="amber"
                                               dense

                                               half-increments
                                               readonly
                                               size="25"
                                           ></v-rating>

                                           <div class="grey--text ml-4">
                                               4.5 (413)
                                           </div>
                                           <v-spacer></v-spacer>
                                           <v-btn icon large >
                                               <v-icon>mdi-plus</v-icon>
                                           </v-btn>

                                           <v-btn @click="dialog_ajouter_panier = true" icon large>
                                               <v-icon>mdi-basket</v-icon>
                                           </v-btn>

                                           <v-btn  icon large>
                                               <v-icon>mdi-share-variant</v-icon>
                                           </v-btn>

                                       </v-card>
                                   </v-col>


                               </v-row>

                                <v-row>
                                    <v-col lg="8">
                                    <v-btn
                                        class="ma-2 mt-3"
                                        color="orange"
                                        outlined
                                        block
                                        x-large

                                        @click="dialog_ajouter_panier = true"
                                    >
                                        Acheter<v-icon>
                                        mdi-basket
                                    </v-icon>
                                    </v-btn>
                                    </v-col>
                                </v-row>


                            </v-card-text>

                        </v-card>
                    </template>
                </v-dialog>
                <v-dialog
                    v-model="dialog_ajouter_panier"
                    persistent
                    disable="dialog_ajouter_panier"
                    :max-width="isMobile ?  390 : 590"
                >
                    <v-card>
                        <div>
                            <v-card-title class="subtitle-1">Voulez-vous ajouter cet article au panier ? <v-icon> mdi-basket </v-icon>  </v-card-title>
                            <v-card-actions>
                                <v-spacer></v-spacer>
                                <div >
                                    <v-btn
                                        depressed  rounded color="primary"
                                        :disabled="chargement_ajp"
                                        @click="dialog_ajouter_panier = false"
                                    >
                                        <v-icon>mdi-close</v-icon>  Non
                                    </v-btn>
                                    <v-btn
                                        depressed  rounded color="error"
                                        :loading="chargement_ajp"
                                        @click="ajouterAuPanier"
                                    >
                                        <v-icon>fa-check</v-icon>  Oui
                                    </v-btn>
                                </div>

                            </v-card-actions>
                        </div>



                    </v-card>
                </v-dialog>





            </v-col>
        </v-row>

    </v-container>

</template>
<script>
export default {
    mounted() {

        setTimeout( ()=> {
            this.remplirListeLivre();
            this.listeDesCategories();
        }, 1000);
    },
    data: () => ({
        loading: false,
        snack_info: false,
        message_snak :'',
        temps_snak: 4000,
        list_categorie : [],
        cat_select: null,
        dialog_ajouter_panier: false,
        chargement_ajp : false,
        chargement: true,
        livre_selec : [],
        page : 1,

        nb_total_page: 0,
        dialog_article :false,
        data_livres: [

        ],

        selection: 1,
        isMobile: window.innerWidth < 700,
    }),

    methods: {

        listeDesCategories(){

            axios.post('/get_liste_des_categorie').then(response => {

                this.list_categorie = response.data.data_cat;


            });
            this.chargement = false;

        },

        remplirCategorie(){

            this.chargement = true;
            axios.post('/get_categorie?cat='+this.cat_select.id).then(response => {


                let data = response.data.data.data;
                this.nb_total_page = response.data.data.last_page;
                this.data_livres = [];
                this.data_livres = data;


            });
            this.chargement = false;

        },
        remplirListeLivre() {

            this.chargement = true;
            let ce = this;
            axios.post('/tous_livres?page='+this.page).then(function(response) {

                let data = response.data.data.data;

                ce.nb_total_page = response.data.data.last_page;
                ce.data_livres = [];
                ce.data_livres = data;
            });
            this.chargement = false;

        },
        selectionPanier(card ){
            this.livre_selec = card ; this.dialog_ajouter_panier = true
        },
        plusDinfoSurLivre(item ){
            this.livre_selec = [];
            this.livre_selec = item;

            this.dialog_article = !this.dialog_article;
        },
        ajouterAuPanier(){

            this.chargement_ajp = true;

            axios.post('/ajouter_panier?livre_id='+this.livre_selec.id).then( response =>  {


                this.dialog_article = false;
               this.$root.$emit('setNbArticle', response.data.panier);
                this.snack_info = true;
                this.dialog_ajouter_panier = false;
                this.message_snak = "Livre ajouter au panier.";


            }).catch(error => {


            });


            this.chargement_ajp = false;
        },
    },
}
</script>
<style>
@media only screen and (min-width: 900px) {
    .img_book {
        margin-left: 150px;
    }
}
</style>
