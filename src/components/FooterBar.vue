<template>
    <footer>
    <div class="row m0"  style="padding:20px;">
            <div class="col-3">
                <p>ECF , création d' un  site web pour un  garage fictif,
                " réalisé dans le cadre de ma formation de développeur web et d'application web chez Studi  
                pour la section décembre 2023. </p> 
            </div>
            <div class="col-3">
                <p class = "_footer-contact">
                    Garage V-Parrot , <span>Entretiens , réparations et ventes automobiles </span> 
                    <br>
                    Adresse : 21 Rue des Belles Voitures, 31000 Toulouse, France
                    <br>
                    Téléphone : +33 5 55 55 55 55
                    <br>
                    Email : contact@V-Parrot.com 
                    </p>
            </div>
            <div class="col-6 text-center" >
                <div class="box-logos "> 
                    <a href="https://fr-fr.facebook.com/" target="_blank">
                        <img src="../assets/images/logos/logo_facebook.png" alt="logo_facebook">
                    </a>
                    <a href="https://www.instagram.com/" target="_blank">
                        <img src="../assets/images/logos/logo_insta.png" alt="logo_insta">
                    </a>
                    <a href="https://twitter.com/accueil?lang=fr" target="_blank">
                        <img src="../assets/images/logos/logo_twitter.png" alt="logo_twitter">
                    </a>
                </div>
            </div>
                <p class="text-center p0 m0">cinartDev &copy; tout droits réservés</p>
        </div>
      

         
       
</footer>
</template>

<script>
export default {
  name: 'FooterBar'
 
}
</script>

<style scoped>
  footer {
  margin-bottom: -30px;
  background-color: black;
  color: white;
  width: 100%;
  height: auto;
  font-size: 12px;
  font-weight: bolder;
}

.box-logos {
  width: 70%;
  margin-left: 130px;
}
.box-logos img {
  margin: 15px;
  width: 100px;
}
@media screen and (max-width: 820px) {
  footer {
    font-size: 12px;
    font-weight: 400;
  }
  .box-logos {
    margin-top: 45px;
    margin-left: 60px;
  }
  .box-logos img {
    margin: 5px;
    width: 75px;
  }

}
@media screen and (max-width: 400px) {
  footer {
    font-size: 10px;
    font-weight: 200;
  }
  .box-logos {
    margin-top: 60px;
    margin-left: 40px;
  }
  .box-logos img {
    margin: 5px;
    width: 50px;
  }

}
</style>