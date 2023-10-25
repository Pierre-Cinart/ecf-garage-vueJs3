<?php
// Inclure le fichier de configuration de la base de données
require_once('bdd.php');

// Mot de passe en clair
$password = 'Example123';

// Hacher le mot de passe
$hashedPassword = password_hash($password, PASSWORD_BCRYPT);

// Insérer le mot de passe haché dans la base de données (exemple : table staff)
$query = "UPDATE staff SET password_hash = ? WHERE email = 'johndoe@example.com'";
$stmt = $bdd->prepare($query);
$stmt->bind_param('s', $hashedPassword);

if ($stmt->execute()) {
    echo 'Mot de passe haché et enregistré dans la base de données avec succès.';
} else {
    echo "Erreur lors de l'enregistrement du mot de passe haché : " . $stmt->error;
}

$bdd->close();
?>
