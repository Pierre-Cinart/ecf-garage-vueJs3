<template>
    <div>
      <h2>Connexion</h2>
      <form @submit.prevent="login">
        <div class="form-group">
          <label for="username">Nom d'utilisateur :</label>
          <input type="text" id="username" v-model="username" required>
        </div>
        <div class="form-group">
          <label for="password">Mot de passe :</label>
          <input type="password" id="password" v-model="password" required>
        </div>
        <button type="submit">Se connecter</button>
      </form>
    </div>
  </template>
  
  <script>
  export default {
    data() {
      return {
        username: '',
        password: '',
      };
    },
    methods: {
      login() {
        // Validation côté client (vérifiez que les champs ne sont pas vides)
        if (!this.username || !this.password) {
          alert('Veuillez remplir tous les champs.');
          return;
        }
        
        // Envoiez les données d'authentification au serveur (API) pour validation
        fetch('http://localhost/ECF2023/ECF-GARAGE-V-PARROT/garrage-v-parrot-vue/backend/AdminConnect.php', {
          method: 'POST',
          body: JSON.stringify({
            username: this.username,
            password: this.password,
          }),
          headers: {
            'Content-Type': 'application/json',
          },
        })
        .then(response => response.json())
        .then(data => {
          if (data.success) {
            // L'authentification a réussi, vous pouvez rediriger l'utilisateur
            this.$router.push('/dashboard');
          } else {
            alert('Identifiant ou mot de passe incorrect');
          }
        })
        .catch(error => {
          console.error('Erreur de connexion :', error);
          alert('Erreur de connexion. Veuillez réessayer plus tard.');
        });
      },
    },
  };
  </script>
  