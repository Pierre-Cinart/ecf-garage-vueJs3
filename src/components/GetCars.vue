<template>
  <div>
    
    <!-- Barre de recherche et tri -->
    <div class="search-and-sort">
      <input type="text" v-model="searchTerm" placeholder="Rechercher...">
      <select v-model="sortOption">
        <option value="">-- Options de tri --</option>
        <option value="prix-croissant">Prix croissant</option>
        <option value="prix-decroissant">Prix décroissant</option>
        <option value="marque">Marque</option>
        <option value="modele">Modèle</option>
      </select>
      <button @click="searchAndSort">Rechercher</button>
    </div>

    <!-- Liste des véhicules -->
    <div class="gallery">
      <div v-for="vehicle in vehicles" :key="vehicle.car_id" class="card">
        <div class="card-txt">
          <h3>{{ vehicle.car_mark }} {{ vehicle.car_model }}</h3>
          <p><b>Kilométrage :</b> {{ vehicle.car_km }} km</p>
          <p><b>Couleur :</b> {{ vehicle.car_color }}</p>
          <p><b>Prix :</b> {{ vehicle.car_price }} €</p>
        </div>
        <div class="card-img">
          <!-- Construire le chemin complet de l'image -->
          <img class = "card-img" :src="'http://localhost/garage-v-parrot-vue/backend/img/' + vehicle.car_mark + '/' + vehicle.car_picture" :alt="vehicle.car_mark + '/' + vehicle.car_picture">

          <p>{{ vehicle.car_info }}</p>
        </div>
      </div>
    </div>

    <!-- Pagination -->
    <div class="pagination">
      <button @click="previousPage" :disabled="currentPage === 1">Page précédente</button>
      <p>{{ currentPage }}</p>
      <button @click="nextPage" :disabled="vehicles.length < perPage">Page suivante</button>
    </div>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      vehicles: [],
      currentPage: 1,
      perPage: 10,
      searchTerm: '',
      sortOption: '',
    };
  },
  created() {
    this.searchAndSort();
  },
  methods: {
    
    async searchAndSort() {
      try {
        const offset = (this.currentPage - 1) * this.perPage;
        const response = await axios.get(`GetCars.php?page=${this.currentPage}&perPage=${this.perPage}&offset=${offset}&search=${this.searchTerm}&sort_select=${this.sortOption}`);
        this.vehicles = response.data;
      } catch (error) {
        console.error('Erreur lors de la récupération des véhicules :', error);
      }
    },
    previousPage() {
      if (this.currentPage > 1) {
        this.currentPage--;
        this.searchAndSort();
      }
    },
    nextPage() {
      this.currentPage++;
      this.searchAndSort();
    },
    // Fonction pour construire le chemin complet de l'image
    getVehicleImageSrc(vehicle) {
      console.log();
      return `@/assets/images/ventes/${vehicle.car_mark}/${vehicle.car_picture}`;
      
    },
  },
};
</script>
