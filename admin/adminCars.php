<?php
session_start();
$currentPage = 'adminCars';
if (!isset($_SESSION["log_in"])) {
    header('Location: logout.php');
    exit();
}

require_once('../backend/bdd.php');

$orderBy = "car_mark"; // Par défaut, triez par marque
$searchTerm = "";

if (isset($_GET['search'])) {
    $searchTerm = mysqli_real_escape_string($bdd, $_GET['search']);
}

// Recherche par marque (car_mark) ou modèle (car_model) en fonction de "sort_by"
if (isset($_GET['sort_by'])) {
    if ($_GET['sort_by'] === 'car_model') {
        $query = "SELECT c.*, m.mark_name AS car_mark, cl.color_name AS car_color FROM cars c
                  LEFT JOIN marks m ON c.car_mark_id = m.mark_id
                  LEFT JOIN colors cl ON c.car_color_id = cl.color_id
                  WHERE c.car_model LIKE '%$searchTerm%'
                  ORDER BY car_model";
        $orderBy = "car_model";
    } else {
        $query = "SELECT c.*, m.mark_name AS car_mark, cl.color_name AS car_color FROM cars c
                  LEFT JOIN marks m ON c.car_mark_id = m.mark_id
                  LEFT JOIN colors cl ON c.car_color_id = cl.color_id
                  WHERE m.mark_name LIKE '%$searchTerm%'
                  ORDER BY car_mark";
        $orderBy = "car_mark";
    }
} else {
    // Aucun tri spécial, utilisez la recherche par défaut
    $query = "SELECT c.*, m.mark_name AS car_mark, cl.color_name AS car_color FROM cars c
              LEFT JOIN marks m ON c.car_mark_id = m.mark_id
              LEFT JOIN colors cl ON c.car_color_id = cl.color_id
              ORDER BY $orderBy";
}

$result = mysqli_query($bdd, $query);

if (!$result) {
    die('Erreur dans la requête SQL : ' . mysqli_error($bdd));
}

$vehicles = [];

while ($row = mysqli_fetch_assoc($result)) {
    $vehicles[] = $row;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <?php include_once("./phpComponents/head.php"); ?>
    <title>Gestion des véhicules</title>
</head>
<body>
    <?php 
        include_once("./phpComponents/header.php"); 
        include_once("./phpComponents/infos.php");
    ?>
    

    <!-- Barre de recherche -->
    <form method="GET" action="adminCars.php">
        <input type="text" name="search" placeholder="Rechercher par marque ou modèle">
        <select name="sort_by">
            <option value="car_mark" <?php echo $orderBy === 'car_mark' ? 'selected' : ''; ?>>Trier par Marque</option>
            <option value="car_model" <?php echo $orderBy === 'car_model' ? 'selected' : ''; ?>>Trier par Modèle</option>
        </select>
        <button type="submit">Rechercher</button>
    </form>
    <a href="addCar.php">Ajouter un nouveau véhicule</a>

    <div class="gallery">
    <?php foreach ($vehicles as $vehicle) : ?>
        <div class="card">
            <div class ="card-txt">
                <h3><?php echo $vehicle['car_mark'] . ' ' . $vehicle['car_model']; ?></h3>
                <p><b>Kilométrage :</b> <?php echo $vehicle['car_km']; ?> km</p>
                <p><b>Couleur :</b> <?php echo $vehicle['car_color']; ?></p>
                <p><b>Prix :</b> <?php echo $vehicle['car_price']; ?> €</p>
            </div>
            <div class="card-img">
                <img class="card-img" src="http://localhost/garage-v-parrot-vue/backend/img/<?php echo $vehicle['car_mark'] . '/' . $vehicle['car_picture']; ?>" alt="<?php echo $vehicle['car_mark'] . '/' . $vehicle['car_picture']; ?>">
                <p><?php echo $vehicle['car_info']; ?></p>
                <div class="card-ico">
                    <form action="modifCar.php" method="post">
                        <input type="hidden" name="carId" value="<?php echo $vehicle['car_id']; ?>">
                        <button type="submit" class="icon-button bg-green"><i class="fas fa-cog"></i></button>
                    </form>
                    <form action="deleteCar.php" method="post">
                        <input type="hidden" name="carId" value="<?php echo $vehicle['car_id']; ?>">
                        <button type="submit" class="icon-button bg-red"><i class="fas fa-trash"></i></button>
                    </form>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>

    <?php include_once("./phpComponents/script.php"); ?>
</body>
</html>
