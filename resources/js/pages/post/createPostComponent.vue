<template>
    <v-container >
        <v-row >
            <v-col cols="12">
                <v-card>
                    <v-card-text>
                        <h3 class="center-align"> Administrar publicaciones ! </h3>
                            <br>
                            <v-btn v-if="!form" small class="bg-primary fw-bold color-white" @click="form = !form">
                                Crear post
                            </v-btn>
                            <v-btn v-else small color="red" class="fw-bold color-white"  @click="form = !form; clear()">
                                Cancelar
                            </v-btn>
                            <div v-if="form">
                                <v-container>
                                    <v-form id="form" @submit.prevent="setPost" enctype="multipart/form-data">
                                        <v-row>
                                            <v-col cols="12" md="6">
                                                <v-text-field
                                                    v-model="title"
                                                    :rules="titleRules"
                                                    label="Titulo"
                                                ></v-text-field>
                                            </v-col>
                                            <v-col cols="12" md="6">
                                                <v-text-field
                                                    v-model="author"
                                                    :rules="authorRules"
                                                    label="Autor"
                                                ></v-text-field>
                                            </v-col>
                                        </v-row>
                                        <v-row>
                                            <v-col cols="12" md="6">
                                                <v-text-field
                                                    v-model="slug"
                                                    label="Slug"
                                                ></v-text-field>
                                            </v-col>
                                            <v-col cols="12" md="6">
                                                <v-textarea
                                                    v-model="description"
                                                     rows="2"
                                                    label="Descripcion"
                                                ></v-textarea>
                                            </v-col>
                                        </v-row>
                                        <v-row>
                                            <v-col cols="12" md="6">
                                                <input type="file"
                                                truncate-length="15"
                                                @change="onFileUpload" accept="image/*" 
                                                />
                                            </v-col>
                                            <v-col cols="12" md="6">
                                                <img v-if="image" :src="preview" alt="vista previa" width="70">
                                            </v-col>
                                        </v-row>
                                        <v-checkbox
                                            v-model="published"
                                            :label="`Checkbox 1: ${published.toString()}`"
                                        ></v-checkbox>
                        
                                        <v-btn type="submit"  class="primary fw-bold" v-if="form && !edit">Crear</v-btn>
                                    </v-form>
                                    <v-btn  class="primary fw-bold" v-if="edit" @click="putPost">Guardar</v-btn>
                                </v-container>
                            </div>
                            <div v-else>
                                <v-simple-table v-if="posts.length > 0">
                                    <template v-slot:default>
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Título</th>
                                                <th>Autor</th>
                                                <th>Descripción</th>
                                                <th>Miniatura</th>
                                                <th>Publicado</th>
                                                <th>Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="(post, index) in posts" :key="index">
                                                <td>{{ index + 1 }}</td>
                                                <td>{{ post.title }}</td>
                                                
                                                <td>{{ post.author }}</td>
                                                <td>{{ post.description.slice(0, 10) }}</td>
                                                <td>
                                                    <img v-if="post.image" :src="'/' + post.image" alt="vista previa" width="70">
                                                </td>
                                                <td>{{ post.published ? 'Si' : 'No' }}</td>
                                                <td>
                                                    <v-btn small class="yellow" @click="editPost(index)">Editar</v-btn>
                                                    <v-btn small class="red" @click="delPost(post.id)">Borrar</v-btn>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </template>
                                </v-simple-table>
                                <h4 class="text-center" v-else>no hay información para mostrar</h4>
                            </div>
                    </v-card-text>
                </v-card>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
import Swal from "sweetalert2"
export default {
    data() {
        return {
            form: false,
            edit: false,
            posts: [],
            id: null,
            title: null,
            author: null,
            slug: null,
            description: null,
            image: null,
            published: false,
            lastFile: null,
            titleRules: [
                v => !!v || 'El titulo es requerido',
            ],
            authorRules: [
                v => !!v || 'El autor es requerido',
            ],
        }
    },
    watch: {
        published() {
            if(this.published == null) {
                this.published = false
            }
        }
    },
    methods: {
        onFileUpload(evt) {
            this.image      = evt.target.files[0]
            this.lastFile   = URL.createObjectURL(this.image)
        },
        editPost(index) {
            let data            = this.posts[index]
            this.edit           = true
            this.form           = true
            this.id             = data.id
            this.title          = data.title
            this.author         = data.author
            this.slug           = data.slug
            this.description    = data.description
            this.image          = data.image
            this.published      = Boolean(data.published)
            this.lastFile       = data.image
        },
        clear() {
            this.form           = false
            this.edit           = false
            this.id             = null
            this.title          = null
            this.author         = null
            this.slug           = null
            this.description    = null
            this.image          = null
            this.published      = false
            this.lastFile       = null
        },
        async getPosts() {
            try {
                const url    = `/admin/posts`
                let response = await axios.get(url)

                if (response.data) {
                    this.posts = response.data
                    console.log(this.posts);
                }
            } catch (error) {
                console.log(error)
            }
        },
        async setPost() {
            try {
                const url   = `/admin/posts/store`
                let params  = new FormData(document.getElementById("form"))
                params.append("title", this.title)
                
                params.append("author", this.author)
                params.append("slug", this.slug)
                params.append("description", this.description)
                params.append("image", this.image)
                params.append("published", Boolean(this.published))

                let response = await axios.post(url, params)

                if (response.data) {
                    this.getPosts()
                    this.clear()
                    Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: 'Post guardado correctamente',
                        showConfirmButton: false,
                        timer: 1500
                    })
                }                
            } catch (error) {
                console.log(error.response.data.errors)
            }
        },
        async putPost() {
            try {
                const url   = `/admin/posts/${this.id}/update`
                let params  = new FormData(document.getElementById("form"))

                params.append("title", this.title)
                params.append("author", this.author)
                params.append("slug", this.slug)
                params.append("description", this.description)
                params.append("image", this.image)
                params.append("published", Boolean(this.published))

                let response = await axios.post(url, params)

                if (response.data) {
                    this.getPosts()
                    this.clear()
                    Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: 'Post actualizado correctamente',
                        showConfirmButton: false,
                        timer: 1500
                    })
                }                
            } catch (error) {
                console.log(error)
            }
        },
        async delPost(id) {
            try {
                const url    = `/admin/posts/${id}/delete`
                let response = await axios.delete(url)

                if (response.data) {
                    this.getPosts()
                    this.clear()
                    Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: 'Post borrado correctamente',
                        showConfirmButton: false,
                        timer: 1500
                    })
                } 
            } catch (error) {
                console.log(error)
            }
        }
    },
    computed: {
        preview() {
            if(this.edit) {
                if(this.lastFile.startsWith('blob')) {
                    return this.lastFile
                } else {
                    return `storage/${ this.lastFile }`
                }
            } else {
                return this.lastFile
            }
        }
    },
    mounted() {
        this.getPosts()
    }
}
</script>