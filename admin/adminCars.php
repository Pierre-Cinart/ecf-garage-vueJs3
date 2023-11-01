<?php
// à faire
//séparer le code en 2 et renoyer les infos de recherche en get
//permettre la modification la suppression et l ajout de carte de véhicule
//implémenter un system de recherche pour trier la page (marque, model)
session_start();
$currentPage = 'adminCars';
if (!isset($_SESSION["log_in"])) {
    header('Location: logout.php');
    exit();
}

// Inclure le fichier de connexion à la base de données
require_once('../backend/bdd.php');

// Requête SQL pour récupérer tous les véhicules
$query = "SELECT c.*, m.mark_name AS car_mark, cl.color_name AS car_color FROM cars c
          LEFT JOIN marks m ON c.car_mark_id = m.mark_id
          LEFT JOIN colors cl ON c.car_color_id = cl.color_id";

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
    <!-- afficher que si bouton ajouter un véhuicule est préssé -->
    <!-- afficher carte vierge et creer un fichier php pour vérifier ajouter les infos en bdd  -->
    <!-- afficher que si bouton modifier un véhuicule est préssé -->
    <!-- gérer les options se recherche ici -->
    <div class="gallery">
        <?php foreach ($vehicles as $vehicle) : ?>
            <div class="card">
                <div class="card-txt">
                    <h3><?php echo $vehicle['car_mark'] . ' ' . $vehicle['car_model']; ?></h3>
                    <p><b>Kilométrage :</b> <?php echo $vehicle['car_km']; ?> km</p>
                    <p><b>Couleur :</b> <?php echo $vehicle['car_color']; ?></p>
                    <p><b>Prix :</b> <?php echo $vehicle['car_price']; ?> €</p>
                    <!-- ajouter un bouton suprimer et modifier (icone engrenage) -->
                    <!-- gerer l envoie d info en post selon les conditions -->
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
