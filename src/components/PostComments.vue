<template>
  <div class="post_comment">
    <h2>Votre avis nous intéresse<br>Laissez-nous un commentaire :</h2>
    <form @submit.prevent="postComment">
      <div class="l">
        <input type="text" v-model="newComment.firstname" placeholder="Prénom" required>
        <br><br>
        <input type="text" v-model="newComment.lastname" placeholder="Nom" required>
        <br><br>
      </div>
      <textarea v-model="newComment.content" rows="5" placeholder="Votre commentaire" required></textarea>
      <button type="submit">Poster le commentaire</button>
    </form>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      newComment: {
        firstname: '',
        lastname: '',
        content: '',
      },
    };
  },
  methods: {
    async postComment() {
      try {
        // Envoi de la requête POST au serveur
        const response = await axios.post('PostComments.php', this.newComment);
        
        // Si la réponse est un succès (code 201), effectuez une action ici
        if (response.status === 201) {
          // Réinitialisation du formulaire
          this.newComment = {
            firstname: '',
            lastname: '',
            content: '',
          };
        } else {
          // Sinon, affichez un message d'erreur ici
        }
      } catch (error) {
        // En cas d'erreur, affichez un message d'erreur ici et affichez l'erreur dans la console
        console.error(error);
      }
    },
  },
};
</script>

<style scoped>
/* Styles spécifiques au composant PostComment.vue */
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
  text-align: left;
}
</style>
