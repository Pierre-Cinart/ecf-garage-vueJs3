<?php
session_start();
$currentPage = 'addAdmin';
if (!$_SESSION["log_in"]||$_SESSION["admin"]=="n"){
    header('Location:index.php');
    exit();
}
//verifier si les données post existent les traiter et renvoyer un message d 'info
//renvoyer vers admin.php si succés , ou signaler l ' erreur
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
   <div class="admin-form">
    <!-- redirige vers un formulaire d 'inscription du personnel addAmin.php -->

   </div>
   <?php include_once ("./phpComponents/script.php");?>
</body>
</html>
