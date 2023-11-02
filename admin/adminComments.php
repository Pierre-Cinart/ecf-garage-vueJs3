<?php
session_start();

$currentPage = 'adminComments';
if (!isset($_SESSION["log_in"])) {
    header('Location: logout.php');
    exit();
}
require_once('../backend/bdd.php');
// Gestion de ok et wait pour l'affichage des commentaires
if (!isset($_GET["ok"]) || (isset($_GET["ok"]) && $_GET["ok"] != 1)) {
    $ok = 0;
}
if (isset($_GET["ok"]) && $_GET["ok"] == 1) {
    $ok = 1;
}
if (!isset($_GET["wait"]) || (isset($_GET["wait"]) && $_GET["wait"] != 1)) {
    $wait = 0;
}
if (isset($_GET["wait"]) && $_GET["wait"] == 1) {
    $wait = 1;
}

// Requête SQL pour compter les commentaires en attente de traitement
$queryComments = "SELECT COUNT(*) FROM comments WHERE comment_status = 'wait'";
$resultComments = mysqli_query($bdd, $queryComments);
$commentsWait = mysqli_fetch_array($resultComments)[0];

// Requête SQL pour compter les commentaires validés
$queryCommentsOk = "SELECT COUNT(*) FROM comments WHERE comment_status = 'ok'";
$resultCommentsOk = mysqli_query($bdd, $queryCommentsOk);
$commentsOk = mysqli_fetch_array($resultCommentsOk)[0];

// Total des commentaires
$commentsTotal = $commentsOk + $commentsWait;

// Traitement des actions de modification (valider ou supprimer)
if (isset($_POST['commentId']) && isset($_POST['action'])) {
    $commentId = $_POST['commentId'];
    $action = $_POST['action'];

    if ($action === 'validate') {
        // Action de validation du commentaire
        $updateQuery = "UPDATE comments SET comment_status = 'ok' WHERE comment_id = $commentId";
        $result = mysqli_query($bdd, $updateQuery);

        if ($result) {
            // Commentaire validé avec succès, redirigez vers la page adminComments.php (commentaires validés)
            header('Location: adminComments.php?ok=1');
            exit();
        }
    } elseif ($action === 'delete') {
        // Action de suppression du commentaire
        $deleteQuery = "DELETE FROM comments WHERE comment_id = $commentId";
        $result = mysqli_query($bdd, $deleteQuery);

        if ($result) {
            // Commentaire supprimé avec succès, redirigez vers la page adminComments.php (commentaires à traiter)
            header('Location: adminComments.php?wait=1');
            exit();
        }
    }
}
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
        <p><a href="./adminComments.php?wait=1"><?php echo "Commentaires à traiter : " . $commentsWait; ?></a></p>
        <p><a href="./adminComments.php?ok=1"><?php echo "Commentaires validés : " . $commentsOk; ?></a></p>
        <!-- Gérer l'affichage avec pagination lors du clic + flèches de retour en haut et en bas de la div -->
    </div>
    <div id="show-list">
    <?php
        if ($ok == 1) {
            $_SESSION['comments'] = "ok";
            echo "<h2>Commentaires validés : </h2>";
            echo '<div class="sep"></div>';
            include_once('./phpFunctions/showComments.php');
            // Afficher ici les commentaires validés
        } elseif ($wait == 1) {
            $_SESSION['comments'] = "wait";
            echo "<h2>Commentaires à traiter :</h2> ";
            echo '<div class="sep"></div>';
            include_once('./phpFunctions/showComments.php');
            // Afficher ici les commentaires à traiter
        }
    ?>
    </div>
    <?php include_once("./phpComponents/script.php"); ?>
    <script src= "./js/confirmDelete.js"></script>
</body>
</html>
