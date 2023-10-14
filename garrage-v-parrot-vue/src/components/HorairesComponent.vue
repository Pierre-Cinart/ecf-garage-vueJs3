<template>
<!-- Horaires -->
      <section class="horaire">
        <h2>Horaires</h2>
        <p style="text-align: left">
          <span>Lundi :</span> 8h00 - 17h00 <br>
          <span>Mardi :</span> 8h00 - 17h00 <br>
          <span>Mercredi :</span> 8h00 - 17h00 <br>
          <span>Jeudi :</span> 8h00 - 17h00 <br>
          <span>Vendredi :</span> 8h00 - 17h00 <br>
          <span>Samedi :</span> 9h00 - 12h00 (matin seulement) <br>
          <span>Dimanche :</span> Fermé
        </p>
      </section>
    
 
</template>

<script>
// @ est un alias vers /src


export default {
  name: 'HorairesComponent',
  components: {
   
  }
}
</script>

<style scoped>
.horaire {
  width: 25%;
  min-width: 210px;
  margin: auto;
  margin-bottom: 20px;
}
.horaire h2 {
  text-align: center;
}
.horaire p {
  padding-left: 20%;
}
.horaire span {
  font-weight: 700;
}</style>
