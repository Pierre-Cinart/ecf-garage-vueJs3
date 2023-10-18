<template>
  <div>
  
    <div class="bg">
      <img src="@/assets/images/carrosserie/bg.jpg" alt="image de fond carrosserie">
    </div>
   
    <section class="main">
      <div class="sep"></div>
      <h1 id ="link-place"><h1>Bienvenue chez Garage V-Parrot - Votre Expert en Réparation Automobile à Toulouse</h1></h1>
      <div class="sep"></div>

      <!-- A propos -->
      <article id="a_propos" class="article-center txt-m">
        <h2> A propos </h2>
        <p>Chez <strong>Garage V-Parrot</strong>, nous sommes passionnés par les voitures. Forts de nos 
          <strong>15 années d'expérience</strong> dans la réparation automobile, nous mettons tout en œuvre pour offrir 
          à nos clients des services de qualité inégalée. Que vous recherchiez une réparation mécanique ou de carrosserie, 
          l'entretien régulier de votre véhicule ou même une voiture d'occasion de confiance, vous êtes au bon endroit.</p>
        <p>Nous croyons en l'importance de la <strong>transparence</strong> et de l'<strong>intégrité</strong>. 
          Notre entreprise est fondée sur la confiance et l'engagement envers l'excellence. 
          L'expérience de 15 ans de Vincent Parrot dans la réparation automobile est au cœur de notre réputation. 
          Notre équipe d'experts passionnés est dévouée à la sécurité et à la performance de votre véhicule.</p>
        <p>Le Garage V-Parrot est bien plus qu'un simple atelier. C'est un lieu de confiance où votre voiture est toujours 
          entre de bonnes mains. Nous offrons un service <strong>personnalisé</strong> à chaque client, car nous comprenons 
          que chaque voiture est unique, tout comme les besoins de ses propriétaires.</p>
        <p>Nous sommes fiers de vous proposer un service complet, de la réparation à l'entretien, en passant par la vente 
          de voitures d'occasion. Notre engagement envers l'excellence et la satisfaction du client est notre priorité 
          absolue. Avec Garage V-Parrot, vous pouvez être sûr que votre voiture est entre les mains d'experts passionnés 
          qui se soucient de son bien-être autant que vous.</p>
        <p>Explorez notre site pour en savoir plus sur nos services, notre équipe et nos engagements envers la qualité. 
          Nous attendons avec impatience de vous accueillir dans notre garage et de prouver notre dévouement envers votre 
          voiture. Faites-nous confiance pour prendre soin de votre véhicule comme si c'était le nôtre.</p>

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

import GetComments from "@/components/GetComments.vue";
import PostComments from "@/components/PostComments.vue";
export default {
  name: 'HomeView',
  components: {
   
    GetComments,PostComments // Ajout du composant GetComments
  }
}
</script>

<style scoped>
/* Ajoutez vos styles CSS ici, s'ils sont spécifiques à cette vue */
</style>
