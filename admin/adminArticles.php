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
    <title>Gestion des véhicules</title>
</head>
<div class="dashboard-info">
    <!-- afficher un bouton pour chaque catégorie type submit post  -->
    <!-- gérer l affichage avec pagination lors du clique + flèche de retour en haut et bas de div -->
   </div>
   <div id="show-article">
    <!-- gérer l affichage de l article concerné dans un text-area pour pouvoir le modifier -->
    <!-- ajouter un bouton submit et creer une fonction javascript et requete fetch async pour mettre à jour l article-->
   </div>
<body>
<?php include_once ("./phpComponents/header.php");?>
   <div class="connect-info">
    <div class = "btn-connect"></div>
    <p>connecté en tant que <?php echo $_SESSION["user"]?></p>
   </div>
   <?php include_once ("./phpComponents/script.php");?>
</body>
</html>
