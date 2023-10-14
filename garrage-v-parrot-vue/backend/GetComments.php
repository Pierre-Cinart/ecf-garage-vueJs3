<?php

header('Content-Type: application/json');
header("Access-Control-Allow-Origin: http://localhost:8080",'http://192.168.1.20:8080');
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");


// Configuration de la base de données et connexion à la bdd
require_once('bdd.php');

// Requête SQL pour récupérer les commentaires
$query = "SELECT * FROM comments WHERE comment_status ='ok'";

$result = $bdd->query($query);

if (!$result) {
    die('Erreur dans la requête SQL : ' . $bdd->error);
}

$comments = [];

// Parcourir les résultats et les ajouter au tableau des commentaires
while ($row = $result->fetch_assoc()) {
    $comments[] = $row;
}

// Fermeture de la connexion à la base de données
$bdd->close();

// Renvoyer les commentaires au format JSON
echo json_encode($comments);
?>
