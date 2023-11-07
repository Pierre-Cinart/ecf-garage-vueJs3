<?php
session_start();
$currentPage = 'admin';
if (!$_SESSION["log_in"]||$_SESSION["admin"]!="y"){
    header('Location:logout.php');
    exit();
}
// if (sever method === GET) {
//  if (isset($_GET["show"])) {
    // if ( $_GET["show"] === admin ) { afficher la liste les adminstateurs}
    // if ( $_GET["show"] === logs ) { afficher la liste les logs}
// }
// };
 ?>
<!DOCTYPE html>
<html lang="fr">
<head>
<?php include_once ("./phpComponents/head.php");?>
    <title>Gestion du personnel</title>
</head>
<body>
<?php 
    include_once("./phpComponents/header.php"); 
    include_once('./phpComponents/infos.php');
?>
  
   
   <div class="search-admin">
    <!-- creer une barre de recherche qui permet de rechercher un membre du personnel -->
   </div>
   <div class="dashboard-info">
        <!-- Afficher un bouton Commentaires à traiter et un bouton Commentaires validés -->
        <p><a href="./admin.?show=admins"><?php echo "Afficher les administrateurs : " ?></a></p>
        <p><a href="./admin.php?shows=logs"><?php echo "Afficher les logs  " ?></a></p>
        <p><a href="./addAdmin.php"><?php echo "Ajouter un administrateur "  ?></a></p>
        <!-- Gérer l'affichage avec pagination lors du clic + flèches de retour en haut et en bas de la div -->
    </div>
    <div id="show-list">
  
   </div>
   <?php include_once ("./phpComponents/script.php");?>
</body>
</html>
