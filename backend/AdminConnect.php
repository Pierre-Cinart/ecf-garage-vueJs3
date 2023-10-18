<?php
header('Content-Type: application/json');
header("Access-Control-Allow-Origin: http://localhost:8080");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");

// Configuration de la base de données et connexion à la base de données
require_once('bdd.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'));

    if ($data) {
        if (isset($data->email) && isset($data->password)) {
            $email = $data->email;
            $password = $data->password;

            // Requête SQL avec une requête préparée
            $query = "SELECT * FROM staff WHERE email = ?";
            $stmt = $bdd->prepare($query);
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows === 1) {
                $user = $result->fetch_assoc();

                // Vérification du mot de passe avec password_verify
                if (password_verify($password, $user['password_hash'])) {
                    // Authentification réussie
                    $response = [
                        'success' => true,
                        'message' => 'Authentification réussie'
                    ];
                    echo json_encode($response);
                } else {
                    // Mot de passe incorrect
                    http_response_code(401);
                    $response = [
                        'success' => false,
                        'error' => 'Mot de passe incorrect'
                    ];
                    echo json_encode($response);
                }
            } else {
                // Utilisateur non trouvé
                http_response_code(401);
                $response = [
                    'success' => false,
                    'error' => 'Utilisateur non trouvé'
                ];
                echo json_encode($response);
            }
        } else {
            // Données manquantes
            http_response_code(400);
            $response = [
                'success' => false,
                'error' => 'Veuillez fournir l\'e-mail et le mot de passe'
            ];
            echo json_encode($response);
        }
    } else {
        // Données non valides
        http_response_code(400);
        $response = [
            'success' => false,
            'error' => 'Données non valides'
        ];
        echo json_encode($response);
    }
} else {
    // Méthode non autorisée
    http_response_code(405);
    echo 'Méthode non autorisée';
}
?>

