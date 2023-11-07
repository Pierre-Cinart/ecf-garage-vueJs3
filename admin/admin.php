<?php
session_start();
$currentPage = 'admin';
if (!$_SESSION["log_in"] || $_SESSION["admin"] != "y") {
    header('Location: logout.php');
    exit();
}


?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <?php include_once("./phpComponents/head.php"); ?>
    <title>Gestion du personnel</title>
</head>
<body>
    <?php include_once("./phpComponents/header.php"); ?>
    <?php include_once('./phpComponents/infos.php'); ?>

    <div class="search-admin">
        <!-- Créez une barre de recherche pour les administrateurs si nécessaire -->
        <!-- Créez une fonction de tri par date des logs si nécessaire -->
    </div>
    <div class="dashboard-info">
        <p><a href="./admin.php?show=admins"><?php echo "Afficher les administrateurs" ?></a></p>
        <p><a href="./admin.php?show=logs"><?php echo "Afficher les logs" ?></a></p>
        <p><a href="./addAdmin.php"><?php echo "Ajouter un administrateur" ?></a></p>
    </div>
    <div id="show-list">
    <?php
    if (isset($_GET['show'])){
        $show = $_GET['show'];
    } else {
        $show = "";
    }
        if ($show === "admins") {
            include_once ('./phpFunctions/showAdmins.php');
            
            
        } elseif ($show === "logs") {
            include_once ('./phpFunctions/showLogs.php');            
        }
    ?>
    <?php include_once("./phpComponents/script.php"); ?>
</body>
</html>
