<?php

header('Content-Type: application/json');
header("Access-Control-Allow-Origin: http://localhost:8080");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
// Configuration de la base de données et connexion à la bdd
require_once('bdd.php');

//verifier les droits administrateur et afficher les véhicules et permettre la gestion
?>