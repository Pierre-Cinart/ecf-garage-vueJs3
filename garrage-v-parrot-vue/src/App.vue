<template>
  <div id="app">
    <!-- Intégrer le composant NavBar -->
    <NavBar/>

    <!-- Le contenu de votre application -->
    <router-view/>

    <FooterBar/>
  </div>
</template>

<script>
import NavBar from "@/components/NavBar.vue";
import FooterBar from "@/components/FooterBar.vue";
export default {
  name: "App",
  components: {
    NavBar ,FooterBar
  }
}
</script>

<style>
/* Styles pour l'application principale */
</style>
