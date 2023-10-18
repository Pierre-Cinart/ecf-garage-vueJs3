<?php

header('Content-Type: application/json');
header("Access-Control-Allow-Origin: http://localhost:8080");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
// Configuration de la base de données et connexion à la bdd
require_once('bdd.php');
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    // Si la méthode HTTP est OPTIONS, c'est une pré-vérification CORS, donc retournez les en-têtes CORS appropriés.
    header("HTTP/1.1 200 OK");
    exit;
}
//verifier les droits administrateur et afficher les messageset permettre la gestion
?>