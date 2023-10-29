<?php
session_start();
$currentPage = 'adminArticles';
if (!$_SESSION["log_in"]){
    header('Location:index.php');
    exit();
}
 ?>
<!DOCTYPE html>
<html lang="fr">
    <head>
    <?php include_once ("./phpComponents/head.php");?>
        <title>Gestion des articles</title>
    </head>
<body>  
    <?php include_once ("./phpComponents/header.php");?>
    <div class="connect-info">
        <div class = "btn-connect"></div>
        <p>connecté en tant que <?php echo $_SESSION["user"]?></p>
    </div>
    <div class="dashboard-info">
        <h2>Quel article souhaitez vous gérer ?</h2>
        <!-- afficher un bouton pour chaque catégorie type submit post  -->
        <p><a href="./adminArticles.php?article=a-propos">A-propos</a></p>
        <p><a href="./adminArticles.php?article=carrosserie">Carrosserie</a></p>
        <p><a href="./adminArticles.php?article=mecanique">Mécanique</a></p>
        <p><a href="./adminArticles.php?article=entretien">Entretiens</a></p>
    </div>
    <div id="show-article">
    <!-- gérer l affichage de l article concerné dans un text-area pour pouvoir le modifier -->
    <!-- ajouter un bouton submit et creer une fonction javascript et requete fetch async pour mettre à jour l article-->
    </div>
   
   <?php include_once ("./phpComponents/script.php");?>
</body>
</html>
