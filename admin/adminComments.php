<?php
session_start();
$currentPage = 'adminComments';
if (!$_SESSION["log_in"]){
    header('Location:index.php');
    exit();
}
 ?>
<!DOCTYPE html>
<html lang="fr">
<head>
<?php include_once ("./phpComponents/head.php");?>
    <title>Document</title>
</head>
<body>
<?php include_once ("./phpComponents/header.php");?>
   <div class="connect-info">
    <div class = "btn-connect"></div>
    <p>connecté en tant que <?php echo $_SESSION["user"]?></p>
   </div>
   <div class="dashboard-info">
    <!-- afficher un bouton commentaires validés et un bouton commentaires à valider type submit post  -->
    <!-- gérer l affichage avec pagination lors du clique + flèche de retour en haut et bas de div -->
   </div>
   <div id="show-list">
    <!-- gérer l affichage avec pagination lors du clique + flèche de retour en haut et bas de div -->
    <!-- cf partie front pour pagination et affichage creer une fonction javascript et requete fetch async -->
   </div>
   <?php include_once ("./phpComponents/script.php");?>
</body>
</html>
