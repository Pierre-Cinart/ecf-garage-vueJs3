<template>
  <section class="main">
    <article class="article-center">
      <div>
        <div class="sep"></div>
        <div id="topPage">
          <h1 id ="link-place"> Le garage v-parrot est à votre écoute :</h1>
        </div>
        <br>
        <div class="contact-form">
          <h2 style="margin:auto;text-align:center;">Besoin de plus d'informations ?<br>Contactez-nous :</h2>
          <form @submit.prevent="postMessage" method="post">
            <!-- Champ pour le prénom -->
            <div class="form-box">
              <label>Prénom :</label>
              <input type="text" v-model="newMessage.firstname" placeholder="Prénom" required>
            </div>
            <!-- Champ pour le nom -->
            <div class="form-box">
              <label>Nom :</label>
              <input type="text" v-model="newMessage.lastname" placeholder="Nom" required>
            </div>
            <!-- Champ pour l'e-mail -->
            <div class="form-box">
              <label>Email :</label>
              <input type="email" v-model="newMessage.email" placeholder="E-mail" required>
            </div>
            <div class="form-box">
              <label>Téléphone :</label>
              <input type="txt" v-model="newMessage.telephone" placeholder="Téléphone" >
            </div>
            <!-- Champ pour le sujet -->
            <div class="form-box">
              <label>Sujet :</label>
              <input type="text" v-model="newMessage.subject" placeholder="Sujet du message" required>
            </div>
            <!-- Champ pour le message -->
            <div class="form-box">
              <label>Message :</label>
              <textarea v-model="newMessage.content" rows="8" placeholder="Votre message" required></textarea>
            </div>
            <!-- Ajoutez une div pour le widget reCAPTCHA -->
            <div id="recaptcha"></div>
            <!-- Bouton pour envoyer le message -->
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
        email: '', 
        telephone: '', 
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

      // Valider l'e-mail
      if (!this.validateEmail(this.newMessage.email)) {
        console.error('L\'adresse e-mail n\'est pas valide.');
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
        

        if (recaptchaToken) {
          // Le reCAPTCHA a réussi, envoyez le message à l'API
          const response = await axios.post('PostMessages.php', {
            ...this.newMessage,
            recaptchaToken: recaptchaToken,
          });

          if (response.status === 201) {
            this.newMessage = {
              firstname: '',
              lastname: '',
              email: '',
              subject: '',
              content: '',
            };
          } else {
            console.error('Erreur lors de la création du message.');
          }
        } else {
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
    validateEmail(email) {
      // Valider l'adresse e-mail avec une expression régulière
      const emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
      return emailRegex.test(email);
    },
    validateTelephone(telephone) {
      // Valider le numéro de téléphone avec une expression régulière
      const telRegex = /^[0-9]+$/; // Autorise un ou plusieurs chiffres
      return telRegex.test(telephone);
    },
    validateMessageLength(message) {
      return message.length >= 16;
    },
    validateSubjectLength(subject) {
      return subject.length >= 5 && subject.length <= 100;
    },
  },
};
</script>

<style scoped>
/* Votre CSS personnalisé */
</style>
