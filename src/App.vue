<template>
  <v-app>
    <header-component />
    <v-main>
      <home-view />
    </v-main>
  </v-app>
</template>

<script>
import HeaderComponent from "@/components/header.vue";
import HomeView from "@/views/home.vue"

export default {
  name: "App",

  components: {
    HeaderComponent,
    HomeView
  },

  data: () => ({
    //
  }),
};
</script>

<style>
body {
  overflow-y: auto !important;
}
</style>
