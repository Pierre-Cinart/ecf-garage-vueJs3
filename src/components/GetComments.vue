<template>
  <div>
    <h2>Avis de nos clients</h2>
    <!-- Boucle pour afficher les commentaires -->
    <div v-for="comment in comments" :key="comment.comment_id" class="comment-box">
      <div class="info-box">
        <p class="name">{{ comment.firstname }}</p>
        <p class="date">{{ formatDate(new Date(comment.comment_date)) }}</p>
      </div>
      <div class="text">{{ comment.comment_text }}</div>
    </div>

    <!-- Pagination -->
    <div class="pagination">
      <button @click="previousPage" :disabled="currentPage === 1">Page précédente</button>
      <p>{{ currentPage }}</p>
      <button @click="nextPage" :disabled="comments.length < perPage">Page suivante</button>
    </div>
  </div>
</template>

<script>
import { format, isDate } from 'date-fns';
import fr from 'date-fns/locale/fr';
import axios from 'axios';

export default {
  data() {
    return {
      comments: [],
      currentPage: 1,
      perPage: 5
    };
  },
  created() {
    // Au chargement du composant, récupère les commentaires de la première page.
    this.getComments(this.currentPage);
  },
  methods: {
    // Fonction asynchrone pour récupérer les commentaires.
    async getComments(page) {
      try {
        const offset = (page - 1) * this.perPage;
        // Effectue une requête à l'API pour récupérer les commentaires de la page actuelle.
        const response = await axios.get(`GetComments.php?page=${page}&perPage=${this.perPage}&offset=${offset}`);
        // Met à jour la liste des commentaires avec les données de la réponse.
        this.comments = response.data;
      } catch (error) {
        console.error('Erreur lors de la récupération des commentaires :', error);
      }
    },
    // Fonction pour formater la date en français.
    formatDate(date) {
      if (isDate(date)) {
        return format(date, 'EEEE d MMMM', { locale: fr });
      }
      return 'Date invalide';
    },
    // Fonction pour passer à la page précédente.
    previousPage() {
      if (this.currentPage > 1) {
        this.currentPage--;
        this.getComments(this.currentPage); // Récupère les commentaires de la page précédente.
      }
    },
    // Fonction pour passer à la page suivante.
    nextPage() {
      this.currentPage++;
      this.getComments(this.currentPage); // Récupère les commentaires de la page suivante.
    }
  }
};
</script>

<style scoped>
.comment-box {
  background-color: #eed025;
  border: 1px solid #000;
  border-radius: 5px;
  margin : 15px;
  display: flex;
  padding: 10px;
}

.info-box {
  background-color: #fff;
  width: 25%;
  min-width: 110px;
  padding: 15px;
  border-radius: 5px;
  border: 1px solid #000;
}

.name {
  text-align: left;
  font-weight: bold;
  text-decoration: underline;
}

.date {
  text-align: left;
}

.text {
  flex: 1;
  padding-left: 10px;
}

.pagination button, .pagination p {
  margin: 10px;
  text-align: center;
}
</style>
