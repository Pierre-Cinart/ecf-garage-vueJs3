<template>

   <!-- image bannière  -->
    <div class="bg">
        <img src="@/assets/images/entretien/bg.jpg" alt="image de fond entretien">
    </div>

    <div class = "sep"></div>

     <!-- main section -->
    <section class="main">
    <h1 id ="link-place">Entretien de Votre Véhicule au Garage V-Parrot</h1>
    <div class = "sep"></div>
    <!-- images de fond  ,présentation -->
        <div class ="pictures">
            <div>
                <img src="@/assets/images/entretien/ent1.jpeg" alt="image entretien vehicule">
                <img src="@/assets/images/entretien/ent2.jpeg" alt="image entretien vehicule"> 
            </div>
            <div>
                <img src="@/assets/images/entretien/ent3.jpeg" alt="image entretien vehicule">
                <img src="@/assets/images/entretien/ent4.jpg" alt="image entretien vehicule"> 
            </div>
        </div>

        <div class = "sep"></div>
        
        <!-- texte de description -->
        <article >
            <div class="txt-box">
            
                <get-article :title="'entretien'"></get-article>  

            </div>
        </article>       
    </section>

</template>

<script>
import GetArticle from "@/components/GetArticle.vue"; 
export default {
  name: 'EntretiensView',
  components: {
    GetArticle
  }
}
</script>

<style>

</style>