<?php
session_start();
$articleValue ="";
$currentPage = 'adminArticles';
require_once("../backend/bdd.php");

if (!$_SESSION["log_in"]){
    header('Location:index.php');
    exit();
}
if (isset($_GET['article'])) {
    $article = htmlspecialchars($_GET['article']);
}
else {
    $article = "";
}

if ($article != "") {
    $query = "SELECT content FROM articles WHERE title = '$article' LIMIT 1";
    $result = $bdd->query($query);
    if ($result){
        $row = $result->fetch_assoc();
        $articleValue = html_entity_decode($row['content']);
    }
}
//configurer l article à afficher
// si $article !="" et que dans la table articles il existe une column avec le title = $article
// $articleValue = le champs article content 
 ?>
<!DOCTYPE html>
<html lang="fr">
    <head>
    <?php include_once ("./phpComponents/head.php");?>
        <title>Gestion des articles</title>
    </head>
<body>  
    <?php include_once ("./phpComponents/header.php");?>
    <div class="connect-info">
        <div class = "btn-connect"></div>
        <p>connecté en tant que <?php echo $_SESSION["user"]?></p>
    </div>
    <div class="dashboard-info">
        <h2>Quel article souhaitez vous gérer ?</h2>
        <!-- afficher un bouton pour chaque catégorie type submit post  -->
        <p><a href="./adminArticles.php?article=a-propos">A-propos</a></p>
        <p><a href="./adminArticles.php?article=carrosserie">Carrosserie</a></p>
        <p><a href="./adminArticles.php?article=mecanique">Mécanique</a></p>
        <p><a href="./adminArticles.php?article=entretien">Entretiens</a></p>
    </div>
    <div id="show-article">
    <!-- gérer l affichage de l article concerné dans un text-area pour pouvoir le modifier -->
    <form method = "POST" action="adminArticles">
        <h2>Entrer la mise à jour de l article : </h2>
        <textarea name="txt-area" rows="12" ><?php  echo $articleValue ?></textarea><br>
    </form>
    <input class="btn-sub float-r" type="submit" value="valider">
    <!-- ajouter un bouton submit et creer une fonction javascript et requete fetch async pour mettre à jour l article-->
    </div>
   
   <?php include_once ("./phpComponents/script.php");?>
</body>
</html>
