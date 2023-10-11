<template>
  <div>
  
    <div class="bg">
      <img src="@/assets/images/carrosserie/bg.jpg" alt="image de fond carrosserie">
    </div>

    <section class="main">
      <div class="sep"></div>

      <!-- A propos -->
      <article id="a_propos" class="article-center txt-m">
        <h2>A propos</h2>
        <p>
          Bienvenue sur notre site automobile ! Chez <b>Garage V-Parrot</b>, nous sommes passionnés par les voitures et nous mettons tout en œuvre pour offrir des services de qualité à nos clients. Que vous ayez besoin d'une <b>réparation</b>, de l'<b>entretien régulier</b> de votre véhicule ou que vous cherchiez une <b>voiture d'occasion</b>, vous êtes au bon endroit.
          <!-- (Le reste de votre contenu) -->
        </p>
      </article>

      <div class="sep"></div>

      <!-- Div pour afficher les commentaires -->
      <div id="commentaires">
        <GetComments /> <!-- Utilisation du composant GetComments.vue -->
      </div>
    </section>
  </div>
</template>

<script>

import GetComments from "@/components/GetComments.vue";

export default {
  name: 'HomeView',
  components: {
   
    GetComments, // Ajout du composant GetComments
  }
}
</script>

<style scoped>
/* Ajoutez vos styles CSS ici, s'ils sont spécifiques à cette vue */
</style>
