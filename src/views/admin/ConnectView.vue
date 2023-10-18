<template>
  <div>
    <h2>Connexion</h2>
    <form @submit="login" class="login-form">
      <div class="input-group">
        <label for="email">Email :</label>
        <input type="email" id="email" v-model="email" required />
      </div>
      <div class="input-group">
        <label for="password">Mot de passe :</label>
        <input type="password" id="password" v-model="password" required />
      </div>
      <button type="submit" class="submit-button">Se connecter</button>
    </form>
    <p v-if="error" class="error">{{ error }}</p>
  </div>
</template>

<script>
import axios from 'axios'; // Importez Axios ici

export default {
  data() {
    return {
      email: '',
      password: '',
      error: '',
    };
  },
  methods: {
    async login(event) {
      event.preventDefault();
      this.error = '';

      try {
        // Envoie de la demande d'authentification à l'API
        const response = await axios.post('AdminConnect.php', {
          email: this.email,
          password: this.password,
        });

        if (response.data.success) {
          // Authentification réussie, redirigez vers le tableau de bord (admin/dashboard)
          this.$router.push('/admin/dashboard');
        } else {
          // Affichez le message d'erreur de l'API
          this.error = response.data.error;
        }
      } catch (error) {
        console.error(error);
        this.error = 'Une erreur s\'est produite lors de l\'authentification.';
      } 

    },
  },
};
</script>

<style scoped>
/* Votre CSS personnalisé */
.login-form {
  background-color: #eed025;
  border: 1px solid #000;
  border-radius: 5px;
  padding: 20px;
}

.input-group {
  margin: 10px 0;
  display: flex;
  justify-content: space-between;
}

label {
  flex: 1;
  text-align: left;
}

input {
  flex: 3;
  width: 100%;
}

.submit-button {
  background-color: #4CAF50;
  color: white;
  border: none;
  border-radius: 5px;
  padding: 10px 20px;
  cursor: pointer;
}

.error {
  color: red;
  margin-top: 10px;
}
</style>
