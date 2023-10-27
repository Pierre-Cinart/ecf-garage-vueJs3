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
   <?php include_once ("./phpComponents/script.php");?>
</body>
</html>
