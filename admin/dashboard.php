<?php
session_start();
$currentPage = 'dashboard';
if (!$_SESSION["log_in"]){
    header('Location:index.php');
    exit();
}

// Inclure le fichier de connexion à la base de données
require_once('../backend/bdd.php');
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <?php include_once ("./phpComponents/head.php");?>
    <title>Dashboard</title>
</head>
<body>
    <?php include_once ("./phpComponents/header.php");?>
    <div class="connect-info">
        <div class="btn-connect"></div>
        <p>Connecté en tant que <?php echo $_SESSION["user"] ?></p>
    </div>
    <div class="dashboard-info">
        <?php
            // Requête SQL pour compter les commentaires en attente de traitement
            $queryComments = "SELECT COUNT(*) FROM comments WHERE comment_status = 'wait'";
            $resultComments = mysqli_query($bdd, $queryComments);
            $commentsCount = mysqli_fetch_array($resultComments)[0];

            // Requête SQL pour compter les messages en attente de traitement
            $queryMessages = "SELECT COUNT(*) FROM messages WHERE message_status = 'wait'";
            $resultMessages = mysqli_query($bdd, $queryMessages);
            $messagesCount = mysqli_fetch_array($resultMessages)[0];
        ?>
        <p><a href="./adminComments.php"><?php echo "Commentaires à traiter : " . $commentsCount; ?></a></p>
        <p><a href="./adminMessages.php"><?php echo "Messages à traiter : " . $messagesCount; ?></a></p>
        <p><a href="./adminCars.php"><?php echo "Gérer les véhicules" ?></a></p>
        <p><a href="./adminArticles.php"><?php echo "Modifier les articles" ?></a></p>
    </div>
    <?php include_once ("./phpComponents/script.php");?>
</body>
</html>
