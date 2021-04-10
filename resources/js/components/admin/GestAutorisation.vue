<template>
    <div>
        <v-card class="mt-3">
            <v-toolbar
                flat
                dark
                color="primary"
            >
                <v-toolbar-title>Gestion des autorisations d'absence</v-toolbar-title>
            </v-toolbar>
            <v-tabs :vertical="!isMobile">
                <v-tab >
                    <v-icon  left>
                        fa-spinner
                    </v-icon>
                    En Attentes
                </v-tab>
                <v-tab>
                    <v-icon left>
                        fa-check
                    </v-icon>
                    Accordées
                </v-tab>
                <v-tab>
                    <v-icon left>
                        fa-ban
                    </v-icon>
                    Rejetées
                </v-tab>

                <v-tab-item>
                    <v-card flat>
                        <v-skeleton-loader
                            class="mx-auto"
                            v-if="loading_data"
                            type="card"
                        ></v-skeleton-loader>

                        <div v-if="!loading_data" class="mt-3">
                            <v-data-table
                                :headers="absHeaders"
                                :items="data_autorisation"
                                single-expand
                                :expanded.sync="expanded1"
                                item-key="id"
                                hide-default-footer
                                @click:row="clicked"
                                :page.sync="page1"

                                show-expand
                                class="elevation-1"
                            >


                                <template v-slot:top>
                                    <v-toolbar flat>
                                        <v-toolbar-title></v-toolbar-title>
                                        <v-spacer></v-spacer>

                                    </v-toolbar>
                                </template>
                                <template v-slot:expanded-item="{ headers, item }">
                                    <td :colspan="headers.length">

                                        <p class="subtitle-1"> Raison de l'absence : (<b>{{item.raison_abs}} </b>  ).<br>
<!--                                            De façon à compenser ses heures d'absence : (  <b> {{item.compensation}} </b> ).<br>-->
                                        </p>
                                        <v-divider></v-divider>
                                        <v-btn class="mt-2 ma-2" @click="reponse.statut = 1; Accorder(); reponse.id = item.id;  type_retour = 'Accorder';  max_width_dialog = 390 ;  dialog_mes_retr = true; "   outlined color="success">
                                            <v-icon>fa-check</v-icon> Accorder
                                        </v-btn>

                                        <v-btn class="mt-2 ma-2" reponse.statut = 2; @click="Rejeter(); max_width_dialog =  590 ;reponse.id = item.id;
                                        dialog_mes_retr = true;  type_retour = 'Rejeter'; " outlined color="error">
                                            <v-icon>fa-ban</v-icon> Rejeter
                                        </v-btn>
                                    </td>
                                </template>

                                <template v-slot:no-data>
                                    <p class="subtitle-1">Aucune donnée disponible</p>
                                </template>

                            </v-data-table>

                            <v-row justify="center" v-if="nb_page_abs > 1">
                                <v-col cols="8">
                                    <v-container class="max-width">
                                        <v-pagination
                                            v-model="page1"
                                            class="my-4"
                                            @input="remplirTableDemandeAttente()"
                                            :length="nb_page_abs"
                                        ></v-pagination>
                                    </v-container>
                                </v-col>
                            </v-row>

                        </div>

                    </v-card>
                </v-tab-item>
                <v-tab-item>
                    <v-card flat>
                        <v-card-text>
                            <v-skeleton-loader
                                class="mx-auto"
                                v-if="loading_data"
                                type="card"
                            ></v-skeleton-loader>
                            <div v-if="!loading_data" class="mt-3">
                                <v-data-table
                                    :headers="absHeaders"
                                    :items="data_autorisation_acc"
                                    single-expand
                                    :expanded.sync="expanded2"
                                    item-key="id"
                                    hide-default-footer
                                    @click:row="clicked2"
                                    :page.sync="page2"

                                    show-expand
                                    class="elevation-1"
                                >


                                    <template v-slot:top>
                                        <v-toolbar flat>
                                            <v-toolbar-title></v-toolbar-title>
                                            <v-spacer></v-spacer>

                                        </v-toolbar>
                                    </template>
                                    <template v-slot:expanded-item="{ headers, item }">
                                        <td :colspan="headers.length">



                                            <p class="subtitle-1"> Raison de l'absence : (<b>{{item.raison_abs}} </b>  ).<br>
<!--                                                De façon à compenser ses heures d'absence : (  <b> {{item.compensation}} </b> ).<br>-->
                                            </p>
                                            <v-divider></v-divider>
                                            <v-btn class="mt-2 ma-2" @click="reponse.id = item.id; reponse.statut = 1; dialog_mes_retr = true"  color="primary">
                                                <v-icon>mdi-printer</v-icon> Imprimer la demande
                                            </v-btn>


                                        </td>

                                    </template>
                                    <template v-slot:no-data>
                                        <p class="subtitle-1">Aucune donnée disponible</p>
                                    </template>

                                </v-data-table>

                                <v-row justify="center" v-if="nb_page_abs > 1">
                                    <v-col cols="8">
                                        <v-container class="max-width">
                                            <v-pagination
                                                v-model="page1"
                                                class="my-4"
                                                @input="remplirTableDemandeAttente()"
                                                :length="nb_page_abs"
                                            ></v-pagination>
                                        </v-container>
                                    </v-col>
                                </v-row>

                            </div>

                        </v-card-text>
                    </v-card>
                </v-tab-item>
                <v-tab-item>
                    <v-card flat>
                        <v-card-text>
                            <v-skeleton-loader
                                class="mx-auto"
                                v-if="loading_data"
                                type="card"
                            ></v-skeleton-loader>

                            <div v-if="!loading_data" class="mt-3">
                                <v-data-table
                                    :headers="absHeaders"
                                    :items="data_autorisation_rejete"
                                    single-expand
                                    :expanded.sync="expanded3"
                                    item-key="id"
                                    hide-default-footer
                                    @click:row="clicked3"
                                    :page.sync="page3"

                                    show-expand
                                    class="elevation-1"
                                >


                                    <template v-slot:top>
                                        <v-toolbar flat>
                                            <v-toolbar-title></v-toolbar-title>
                                            <v-spacer></v-spacer>

                                        </v-toolbar>
                                    </template>
                                    <template v-slot:expanded-item="{ headers, item }">
                                        <td :colspan="headers.length">

                                            <p class="subtitle-1"> Raison de l'absence : (<b>{{item.raison_abs}} </b>  ).<br>
<!--                                                De façon à compenser ses heures d'absence : (  <b> {{item.compensation}} </b> ).<br>-->
                                            </p>

                                        </td>
                                    </template>

                                    <template v-slot:no-data>
                                        <p class="subtitle-1">Aucune donnée disponible</p>
                                    </template>

                                </v-data-table>

                                <v-row justify="center" v-if="nb_page_abs > 1">
                                    <v-col cols="8">
                                        <v-container class="max-width">
                                            <v-pagination
                                                v-model="page1"
                                                class="my-4"
                                                @input="remplirTableDemandeAttente()"
                                                :length="nb_page_abs"
                                            ></v-pagination>
                                        </v-container>
                                    </v-col>
                                </v-row>
                            </div>

                        </v-card-text>
                    </v-card>
                </v-tab-item>
            </v-tabs>
        </v-card>
        <v-dialog
            v-model="dialog_mes_retr"
            persistent
            disable="dialog_mes_retr"
            :max-width="max_width_dialog"
        >
            <v-card>
                <div>
                    <v-card-title class="subtitle-1">Voulez-vous vraiment {{type_retour}} cette demande </v-card-title>
                    <v-card-actions>
                        <v-spacer></v-spacer>
                    <div v-if="max_width_dialog <400">
                        <v-btn
                            depressed  rounded color="primary"
                            :disabled="loadform"
                            @click="dialog_mes_retr = false"
                        >
                            <v-icon>mdi-close</v-icon>  Non
                        </v-btn>
                        <v-btn
                            depressed  rounded color="error"


                            :loading="loadform"
                            @click="reponseAdmin()"
                        >
                            <v-icon>fa-check</v-icon>  Oui
                        </v-btn>
                    </div>
                        <v-container v-if="max_width_dialog > 400">
                                <v-textarea
                                    filled
                                    auto-grow
                                    solo
                                    prepend-icon="mdi-comment"
                                    :disabled="loadform"
                                    v-model="reponse.mes_retour"
                                    label="Entrez les raisons du rejet de la demande"
                                    rows="4"
                                    clearable
                                    clear-icon="mdi-close-circle"
                                    counter="995"
                                    row-height="30"
                                    shaped
                                ></v-textarea>
                            <v-divider></v-divider>
                            <v-btn
                                depressed  rounded color="primary"
                                :disabled="loadform"
                                @click="dialog_mes_retr = false"
                            >
                                <v-icon>mdi-close</v-icon>  Non
                            </v-btn>
                            <v-btn
                                depressed  rounded color="error"


                                :loading="loadform"
                                @click="reponseAdmin()"
                            >
                                <v-icon>fa-check</v-icon>  Envoyer
                            </v-btn>

                        </v-container>


                    </v-card-actions>
                </div>



            </v-card>
        </v-dialog>
        <v-dialog
            v-model="dialog_ope_eff"
            persistent
            max-width="420"
        >
            <v-card>

                <v-card-title >Opération effectuée <img height="24px" widht="24px"   :src="lien_site+'/img/smile.png'"> </v-card-title>
                <v-divider></v-divider>
                <v-card-text>
                    <div >
                        <p class="text-justify"> Que voulez-vous faire ? </p>
                        <div class="my-2">
                            <v-btn
                                color="primary"
                                rounded
                                dark
                                :small="!!isMobile"
                                outlined
                                @click="telechargerFiche(reponse.id)"
                            ><v-icon>mdi-download</v-icon>
                                Télécharger
                            </v-btn>

                            <v-btn
                                color="success"
                                rounded
                                outlined
                                dark
                                @click="imprimerFiche(reponse.id)"
                                :small="!!isMobile"
                            >
                                <v-icon>mdi-printer</v-icon>   Imprimer
                            </v-btn>
                            <v-divider></v-divider>
                            <v-btn
                                depressed  icon  class="float-right" color="#757575" fab x-small
                                @click="dialog_ope_eff =  false;"
                            >
                                <v-icon>mdi-close</v-icon>
                            </v-btn>

                        </div>
                    </div>


                </v-card-text>

                <v-card-actions>
                    <v-spacer></v-spacer>

                </v-card-actions>




            </v-card>
        </v-dialog>
    </div>

    <!--    -->
</template>
<script>
export default {
    mounted() {
        this.isMobile = window.innerWidth < 600;
        this.remplirTableDemandeAttente();


    },
    data () {
        return {
            expanded1: [],
            singleExpand1: false,
            page1: 1,
            nb_page_abs : 1,
            pageCount1: 0,
            itemsPerPage1: 10,
            max_width_dialog: 390,

            expanded2: [],
            lien_site : location.protocol + '//' + location.host,
            singleExpand2: false,
            page2: 1,
            pageCount2: 0,
            itemsPerPage2: 10,


            expanded3: [],
            singleExpand3: false,
            page3: 1,
            pageCount3: 0,
            itemsPerPage3: 10,

            dialog_mes_retr : false,
            type_retour :'',
            isMobile : false,
            loading_data: true,
            message_retour: '',
            loadform: false,
            reponse: {id: 0, mes_retour : 'Nous faisons suite au courrier cité en référence.  Nous avons le regret de ne pouvoir donner une suite favorable à votre demande. \n' +
                    '\n' +
                    '\n', statut : 0},
            absHeaders: [
                {
                    text: 'Nom & Pénoms',
                    align: 'start',
                    sortable: true,
                    value: 'name',
                },
                { text: 'Poste', value: 'post' },
                { text: 'Contact', value: 'contacts' },
                { text: 'Date de début', value: 'date_debut' },
                { text: 'Date de fin', value: 'date_fin' },
                { text: 'Nombre de jour', value: 'nb_jr' },
                { text: '', value: 'data-table-expand' },
            ],
            data_autorisation: [

            ],
            data_autorisation_acc: [

            ],
            data_autorisation_rejete: [

            ],
            dialog_ope_eff: false,
        }
    },
    methods :{
        clicked(value) {
            this.expanded1.push(value);
        },
        clicked2(value) {
            this.expanded2.push(value);
        },

        clicked3(value) {
            this.expanded3.push(value);
        },
        remplirTableDemandeAttente() {

            let ce = this;
            axios.post('/admin/demande_en_attente?page='+this.page1).then(function(response){

                let data = response.data.data.data;
                console.log(data);
                ce.nb_page_abs = response.data.data.last_page;
                ce.data_autorisation = [];
                ce.data_autorisation_rejete = [];
                ce.data_autorisation_acc = [];




                Object.keys(data).forEach(function (value,index) {

                    let  obj = {
                        name: '',
                        id: 0,
                        raison_abs: '',
                        compensation: '',
                        post: '',
                        contacts: '',
                        date_debut: '',
                        email : '',
                        date_fin: '',
                        nb_jr: '',
                    };


                    obj.id = data[index].id;

                    obj.name = data[index].nom;
                    obj.post = data[index].post;
                    obj.contacts = data[index].tel;
                    obj.email = data[index].email;

                    obj.raison_abs = data[index].raison_abs;
                    obj.compensation = data[index].compensation;
                    obj.statut = data[index].statut;
                    obj.date_debut = data[index].date_debut;
                    obj.date_fin = data[index].date_fin;

                    let date1 = new Date(data[index].date_debut);
                    let date2 = new Date(data[index].date_fin);

                    let date_diff  = date2.getTime() - date1.getTime();

                    obj.nb_jr  = date_diff / (1000 * 3600 * 24);

                    switch (obj.statut){
                        case 0:
                            ce.data_autorisation.push(obj);
                            break;
                        case 1:
                            ce.data_autorisation_acc.push(obj);
                            break;
                        case 2:
                            ce.data_autorisation_rejete.push(obj)
                            break;
                    }


                    //Vérifier Taille



                });
                ce.loading_data = false;


            }).catch(error => {


            });

        },
        reponseAdmin(){
            this.loadform = true;
            let ce = this;

            if(this.reponse.statut === 1)
                this.Accorder();
            else
                this.Rejeter();


            axios.post('/admin/reponse_autorisation', this.toFormData(this.reponse)).then(function(response){

                if(response.data.response){



                    let index  = ce.getItem(ce.reponse.id)

                    let  obj = {
                        name: '',
                        id: 0,
                        raison_abs: '',
                        compensation: '',
                        post: '',
                        contacts: '',
                        date_debut: '',
                        email : '',
                        date_fin: '',
                        nb_jr: '',
                    };


                    obj.id = ce.data_autorisation[index].id;
                    obj.name = ce.data_autorisation[index].name;
                    obj.post = ce.data_autorisation[index].post;
                    obj.contacts = ce.data_autorisation[index].contacts;
                    obj.email = ce.data_autorisation[index].email;
                    obj.raison_abs = ce.data_autorisation[index].raison_abs;
                    obj.compensation = ce.data_autorisation[index].compensation;
                    obj.statut = ce.data_autorisation[index].statut;
                    obj.date_debut = ce.data_autorisation[index].date_debut;
                    obj.date_fin = ce.data_autorisation[index].date_fin;
                    obj.nb_jr  =  ce.data_autorisation[index].nb_jr;


                    ce.data_autorisation.splice(index,1);
                    switch (ce.reponse.statut){
                        case 1:
                            //Supprimer et ajouter dans accordées

                            ce.data_autorisation_acc.push(obj);
                            break;

                        case 2:
                            //Supprimer et ajouter dans rejetées
                            ce.data_autorisation_rejete.push(obj);
                            break;
                    }
                    ce.loadform = false;

                    ce.dialog_mes_retr = false;
                    ce.dialog_ope_eff = true;
                }

            }).catch(error => {



            });

        },
        toFormData: function(obj) {
            let formData = new FormData();
            for(let key in obj) {
                formData.append(key, obj[key]);
            }
            return formData;
        },
        imprimerFiche(id_auto){


            window.open(this.lien_site +'/admin/fichier_pdf_autorisation_abs/'+id_auto, '_blank');
            //this.$router.push({ path: '/fichier_pdf_autorisation_abs' });


        }
        ,
        telechargerFiche(id_auto){


            window.open(this.lien_site +'/admin/fichier_pdf_autorisation_abs/'+id_auto, '_blank');
            //this.$router.push({ path: '/fichier_pdf_autorisation_abs' });



        },
        Rejeter(){
            this.reponse.mes_retour = "Nous faisons suite au courrier cité en référence.  Nous avons le regret de ne pouvoir donner une suite favorable à votre demande.";
        },
        Accorder(){
            this.reponse.mes_retour = "Nous faisons suite au courrier cité en référence. Nous avons le plaisir d'accueillir favorablement votre demande.";
        }
        ,
        getItem(id){

            let ce = this;
            let indx = 0;
            Object.keys(this.data_autorisation).forEach(function (index) {
                indx = 0;

                if(ce.data_autorisation[index].id === id){

                    indx = index;

                }

            });
            return indx;
        }
    },
}
</script>
