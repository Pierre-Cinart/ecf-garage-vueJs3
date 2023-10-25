<template>
  <div>
    <h2>Connexion Admin</h2>
    <p v-if="error" class="error">{{ error }}</p>
    <form @submit.prevent="login">
      <label for="email">E-mail :</label>
      <input type="email" id="email" v-model="email" required /><br /><br>
      <label for="password">Mot de passe :</label>
      <input type="password" id="password" v-model="password" required /><br /><br>
      <button type="submit">Se connecter</button>
    </form>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      email: '',
      password: '',
      error: '',
    };
  },
  methods: {
    async login() {
      try {
        const response = await axios.post('AdminConnect.php', {
          email: this.email,
          password: this.password,
        });

        if (response.data.success) {
          // Authentification réussie, redirigez vers le tableau de bord de l'admin
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
.error {
  color: red;
}
</style>
