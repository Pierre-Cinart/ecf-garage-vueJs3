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
      <!-- Ajout d une div pour le widget reCAPTCHA -->
      <div id="recaptchaComment"></div> <!-- Utiliser un identifiant unique, par exemple, "recaptchaComment" -->
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
    async postComment(event) {
      event.preventDefault();
      // Valider les noms et prénoms
      if (!this.validateName(this.newComment.firstname) || !this.validateName(this.newComment.lastname)) {
        console.error('Le prénom et le nom doivent contenir entre 2 et 25 lettres.');
        return;
      }
      // Valider la longueur du message
      if (!this.validateMessageLength(this.newComment.content)) {
        console.error('Le commentaire doit contenir au moins 16 caractères.');
        return;
      }
      try {
        // Exécution reCAPTCHA avant d'envoyer le commentaire
        const recaptchaToken = await this.$recaptcha('comment'); // Utilisez le bon nom de l'action, par exemple, 'comment'

        if (recaptchaToken) {
          // Le reCAPTCHA a réussi, envoyez le commentaire à l'API
          const response = await axios.post('PostComments.php', {
            ...this.newComment,
            recaptchaToken: recaptchaToken,
          });

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
            console.error('Erreur lors de la création du commentaire.');
          }
        } else {
          console.error('Veuillez cocher la case "Je ne suis pas un robot".');
        }
      } catch (error) {
        // En cas d'erreur, affiche un message d'erreur dans la console
        console.error("Une erreur s'est produite lors de la création du commentaire.", error);
      }
    },
    validateName(name) {
      // Valider le prénom ou le nom (entre 2 et 25 lettres)
      const regex = /^[\p{L}\s]{2,25}$/u;
      return regex.test(name);
    },
    validateMessageLength(content) {
      return content.length >= 16;
    }
  },
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
  text-align: left;
}
</style>
