<template>
    <v-container>
        <v-card>
            <v-card-text>
            <v-row >
                <v-col cols="12">
                    <v-card-title class="center-align" > Bienvenido {{ getNameUser ? getNameUser : "" }} </v-card-title>
                </v-col>
            </v-row>
            <v-row >
                <v-col cols="12">
                    <posts-component />
                </v-col>
            </v-row>
            </v-card-text>
        </v-card>
    </v-container>
</template>

<script>
import { mapGetters } from 'vuex'
export default {
    name: "Home",
    computed: {
        ...mapGetters(['getNameUser'])
    }
}
</script>

<style scoped>

.padding{
    padding-left: 50px;
    padding-right: 50px;
    padding-bottom: 100px;
    font-family: "Nunito", Times, serif;
}
.imagen-portada{ width: 400px; }
.section-imagen{
    display: flex;
    align-items: center;
    height: 40vh;
}
</style>
