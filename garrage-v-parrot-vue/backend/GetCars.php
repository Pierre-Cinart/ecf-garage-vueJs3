<?php

header('Content-Type: application/json');
header("Access-Control-Allow-Origin: http://localhost:8080");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
// Configuration de la base de données et connexion à la bdd
require_once('bdd.php');

// Requête SQL pour récupérer les informations sur les véhicules
$query = "SELECT * FROM cars";

$result = $bdd->query($query);

if (!$result) {
    die('Erreur dans la requête SQL : ' . $bdd->error);
}

$cars = [];

// Parcourir les résultats et les ajouter au tableau des véhicules
while ($row = $result->fetch_assoc()) {
    $cars[] = $row;
}

// Fermeture de la connexion à la base de données
$bdd->close();

// Renvoyer les informations sur les véhicules au format JSON
echo json_encode($cars);
?>
