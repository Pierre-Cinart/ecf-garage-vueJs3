<?php
session_start();
$currentPage = 'adminCars';

if (!isset($_SESSION["log_in"])) {
    header('Location: logout.php');
    exit();
}
//mettre la verif token à améliorer
require_once('../backend/bdd.php');

// Vérifie  si un ID de véhicule a été transmis via POST
if (isset($_POST['carId'])) {
    $carId = $_POST['carId'];

    // Requête SQL pour récupérer les informations du véhicule, y compris la marque et la couleur
    $query = "SELECT c.*, m.mark_name AS car_mark, cl.color_name AS car_color FROM cars c
              LEFT JOIN marks m ON c.car_mark_id = m.mark_id
              LEFT JOIN colors cl ON c.car_color_id = cl.color_id
              WHERE c.car_id = $carId";

    $result = mysqli_query($bdd, $query);

    if (!$result) {
        die('Erreur dans la requête SQL : ' . mysqli_error($bdd));
    }

    // Récupére les informations du véhicule, de la marque et de la couleur
    $vehicleInfo = mysqli_fetch_assoc($result);
    $marque = $vehicleInfo['car_mark'];
    $couleur = $vehicleInfo['car_color'];

}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <?php include_once("./phpComponents/head.php"); ?>
    <title>Modifier un véhicule</title>
</head>
<body>
    <?php include_once("./phpComponents/header.php"); ?>

    <div class="admin-form car-form">
        <h2>Modifier les informations du véhicule</h2>
        <form action="modifier_vehicule.php" method="post">
            <input type="hidden" name="vehicle_id" value="<?php echo $carId; ?>"> 
            <div class="form-box">
                <label for="marque">Marque :</label>
                <input type="text" name="marque" id="marque" value="<?php echo $marque; ?>">
            </div>
            <div class="form-box">
                <label for="modele">Modèle :</label>
                <input type="text" name="modele" id="modele" value="<?php echo $vehicleInfo['car_model']; ?>">
            </div>
            <div class="form-box">
                <label for="km">Kilométrage :</label>
                <input type="text" name="km" id="km" value="<?php echo $vehicleInfo['car_km']; ?>">
            </div>
            <div class="form-box">
                <label for="color">Couleur :</label>
                <input type="text" name="color" id="color" value="<?php echo $couleur; ?>">
            </div>
            <div class="form-box"> 
                <label for="price">Prix :</label>
                <input type="text" name="price" id="price" value="<?php echo $vehicleInfo['car_price']; ?>">
            </div>
            <div class="form-box">
                <label for="image">Image :</label>
                <input type="file" name="image" id="image">
            </div>
            <div class="form-box">
                <label for="infos">Info :</label>
                <textarea name="infos" id="infos" rows="6" cols="32"><?php echo $vehicleInfo['car_info']; ?></textarea>
            </div>

            <input type="submit" class="btn-sub" style="margin-left: 80%;" value="Modifier">
        </form>
    </div>
    <?php include_once("./phpComponents/script.php"); ?>
</body>
</html>
