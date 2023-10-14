<!-- NotFoundView.vue -->
<template>
  <div class="not-found-container">
    <h2 class="not-found-title">Oops! Page non trouvée (404)</h2>
    <p class="not-found-message">Désolé, la page que vous cherchez n'a pas été trouvée.</p>
    <router-link to="/home" class="not-found-link">Retour à l'accueil</router-link>
  </div>
</template>

<script>
export default {
  name: 'NotFoundView',
};
</script>

<style scoped>
/* Styles pour NotFoundView */
.not-found-container {
  border: solid 1px black;
  padding: 20px;
  background-color: #58c941;
  text-align: center;
  margin: 100px auto;
}

.not-found-title {
  font-size: 30px;
  color: #f44336; /* Couleur rouge (personnalisez-la selon votre choix) */
  font-weight: bold;
}

.not-found-message {
  font-size: 22px;
  font-style: italic;
  color: #333; /* Couleur de texte principale (personnalisez-la selon votre choix) */
  margin-top: 10px;
}

.not-found-link {
  display: inline-block;
  font-size: 18px;
  color: #04131f; /* Couleur bleue (personnalisez-la selon votre choix) */
  font-weight: bold; 
  margin-top: 20px;
}

.not-found-link:hover {
  text-decoration: underline;
}
</style>
