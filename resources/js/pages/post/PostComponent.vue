<template>
    <v-container>
        <v-row>
            <v-col cols="1">
                <router-link to="/">
                    <v-btn 
                        class="btn btn center"
                        @click="redirect"
                    >Volver</v-btn>
                </router-link>
            </v-col>
            <v-col cols="11">
                <v-card max-width="600" class="mx-auto">
                    <v-img :src="'/' + post_selected.image"> 
                    </v-img>
                    <v-card-subtitle>Autor: {{post_selected.author}}</v-card-subtitle>
                    <v-card-title>{{post_selected.title}}</v-card-title>
                   
                    <v-card-text>
                        <v-card-title>{{ post_selected.description }}</v-card-title>
                        <p>
                            publicado: {{ post_selected.created_at | formatDate }}
                        </p>                   
                    </v-card-text>
                </v-card>
                <center class="mt-3" v-if="this.$store.state.posts.length >= 1">
                    <v-btn @click="prev">Anterior</v-btn>
                    <v-btn disabled>
                      <h2>{{ position }}</h2>
                    </v-btn>
                    <v-btn @click="next">siguiente</v-btn>                                
                </center>
                <span v-else>
                    <p>No hay mas post publicados</p>
                </span>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
import { mapActions, mapGetters } from 'vuex'
import moment from 'moment';

export default {
    props: ['post', 'user'],
    data() {
        return {
            post_selected: this.post,
            id: null
        }
    },
    filters: {
        formatDate(value) {
            if (value) {
                return moment(String(value)).format('DD/MM/YYYY')
            }
        }
    },
    methods: {
        async visit(id) {
            try {
                const url   = `/post/visit/new`
                let params  = {
                    id
                }
                let resp    = await axios.post(url, params)
            } catch (error) {
                console.log(error)
            }
        },
        next() {
            let allPost = this.$store.state.posts
            let index = allPost.map(element => element.id).indexOf(this.post_selected.id)
            
            if(index <= allPost.length) {
                let id = allPost[index + 1].id
                this.visit(id)

                this.$router.push({ 
                name: 'AnPost', 
                params: {
                        id,
                        post: allPost[index + 1]
                    }
                })
                setTimeout(() => this.getPost(), 1000)
            }
        },
        prev() {
            let allPost = this.$store.state.posts
            let index = allPost.map(e => e.id).indexOf(this.post_selected.id)

            if(index > 0) {
                let id = allPost[index - 1].id
                this.visit(id)

                this.$router.push({ 
                name: 'AnPost', 
                params: {
                        id: allPost[index - 1].id,
                        post: allPost[index - 1]
                    }
                })

                setTimeout(() => this.getPost(), 1000)
            }
        },
        redirect() {
            if(this.user != undefined && this.user == 'guest') {
                window.location.href = `/`
            }
        },
        async getPost() {
            try {
                const url = `/post/${ this.$route.params.id }`
                let response = await axios.get(url)

                if(response.data) {
                    this.post_selected = response.data
                }
            } catch (error) {
                console.log(error)
            }
        },
        ...mapActions(['getAllPost'])
    },
    mounted() {
        this.getPost()
        this.getAllPost()
        
    },
    computed: {
        ...mapGetters(['getRoleUser', 'getIdUser', 'getEmailUser']),
        position() {
            let allPost = this.$store.state.posts
            let index   = allPost.map(element => element.id).indexOf(this.post_selected.id)
            return (index + 1)
        }
    }
}
</script>

<style scoped>
.v-card__subtitle{
    padding: 5px 16px 0px ;
}
.mt-3{
    margin-top: 20px;
}
.v-btn {
    background-color:#1f4df0!important;
    font-weight: bold;
    color: white;
}

</style>