<?php
session_start();
$currentPage = 'adminComments';

if (!$_SESSION["log_in"]) {
    header('Location: index.php');
    exit();
}

// Inclure le fichier de connexion à la base de données
require_once('../backend/bdd.php');

// Requête SQL pour compter les commentaires en attente de traitement et les commentaires validés
$queryComments = "SELECT comment_status, COUNT(*) AS count FROM comments GROUP BY comment_status";
$resultComments = mysqli_query($bdd, $queryComments);
$comments = [];
while ($row = mysqli_fetch_assoc($resultComments)) {
    $comments[$row['comment_status']] = $row['count'];
}

$commentsWait = ($comments['wait'] == 1) ? $comments['wait'] : 0;
$commentsOk = ($comments['ok'] == 1) ? $comments['ok'] : 0;



?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <?php include_once("./phpComponents/head.php"); ?>
    <title>Gestion des commentaires</title>
</head>
<body>
    <?php include_once("./phpComponents/header.php"); ?>
    <div class="connect-info">
        <div class="btn-connect"></div>
        <p>Connecté en tant que <?php echo $_SESSION["user"] ?></p>
    </div>
    <div class="dashboard-info">
        <!-- Afficher un bouton Commentaires à traiter et un bouton Commentaires validés -->
        <p><a href="./adminComments.php?wait=1&ok=0"><?php echo "Commentaires à traiter : " . $commentsWait; ?></a></p>
        <p><a href="./adminComments.php?wait=0&ok=1"><?php echo "Commentaires validés : " . $commentsOk; ?></a></p>
    </div>
    <div id="show-list">
        <!-- Gérer l'affichage des commentaires ici (pagination, etc.) -->
        <?php
        if (isset($_GET['ok']) && $_GET['ok'] === '1') {
            echo "Commentaires validés : ";
        } elseif (isset($_GET['wait']) && $_GET['wait'] === '1') {
            echo "Commentaires à traiter : ";
        }
        ?>
        <!-- Mettez ici votre code d'affichage des commentaires -->
    </div>
    <?php include_once("./phpComponents/script.php"); ?>
</body>
</html>
