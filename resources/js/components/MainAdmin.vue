<template>
    <v-app id="inspire">
        <v-navigation-drawer
            v-model="drawer"
            :clipped="$vuetify.breakpoint.lgAndUp"
            app
        >
            <v-list shaped rounded>
                <template v-if="auth > 0" v-for="item in items">
                    <v-row
                        v-if="item.heading"
                        :key="item.heading"
                        align="center"

                    >
                        <v-col cols="6">
                            <v-subheader v-if="item.heading">
                                {{ item.heading }}
                            </v-subheader>
                        </v-col>
                        <v-col
                            cols="6"
                            class="text-center"
                        >
                            <a
                                href="#!"
                                class="body-2 black--text"
                            >EDIT</a>
                        </v-col>
                    </v-row>
                    <v-list-item
                        v-else
                        :key="item.text"
                        @click="click_item(item.id)"
                        :to="item.link"
                        color="primary"


                    >
                        <v-list-item-action>
                            <v-icon>{{ item.icon }}</v-icon>
                        </v-list-item-action>
                        <v-list-item-content>
                            <v-list-item-title>
                                {{ item.text }}
                            </v-list-item-title>
                        </v-list-item-content>
                    </v-list-item>
                </template>
            </v-list>
        </v-navigation-drawer>

        <v-app-bar
            :clipped-left="$vuetify.breakpoint.lgAndUp"
            app
            color="blue darken-3"
            dark
        >
            <v-app-bar-nav-icon @click.stop="drawer = !drawer" />
            <v-toolbar-title
                style="width: 300px"
                class="ml-0 pl-4"
            >
                <span class="hidden-sm-and-down">{{titre}}</span>
            </v-toolbar-title>
            <v-spacer />
            <v-btn v-if="isConnected" @click="dialog_deco = !dialog_deco"  icon>
                <v-icon>fas fa-sign-out-alt</v-icon>

            </v-btn>
            <v-btn
                icon
                large
            >
                <v-avatar
                    size="32px"
                    item


                >

                    <v-img :src="logo" aspect-ratio="1.4"></v-img>
                </v-avatar>
            </v-btn>
        </v-app-bar>

        <v-main>


                <v-row justify="center">

                    <v-dialog
                        v-model="dialog_deco"
                        persistent
                        disable="dialog_deco"
                        max-width="290"
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
                                        @click="Deco"
                                    >
                                        Oui
                                    </v-btn>
                                </v-card-actions>
                            </div>



                        </v-card>
                    </v-dialog>
                </v-row>


            <vue-page-transition>
                <router-view/>
            </vue-page-transition>


        </v-main>




    </v-app>
</template>



<script>
export default {

    mounted(){


        this.$root.$on('responsive', data => {
           this.drawer = !this.drawer;
        });


        this.isConnected =  this.auth > 0;

    },
    props: ['auth'],
    data: () => ({
        logo: '',
        dialog: false,
        drawer: null,
        dialog_deco: false,
        isConnected : true,
        time: 0,
        value: 0,
        loadform: false,
        temps: null,
        titre : 'Administration',
        items: [
            { icon: 'mdi-home', text: 'Accueil' , link : '/admin/accueil', id : 0,},
            { icon: 'mdi-file-account', text: 'Gestion des autorisations' , link : '/admin/autorisation_absence', id : 1},
            { icon: 'fa-money', text: 'Gestion des demandes de fonds'  ,  link : '/admin/demandes_fonds', id : 2 },
            { icon: 'mdi-account-settings', text: 'Paramètres'  ,  link : '/admin/parametres', id : 3 },

            /*{ icon: 'fa-user-tie', text: 'Expériences pro' ,   link : '/experience' , id : 4},//Dossier de téléchargement
            { icon: 'fa-award', text: 'Certification' ,   link : '/certification' , id : 5},//Dossier de téléchargement
            { icon: 'fa-laptop-code', text: 'Compétences' ,   link : '/competence' , id : 6},//Dossier de téléchargement
            // { icon: 'mdi-message', text: 'Envoyer un fichier', link : '/file' ,id : 4 },
            { icon: 'mdi-help-circle', text: 'A propos', link : '/about' ,id : 7},*/


            // { icon: 'fa-comments', text: 'Laisser un messsage', link : '/laismes' ,id : 7},
        ],
    }),

    methods :{
        Deco(){
            let ce = this;
            this.loadform_deco  = true;
            axios.post('/admin/deconnexion').then(function(response){
                ce.loadform_deco = false;
                ce.dialog_deco = false;
               location.reload();
            });

        },
        click_item(val){
            this.value = val;

            switch (val){
                case 0:
                    //router.push({ name: 'accueil'});
                    this.titre = "Accueil"
                    break;
                case 1:
                    //  router.push({ name: 'user'})
                    this.titre = "Autorisation d'absence"
                    break;
                case 2:
                    //router.push({ name: 'demande_de_fond'})
                    this.titre = "Demande de fond"
                    break;
            }

            /*if(key === 1){
                router.push({ name: 'user', params: { userId: 123 }})
                router.push({ name: 'adminHistorique'})
             }*/
        },
        mounted() {
            // this.titre =  this.$route.name;

        },
        chrono(){

            this.time --;
            if(this.time === 0){
                clearInterval(this.temps);
                this.dialog_deco = false;
            }
        },


    }

}
</script>
