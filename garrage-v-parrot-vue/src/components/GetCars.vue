<template>
    <div>
      <h2>vehicules</h2>
      <div v-for="car in cars" :key="car.id" class="txt-box" style="margin-bottom: 10px;">
        <div style="background-color: white; width: 25%; min-width: 110px; padding: 15px; border-radius: 5px; border: 1px solid black;">
          <p>Nom de la voiture : {{ car.car_model }}</p>
          <p>info  : {{ car.car_info }}</p>
          <!-- Ajoutez d'autres données de voiture que vous souhaitez afficher -->
        </div>
      </div>
    </div>
  </template>
  
  <script>
  export default {
    data() {
      return {
        cars: [],
      };
    },
    created() {
      // Effectuez une requête pour récupérer les données des voitures depuis votre API
      this.getCars();
    },
    methods: {
      getCars() {
        fetch('http://localhost/ECF2023/ECF-GARAGE-V-PARROT/garrage-v-parrot-vue/backend/GetCars.php')
          .then((response) => response.json())
          .then((data) => {
            this.cars = data;
          })
          .catch((error) => {
            console.error('Erreur lors de la récupération des données des voitures :', error);
          });
      },
    },
  };
  </script>
  
  <style scoped>
  /* Ajoutez vos styles CSS ici, s'ils sont spécifiques à ce composant */
  </style>
  