<template>

    <v-container fill-height fluid>
        <v-row  >
            <v-col class="d-flex"
                   cols="10"
                   sm="10">
                <v-text-field
                    flat
                    v-model="ville_recherche"
                    rounded
                    hide-details
                    solo
                    v-on:change="changerEtat"
                    clearable
                    :disabled="searchVille"
                    outlined
                    prepend-inner-icon="mdi-magnify"
                    label="Rechercher une ville"

                />
            </v-col>
            <v-col class="d-flex"
                   cols="2"
                   sm="2" >
                <v-btn
                    color="primary"
                    elevation="2"
                    icon
                    :disabled="searchVille"
                    class="ml-3"
                    @click="meteoRecherche"
                    bock
                    large
                >
                    <v-icon>
                        mdi-magnify
                    </v-icon>
                </v-btn>
            </v-col>
        </v-row>
        <v-row v-if="no_result" justify="center" align="center">
            <v-col >

                <v-card  >
                    <v-card-title>Aucune donnée disponible.</v-card-title>
                    <img  width="250px" height="250px" src="https://thumbs.dreamstime.com/b/upset-magnifying-glass-cute-not-found-symbol-unsuccessful-s-upset-magnifying-glass-cute-not-found-symbol-unsuccessful-122205900.jpg">
                </v-card>
            </v-col>
        </v-row>
        <v-row dense>
            <v-col
                lg="4"
                v-for="meteo in data_meteo"
                :key="meteo.id"
            >
                <v-card
                    class="mx-auto"
                    max-width="500"
                >
                    <v-list-item two-line>
                        <v-list-item-content>
                            <v-list-item-title class="headline">
                                {{meteo.name}}
                            </v-list-item-title>
                            <v-list-item-subtitle>{{new Date().toLocaleString()}}</v-list-item-subtitle>
                        </v-list-item-content>
                    </v-list-item>

                    <v-card-text>
                        <v-row align="center">
                            <v-col
                                class="display-3"
                                cols="6"
                            >
                                {{meteo.main.temp}}&deg;C
                            </v-col>
                            <!--                        <v-col cols="6">
                                                        <v-img
                                                            src="https://cdn.vuetifyjs.com/images/cards/sun.png"
                                                            alt="Sunny image"
                                                            width="92"
                                                        ></v-img>
                                                    </v-col>-->
                        </v-row>
                    </v-card-text>

                    <v-list-item>
                        <v-list-item-icon>
                            <v-icon>mdi-send</v-icon>
                        </v-list-item-icon>
                        <v-list-item-subtitle> Vitesse du vent : {{meteo.wind.speed}}</v-list-item-subtitle>
                    </v-list-item>

                    <v-list-item>
                        <v-list-item-icon>
                            <v-icon>mdi-cloud-download</v-icon>
                        </v-list-item-icon>
                        <v-list-item-subtitle> Humidité : {{meteo.main.humidity}}%</v-list-item-subtitle>
                    </v-list-item>

                    <v-list-item>
                        <v-list-item-icon>
                            <img :src="'http://openweathermap.org/img/w/'+meteo.weather[0].icon +'.png'">
                        </v-list-item-icon>
                        <v-list-item-subtitle> Temps : {{meteo.weather[0].description}} </v-list-item-subtitle>
                    </v-list-item>


                </v-card>


            </v-col>


        </v-row>
    </v-container>
</template>
<script>
export default {
    mounted() {

        this.initialiserCi();

        this.isMobile =  window.innerWidth > 700;




    },
    data () {
        return {

            time: 0,
            ville_recherche :'',
            no_result :false,
            searchVille:false,
            isMobile: false,
            lien_site : location.protocol + '//' + location.host,
            data_meteo :[],
        }
    },
    methods:{
        meteoRecherche(){
          this.searchVille = true;
          this.data_meteo = [];
            axios.post('/getmeteo?ville='+this.ville_recherche).then( response =>{

                this.searchVille = false;

                if(response.data.trouve){
                    this.no_result = false;
                    this.no_result = false;
                    this.data_meteo.push(response.data.data);

                }else{
                    this.no_result = true;
                }





            }).catch(error => {





            });

        },
        changerEtat (){
            if(this.ville_recherche === ''){
                this.initialiserCi();
            }
        },

        initialiserCi(){
            this.setDataMeteo("yamoussoukro");
            this.setDataMeteo("abidjan");
            this.setDataMeteo("bouake");
            this.setDataMeteo("san-pedro");
            this.setDataMeteo("man");
            this.setDataMeteo("daloa");

        },
        setDataMeteo(ville){

            let ce = this;
            axios.post('/getmeteo?ville='+ville).then(function (response){

                ce.data_meteo.push(response.data.data);


            }).catch(error => {





            });

        },
    },
}
</script>
