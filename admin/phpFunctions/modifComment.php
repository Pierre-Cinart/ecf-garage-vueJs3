<?php
session_start();

// Chemin relatif vers le répertoire 'vendor' à partir du répertoire actuel (modifComment.php)
$vendorPath = __DIR__ . '/../vendor/autoload.php';

// Inclure l'autoloader Composer
require_once($vendorPath);

require_once('../../backend/bdd.php'); // Assurez-vous d'inclure le fichier de connexion à la base de données

if (isset($_SESSION["log_in"])) {
    // Vérifie si l'utilisateur est connecté

    if (isset($_POST['commentId']) && isset($_POST['action'])) {
        // Vérifie si les paramètres nécessaires sont définis

        $commentId = mysqli_real_escape_string($bdd, $_POST['commentId']);
        $action = $_POST['action'];

        if ($action === "validate") {
            // Si l'action est de valider le commentaire, mettez à jour le commentaire_status en "ok"

            $updateQuery = "UPDATE comments SET comment_status = 'ok' WHERE comment_id = '$commentId'";
            $result = mysqli_query($bdd, $updateQuery);

            if ($result) {
                // Commentaire validé avec succès
                header('Location: ../adminComments.php');
                exit();
            } else {
                // Erreur lors de la mise à jour
                echo "Erreur lors de la mise à jour du commentaire.";
            }
        } elseif ($action === "delete") {
            // Si l'action est de supprimer le commentaire, supprimez-le de la base de données

            $deleteQuery = "DELETE FROM comments WHERE comment_id = '$commentId'";
            $result = mysqli_query($bdd, $deleteQuery);

            if ($result) {
                // Commentaire supprimé avec succès
                header('Location: ../adminComments.php');
                exit();
            } else {
                // Erreur lors de la suppression
                echo "Erreur lors de la suppression du commentaire.";
            }
        } else {
            // Action non reconnue
            echo "Action non reconnue.";
        }
    } else {
        // Paramètres manquants
        echo "Paramètres manquants.";
    }
} else {
    // Rediriger vers la page de déconnexion si l'utilisateur n'est pas connecté
    header('Location: logout.php');
    exit();
}
?>
