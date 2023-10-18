<template>
    <div id="app" class="app-container">
      <!-- Masquer la NavBar pour les routes admin -->
      <NavBar v-if="!isAdminRoute" />
      
      <!-- Le contenu de votre application -->
      <router-view />
  
      <!-- Horaires et Bouton de contact -->
      <div class="sep" v-if="!isAdminRoute"></div>
      <div class="h-c" v-if="!isAdminRoute">
        <HorairesComponent />
        <br />
        <BtnContact />
      </div>
    </div>
    <FooterBar class="footer" v-if="!isAdminRoute" />
  </template>
  
  <script>
  import NavBar from "@/components/NavBar.vue";
  import FooterBar from "@/components/FooterBar.vue";
  import HorairesComponent from "@/components/HorairesComponent.vue";
  import BtnContact from "@/components/BtnContact.vue";
  
  export default {
    name: "PublicViews",
    components: {
      NavBar,
      FooterBar,
      HorairesComponent,
      BtnContact,
    },
    computed: {
      isAdminRoute() {
        return this.$route.path.startsWith('/admin');
      },
    },
  };
  </script>
  
  <style scoped>
  #app{
    scrollbar-width: none;
  }
  .app-container {
    
    min-height: 100vh;
    display: flex;
    flex-direction: column;
  }
  
  .footer {
    margin-top: auto;
  }
  </style>
  