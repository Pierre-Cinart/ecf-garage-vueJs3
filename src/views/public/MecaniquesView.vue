<template>


    <!-- image banniere -->
    <div class="bg">
        <img src="@/assets/images/mecanique/bg.jpg" alt="image de fond mecanique">
    </div>

    <div class = "sep"></div>
    <!-- main section -->
    <section class="main" >
        <h1 id ="link-place">Réparation Mécanique de Qualité au Garage V-Parrot</h1>
        <div class = "sep"></div>
        <section class ="pictures">
            <div>
                <img src="@/assets/images/mecanique/repa1.jpeg" alt="image mecanique vehicule">
                <img src="@/assets/images/mecanique/repa2.jpeg" alt="image mecanique vehicule"> 
            </div>
            <div>
                <img src="@/assets/images/mecanique/repa3.jpg" alt="image mecanique vehicule">
                <img src="@/assets/images/mecanique/repa4.jpg" alt="image mecanique vehicule"> 
            </div>
        </section>

        <div class = "sep"></div>
            <!-- texte informations -->
            <article class="txt-box" >
                
                  
             <!-- injection de larticle concerné  -->
        <get-article :title="'mecanique'"></get-article>
            </article>
            
            
    </section>
   
</template>

<script>
    import GetArticle from "@/components/GetArticle.vue"; 

    export default {
        name: 'MecaniquesView',
        components: {
        GetArticle
    }

    }
</script>

<style>

</style>