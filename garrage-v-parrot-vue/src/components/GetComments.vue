<template>
    <div>
      <h2>Liste des commentaires</h2>
      <ul>
        <li v-for="comment in comments" :key="comment.comment_id">
          <strong>{{ comment.firstname }} {{ comment.name }}:</strong>
          {{ comment.comment_text }}
        </li>
      </ul>
    </div>
  </template>
  
  <script>
  export default {
    data() {
      return {
        comments: [],
      };
    },
    created() {
      // Effectue une requête pour récupérer les commentaires depuis votre API
      // Assurez-vous de remplacer 'URL_DE_VOTRE_API' par l'URL de votre API.
      fetch('http://localhost/ECF2023/ECF-GARAGE-V-PARROT/garrage-v-parrot-vue/backend/GetComments.php')
        .then(response => response.json())
        .then(data => {
          this.comments = data;
        })
        .catch(error => {
          console.error('Erreur lors de la récupération des commentaires :', error);
        });
    },
  };
  </script>
  
  <style scoped>
  /* Ajoutez vos styles CSS ici, s'ils sont spécifiques à ce composant */
  </style>
  