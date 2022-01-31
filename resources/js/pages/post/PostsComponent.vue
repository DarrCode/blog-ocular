<template>
    <v-container >
        <v-row>
            <v-col cols="12">
                <span v-if="posts != null && posts.length > 0">
                    <paginate name="posts" :list="posts" :per="5">
                        <v-row>
                            <v-col cols="4" v-for="(post, index) in paginated('posts')" :key="post.id">
                                <v-card max-width="374">
                                    <v-img
                                        height="250"
                                        :src="post.image"
                                    ></v-img>
                                    <v-card-title>{{post.title}}</v-card-title>
                                    <v-card-text>
                                        <v-card-title>{{ post.description | resume }}</v-card-title>
                                        <div class="my-4 text-subtitle-1 float-end" style="text-align: right">
                                            Autor: {{post.author}}
                                        </div>
                                        <v-btn
                                            text
                                            class="color-primary fw-bold mt-5"
                                            @click="redirect(post.id, index)"
                                            >ver mas</v-btn>
                                    </v-card-text>
                                </v-card>
                            </v-col>
                        </v-row>
                    </paginate>
                     <paginate-links
                        for="posts"
                        :show-step-links="true"
                        :simple="{
                            prev: 'Anterior',
                            next: 'Siguiente'  
                        }"
                    ></paginate-links>
                </span>

                <h5 v-else>
                    <b>No hay posts para mostrar</b>
                </h5>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
export default {
    props: ['user'],
    data() {
        return {
            posts: [],
            paginate: ['posts'],
        }
    },
    filters: {
        resume(value) {
            let resume = value.slice(0, 50);
            return resume + '...'
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
        redirect(id, index) {
            if(this.user != undefined && this.user == 'guest') {
                let anchor  = document.createElement('a')
                anchor.href = `/post/${id}/?guest=true`
                anchor.click()
            } else {
                this.$router.push({ 
                    name: 'AnPost', 
                    params: {
                        id,
                        post: this.posts[index]
                    }
                })
            }

            this.visit(id)
        },
        async getPost() {
            try {
                const url       = `/all/posts`
                let responses   = await axios.get(url)

                if(responses.data) {
                    this.posts = responses.data
                }                
            } catch (error) {
                console.log(error)
            }
        }
    },
    mounted() {
        this.getPost()
    }
}
</script>
<style>
.paginate-links{
    margin-top: 25px;
    width:100%;
    list-style: none;
    text-align: center;
}
.paginate-links li {
    display: inline;
    background-color:#1f4df0;
    padding:0.5rem;
    margin-left:0.3rem;
    margin-right: 0.3rem;
    cursor:pointer;
    border-radius: 4px;
    text-transform: uppercase;
    font-weight: bold;
}
.paginate-links li a{
    color:white!important;
}

.paginate-result{
    width: 100%;
    text-align:center;
    margin-bottom: 1rem;
}
</style>
