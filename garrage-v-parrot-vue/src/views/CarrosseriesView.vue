<template>
  
     <!-- image banniere -->
     <div class="bg">
        <img src="@/assets/images/carrosserie/bg.jpg" alt="image de fond mecanique">
    </div>

    <div class = "sep"></div>
    <!-- main section -->
    <section class = "main">
        <h1 id ="link-place">Réparations de carrosseries :</h1>

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
            <p class="txt-s">
                Au Garage <b>V-Parrot</b>. Nous sommes spécialisés dans 
                la <b>réparation de carrosserie</b>, offrant des services de qualité pour redonner vie à votre véhicule. 
                Notre équipe expérimentée utilise les meilleures techniques et équipements pour restaurer l'aspect 
                d'origine de votre voiture. Que ce soit pour des bosses, des rayures ou d'autres dommages, 
                <b>faites confiance à nos experts pour des résultats exceptionnels</b>.
                Prenez rendez-vous dès aujourd'hui et confiez votre voiture entre nos mains expertes.
            </p>
        </article>
      
       
    </section>
</template>

<script>
export default {

 name: 'CarroseriesView',
  components: {
   
  }
}
</script>

<style>

</style>