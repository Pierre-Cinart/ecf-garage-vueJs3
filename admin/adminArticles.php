<?php
session_start();
$articleValue = "";
$currentPage = 'adminArticles';
require_once("../backend/bdd.php");
if (!isset($_SESSION['article'])) {
    $_SESSION['article'] ="";
}
if (!$_SESSION["log_in"]) {
    header('Location:index.php');
    exit();
}

if (isset($_GET['article'])) {
    $_SESSION['article'] = htmlspecialchars($_GET['article']);
}

if ($_SESSION['article'] != "") {
    $query = "SELECT content FROM articles WHERE title = '{$_SESSION['article']}' LIMIT 1";
    $result = $bdd->query($query);
    if ($result) {
        $row = $result->fetch_assoc();
        $articleValue = html_entity_decode($row['content']);
    }
}

// Vérifier si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['txt-area'])) {
    // Récupérer le nouveau contenu du textarea
    $nouveauContenu = $_POST['txt-area'];
    

    // Mettre à jour l'article dans la base de données
    $requeteMiseAJour = $bdd->prepare("UPDATE articles SET content = ? WHERE title = ?");
    $requeteMiseAJour->bind_param("ss", $nouveauContenu, $_SESSION['article']);
    
    if ($requeteMiseAJour->execute()) {
        // Mise à jour réussie
        echo "L'article a été mis à jour avec succès.";
    } else {
        // Erreur de mise à jour
        echo "Erreur lors de la mise à jour de l'article : " . $bdd->error;
    }
    $requeteMiseAJour->close();
    
    // Réinitialiser la variable de session
    $_SESSION['article'] = "";
}
?>
<!DOCTYPE html>
<html lang="fr">
    <head>
        <?php include_once("./phpComponents/head.php");?>
        <title>Gestion des articles</title>
    </head>
    <body>
        <?php include_once("./phpComponents/header.php");?>
        <div class="connect-info">
            <div class="btn-connect"></div>
            <p>Connecté en tant que <?php echo $_SESSION["user"]?></p>
        </div>
        <div class="dashboard-info">
            <h2>Quel article souhaitez-vous gérer ?</h2>
            <!-- afficher un bouton pour chaque catégorie type submit post  -->
            <p><a href="./adminArticles.php?article=a-propos">A-propos</a></p>
            <p><a href="./adminArticles.php?article=carrosserie">Carrosserie</a></p>
            <p><a href="./adminArticles.php?article=mecanique">Mécanique</a></p>
            <p><a href="./adminArticles.php?article=entretien">Entretiens</a></p>
        </div>
        <div id="show-article">
            <!-- gérer l'affichage de l'article concerné dans un textarea pour pouvoir le modifier -->
            <form method="POST" action="adminArticles.php">
                <h2>Entrer la mise à jour de l'article :</h2>
                <textarea name="txt-area" rows="12"><?php echo $articleValue ?></textarea><br>
                <input class="btn-sub float-r" type="submit" value="Valider">
            </form>
        </div>

        <?php include_once("./phpComponents/script.php");?>
    </body>
</html>
