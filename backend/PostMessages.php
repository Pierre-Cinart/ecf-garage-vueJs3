<?php
// Configuration des en-têtes CORS pour permettre les requêtes depuis n'importe quelle origine
header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");

// Inclusion du fichier de configuration de la base de données
require_once('bdd.php'); // Assurez-vous que 'bdd.php' est correctement configuré.

// Clé secrète reCAPTCHA (remplacez par votre propre clé secrète)
$recaptchaSecretKey = '6LfHo7QoAAAAAM3rLyJkfOhG_U6EfCT8khqD2Oa6';

// Vérification de la méthode HTTP (POST)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupération des données JSON envoyées depuis le front-end
    $data = json_decode(file_get_contents("php://input"), true);

    // Vérification reCAPTCHA
    $recaptchaResponse = $data['recaptchaToken']; // Assurez-vous que le nom du champ correspond à votre front-end
    $recaptchaUrl = 'https://www.google.com/recaptcha/api/siteverify';
    $recaptchaData = [
        'secret' => $recaptchaSecretKey,
        'response' => $recaptchaResponse,
        'remoteip' => $_SERVER['REMOTE_ADDR']
    ];

    $recaptchaOptions = [
        'http' => [
            'method' => 'POST',
            'header' => 'Content-Type: application/x-www-form-urlencoded',
            'content' => http_build_query($recaptchaData)
        ]
    ];

    $recaptchaContext = stream_context_create($recaptchaOptions);
    $recaptchaResult = file_get_contents($recaptchaUrl, false, $recaptchaContext);
    $recaptchaResult = json_decode($recaptchaResult, true);

    if (!$recaptchaResult['success']) {
        http_response_code(400); // Code de réponse HTTP "Bad Request"
        echo json_encode(['error' => 'Veuillez valider le reCAPTCHA.']);
        exit;
    }

    // Extraction des données du message
    $firstname = $data['firstname'];
    $lastname = $data['lastname'];
    $subject = $data['subject'];
    $content = $data['content'];
    $message_status = 'wait'; // Par défaut, le message est en attente de modération

    // Validation des noms et prénoms
    if (!validateName($firstname) || !validateName($lastname)) {
        http_response_code(400); // Code de réponse HTTP "Bad Request"
        echo json_encode(['error' => 'Le prénom et le nom doivent contenir entre 2 et 25 lettres.']);
        exit;
    }

    // Validation de la longueur du message
    if (!validateMessageLength($content)) {
        http_response_code(400); // Code de réponse HTTP "Bad Request"
        echo json_encode(['error' => 'Le message doit contenir au moins 16 caractères.']);
        exit;
    }

    // Validation de la longueur du sujet
    if (!validateSubjectLength($subject)) {
        http_response_code(400); // Code de réponse HTTP "Bad Request"
        echo json_encode(['error' => 'Le sujet du message doit contenir entre 5 et 100 caractères.']);
        exit;
    }

    // Insertion du message dans la base de données en utilisant des requêtes préparées
    $query = "INSERT INTO messages (firstname, lastname, message_subject, message_text, message_status) VALUES (?, ?, ?, ?, ?)";
    $stmt = $bdd->prepare($query);
    $stmt->bind_param('sssss', $firstname, $lastname, $subject, $content, $message_status);

    if ($stmt->execute()) {
        http_response_code(201); // Code 201 pour une création réussie
        echo json_encode(['message' => 'Message posté avec succès.']);
    } else {
        http_response_code(500);
        echo json_encode(['error' => 'Erreur lors de la création du message.']);
    }
}

function validateName($name) {
    // Valider le prénom ou le nom (entre 2 et 25 lettres)
    $regex = '/^[\p{L}\s]{2,25}$/u';
    return preg_match($regex, $name);
}

function validateMessageLength($message) {
    // Valider la longueur du message (au moins 16 caractères)
    return mb_strlen($message) >= 16;
}

function validateSubjectLength($subject) {
    // Valider la longueur du sujet (entre 5 et 100 caractères)
    return mb_strlen($subject) >= 5 && mb_strlen($subject) <= 100;
}
?>
