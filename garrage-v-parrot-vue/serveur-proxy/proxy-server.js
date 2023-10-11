const express = require('express');
const axios = require('axios');

const app = express();
const port = 3000; // Choisissez un port disponible

app.use(express.json());

// Définissez une route pour votre application Vue.js
app.get('/api/comments', async (req, res) => {
  try {
    // Faites une requête vers le serveur distant
    const response = await axios.get('http://localhost/ECF2023/ECF-GARAGE-V-PARROT/garrage-v-parrot-vue/backend/GetComments.php');

    // Renvoyez la réponse au client (votre application Vue.js)
    res.send(response.data);
  } catch (error) {
    console.error(error);
    res.status(500).send('Erreur lors de la récupération des données.');
  }
});

app.listen(port, () => {
  console.log(`Serveur proxy en cours d'exécution sur le port ${port}`);
});
