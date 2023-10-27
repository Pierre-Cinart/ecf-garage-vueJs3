<template>
    <div>
      <p>{{ article.content }}</p>
    </div>
  </template>
  
  <script>
  import axios from 'axios';
  
  export default {
    data() {
      return {
        article: {} // Initialise l'objet article
      };
    },
    created() {
      // Récupére l'article en utilisant une requête API
      this.getArticle(this.title); // Appelez la fonction pour récupérer l'article
    },
    props: ['title'], // Propriété "title" pour passer le titre de l'article
  
    methods: {
      getArticle(title) {
        // Utilise le titre comme paramètre pour récupérer l'article
        axios.get(`GetArticle.php?title=${title}`)
          .then(response => {
            this.article = response.data; // mise à jour l'objet article avec les données récupérées depuis l'API
          })
          .catch(error => {
            console.error('Erreur lors de la récupération de l\'article :', error);
          });
      }
    }
  };
  </script>
  