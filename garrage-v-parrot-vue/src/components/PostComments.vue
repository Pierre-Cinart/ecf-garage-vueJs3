<template>
    <div class="post_comment">
      <h2>Votre avis nous intéresse<br>Laissez-nous un commentaire :</h2>
      <form @submit="postComment" method="post">
        <div class="l">
          <input type="text" v-model="newComment.prenom" placeholder="Prénom">
          <br><br>
          <input type="text" v-model="newComment.nom" placeholder="Nom">
          <br><br>
        </div>
        <textarea v-model="newComment.text" rows="5" placeholder="Votre commentaire"></textarea>
        <button type="submit">Poster le commentaire</button>
      </form>
    </div>
  </template>
  
  <script>
  export default {
    data() {
      return {
        newComment: {
          prenom: '',
          nom: '',
          text: '',
        },
      };
    },
    methods: {
      postComment(event) {
        event.preventDefault();
        // Envoyer le nouveau commentaire à votre API (à implémenter)
        // Réinitialiser le champ du nouveau commentaire
        this.newComment = {
          prenom: '',
          nom: '',
          text: '',
        };
        // Mettre à jour la liste des commentaires (si nécessaire)
        // this.$emit('commentPosted'); // Émet un événement personnalisé pour informer le composant parent
      },
    },
  };
  </script>
  
  <style scoped>
  /* Styles spécifiques au composant PostComment.vue */
  .post_comment {
    max-width: 600px;
    margin: 0 auto;
    padding: 20px;
    text-align: center;
    background-color: #f9f9f9;
    border-radius: 5px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
  }
  
  .post_comment textarea {
    width: 100%;
    padding: 10px;
    border-radius: 5px;
    border: 1px solid #ccc;
    resize: vertical;
    margin-bottom: 10px;
  }
  
  .post_comment button {
    padding: 10px 20px;
    border-radius: 5px;
    border: none;
    background-color: #007bff;
    color: #fff;
    cursor: pointer;
  }
  .l {
    text-align: left;
  }
  </style>