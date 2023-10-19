<template>
    <!-- Main section -->
    <section class="main">
        <article class="article-center">
            <div>
                <div class="sep"></div>
                <div id="topPage">
                    <h2  style="margin:auto;text-align:center;">Besoin de plus d'informations ?<br>Contactez-nous :</h2>
                </div>
                <br>
               
                <!-- Formulaire de contact -->
                <div class="contact-form">
                 
                    <form method="POST" action="">
                        <div class="form-box">
                            <label for="firstname">Prénom :</label>
                            <input type="text" name="firstname" id="firstname" placeholder="Prénom">
                        </div>
                        <br>
                        <div class="form-box">
                            <label for="name">Nom :</label>
                            <input type="text" name="name" id="name" placeholder="Nom">
                        </div>
                        <br>
                        <div class="form-box">
                            <label for="subject">Sujet du message :</label>
                            <input type="text" name="subject" id="subject" placeholder="Sujet du message">
                        </div>
                        <br>
                        <div class="form-box">
                            <label for="message">Message :</label>
                            <textarea id="message" name="message" rows="8" cols="40"></textarea>
                        </div>
                        <br>
                        <div class="btn-sub">
                            <input type="submit" name="submit-form" id="submit-form" value="Envoyer">
                        </div>
                    </form>
                    
                </div>
                <br>
                <div class="sep"></div>
                <!-- Informations de contact -->
                <p>
                    Garage V-Parrot, Entretiens, réparations et ventes automobiles <br>
                    Adresse : 123 rue des belles voitures, 75000 Paris, France <br>
                    Téléphone : +33 1 23 45 67 89 <br>
                    Email : contact@V-Parrot.com <br>
                </p>
            </div>
        </article>
    </section>
    


</template>

<script>
export default {
  name: 'ContactView',
  components: {
   
  }
}
</script>

<style>

</style>