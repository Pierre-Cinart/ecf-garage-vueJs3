<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
// Connexion à la base de données
require_once("../backend/bdd.php");

// Inclusion des fonctions de code aléatoire et de formatage du pseudo

$erreurInscription = '';

// Validation du formulaire
if (isset($_POST['inscription'])) {
    if (!empty($_POST['new-user']) && !empty($_POST['new-user-2']) && !empty($_POST['firstname']) && !empty($_POST['lastname'])) {
        // import de la fonction de creation de token
        require_once ('./phpFunctions/createToken.php');
        // Vérification des adresses e-mail identiques
       
    } else {
        $erreurInscription = 'Tous les champs doivent être remplis';
    }
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <?php include_once('./phpComponents/head.php'); ?>
    <title>Inscription</title>
</head>

<body>
    <?php include_once('./phpComponents/header.php'); ?>

    <div class="text-sub">
        <div class="sep"></div>
    </div>

    <?php
    if (isset($erreurInscription) && !empty($erreurInscription)) {
        echo '<p class="error-mess">' . $erreurInscription . '</p>';
    }
    ?>

    <div class="sep"></div>

    <div class="connect-form">
        <h2>Inscription</h2>
        <form method="POST" action="addAdmin.php">
            <div class="form-box">
                <label for="firstname">Prénom :</label>
                <input type="text" name="firstname" id="firstname" placeholder="Entrez votre prénom">
            </div>
            <br>
            <div class="form-box">
                <label for="lastname">Nom :</label>
                <input type="text" name="lastname" id="lastname" placeholder="Entrez votre nom">
            </div>
            <br>
            <div class="form-box">
                <label for="new-user">E-mail :</label>
                <input type="email" name="new-user" id="new-user" placeholder="Entrez votre adresse e-mail">
            </div>
            <br>
            <div class="form-box">
                <label for="new-user-2">Confirmez l'e-mail :</label>
                <input type="email" name="new-user-2" id="new-user-2" placeholder="Entrez votre adresse e-mail">
            </div>
            <br>
          
           
            <br>
            <div class="btn-sub">
                <input type="submit" name="inscription" id="inscription" value="Créer un compte" onclick="return validateForm()">
            </div>
            <br>
        </form>
    </div>

    <div class="sep"></div>

    <?php include_once('./phpComponents/script.php'); ?>

    
</body>

</html>
