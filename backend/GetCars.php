<?php
header('Content-Type: application/json');
header("Access-Control-Allow-Origin: http://localhost:8080");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");

// Inclure le fichier de configuration de la base de données
require_once('bdd.php');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    // Si la méthode HTTP est OPTIONS, c'est une pré-vérification CORS, donc retournez les en-têtes CORS appropriés.
    header("HTTP/1.1 200 OK");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
    $perPage = isset($_GET['perPage']) ? intval($_GET['perPage']) : 10;
    $offset = isset($_GET['offset']) ? intval($_GET['offset']) : 0;
    $searchTerm = isset($_GET['search']) ? mysqli_real_escape_string($bdd, $_GET['search']) : '';
    $sortOption = isset($_GET['sort_select']) ? $_GET['sort_select'] : '';

    // Requête SQL pour récupérer les véhicules en fonction des critères de recherche et de tri
    $query = "SELECT c.*, m.nom_marque AS car_mark, cl.nom_couleur AS car_color FROM cars c
              LEFT JOIN marques m ON c.car_mark_id = m.marque_id
              LEFT JOIN couleurs cl ON c.car_color_id = cl.couleur_id
              WHERE c.car_model LIKE '%$searchTerm' OR m.nom_marque LIKE '%$searchTerm'";

    // Modifier la requête en fonction de l'option de tri
    switch ($sortOption) {
        case 'prix-croissant':
            $query .= " ORDER BY c.car_price ASC";
            break;
        case 'prix-decroissant':
            $query .= " ORDER BY c.car_price DESC";
            break;
        case 'marque':
            $query .= " ORDER BY m.nom_marque ASC";
            break;
        case 'modele':
            $query .= " ORDER BY c.car_model ASC";
            break;
    }

    // Ajouter LIMIT et OFFSET pour la pagination
    $query .= " LIMIT $perPage OFFSET $offset";

    $result = $bdd->query($query);

    if (!$result) {
        die('Erreur dans la requête SQL : ' . $bdd->error);
    }

    $vehicles = [];

    while ($row = $result->fetch_assoc()) {
        $vehicles[] = $row;
    }

    $bdd->close();

    echo json_encode($vehicles);
} else {
    // Méthode non autorisée
    http_response_code(405);
    echo 'Méthode non autorisée';
}
