<template>

    <v-main>
        <v-container
            class="fill-height"
            fluid
        >
            <v-row
                align="center"
                justify="center"
            >
                <v-col
                    cols="12"
                    sm="12"

                >

                        <v-card
                            class="mx-auto"
                            :max-width="taille_card"
                            outlined
                            elevation="5"

                        >
                            <v-list-item three-line>
                                <v-list-item-content>
                                    <div class="headline mb-4">
                                      Bienvenue
                                    </div>

                                    <v-hover v-slot="{ hover }">
                                    <v-card @click="router(1)" :color="hover ?  'blue lighten-4' :  '#ffff' "  shaped class="ma-2"  :max-width="taille_min_card" height="185">
                                        <v-container>
                                            <v-row >

                                                <v-col cols="auto">
                                                    <v-img
                                                        height="80"
                                                        width="80"
                                                        :src="lien_site+'/img/autorisation.png'"
                                                    ></v-img>
                                                    <p class="subtitle-1 mt-3">Gestion des autorisation d'absence</p>


                                                </v-col>

                                            </v-row>
                                        </v-container>


                                    </v-card>
                                    </v-hover>

                                    <v-hover v-slot="{ hover }">
                                    <v-card   @click="router(2)"  :color="hover ?  'blue lighten-4' :  '#ffff' " shaped class="ma-2"  :max-width="taille_min_card" height="185">
                                        <v-container>
                                            <v-row >

                                                <v-col cols="auto">
                                                    <v-img
                                                        height="80"
                                                        width="80"
                                                        :src="lien_site+'/img/fonds.png'"
                                                    ></v-img>
                                                    <p class="subtitle-1 mt-3">Gestion des demandes de fonds</p>


                                                </v-col>

                                            </v-row>
                                        </v-container>


                                    </v-card>
                                    </v-hover>

                                    <v-hover v-slot="{ hover }">
                                    <v-card   @click="router(3)"  :color="hover ?  'blue lighten-4' :  '#ffff' "  shaped class="ma-2"  :max-width="taille_min_card" height="185">
                                        <v-container>
                                            <v-row >

                                                <v-col cols="auto">
                                                    <v-img
                                                        height="80"
                                                        width="80"
                                                        :src="lien_site+'/img/parametre.png'"
                                                    ></v-img>
                                                    <p class="subtitle-1 mt-3">Paramètres</p>


                                                </v-col>

                                            </v-row>
                                        </v-container>


                                    </v-card>
                                    </v-hover>


                                </v-list-item-content>
                            </v-list-item>

                            <v-card-actions>

                            </v-card-actions>
                        </v-card>




                </v-col>
            </v-row>


        </v-container>








    </v-main>

</template>

<script>
export default {
    mounted() {
        window.addEventListener('resize', this.onResize, { passive: true })
        this.onResize();
    },
    data : () =>({

        isMobile: false,
        taille_card : 400,
        lien_site : location.protocol + '//' + location.host,
        taille_min_card : 100,

    }),
    methods:{
        router(id){
            switch (id){
                case 1:
                    this.$router.push({name : 'auto_abs'})
                    break;
                case 2:
                    this.$router.push({name : 'fonds'})
                    break;
                case 3:
                    this.$router.push({name : 'para'})
                    break;
            }
        },
        beforeDestroy () {
            if (typeof window === 'undefined') return

            window.removeEventListener('resize', this.onResize, { passive: true })
        },
        onResize () {
            this.isMobile = window.innerWidth < 600
            if(this.isMobile){
                this.taille_min_card =  125;
                this.taille_card = 400 ;
            }else {
                this.$root.$emit('responsive', 2);

                this.taille_min_card =  150;
                this.taille_card = 550 ;
            }
        },

    }
}
</script>
