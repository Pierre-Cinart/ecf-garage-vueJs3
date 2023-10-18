<?php
header('Content-Type: application/json');
header("Access-Control-Allow-Origin: http://localhost:8080");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");

// Configuration de la base de données et connexion à la BDD
require_once('bdd.php');

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Validez et récupérez les paramètres de pagination
    $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
    $perPage = isset($_GET['perPage']) ? intval($_GET['perPage']) : 5;
    $offset = ($page - 1) * $perPage;

    // Requête SQL pour récupérer les commentaires de la page actuelle
    $query = "SELECT * FROM comments WHERE comment_status = 'ok' ORDER BY comment_date DESC LIMIT ? OFFSET ?";
    $stmt = $bdd->prepare($query);
    $stmt->bind_param('ii', $perPage, $offset);
    $stmt->execute();
    $result = $stmt->get_result();

    if (!$result) {
        http_response_code(500);
        echo json_encode(['error' => 'Erreur dans la requête SQL']);
        exit;
    }

    $comments = [];

    while ($row = $result->fetch_assoc()) {
        $comments[] = $row;
    }

    $bdd->close();

    echo json_encode($comments);
} else {
    // Méthode non autorisée
    http_response_code(405);
    echo 'Méthode non autorisée';
}
?>
