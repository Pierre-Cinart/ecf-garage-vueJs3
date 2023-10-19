<?php
header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");

// Configuration de la base de données et connexion à la BDD
require_once('bdd.php');
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    // Si la méthode HTTP est OPTIONS, c'est une pré-vérification CORS, donc retournez les en-têtes CORS appropriés.
    header("HTTP/1.1 200 OK");
    exit;
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);

    $firstname = $data['firstname'];
    $lastname = $data['lastname'];
    $content = $data['content'];
    $comment_status = 'wait';  // Par défaut, le commentaire est en attente de modération

    // Valider les noms et prénoms
    if (!validateName($firstname) || !validateName($lastname)) {
        http_response_code(400); // Code de réponse HTTP "Bad Request"
        echo json_encode(['error' => 'Le prénom et le nom doivent contenir entre 2 et 25 lettres.']);
        exit;
    }

    // Valider la longueur du commentaire
    if (!validateCommentLength($content)) {
        http_response_code(400); // Code de réponse HTTP "Bad Request"
        echo json_encode(['error' => 'Le commentaire doit contenir au moins 16 caractères.']);
        exit;
    }

    // Insertion du commentaire dans la base de données
    $query = "INSERT INTO comments (firstname, lastname, comment_text, comment_status) VALUES (?, ?, ?, ?)";
    $stmt = $bdd->prepare($query);
    $stmt->bind_param('ssss', $firstname, $lastname, $content, $comment_status);

    if ($stmt->execute()) {
        http_response_code(201); // Code 201 pour une création réussie
        echo json_encode(['message' => 'Commentaire posté avec succès.']);
    } else {
        http_response_code(500);
        echo json_encode(['error' => 'Erreur lors de la création du commentaire.']);
    }
}

function validateName($name) {
    // Valider le prénom ou le nom (entre 2 et 25 lettres)
    $regex = '/^[\p{L}\s]{2,25}$/u';
    return preg_match($regex, $name);
}

function validateCommentLength($comment) {
    // Valider la longueur du commentaire (au moins 16 caractères)
    return mb_strlen($comment) >= 16;
}
?>
