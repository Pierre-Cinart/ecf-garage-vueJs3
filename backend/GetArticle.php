<?php
header('Content-Type: application/json');
header("Access-Control-Allow-Origin: http://localhost:8080");
header("Access-Control-Allow-Methods: GET,OPTIONS");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");

// Configuration de la base de données et connexion à la BDD
require_once('bdd.php');

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $title = isset($_GET['title']) ? $_GET['title'] : '';

    if (empty($title)) {
        http_response_code(400);
        echo json_encode(['error' => 'Le paramètre "title" est requis.']);
        exit;
    }

    $title = $bdd->real_escape_string($title); //  titre  sécurisé contre les injections SQL.

    // Requête SQL pour récupérer l'article par titre
    $query = "SELECT * FROM articles WHERE title = ? ";
    $stmt = $bdd->prepare($query);
    $stmt->bind_param('s', $title);
    $stmt->execute();
    $result = $stmt->get_result();

    if (!$result) {
        http_response_code(500);
        echo json_encode(['error' => 'Erreur dans la requête SQL']);
        exit;
    }

    $article = $result->fetch_assoc();

    if (!$article) {
        http_response_code(404);
        echo json_encode(['error' => 'Aucun article trouvé avec le titre spécifié.' .var_dump($title)]);
        exit;
    }

    $bdd->close();

    echo json_encode($article);
} else {
    // Méthode non autorisée
    http_response_code(405);
    echo 'Méthode non autorisée';
}
?>
