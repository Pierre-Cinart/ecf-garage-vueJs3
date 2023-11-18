<?php
session_start();
// à faire cacher le formulaire si aucun article n 'est selectionné
//deconnexion automatique si user non autorisé
if (!isset($_SESSION["log_in"])){
    header('Location:logout.php');
    exit();
}

$currentPage = 'adminArticles'; //nom de page pour la navBar
// accés bdd
require_once("../backend/bdd.php");

$articleValue = "";
;

//récupération du get pour recherché l


if (isset($_GET['article'])) {
    
    $_SESSION['article'] = htmlspecialchars($_GET['article']);
    if ($_SESSION['article'] != "") {
        $query = "SELECT content FROM articles WHERE title = '{$_SESSION['article']}' LIMIT 1";
        $result = $bdd->query($query);
        if ($result) {
            $row = $result->fetch_assoc();
            $articleValue = ($row['content']);
        }
    } 
}
 


// Vérifier si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['txt-area'])) {
     // verification de token
     include_once("./phpFunctions/verifToken.php");
     if ($_SESSION['validateToken'] != 1){
         header('Location: logout.php');
         exit();
     }
    // Récupérer le nouveau contenu du textarea
    $newContent = $_POST['txt-area'];
    
    // Mettre à jour l'article dans la base de données
    $updateQuery = $bdd->prepare("UPDATE articles SET content = ? WHERE title = ?");
    $updateQuery->bind_param("ss", $newContent, $_SESSION['article']);
    
    if ($updateQuery->execute()) {// a traier en pop up ...
        // Mise à jour réussie
       $_SESSION['info'] = 'l article a bien était mise à jour';
       $_SESSION['info-type'] = 'success';
       include_once ("./phpFunctions/insertLog.php");
        insertLog("modification de l article ".$_SESSION['article'], $bdd);
    } else {
        // Erreur de mise à jour
        $_SESSION['info'] = "Erreur lors de la mise à jour de l'article : " . $bdd->error;
        $_SESSION['info-type'] = 'error';
       
    }
   
    $updateQuery->close();
    
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
        <?php include_once("./phpComponents/header.php");
        include_once("./phpComponents/infos.php");?>

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
