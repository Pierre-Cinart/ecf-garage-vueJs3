<template>
  <div id="app">
    <!-- Intégrer le composant NavBar -->
    <NavBar/>

    <!-- Le contenu de votre application -->
    <router-view/>

    <!-- horaires -->
    <div class="sep"></div>
   <div class ="h-c">
    <HorairesComponent/>
    <br>
    <BtnContact/>
   </div>
    <FooterBar/>
  </div>
</template>

<script>
import NavBar from "@/components/NavBar.vue";
import FooterBar from "@/components/FooterBar.vue";
import HorairesComponent from "@/components/HorairesComponent.vue";
import BtnContact from "@/components/BtnContact.vue";
export default {
  name: "App",
  components: {
    NavBar, FooterBar, HorairesComponent,BtnContact,
  }
}
</script>

<style scoped>
</style>
