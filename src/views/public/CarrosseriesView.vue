<template>
  
     <!-- image banniere -->
     <div class="bg">
        <img src="@/assets/images/carrosserie/bg.jpg" alt="image de fond mecanique">
    </div>

    <div class = "sep"></div>
    <!-- main section -->
    <section class = "main">
        <h1 id ="link-place">Réparation de Carrosserie de Qualité au Garage V-Parrot</h1>

        <div class = "sep"></div>
        <!-- images de fond , presentation -->
        <section class ="pictures" >
            <div>
                <img src="@/assets/images/carrosserie/car4.webp" alt="image carrosserie vehicule">
                <img src="@/assets/images/carrosserie/car2.jpg" alt="image carrosserie vehicule"> 
            </div>
            <div>
                <img src="@/assets/images/carrosserie/car3.jpg" alt="image carrosserie vehicule">
                <img src="@/assets/images/carrosserie/car1.jpg" alt="image carrosserie vehicule"> 
            </div>
        </section>

        <div class = "sep"></div>
        <!-- text informations -->
        <article class="txt-box">
            
             <!-- injection de larticle concerné  -->
        <get-article :title="'carrosserie'"></get-article>
        </article>
      
       
    </section>
</template>

<script>
    import GetArticle from "@/components/GetArticle.vue"; 

    export default {
   
        name: 'CarroseriesView',
        components: {
            GetArticle
        }
    }
</script>

<style>

</style>