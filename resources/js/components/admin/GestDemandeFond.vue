<template>
    <div>
        <v-card class="mt-3">
            <v-toolbar
                flat
                dark
                color="primary"
            >
                <v-toolbar-title>Gestion des demandes de fonds</v-toolbar-title>
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


                                        <v-simple-table>
                                            <template >
                                                <thead>
                                                <tr>
                                                    <th class="text-left">
                                                        Désignation
                                                    </th>
                                                    <th class="text-left">
                                                        Quantité
                                                    </th>
                                                    <th class="text-left">
                                                        Prix Unitaire
                                                    </th>

                                                    <th class="text-left">
                                                        Total
                                                    </th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr
                                                    v-for="it in item.data"

                                                >
                                                    <td>{{ it.name }}</td>
                                                    <td>{{ it.quantite }}</td>
                                                    <td>{{ it.prix_init }}</td>
                                                    <td>{{ it.total}}</td>
                                                </tr>
                                                </tbody>
                                            </template>
                                            <v-divider></v-divider>

                                            <p class="subtitle-1"> Raison de la demande : (<b>{{item.cause}} </b>  ).<br>

                                            </p>

                                        </v-simple-table>

                                    <v-divider></v-divider>
                                         <v-btn class="mt-2 ma-2" @click=" Accorder(); reponse.id = item.id; reponse.statut = 1; type_retour = 'Accorder';  max_width_dialog = 590 ;  dialog_mes_retr = true; "   outlined color="success">
                                            <v-icon>fa-check</v-icon> Accorder
                                        </v-btn>

                                        <v-btn class="mt-2 ma-2"  @click=" max_width_dialog =  590 ;reponse.id = item.id;
                                        reponse.statut = 2; dialog_mes_retr = true;  type_retour = 'Rejeter'; Rejeter() " outlined color="error">
                                            <v-icon>fa-ban</v-icon> Rejeter
                                        </v-btn>
                                    </td>
                                </template>

                                <template v-slot:no-data>
                                    <p class="subtitle-1">Aucune donnée disponible</p>
                                </template>

                            </v-data-table>
                            <v-row justify="center" v-if="nb_page_fonds > 1">
                                <v-col cols="8">
                                    <v-container class="max-width">
                                        <v-pagination
                                            v-model="page1"
                                            class="my-4"
                                            @input="remplirTableDemandeAttente()"
                                            :length="nb_page_fonds"
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

                                            <v-simple-table>
                                                <template >
                                                    <thead>
                                                    <tr>
                                                        <th class="text-left">
                                                            Désignation
                                                        </th>
                                                        <th class="text-left">
                                                            Quantité
                                                        </th>
                                                        <th class="text-left">
                                                            Prix Unitaire
                                                        </th>

                                                        <th class="text-left">
                                                            Total
                                                        </th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <tr
                                                        v-for="it in item.data"

                                                    >
                                                        <td>{{ it.name }}</td>
                                                        <td>{{ it.quantite }}</td>
                                                        <td>{{ it.prix_init }}</td>
                                                        <td>{{ it.total}}</td>
                                                    </tr>
                                                    </tbody>
                                                </template>
                                                <v-divider></v-divider>

                                                <p class="subtitle-1"> Raison de la demande : (<b>{{item.cause}} </b>  ).<br>

                                                </p>

                                            </v-simple-table>
                                            <v-divider></v-divider>
                                            <v-btn class="mt-2 ma-2"  @click="imprimerFiche(item.id)"  color="primary">
                                                <v-icon>mdi-printer</v-icon> Imprimer la demande
                                            </v-btn>
                                        </td>

                                    </template>
                                    <template v-slot:no-data>
                                        <p class="subtitle-1">Aucune donnée disponible</p>
                                    </template>

                                </v-data-table>
                                <v-row justify="center" v-if="nb_page_fonds > 1">
                                    <v-col cols="8">
                                        <v-container class="max-width">
                                            <v-pagination
                                                v-model="page1"
                                                class="my-4"
                                                @input="remplirTableDemandeAttente()"
                                                :length="nb_page_fonds"
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

                                            <v-simple-table>
                                                <template >
                                                    <thead>
                                                    <tr>
                                                        <th class="text-left">
                                                            Désignation
                                                        </th>
                                                        <th class="text-left">
                                                            Quantité
                                                        </th>
                                                        <th class="text-left">
                                                            Prix Unitaire
                                                        </th>

                                                        <th class="text-left">
                                                            Total
                                                        </th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <tr
                                                        v-for="it in item.data"

                                                    >
                                                        <td>{{ it.name }}</td>
                                                        <td>{{ it.quantite }}</td>
                                                        <td>{{ it.prix_init }}</td>
                                                        <td>{{ it.total}}</td>
                                                    </tr>
                                                    </tbody>
                                                </template>
                                                <v-divider></v-divider>

                                                <p class="subtitle-1"> Raison de la demande : (<b>{{item.cause}} </b>  ).<br>

                                                </p>

                                            </v-simple-table>
                                            <v-divider></v-divider>
                                            <v-btn class="mt-2 ma-2"  @click="imprimerFiche(item.id)"  color="primary">
                                                <v-icon>mdi-printer</v-icon> Imprimer la demande
                                            </v-btn>

                                        </td>
                                    </template>

                                    <template v-slot:no-data>
                                        <p class="subtitle-1">Aucune donnée disponible</p>
                                    </template>

                                </v-data-table>
                                <v-row justify="center" v-if="nb_page_fonds > 1">
                                    <v-col cols="8">
                                        <v-container class="max-width">
                                            <v-pagination
                                                v-model="page1"
                                                class="my-4"
                                                @input="remplirTableDemandeAttente()"
                                                :length="nb_page_fonds"
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

                        <v-container >
                            <v-textarea
                                filled
                                auto-grow
                                solo
                                prepend-icon="mdi-comment"
                                :disabled="loadform"
                                v-model="reponse.mes_retour"
                                label="Entrez les raisons du rejet de la demande"
                                rows="4"
                                :error-messages="reponseET"
                                :error="reponseEB"
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

                <v-card-title >Opération effectuée <img height="24px" widht="24px"  :src="lien_site+'/img/smile.png'"> </v-card-title>
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
        //this.testAssignation();



    },
    data () {
        return {
            expanded1: [],
            singleExpand1: false,
            page1: 1,
            pageCount1: 0,
            itemsPerPage1: 10,
            nb_page_fonds : 1,
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
            reponseEB : false,
            reponseET : '',
            loadform: false,
            reponse: {id: 0, mes_retour : 'Nous faisons suite au courrier cité en référence.  Nous avons le regret de ne pouvoir donner une suite favorable à votre demande. \n' +
                    '\n' +
                    '\n', statut : 0},
            absHeaders: [
                {
                    text: 'Nom',
                    align: 'start',
                    sortable: true,
                    value: 'name',
                },
                { text: 'Contact', value: 'contact' },
                { text: 'Email', value: 'email' },
                { text: 'Poste', value: 'post' },
                { text: 'Fond Demandé (FCFA)', value: 'total' },
                { text: 'Date', value: 'date' },
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
        Rejeter(){
            this.reponse.mes_retour = "Nous faisons suite au courrier cité en référence.  Nous avons le regret de ne pouvoir donner une suite favorable à votre demande.";
        },
        Accorder(){
            this.reponse.mes_retour = "Nous faisons suite au courrier cité en référence. Nous avons le plaisir d'accueillir favorablement votre demande de fonds.";
        },
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

            this.loading_data = true;
            let ce = this;
            axios.post('/admin/demande_en_attente_fond?page='+this.page1).then(function(response){

                let data = response.data.data.data;
                ce.nb_page_fonds = response.data.data.last_page;
                ce.data_autorisation = [];
                ce.data_autorisation_rejete = [];
                ce.data_autorisation_acc = [];


                data.forEach((item,index) => {
                        data[index].data = JSON.parse(item.data);

                    });



                data.forEach((item,index) => {

                    let total = 0;

                    item.data.forEach((it,ind) => {

                        total += it.total;


                    });
                    data[index].total = total;

                });



                data.forEach((item,index) => {
                   let value = item;
                    switch (value.statut){
                        case 0:
                            ce.data_autorisation.push(value);
                            break;
                        case 1:
                            ce.data_autorisation_acc.push(value);
                            break;
                        case 2:
                            ce.data_autorisation_rejete.push(value)
                            break;
                    }


                });
                ce.loading_data = false;


            }).catch(error => {


            });

        },
        reponseAdmin(){

            this.reponseEB = false;
            this.reponseET = '';

            if(this.reponse.mes_retour.length < 10 ){
                this.reponseEB = true;
                this.reponseET = "Le champ doit avoir 10 caractères au minimum";
                return false;
            }
            this.reponseEB = false;
            this.reponseET = '';

            if(this.reponse.mes_retour.length > 995 ){
                this.reponseEB = true;
                this.reponseET = "Le champ doit avoir 995 caractères au maximun";
                return false;
            }


            this.loadform = true;
            let ce = this;

            axios.post('/admin/reponse_demande_fond', this.toFormData(this.reponse)).then(function(response){

                if(response.data.response){




                    let  obj = ce.getItem(ce.reponse.id);
                    ce.data_autorisation.splice(ce.data_autorisation.indexOf(obj),1);
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


            window.open(this.lien_site +'/admin/fichier_pdf_demande_fonds/'+id_auto, '_blank');
            //this.$router.push({ path: '/fichier_pdf_autorisation_abs' });


        }
        ,
        telechargerFiche(id_auto){


            window.open(this.lien_site +'/admin/fichier_pdf_demande_fonds/'+id_auto, '_blank');
            //this.$router.push({ path: '/fichier_pdf_autorisation_abs' });



        }
        ,
        getItem(id){

            let indx = [];





            this.data_autorisation.forEach((item,index) => {


                if(item.id  === id) {

                    indx = item;
                    return indx;
                }
            });

            return indx;
        }
    },
}
</script>
