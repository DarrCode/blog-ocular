<template>
  <div>
    <v-app-bar white>
      <v-img
        contain
        lazy-src="images/logo.png"
        max-height="45"
        max-width="45"
        :src="'/' + 'images/logo.png'"
        ></v-img>
      <v-toolbar-title class="color-primary title_nav">
        <a href="/">Blog Ocular</a>
      </v-toolbar-title>

      <v-spacer></v-spacer>
      <span v-if="this.$route.path == '/login'">
        <v-btn
          dark
          class="bg-primary fw-bold"
          href="/"
        >Ver posts</v-btn>
      </span>
     <span v-else>
         <v-btn
          dark
          class="bg-primary fw-bold"
          href="/login"
        >Login admin</v-btn>
     </span>
    </v-app-bar>
  </div>
</template>