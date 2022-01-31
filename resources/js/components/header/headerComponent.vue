<template>
  <v-app id="inspire">
      <v-navigation-drawer app white>
        <v-list-item>
          <v-list-item-content>
            <v-list-item-title class="text-h6">
              Blog Ocular
            </v-list-item-title>
            <v-list-item-subtitle>
              ADMIN
            </v-list-item-subtitle>
          </v-list-item-content>
        </v-list-item>

        <v-divider></v-divider>
        <v-list nav dense v-for="(items, index) in  menuItems" :key="index">
            <v-list-item link :href="items.route">
                <v-list-item-icon>
                    <v-icon color="#1f4df0">{{items.icon}}</v-icon>
                </v-list-item-icon>
                <v-list-item-title class="title">{{items.title}}</v-list-item-title>
            </v-list-item>
        </v-list>
        <template v-slot:append>
        <div class="pa-2">
          <v-btn 
            dark
            block
            @click="logout"
            class="bg-primary fw-bold">
            Logout
          </v-btn>
        </div>
      </template>
      </v-navigation-drawer>
      <v-content>
          <v-container
            fluid
            fill-height
          >
            <v-layout>
              <v-flex>
                <transition>       
                  <router-view></router-view>
                </transition>
              </v-flex>
            </v-layout>
          </v-container>
      </v-content>
    </v-app>
</template>

<script>
import { mapGetters, mapActions } from 'vuex'
export default {
  props: ['route'],
  name: "Header",
  data() {
    return {
      sidebar: false,
      menuItems: [
        { title: 'Home', route: '/', icon: 'mdi-home' },
        { title: 'Posts', route: '/post', icon: 'mdi-content-paste' },
        { title: 'Estadisticas', route: '/analytic', icon: 'mdi-chart-areaspline' },
      ]
    };
  },
  methods: {
    collapse() {
      this.sidebar = !this.sidebar;
    },
    async logout() {
      try {
        const url = `${ this.route }`
        await axios.post(url)
        console.log('cerrado correctamente')
        window.location.href = "/"
      } catch (error) {
        console.log(error)
      }
    },
    ...mapActions(['getUser']),
  },
  computed: {
    ...mapGetters(['getRoleUser'])
  },
  created() {
    this.getUser()
  }
};
</script>