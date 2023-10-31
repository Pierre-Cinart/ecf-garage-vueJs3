<?php
session_start();
$currentPage = 'adminCars';
if (!$_SESSION["log_in"]){
    header('Location:logout.php');
    exit();
}
 ?>
<!DOCTYPE html>
<html lang="fr">
<head>
<?php include_once ("./phpComponents/head.php");?>
    <title>Gestion des véhicules</title>
</head>
<body>
<?php include_once ("./phpComponents/header.php");?>
   <div class="connect-info">
    <div class = "btn-connect"></div>
    <p>connecté en tant que <?php echo $_SESSION["user"]?></p>
   </div>
   <?php include_once ("./phpComponents/script.php");?>
</body>
</html>
