<template>
  <div>
    <h2>Avis de nos clients</h2>
    <div v-for="comment in comments" :key="comment.comment_id" class="txt-box" style="margin-bottom: 10px;">
      <div style="background-color: white; width: 25%; min-width: 110px; padding: 15px; border-radius: 5px; border: 1px solid black;">
        <p style="text-align: left; font-weight: bold; text-decoration: underline;">{{ comment.firstname }} {{ comment.name }}</p>
        <p style="text-align: left;">{{ formatDate(new Date(comment.comment_date)) }} :</p>
      </div>
      <div>
        <p>{{ comment.comment_text }}</p>
      </div>
    </div>
  </div>
</template>

<script>
import { format, isDate } from 'date-fns';
import fr from 'date-fns/locale/fr';

export default {
  data() {
    return {
      comments: [],
    };
  },
  created() {
    this.getComments();
  },
  methods: {
    getComments() {
      fetch('http://localhost/ECF2023/ECF-GARAGE-V-PARROT/garrage-v-parrot-vue/backend/GetComments.php')
        .then(response => response.json())
        .then(data => {
          this.comments = data;
        })
        .catch(error => {
          console.error('Erreur lors de la récupération des commentaires :', error);
        });
    },
    formatDate(date) {
      if (isDate(date)) {
        return format(date, 'EEEE d MMMM', { locale: fr });
      }
      return 'Date invalide';
    },
  }
};
</script>




<style scoped>
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
h2 {
  font-style: italic;
  text-decoration: underline;
  font-family: "Tilt Neon", sans-serif;
  text-align: center;
  margin-bottom: 20px;
}
</style>
