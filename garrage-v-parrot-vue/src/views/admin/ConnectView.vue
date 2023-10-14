<template>
  <section class="main">
        <div class="sep"></div>
        <div class="connect-form">
            <legend><h2>Connexion</h2></legend>
            <form method="POST" action="">
                <div class="form-box">
                    <label for="user">Identifiant :</label>
                    <input type="email" name="user" id="user" placeholder="Entrez votre adresse e-mail">
                </div>
                <br>
                <div class="form-box">
                    <label for="pass">Mot de passe :</label>
                    <input type="password" name="pass" id="pass" placeholder="Mot de passe">
                </div>
                <br>
                <div class="btn-sub">
                    <input type="submit" name="connexion" id="connexion" value="Se connecter">
                </div>
                <br>
            </form>
            <a href="./mdp_forget.php" style="width: 100%; text-align:center;">Mot de passe oublié</a>
        </div>
  </section>
</template>

<script>

</script>

<style>

</style>