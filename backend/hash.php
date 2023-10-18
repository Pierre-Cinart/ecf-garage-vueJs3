<?php
// Connexion à la base de données
require_once('bdd.php');

// Récupération des mots de passe et des hachages
$query = "SELECT staff_id, password_hash FROM staff";
$result = $bdd->query($query);
$passwords = array();

if ($result) {
    while ($row = $result->fetch_assoc()) {
        $passwords[$row['staff_id']] = $row['password_hash'];
    }

    // Génération de nouveaux hachages sécurisés pour les mots de passe
    $newPasswords = array();
    foreach ($passwords as $staff_id => $password_hash) {
        $newPassword = "nouveaumotdepasse"; // Remplacez par le nouveau mot de passe souhaité
        $newPasswordHash = password_hash($newPassword, PASSWORD_DEFAULT);
        $newPasswords[$staff_id] = $newPasswordHash;
    }

    // Mise à jour des hachages dans la table `staff`
    foreach ($newPasswords as $staff_id => $newPasswordHash) {
        $updateQuery = "UPDATE staff SET password_hash = '$newPasswordHash' WHERE staff_id = $staff_id";
        $bdd->query($updateQuery);
    }

    echo "Les mots de passe ont été mis à jour avec succès.";

    // Fermeture de la connexion à la base de données
    $bdd->close();
} else {
    echo "Une erreur s'est produite lors de la récupération des mots de passe.";
}
?>
