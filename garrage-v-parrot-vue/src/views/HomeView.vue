<template>

    <NavBar/>
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
    <h2> place réservée aux commentaires ...</h2>
      <div class="sep"></div>

      <!-- Horaires -->
      <section class="horraire">
        <h2>Horaires</h2>
        <p style="text-align: left">
          <span>Lundi :</span> 8h00 - 17h00 <br>
          <span>Mardi :</span> 8h00 - 17h00 <br>
          <span>Mercredi :</span> 8h00 - 17h00 <br>
          <span>Jeudi :</span> 8h00 - 17h00 <br>
          <span>Vendredi :</span> 8h00 - 17h00 <br>
          <span>Samedi :</span> 9h00 - 12h00 (matin seulement) <br>
          <span>Dimanche :</span> Fermé
        </p>
      </section>
    </section>
 
</template>

<script>
// @ est un alias vers /src


export default {
  name: 'HomeView',
  components: {
   
  }
}
</script>

<style scoped>
/* Ajoutez vos styles CSS ici, s'ils sont spécifiques à cette vue */
</style>
