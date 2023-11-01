<?php
header('Content-Type: application/json');
header("Access-Control-Allow-Origin: http://localhost:8080");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");

// Inclure le fichier de configuration de la base de données
require_once('bdd.php');



if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
    $perPage = isset($_GET['perPage']) ? intval($_GET['perPage']) : 10;
    $offset = isset($_GET['offset']) ? intval($_GET['offset']) : 0;
    $searchTerm = isset($_GET['search']) ? mysqli_real_escape_string($bdd, $_GET['search']) : '';
    $sortOption = isset($_GET['sort_select']) ? $_GET['sort_select'] : '';

    // Requête SQL pour récupérer les véhicules en fonction des critères de recherche et de tri
    $query = "SELECT c.*, m.mark_name AS car_mark, cl.color_name AS car_color FROM cars c
        LEFT JOIN marks m ON c.car_mark_id = m.mark_id
        LEFT JOIN colors cl ON c.car_color_id = cl.color_id
        WHERE c.car_model LIKE '%$searchTerm%' OR m.mark_name LIKE '%$searchTerm%'";


    // Modifier la requête en fonction de l'option de tri
    switch ($sortOption) {
        case 'prix-croissant':
            $query .= " ORDER BY c.car_price ASC";
            break;
        case 'prix-decroissant':
            $query .= " ORDER BY c.car_price DESC";
            break;
        case 'marque':
            $query .= " ORDER BY m.mark_name ASC";
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
