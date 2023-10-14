<template>


    <!-- image banniere -->
    <div class="bg">
        <img src="@/assets/images/mecanique/bg.jpg" alt="image de fond mecanique">
    </div>

    <div class = "sep"></div>
    <!-- main section -->
    <section class="main" >
        <h1 id ="link-place">Réparations de mécaniques :</h1>
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
                <p class="txt-s">
                    Au Garage <b>V-Parrot</b>. 
                    Nous sommes spécialisés dans <b>la réparation</b> et l'entretien de tous types de véhicules. 
                    Notre équipe de mécaniciens qualifiés est là pour prendre soin de votre voiture et résoudre tous 
                    <b>les problèmes mécaniques</b>. Que ce soit pour une révision, une réparation moteur, 
                     une climatisation ou tout autre service, nous mettons tout en œuvre pour garantir le bon 
                    fonctionnement de votre véhicule. Faites confiance à notre expertise et à notre 
                    engagement envers la qualité du service. 
                    Prenez rendez-vous dès aujourd'hui et laissez-nous prendre soin de votre voiture.
                </p>
            </article>
            
            
    </section>
   
</template>

<script>
export default {
    name: 'MecaniquesView',
  components: {
   
  }

}
</script>

<style>

</style>