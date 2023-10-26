<template>
  <div>
    <div class="bg">
      <img src="@/assets/images/carrosserie/bg.jpg" alt="image de fond carrosserie">
    </div>

    <section class="main">
      <div class="sep"></div>
      <h1 id="link-place"><h1>Bienvenue chez Garage V-Parrot - Votre Expert en Réparation Automobile à Toulouse</h1></h1>
      <div class="sep"></div>

      <!-- A propos -->
      <article id="a_propos" class="article-center txt-m">
        <h2> A propos </h2>
        <get-article :title="'a-propos'"></get-article>
      </article>

      <div class="sep"></div>
      <!-- Div pour afficher les commentaires -->
      <div id="avis_clients">
        <GetComments /> <!-- Utilisation du composant GetComments.vue -->
      </div>
      <div>
        <PostComments/>
      </div>
    </section>
  </div>
</template>

<script>
import GetArticle from "@/components/GetArticle.vue"; // Importer le composant GetArticle

import GetComments from "@/components/GetComments.vue";
import PostComments from "@/components/PostComments.vue";

export default {
  name: 'HomeView',
  components: {
    GetArticle, // Ajouter le composant GetArticle
    GetComments,
    PostComments
  }
}
</script>

<style scoped>

</style>
