<template>
    <v-stepper v-model="e1">
        <v-stepper-header>
            <v-stepper-step
                :complete="e1 > 1"
                :vertical="!!isMobile"
                step="1"
            >
               Méthode de paiement
            </v-stepper-step>

            <v-divider></v-divider>

            <v-stepper-step
                :complete="e1 > 2"
                step="2"
            >
                Paiement
            </v-stepper-step>

            <v-divider></v-divider>

            <v-stepper-step step="3">
                Téléchargement
            </v-stepper-step>
        </v-stepper-header>

        <v-stepper-items>
            <v-stepper-content step="1">
                <v-card
                    class="mb-12"
                    color="grey lighten-1"
                    height="200px"
                ></v-card>

                <v-btn
                    color="primary"
                    @click="e1 = 2"
                >
                    Suivant
                </v-btn>

                <v-btn text>
                    Sortir
                </v-btn>
            </v-stepper-content>

            <v-stepper-content step="2">
                <v-card
                    class="mb-12"
                    color="grey lighten-1"
                    height="200px"
                ></v-card>

                <v-btn
                    color="primary"
                    @click="e1 = 3"
                >
                    Suivant
                </v-btn>

                <v-btn @click="e1 = 1" text>
                    Retour
                </v-btn>
            </v-stepper-content>

            <v-stepper-content step="3">
                <v-card
                    class="mb-12"
                    color="grey lighten-1"
                    height="200px"
                ></v-card>

                <v-btn
                    color="primary"
                    @click="e1 = 1"
                >
                    Suivant
                </v-btn>

                <v-btn @click="e1 = 2" text>
                    Retour
                </v-btn>
            </v-stepper-content>
        </v-stepper-items>
    </v-stepper>
</template>
<script>
export default {
    data () {
        return {
            e1: 1,
            isMobile: window.innerWidth < 700,
        }
    },
}
</script>
