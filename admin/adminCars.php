<?php
session_start();
$currentPage = 'adminCars';
if (!isset($_SESSION["log_in"])) {
    header('Location: logout.php');
    exit();
}

// Inclure le fichier de connexion à la base de données
require_once('../backend/bdd.php');

// Gestion de la recherche
$searchTerm = "";

if (isset($_GET['search']) && !empty($_GET['search'])) {
    $searchTerm = mysqli_real_escape_string($bdd, $_GET['search']);
    $searchQuery = "WHERE m.mark_name LIKE '%$searchTerm%' OR car_model LIKE '%$searchTerm'";
} else {
    $searchQuery = "";
}

// Gestion du tri
$orderBy = "m.mark_name"; // Par défaut, triez par marque

if (isset($_GET['sort_by']) && in_array($_GET['sort_by'], ['m.mark_name', 'car_model'])) {
    $orderBy = $_GET['sort_by'];
}

// Requête SQL pour récupérer les véhicules avec les filtres et le tri
$query = "SELECT c.*, m.mark_name AS car_mark, cl.color_name AS car_color FROM cars c
          LEFT JOIN marks m ON c.car_mark_id = m.mark_id
          LEFT JOIN colors cl ON c.car_color_id = cl.color_id
          $searchQuery
          ORDER BY $orderBy";

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
    <?php include_once("./phpComponents/header.php"); ?>
    <div class="connect-info">
        <div class="btn-connect"></div>
        <p>Connecté en tant que <?php echo $_SESSION["user"]; ?></p>
    </div>

    <!-- Barre de recherche -->
    <form method="GET" action="adminCars.php">
        <input type="text" name="search" placeholder="Rechercher par marque ou modèle">
        <select name="sort_by">
            <option value="car_mark">Trier par Marque</option>
            <option value="car_model">Trier par Modèle</option>
        </select>
        <button type="submit">Rechercher</button>
    </form>

    <div class="gallery">
        <?php foreach ($vehicles as $vehicle) : ?>
            <div class="card">
                <div class="card-txt">
                    <h3><?php echo $vehicle['car_mark'] . ' ' . $vehicle['car_model']; ?></h3>
                    <p><b>Kilométrage :</b> <?php echo $vehicle['car_km']; ?> km</p>
                    <p><b>Couleur :</b> <?php echo $vehicle['car_color']; ?></p>
                    <p><b>Prix :</b> <?php echo $vehicle['car_price']; ?> €</p>
                    <!-- ajouter un bouton supprimer et modifier (icone engrenage) -->
                    <!-- gérer l'envoi d'info en POST selon les conditions -->
                </div>
                <div class="card-img">
                    <!-- Construire le chemin complet de l'image -->
                    <img class="card-img" src="http://localhost/garage-v-parrot-vue/backend/img/<?php echo $vehicle['car_mark'] . '/' . $vehicle['car_picture']; ?>" alt="<?php echo $vehicle['car_mark'] . '/' . $vehicle['car_picture']; ?>">
                    <p><?php echo $vehicle['car_info']; ?></p>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    <?php include_once("./phpComponents/script.php"); ?>
</body>
</html>
