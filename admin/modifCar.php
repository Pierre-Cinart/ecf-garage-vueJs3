<?php
    session_start();
    $currentPage = 'adminCars';
    if (!isset($_SESSION["log_in"])) {
        header('Location: logout.php');
        exit();
    }
?>
verifier les droits et le token 

creer une fonction verfificatiopn de fichier pour l upload dimage
penser à reconvertir les images dans un format léger et unique 
<!DOCTYPE html>
<html lang="fr">
<head>
    <?php 
        include_once("./phpComponents/head.php"); 
    ?>
    <title>Gestion des commentaires</title>
</head>
<body>
    <?php 
       
        include_once("./phpComponents/header.php"); 
        include_once('./phpComponents/infos.php');
    ?>
    <div class="admin-form car-form">
        <h2>Modifier les informations du véhicule</h2>
        <form action="modifier_vehicule.php" method="post">
            <input type="hidden" name="vehicle_id" value="ID_DU_VEHICULE"> 
            <div class="form-box">
                <label for="marque">Marque :</label>
                <input type="text" name="marque" id="marque" value="MARQUE_ACTUELLE">
            </div>
            <div class="form-box">
                <label for="modele">Modèle :</label>
                <input type="text" name="modele" id="modele" value="model_ACTUEL">
            </div>
            <div class="form-box">
                <label for="km">km :</label>
                <input type="text" name="km" id="km" value="km_ACTUEL">
            </div>
            <div class="form-box">
                <label for="color">couleur :</label>
                <input type="text" name="color" id="color" value="couleur_ACTUEL">
            </div>
            <div class="form-box"> 
                <label for="price">prix :</label>
                <input type="text" name="price" id="price" value="prix_ACTUEL"></div>
            <div class="form-box">
                <label for="image">Image :</label>
                <input type="file" name="image" id="image">
            </div>
            <div class="form-box">
                <label for="infos">Info:</label>
                <textarea name="infos" id="infos" rows ="16" cols = "32">INFORMATIONS_ACTUELLES</textarea>
            </div>

            <input type="submit" class ="btn-sub" style = "margin-left : 80%;" value="Modifier">
        </form>
    </div>
    <?php include_once("./phpComponents/script.php"); ?>
</body>
</html>
