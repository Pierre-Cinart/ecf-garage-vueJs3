<?php
session_start();

$currentPage = 'adminComments';
if (!isset($_SESSION["log_in"])) {
    header('Location: logout.php');
    exit();
}
require_once('../backend/bdd.php');

if (!isset($_GET["ok"]) || (isset($_GET["ok"]) && $_GET["ok"] != 1)) {
    $ok = 0;
}
if (isset($_GET["ok"]) && $_GET["ok"] == 1) {
    $ok = 1;
}
if (!isset($_GET["wait"]) || (isset($_GET["wait"]) and $_GET["wait"] != 1)) {
    $wait = 0;
}
if (isset($_GET["wait"]) && $_GET["wait"] == 1) {
    $wait = 1;
}

$queryComments = "SELECT COUNT(*) FROM comments WHERE comment_status = 'wait'";
$resultComments = mysqli_query($bdd, $queryComments);
$commentsWait = mysqli_fetch_array($resultComments)[0];

$queryCommentsOk = "SELECT COUNT(*) FROM comments WHERE comment_status = 'ok'";
$resultCommentsOk = mysqli_query($bdd, $queryCommentsOk);
$commentsOk = mysqli_fetch_array($resultCommentsOk)[0];

$commentsTotal = $commentsOk + $commentsWait;

if (isset($_POST['commentId']) && isset($_POST['action'])) {
    $commentId = $_POST['commentId'];
    $action = $_POST['action'];

    if ($action === 'validate') {
        // Action de validation du commentaire
        $updateQuery = "UPDATE comments SET comment_status = 'ok' WHERE comment_id = $commentId";
        $result = mysqli_query($bdd, $updateQuery);

        if ($result) {
            // Commentaire validé avec succès, redirigez vers la page adminComments.php (commentaires validés)
            $_SESSION['info'] = "Le commentaire a été validé avec succès";
            $_SESSION['info-type'] = 'success';

            // Récupérer le prénom de l'auteur et la date du commentaire
            $queryCommentInfo = "SELECT firstname, comment_date FROM comments WHERE comment_id = $commentId";
            $resultCommentInfo = mysqli_query($bdd, $queryCommentInfo);
            $commentInfo = mysqli_fetch_assoc($resultCommentInfo);
            $authorFirstname = $commentInfo['firstname'];
            $commentDate = $commentInfo['comment_date'];

            // Enregistrer une trace de log pour la validation
            include_once("./phpFunctions/insertLog.php");
            insertLog("Validation du commentaire de " . $authorFirstname . " envoyé le : " . $commentDate, $bdd);
        } else {
            $_SESSION['info'] = "Erreur lors de la validation";
            $_SESSION['info-type'] = 'error';
        }
        header('Location: adminComments.php?ok=1');
        exit();
    } elseif ($action === 'delete') {
        // Récupérer le prénom de l'auteur et la date du commentaire
        $queryCommentInfo = "SELECT firstname, comment_date FROM comments WHERE comment_id = $commentId";
        $resultCommentInfo = mysqli_query($bdd, $queryCommentInfo);
        $commentInfo = mysqli_fetch_assoc($resultCommentInfo);
        $authorFirstname = $commentInfo['firstname'];
        $commentDate = $commentInfo['comment_date'];

        // Action de suppression du commentaire
        $deleteQuery = "DELETE FROM comments WHERE comment_id = $commentId";
        $result = mysqli_query($bdd, $deleteQuery);

        if ($result) {
            // Commentaire supprimé avec succès, redirigez vers la page adminComments.php (commentaires à traiter)
            $_SESSION['info'] = "Le commentaire a été supprimé avec succès";
            $_SESSION['info-type'] = 'success';

            // Enregistrer une trace de log pour la suppression
            include_once("./phpFunctions/insertLog.php");
            insertLog("Suppression du commentaire de " . $authorFirstname . " envoyé le : " . $commentDate, $bdd);
        } else {
            $_SESSION['info'] = "Une erreur est survenue, le commentaire n'a pas été supprimé";
            $_SESSION['info-type'] = 'error';
        }
        header('Location: adminComments.php?wait=1');
        exit();
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
    <?php include_once('./phpComponents/infos.php'); ?>
   
    <div class="dashboard-info">
        <p><a href="./adminComments.php?wait=1"><?php echo "Commentaires à traiter : " . $commentsWait; ?></a></p>
        <p><a href="./adminComments.php?ok=1"><?php echo "Commentaires validés : " . $commentsOk; ?></a></p>
    </div>
    <div id="show-list">
    <?php
        if ($ok == 1) {
            $_SESSION['comments'] = "ok";
            echo "<h2>Commentaires validés : </h2>";
            echo '<div class="sep"></div>';
            include_once('./phpFunctions/showComments.php');
        } elseif ($wait == 1) {
            $_SESSION['comments'] = "wait";
            echo "<h2>Commentaires à traiter :</h2> ";
            echo '<div class="sep"></div>';
            include_once('./phpFunctions/showComments.php');
        }
    ?>
    </div>
    <?php include_once("./phpComponents/script.php"); ?>
    <script src= "./js/confirmDelete.js"></script>
</body>
</html>
