<template>
  <section class="main">
    <article class="article-center">
      <div>
        <div class="sep"></div>
        <div id="topPage">
          <h2 style="margin:auto;text-align:center;">Besoin de plus d'informations ?<br>Contactez-nous :</h2>
        </div>
        <br>
        <div class="contact-form">
          <h2>Votre avis nous intéresse<br>Laissez-nous un message :</h2>
          <form @submit.prevent="postMessage" method="post">
            <div class="form-box">
              <label>Prénom :</label>
              <input type="text" v-model="newMessage.firstname" placeholder="Prénom" required>
            </div>
            <div class ="form-box">
              <label>Nom :</label>
              <input type="text" v-model="newMessage.lastname" placeholder="Nom" required>
            </div>
            <div class="form-box">
              <label>Sujet :</label>
              <input type="text" v-model="newMessage.subject" placeholder="Sujet du message" required>
            </div>
            <div class="form-box">
              <label>Message :</label>
              <textarea v-model="newMessage.content" rows="8" placeholder="Votre message" required></textarea>
            </div>
            <!-- Ajoutez une div pour le widget reCAPTCHA -->
            <div id="recaptcha"></div>
            <button class="btn-sub" type="submit">Envoyer</button>
          </form>
        </div>
      </div>
    </article>
  </section>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      newMessage: {
        firstname: '',
        lastname: '',
        subject: '',
        content: '',
      },
    };
  },
  methods: {
    async postMessage(event) {
      event.preventDefault();

      // Valider les noms et prénoms
      if (!this.validateName(this.newMessage.firstname) || !this.validateName(this.newMessage.lastname)) {
        console.error('Le prénom et le nom doivent contenir entre 2 et 25 lettres.');
        return;
      }

      // Valider la longueur du message
      if (!this.validateMessageLength(this.newMessage.content)) {
        console.error('Le message doit contenir au moins 16 caractères.');
        return;
      }

      // Valider la longueur du sujet
      if (!this.validateSubjectLength(this.newMessage.subject)) {
        console.error('Le sujet du message doit contenir entre 5 et 100 caractères.');
        return;
      }

      try {
        // Exécutez reCAPTCHA avant d'envoyer le message
        const recaptchaToken = await this.$recaptcha('contact');

// Ajoutez cette ligne pour afficher le jeton reCAPTCHA dans la console
console.log('reCAPTCHA Token:', recaptchaToken);

        if (recaptchaToken) {
          // Le reCAPTCHA a réussi, envoyez le message à l'API
          const response = await axios.post('PostMessages.php', {
            ...this.newMessage,
            recaptchaToken: recaptchaToken, // Ajoutez le jeton reCAPTCHA à la demande
          });

          if (response.status === 201) {
            this.newMessage = {
              firstname: '',
              lastname: '',
              subject: '',
              content: '',
            };
          } else {
            console.error('Erreur lors de la création du message.');
          }
        } else {
          // En cas d'échec du reCAPTCHA, affichez un message d'erreur
          console.error('Veuillez cocher la case "Je ne suis pas un robot".');
        }
      } catch (error) {
        console.error("Une erreur s'est produite lors de la création du message.", error);
      }
    },
    validateName(name) {
      // Valider le prénom ou le nom (entre 2 et 25 lettres)
      const regex = /^[\p{L}\s]{2,25}$/u;
      return regex.test(name);
    },
    validateMessageLength(message) {
      // Valider la longueur du message (au moins 16 caractères)
      return message.length >= 16;
    },
    validateSubjectLength(subject) {
      // Valider la longueur du sujet (entre 5 et 100 caractères)
      return subject.length >= 5 && subject.length <= 100;
    },
  },
};
</script>

<style scoped>
/* Votre CSS personnalisé */
</style>
