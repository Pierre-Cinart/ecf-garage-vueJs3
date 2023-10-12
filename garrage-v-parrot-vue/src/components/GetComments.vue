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
    <div class="post_comment">
      <form @submit="postComment" method="post">
        <textarea v-model="newComment" rows="5" placeholder="Votre commentaire"></textarea>
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
      // Envoyer le nouveau commentaire à votre API (à implémenter)
      // Réinitialiser le champ du nouveau commentaire
      this.newComment = '';
      // Mettre à jour la liste des commentaires
      this.getComments();
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
/* Ajoutez vos styles CSS ici, s'ils sont spécifiques à ce composant */
</style>
