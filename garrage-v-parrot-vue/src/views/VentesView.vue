<template>
 
 <section class = "main">
    <div class="sep"></div>
    <h1 id ="link-place">Nos véhicules</h1>
    <div class="sep"></div>
      <GetCars /> <!-- Utilisation du composant GetCars ici -->

</section> 
  </template>
  
  <script>
  import GetCars from '@/components/GetCars.vue'
  
  export default {
    components: {
      GetCars // Inscrivez le composant GetCars dans les composants de cette vue
    }
  }
  </script>
  
  <style scoped>
  /* Ajoutez vos styles CSS ici, s'ils sont spécifiques à cette vue */
  </style>
  