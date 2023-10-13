<template>
  <div>
    <h2 >Avis de nos clients</h2>
    <div v-for="comment in comments" :key="comment.comment_id" class="txt-box" style="margin-bottom: 10px;">
      <div style="background-color: white; width: 25%; min-width: 110px; padding: 15px; border-radius: 5px; border: 1px solid black;">
        <p style="text-align: left; font-weight: bold; text-decoration: underline;">{{ comment.firstname }}</p>
        <p style="text-align: left;">{{ formatDate(new Date(comment.comment_date)) }} :</p>
      </div>
      <div>
        <p>{{ comment.comment_text }}</p>
      </div>
    </div>
   
    <!-- Formulaire pour poster un commentaire -->
    <h2>votre avis nous intéresse <br>
    laissez nous un commentaire :</h2>
    <div class="post_comment">
    <form @submit="postComment" method="post">
      <div class="l">
        <!-- Champ "Nom" -->
      <input  type="text" v-model="newComment.nom" placeholder="Nom">
      <br><br>
      <!-- Champ "Prénom" -->
      <input  type="text" v-model="newComment.prenom" placeholder="Prénom">
      <br><br>
      </div>
      <!-- Champ "Commentaire" -->
      <textarea v-model="newComment.text" rows="5" placeholder="Votre commentaire"></textarea>
      
      <button type="submit">Poster le commentaire</button>
    </form>
  </div>
  </div>
</template>

<script>
import { format, isDate } from 'date-fns';
import fr from 'date-fns/locale/fr'; // Importez fr depuis date-fns/locale

export default {
  data() {
    return {
      comments: [],
      newComment: '' // Champ pour le nouveau commentaire
    };
  },
  created() {
    // Effectue une requête pour récupérer les commentaires depuis votre API
    this.getComments();
  },
  methods: {
    getComments() {
      fetch('http://localhost/ECF2023/ECF-GARAGE-V-PARROT/garrage-v-parrot-vue/backend/GetComments.php')
        .then(response => response.json())
        .then(data => {
          this.comments = data;
        })
        .catch(error => {
          console.error('Erreur lors de la récupération des commentaires :', error);
        });
    },
    postComment(event) {
      event.preventDefault();
      // // Envoyer le nouveau commentaire à votre API (à implémenter)
      // // Réinitialiser le champ du nouveau commentaire
      // this.newComment = '';
      // // Mettre à jour la liste des commentaires
      // this.getComments();
    },
    formatDate(date) {
      if (isDate(date)) {
        return format(date, 'EEEE d MMMM', { locale: fr });
      }
      return 'Date invalide';
    },
  }
};
</script>

<style scoped>
.post_comment {
  max-width: 600px;
  margin: 0 auto;
  padding: 20px;
  text-align: center;
  background-color: #f9f9f9;
  border-radius: 5px;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.post_comment textarea {
  width: 100%;
  padding: 10px;
  border-radius: 5px;
  border: 1px solid #ccc;
  resize: vertical;
  margin-bottom: 10px;
}

.post_comment button {
  padding: 10px 20px;
  border-radius: 5px;
  border: none;
  background-color: #007bff;
  color: #fff;
  cursor: pointer;
}
.l {
  text-align: left; /* Alignez le texte à gauche */
}
h2{
  font-style: italic;
  text-decoration: underline;
  font-family: "Tilt Neon", sans-serif;
  text-align: center;
  margin-bottom: 20px;
}
</style>
