<?php
session_start();
$currentPage = 'adminCars';

if (!isset($_SESSION["log_in"])) {
    header('Location: logout.php');
    exit();
}

require_once('../backend/bdd.php');

// Initialisation des variables
$carId = $marque = $modele = $km = $couleur = $price = $infos = '';

// Vérifie si un ID de véhicule a été transmis via POST
if (isset($_POST['carId'])) {
    $carId = $_POST['carId'];

    // Requête SQL pour récupérer les informations du véhicule, y compris la marque et la couleur
    $query = "SELECT c.*, m.mark_name AS car_mark, cl.color_name AS car_color FROM cars c
              LEFT JOIN marks m ON c.car_mark_id = m.mark_id
              LEFT JOIN colors cl ON c.car_color_id = cl.color_id
              WHERE c.car_id = ?";

    $stmt = mysqli_prepare($bdd, $query);
    mysqli_stmt_bind_param($stmt, "i", $carId);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);

    if (!$result) {
        die('Erreur dans la requête SQL : ' . mysqli_error($bdd));
    }

    // Récupère les informations du véhicule, de la marque et de la couleur
    $vehicleInfo = mysqli_fetch_assoc($result);
    $mark = $vehicleInfo['car_mark'];
    $model = $vehicleInfo['car_model'];
    $km = $vehicleInfo['car_km'];
    $color = $vehicleInfo['car_color'];
    $price = $vehicleInfo['car_price'];
    $infos = $vehicleInfo['car_info'];
    $picture =$vehicleInfo['car_picture'];

    // Libérer les ressources de la requête préparée
    mysqli_stmt_close($stmt);
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
                <label for="mark">Marque :</label>
                <input type="text" name="mark" id="mark" value="<?php echo $mark; ?>">
            </div>
            <div class="form-box">
                <label for="model">Modèle :</label>
                <input type="text" name ="model" id="model" value="<?php echo $model; ?>">
            </div>
            <div class="form-box">
                <label for="km">Kilométrage :</label>
                <input type="text" name="km" id="km" value="<?php echo $km; ?>">
            </div>
            <div class="form-box">
                <label for="color">Couleur :</label>
                <input type="text" name="color" id="color" value="<?php echo $color; ?>">
            </div>
            <div class="form-box">
                <label for="price">Prix :</label>
                <input type="text" name="price" id="price" value="<?php echo $price; ?>">
            </div>
            <div class="form-box">
                <label for="image">Image actuelle :</label>
                <img src="http://localhost/garage-v-parrot-vue/backend/img/<?php echo $mark . '/'.$picture; ?>" alt="Image du véhicule" width="100" height="100">
            </div>
            <div class="form-box">
                <label for="image">Nouvelle image :</label>
                <input type="file" name="image" id="image">
            </div>
            <div class="form-box">
                <label for="infos">Info :</label>
                <textarea name="infos" id="infos" rows="6" cols="32"><?php echo $infos; ?></textarea>
            </div>

            <input type="submit" class="btn-sub" style="margin-left: 80%;" value="Modifier">
        </form>
    </div>
    <?php include_once("./phpComponents/script.php"); ?>
</body>
</html>
