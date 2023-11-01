<?php
session_start();
$currentPage = 'admin';
if (!$_SESSION["log_in"]||$_SESSION["admin"]=="n"){
    header('Location:logout.php');
    exit();
}
 ?>
<!DOCTYPE html>
<html lang="fr">
<head>
<?php include_once ("./phpComponents/head.php");?>
    <title>Ajout de personnel</title>
</head>
<body>
<?php include_once ("./phpComponents/header.php");?>
   <div class="connect-info">
    <div class = "btn-connect"></div>
    <p>connecté en tant que <?php echo $_SESSION["user"]?></p>
   </div>
   <div class="search-admin">
    <!-- creer une barre de recherche qui permet de rechercher un membre du personnel -->
   </div>
   <div class="show-admins">
    <!-- creer un bouton pour voir l ensemble du personnel  -->
   </div>
   <div class="add-admin">
    <!-- creer un bouton qui redirige vers un formulaire d 'inscription du personnel addAmin.php -->
   </div>
   <?php include_once ("./phpComponents/script.php");?>
</body>
</html>
